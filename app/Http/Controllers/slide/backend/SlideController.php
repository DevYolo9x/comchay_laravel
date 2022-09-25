<?php

namespace App\Http\Controllers\slide\backend;

use App\Http\Controllers\Controller;
use App\Models\CategorySlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Slide;
use Illuminate\Validation\Rule;

class SlideController extends Controller
{

    public function index()
    {
        $module = 'slide';
        $slideGroup = CategorySlide::latest()->where('alanguage', config('app.locale'))->paginate(20);
        return view('slide.backend.index', compact('module', 'slideGroup'));
    }


    public function store(Request $request)
    {
        $object = $request->object;
        $catalogueid =  $request->catalogueid;
        if (isset($object['src']) && is_array($object['src']) && count($object['src'])) {
            foreach ($object['src'] as $key => $val) {
                $_insert[] = array(
                    'src' => $val,
                    'title' => !empty($object['title'][$key]) ? $object['title'][$key] : '',
                    'link' => !empty($object['link'][$key]) ? $object['link'][$key] : '',
                    'order' => !empty($object['order'][$key]) ? $object['order'][$key] : 0,
                    'description' => !empty($object['description'][$key]) ? $object['description'][$key] : "",
                    'catalogueid' => $catalogueid,
                    'created_at' => Carbon::now(),
                    'userid_created' => Auth::user()->id,
                    'alanguage' => config('app.locale'),
                );
            }
        }
        $slide = Slide::insert($_insert);
        return response()->json([
            'code' => 200,
        ], 200);
    }
    public function update(Request $request)
    {

        $post = $request->data;
        $_update = [];
        if (isset($post) && is_array($post) && count($post)) {
            foreach ($post as $val) {
                $_update[$val['name']] = $val['value'];
            }
        }
        $update = Slide::find($_update['id'])->update($_update);
        return response()->json([
            'code' => 200,
            'src' => $_update['src'],
            'title' => $_update['title'],
            'description' => $_update['description'],
            'link' => $_update['link'],
        ], 200);
    }

    public function category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'keyword' =>  ['required', Rule::unique('category_slides')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Bạn bắt buộc phải nhập vào ô Tên nhóm Slide',
            'keyword.required' => 'Bạn bắt buộc phải nhập vào ô Từ khóa',

        ]);
        $validator->validate();
        $categoryslidesID  = CategorySlide::insertGetId([
            'title' => $request->title,
            'keyword' => $request->keyword,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'alanguage' => config('app.locale'),
        ]);
        return response()->json([
            'code' => 200,
            'html' => '<li class="mt-2">
            <div class="flex items-center justify-between">
                <a href="javascript:void(0)" class="slide-catalogue" data-id="' . $categoryslidesID . '">' . $request->title . '</a>
                <a type="button" class="slide-group-delete ajax-delete" data-title="Lưu ý: Dữ liệu sẽ không thể khôi phục. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!" data-module="category_slides" data-id="' . $categoryslidesID . '" style="color:#676a6c;"> Xóa</a>
            </div>
        </li>'
        ], 200);
    }
    public function category_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Bạn bắt buộc phải nhập vào ô Tên nhóm Slide',
        ]);
        $validator->validate();
        $categoryslidesID  = CategorySlide::find($request->id)->update([
            'title' => $request->title,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);
        return response()->json([
            'code' => 200
        ], 200);
    }

}