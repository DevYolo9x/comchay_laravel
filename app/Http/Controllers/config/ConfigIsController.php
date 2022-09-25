<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use App\Models\Configis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConfigIsController extends Controller
{
    protected $module = 'configis';
    protected $type = ['ishome' => 'ishome', 'highlight' => 'highlight', 'isaside' => 'isaside', 'isfooter' => 'isfooter'];
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
    ];
    public function index(Request $request)
    {
        $module = $this->module;
        $keyword = $request->keyword;
        $moduleGET = $request->module;
        $data = Configis::orderBy('module', 'asc')->orderBy('type', 'desc');
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($moduleGET)) {
            $data =  $data->where('module', $moduleGET);
        }
        $data =  $data->get();
        $table = $this->table;
        return view('config.is.index', compact('module', 'data', 'table'));
    }
    public function create()
    {
        $module = $this->module;
        $type = $this->type;
        $table = $this->table;
        return view('config.is.create', compact('module', 'type', 'table'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' =>  ['required', Rule::unique('configis')->where(function ($query) use ($request) {
                return $query->where('module', $request->module);
            })],
            'module' => 'required',
        ]);
        $this->submit($request, 'create', 0);
        return redirect()->route('configIs.index')->with('success', "Thêm mới thành công");
    }
    public function edit($id)
    {
        $detail  = Configis::find($id);
        if (!isset($detail)) {
            return redirect()->route('configIs.index')->with('error', "Không tồn tại");
        }
        $module = $this->module;
        $type = $this->type;
        $table = $this->table;
        return view('config.is.edit', compact('module', 'type', 'table', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'type' =>  ['required', Rule::unique('configis')->where(function ($query) use ($request) {
                return $query->where('module', $request->module)->where('id', '!=', $request->id);
            })],
            'module' => 'required',
        ]);
        $this->submit($request, 'update', $id);
        return redirect()->route('configIs.index')->with('success', "Cập nhập thành công");
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
            'module' => $request['module'],
            'type' => $request['type'],
            'active' => !empty($request['active']) ? $request['active'] : 0,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Configis::insertGetId($_data);
        } else {
            Configis::find($id)->update($_data);
        }
    }
}
