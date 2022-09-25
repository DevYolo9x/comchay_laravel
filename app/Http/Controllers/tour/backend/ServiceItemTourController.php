<?php

namespace App\Http\Controllers\tour\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TourServiceItem;

class ServiceItemTourController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tour_service_items',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        $_data = [
            'alanguage' => config('app.locale'),
            'service_id' => $request->id,
            'title' => $request->title,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];
        $id = TourServiceItem::insertGetId($_data);
        return response()->json([
            'code' => 200,
            'id' => $id,
        ], 200);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'title' => 'required|unique:tour_service_items,title,' . $id . ',id',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        $_data = [
            'title' => $request->title,
            'userid_updated' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ];
        $id = TourServiceItem::find($id)->update($_data);
        return response()->json([
            'code' => 200,
        ], 200);
    }

}
