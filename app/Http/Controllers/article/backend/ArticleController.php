<?php

namespace App\Http\Controllers\article\backend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Components\Helper;
use App\Models\CategoryArticle;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $table = 'articles';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_articles'));
        $this->Helper = new Helper();
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  Article::where(['alanguage' => config('app.locale'), 'type' => 0])->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $catalogueid = $request->catalogueid;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data = $data->join('catalogues_relationships', $this->table . '.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', $this->table);
        if (!empty($catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $catalogueid);
        }
        $data =  $data->groupBy('catalogues_relationships.moduleid');
        $data =  $data->paginate(env('APP_paginate'));
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($catalogueid)) {
            $data->appends(['catalogueid' => $catalogueid]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown();
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('article.backend.article.index', compact('data', 'module', 'htmlOption', 'configIs'));
    }
    public function create()
    {
        $dropdown = getFunctions();
        $module = $this->table;
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        //tags
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        }
        // $tags = relationships('\App\Models\Tag', $getTags);
        //end tag
        $tags = Tag::select('id', 'title')->where('module', 'articles')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('article.backend.article.create', compact('module', 'htmlCatalogue', 'tags', 'dropdown', 'getTags', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . config('app.locale') . ',alanguage',
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
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'bai-viet');
        } else {
            $image_url = $request->image_old;
        }
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('articles.index')->with('success', "Thêm mới bài viết thành công");
    }
    public function edit($id)
    {
        $dropdown = getFunctions();
        $module = $this->table;
        $detail  = Article::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('articles.index')->with('error', "Bài viết không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        //tags
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        } else {
            foreach ($detail->tags as $k => $v) {
                $getTags[] = $v['tagid'];
            }
        }
        $tags = Tag::select('id', 'title')->where('module', 'articles')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        // $tags = relationships('\App\Models\Tag', $getTags);
        //end tag
        $getCatalogue = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('article.backend.article.edit', compact('module', 'detail', 'htmlCatalogue', 'tags', 'dropdown', 'getTags', 'getCatalogue', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid,alanguage,' . config('app.locale') . '',
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
            $image_url = uploadImage($request->file('image'), 'bai-viet');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('articles.index')->with('success', "Cập nhập bài viết thành công");
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
        //danh mục phụ
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
        $detail = CategoryArticle::select('id', 'title', 'slug', 'lft')->where('id', $request['catalogue_id'])->first();
        $breadcrumb = CategoryArticle::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        if ($breadcrumb->count() > 0) {
            foreach ($breadcrumb as $v) {
                $tmp_catalogue[] = $v->id;
            }
        }
        $tmp_catalogue = array_unique($tmp_catalogue);
        //end
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'catalogue_id' => $request['catalogue_id'],
            'image' => $image_url,
            'description' => $request['description'],
            'content' => $request['content'],
            'catalogue' => json_encode($tmp_catalogue),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Article::insertGetId($_data);
        } else {
            Article::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa catalogue_relationship
                DB::table('catalogues_relationships')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa tags_relationship
                DB::table('tags_relationships')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa bảng router
                DB::table('router')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //thêm vào bảng catalogue_relationship
            $this->Helper->catalogue_relation_ship($id, $request['catalogue_id'], $tmp_catalogue, $this->table);
            //thêm tag
            $this->Helper->_table_relation_ship($id, $request['tags'], 'tags', 'tagid', $this->table);
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
}
