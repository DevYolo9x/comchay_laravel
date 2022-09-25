<?php

namespace App\Http\Controllers\components;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Image;

class ComponentsController extends Controller
{
    public function language($language)
    {
        Session::put('language', $language);
        Session::save();
        return redirect()->back();
    }
    //dropzone upload
    public function dropzone_upload(Request $request)
    {
        $image_url = '';
        $image = $request->file('file');
        if (!empty($image)) {
            // $name_gen = $image->getClientOriginalName();
            // $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/images/album-anh');
            if (!file_exists($base_path)) {
                mkdir($base_path, 666, true);
            }
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // Image::make($image)->insert(url('frontend/images/logo.webp'))->encode('webp', 90)->save($base_path.'/'.$name_gen);
            // $image_url = 'upload/images/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/images/album-anh/' . $name_gen;
        }
        echo $image_url;
        die;
    }
    public function dropzone_delete(Request $request)
    {
        $filename = base_path($request->filename);
        if (file_exists($filename)) {
            unlink($filename);
        }
        return $filename;
    }
    public function dropzone_image(Request $request)
    {
        $fileList = [];
        $get = DB::table($request->module)->select('image_json')->where('id', $request->id)->first();
        $image_json = json_decode($get->image_json, TRUE);
        if (isset($image_json) && count($image_json) && is_array($image_json)) {
            foreach ($image_json as $k => $v) {
                $size = filesize(base_path($v));
                $fileList[] = ['name' => $v, 'size' => $size, 'path' => url($v)];
            }
        }
        echo json_encode($fileList);
        exit;
    }
}
