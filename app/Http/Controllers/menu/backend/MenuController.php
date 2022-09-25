<?php

namespace App\Http\Controllers\menu\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\CategoryProduct;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;
class MenuController extends Controller
{
    protected $table = 'menus';
    public function index(Request $request)
    {
        $data =  Menu::orderBy('id', 'DESC')->get();

        $module =  $this->table;
        return view('menu.backend.index', compact('module','data'));
    }
    public function create(Request $request)
    {
        $module =  $this->table;
        return view('menu.backend.create', compact('module'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:menus',
            'slug' => 'required|unique:menus',
        ], [
            'title.required' => 'Tên menu là trường bắt buộc.',
            'title.unique' => 'Tên menu đã tồn tại.',
            'slug.required' => 'Từ khóa là trường bắt buộc.',
            'slug.unique' => 'Từ khóa đã tồn tại.',
        ]);
        $validator->validate();
        $_data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'publish' => $request->publish,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        $id = Menu::create($_data);
        if($id) {
            return redirect()->route("menus.edit", ['id' => $id])->with('success', "Thêm mới menu thành công");
        } else {
            return redirect()->route('menus.index')->with('error', 'Thêm mới menu không thành công');
        }
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Menu::find($id);
        if (!isset($detail)) {
            return redirect()->route('menus.index')->with('error', "Menu không tồn tại");
        }
        //lấy danh sách menu
        $menuitems = MenuItem::where('alanguage', config('app.locale'))->where('menu_id', $id)->where('parentid', 0)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('menu.backend.edit', compact('module','detail','menuitems'));
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:menus,title,' . $id . ',id',
            'slug' => 'required|unique:menus,slug,' . $id . ',id',
        ], [
            'title.required' => 'Tên menu là trường bắt buộc.',
            'title.unique' => 'Tên menu đã tồn tại.',
            'slug.required' => 'Từ khóa là trường bắt buộc.',
            'slug.unique' => 'Từ khóa đã tồn tại.',
        ]);
        $validator->validate();
        $_data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'publish' => $request->publish,
            'userid_updated' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ];
        $id = Menu::find($id)->update($_data);
        return redirect()->route("menus.edit", ['id' => $id])->with('success', "Cập nhập menu thành công");
    }
    public function addMenuItem(Request $request)
    {
        $data = $request->all();
        $menuid = $request->menuid;
        $module = $request->module;
        $ids = $request->ids;
        foreach ($ids as $id) {
            $detail = DB::table($module)->where('id', $id)->select('title', 'slug')->first();
            $data['title'] =  $detail->title;
            $data['slug'] =  $detail->slug;
            $data['type'] = $module;
            $data['menu_id'] = $menuid;
            $data['userid_created'] = Auth::user()->id;
            $data['alanguage'] = config('app.locale');
            MenuItem::create($data);
        }
    }
    public function addCustomLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'URL là trường bắt buộc.',
        ]);
        $validator->validate();
        $menuid = $request->menuid;
        MenuItem::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'type' => 'custom',
            'menu_id' => $menuid,
            'updated_at' => NULL,
            'alanguage' => config('app.locale')

        ]);
    }
    //"LƯU MENU" => updateMenu kéo thả
    public function updateMenu(Request $request)
    {
        $content = $request->value;
        $array_menu = json_decode($request->value, true);
        foreach ($array_menu as $k => $v) {
            DB::table('menu_items')->where('alanguage', config('app.locale'))->where('id', $v['id'])->update(['order' => $k, 'parentid' => 0]);
            //cập nhập menu cha cấp 2
            if (!empty($v['children'])) {
                foreach ($v['children'] as $kc => $vc) {
                    DB::table('menu_items')->where('id', $vc['id'])->update(['parentid' => $v['id'], 'order' => $kc]);
                    //cập nhập menu cha cấp 3
                    if (!empty($vc['children'])) {
                        foreach ($vc['children'] as $kcc => $vcc) {
                            DB::table('menu_items')->where('id', $vcc['id'])->update(['parentid' => $vc['id'], 'order' => $kcc]);
                            //cập nhập menu cha cấp 4
                            if (!empty($vcc['children'])) {
                                foreach ($vcc['children'] as $kccc => $vccc) {
                                    DB::table('menu_items')->where('id', $vccc['id'])->update(['parentid' => $vcc['id'], 'order' => $kccc]);
                                    //cập nhập menu cha cấp 5
                                    if (!empty($vccc['children'])) {
                                        foreach ($vccc['children'] as $kcccc => $vcccc) {
                                            DB::table('menu_items')->where('id', $vcccc['id'])->update(['parentid' => $vccc['id'], 'order' => $kcccc]);
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }
    }
    //"Cập nhập" form của từng menu

    public function updateMenuItem(Request $request)
    {
        /*
        if(!empty($request->file('image'))){
            $image = $request->file('image');
            $path = 'menu';
            if(!empty($image)){

                $name_gen = hexdec(uniqid()).'.webp';
                $base_path = base_path('upload/images/'.$path.'/'.date('d-m-Y'));
                if (!file_exists($base_path)) {
                    mkdir($base_path, 666, true);
                }
                Image::make($image)->encode('webp', 100)->save($base_path.'/'.$name_gen);
                $image_url = 'upload/images/'.$path.'/'.date('d-m-Y').'/'.$name_gen;
            }
        }else{
            $image_url = $request->image_old;
        } */
        $_data = [
            'title' => $request->title,
            'slug' => $request->slug,
            'image' => $request->image,
            'target' => $request->target,
            'userid_updated' => Auth::user()->id,
            'updated_at' => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        $item = MenuItem::find($request->id)->update($_data);
        return redirect()->back();
    }
    //"Remove" form cửa từng menu
    public function deleteMenuItem($id,$menu_id)
    {
        $menuitem = MenuItem::findOrFail($id);
        $menuitem->delete();
        return redirect()->route('menus.edit',['id'=>$menu_id])->with('success', 'Xóa menu thành công');
    }
    public function destroy(Request $request)
    {
        MenuItem::where('menu_id', $request->id)->delete();
        Menu::findOrFail($request->id)->delete();
        return redirect()->route('menus.index')->with('success', 'Xóa menu thành công');
    }
}