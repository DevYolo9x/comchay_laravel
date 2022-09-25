<?php

namespace App\Http\Controllers\media\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Components\Helper;

use App\Components\Nestedsetbie;
use App\Models\CategoryMedia;
use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MediaController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $table = 'media';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_media'));
        $this->Helper = new Helper();
    }
    public function index(Request  $request)
    {
        $module = $this->table;
        $data =  Media::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $catalogue_id = $request->catalogueid;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($catalogue_id)) {
            $data =  $data->where('catalogue_id', $catalogue_id);
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($catalogue_id)) {
            $data->appends(['catalogueid' => $catalogue_id]);
        }
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown();
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('media.backend.media.index', compact('data', 'module', 'htmlOption', 'configIs'));
    }


    public function create()
    {
        $module = $this->table;
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('media.backend.media.create', compact('module', 'htmlCatalogue', 'field'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:media',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn bài viết là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn bài viết đã tồn tại.',
            'catalogue_id.gt' => 'Danh mục là trường bắt buộc.',

        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'media');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('media.index')->with('success', "Thêm mới sản phẩm thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Media::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('media.index')->with('error', "Bài viết không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $getCatalogue = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('media.backend.media.edit', compact('module', 'detail', 'htmlCatalogue', 'getCatalogue', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'catalogue_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'media');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('media.index')->with('success', "Cập nhập bài viết thành công");
    }

    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        /*danh mục phụ*/
        $catalogue = $request['catalogue'];
        $tmp_catalogue[] = (int)$request['catalogue_id'];
        if (isset($catalogue)) {
            foreach ($catalogue as $v) {
                if ($v != 0 && $v != $request['catalogue_id']) {
                    $tmp_catalogue[] = (int)$v;
                }
            }
        }
        //lấy danh mục cha (nếu có)
        $detail = CategoryMedia::select('id', 'title', 'slug', 'lft')->where('id', $request['catalogue_id'])->first();
        $breadcrumb = CategoryMedia::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        if ($breadcrumb->count() > 0) {
            foreach ($breadcrumb as $v) {
                $tmp_catalogue[] = $v->id;
            }
        }
        $tmp_catalogue = array_unique($tmp_catalogue);
        /*end*/
        $_data = [
            'title' => $request['title'],
            'layoutid' => $request['layoutid'],
            'file_upload' => $request['file_upload'],
            'slug' => $request['slug'],
            'catalogue_id' => $request['catalogue_id'],
            'image' => $image_url,
            'description' => $request['description'],
            'video_type' => $request['video_type'],
            'video_link' => $request['video_link'],
            'video_iframe' => $request['video_iframe'],
            'image_json' =>  !empty($request['album']) ? json_encode($request['album']) : '',
            'catalogue' => json_encode($tmp_catalogue),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),

        ];
        if ($action == 'create') {
            $id = Media::insertGetId($_data);
        } else {
            Media::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa catalogue_relationship
                DB::table('catalogues_relationships')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa bảng router
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //thêm vào bảng catalogue_relationship
            $this->Helper->catalogue_relation_ship($id, $request['catalogue_id'], $tmp_catalogue, $this->table);
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
        }
    }
    public function get_select_type(Request $request)
    {
        $detail  = CategoryMedia::where('alanguage', config('app.locale'))->select('layoutid')->find($request->catalogueid);
        echo $detail->layoutid;
    }
}
