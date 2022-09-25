<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use App\Models\ConfigColum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConfigColumController extends Controller
{
    protected $module = 'config_colums';
    protected $table = [
        'products' => 'Sản phẩm',
        'category_products' => 'Danh mục sản phẩm',
        'articles' => 'Bài viết',
        'category_articles' => 'Danh mục bài viết',
        'media' => 'Media',
        'category_media' => 'Danh mục media',
        'attributes' => 'Thuộc tính',
        'category_attributes' => 'Danh mục thuộc tính',
        'brands' => 'Thương hiệu',
        'tags' => 'Tags',
        'pages' => 'Trang',
    ];
    protected $type = [
        'input' => 'input',
        'textarea' => 'textarea',
        'editor' => 'editor',
        'json' => 'json',
        'select' => 'select',
        'checkbox' => 'checkbox',
        'radio' => 'radio',
    ];

    public function index(Request $request)
    {
        $module = $this->module;
        $keyword = $request->keyword;
        $moduleGET = $request->module;
        $data = ConfigColum::where('trash', 0)->orderBy('module', 'asc')->orderBy('type', 'desc');
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($moduleGET)) {
            $data =  $data->where('module', $moduleGET);
        }
        $data = $data->get();
        $table = $this->table;
        $type = $this->type;
        return view('config.colums.index', compact('module', 'data', 'table', 'type'));
    }


    public function create()
    {
        $module = $this->module;
        $type = $this->type;
        $table = $this->table;
        return view('config.colums.create', compact('module', 'type', 'table'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', Rule::unique('config_colums')->where(function ($query) use ($request) {
                return $query->where(['module' => $request->module, 'trash' => 0]);
            })],
            'keyword' =>  ['required', Rule::unique('config_colums')->where(function ($query) use ($request) {
                return $query->where(['module' => $request->module, 'trash' => 0]);
            })],
            'module' => 'required',
            'type' => 'required',

        ]);
        $this->submit($request, 'create', 0);
        return redirect()->route('config_colums.index')->with('success', "Thêm mới thành công");
    }


    public function edit($id)
    {
        $detail  = ConfigColum::find($id);
        if (!isset($detail)) {
            return redirect()->route('config_colums.index')->with('error', "Không tồn tại");
        }
        $module = $this->module;
        $type = $this->type;
        $table = $this->table;
        return view('config.colums.edit', compact('module', 'type', 'table', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', Rule::unique('config_colums')->where(function ($query) use ($request) {
                return $query->where(['module' => $request->module, 'trash' => 0])->where('id', '!=', $request->id);
            })],
            'keyword' =>  ['required', Rule::unique('config_colums')->where(function ($query) use ($request) {
                return $query->where(['module' => $request->module, 'trash' => 0])->where('id', '!=', $request->id);
            })],
            'module' => 'required',
            'type' => 'required',
        ]);
        $this->submit($request, 'update', $id);
        return redirect()->route('config_colums.index')->with('success', "Cập nhập thành công");
    }
    public function submit($request = [], $action = '', $id = 0)
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'title' => $request['title'],
            'type' => $request['type'],
            'keyword' => $request['keyword'],
            'module' => $request['module'],
            'data' => json_encode($request['data']),
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = ConfigColum::insertGetId($_data);
        } else {
            ConfigColum::find($id)->update($_data);
        }
    }
    public function destroy(Request $request)
    {
        $id = (int) $request->id;
        ConfigColum::find($id)->update(['trash' => 1]);
        return response()->json([
            'code' => 200,
        ], 200);

        /*ConfigColum::find($id)->update(['trash' => 1]);
        return redirect()->route('config_colums.index')->with('success', "Xóa thành công"); */
    }
    public function deleteAll(Request $request)
    {
        $post = $request->param;

        if (isset($post['list']) && is_array($post['list']) && count($post['list'])) {
            foreach ($post['list'] as $id) {
                ConfigColum::find($id)->update(['trash' => 1]);
            }
        }
        return response()->json([
            'code' => 200,
        ], 200);
    }
}
