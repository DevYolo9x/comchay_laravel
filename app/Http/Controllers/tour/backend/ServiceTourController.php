<?php

namespace App\Http\Controllers\tour\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;
class ServiceTourController extends Controller
{
    protected $table = 'tour_services';
    public function index()
    {
        $module = $this->table;
        $data =  TourService::select('id','title','order','publish','userid_created','created_at','type','ishome')->where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'desc')->get();
        return view('tour.backend.service.index', compact('data', 'module'));

    }
    public function create()
    {
        $module = $this->table;
        return view('tour.backend.service.create', compact('module'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        $this->submit($request, 'create', 0 );
        return redirect()->route('tour_services.index')->with('success', "Thêm mới thành công");
    }

    public function edit($id)
    {
        $module =  $this->table;
        $detail  = TourService::find($id);
        if (!isset($detail)) {
            return redirect()->route('tour_services.index')->with('error', "Service không tồn tại");
        }
        return view('tour.backend.service.edit', compact('detail', 'module'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        $this->submit($request, 'update', $id );
        return redirect()->route('tour_services.index')->with('success', "Cập nhập thành công");
    }
    public function submit($request = [], $action = '', $id = 0)
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        $_data = [
            'title' => $request['title'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = TourService::insertGetId($_data);
        } else {
            TourService::find($id)->update($_data);
        }
    }

}
