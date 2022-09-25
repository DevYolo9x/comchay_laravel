<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('removeutf8')) {
    function removeutf8($value = NULL)
    {
        $chars = array(
            'a'    =>    array('ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'á', 'à', 'ả', 'ã', 'ạ', 'â', 'ă', 'Á', 'À', 'Ả', 'Ã', 'Ạ', 'Â', 'Ă'),
            'e' =>    array('ế', 'ề', 'ể', 'ễ', 'ệ', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê'),
            'i'    =>    array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'),
            'o'    =>    array('ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'Ố', 'Ồ', 'Ổ', 'Ô', 'Ộ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ơ', 'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ơ'),
            'u'    =>    array('ứ', 'ừ', 'ử', 'ữ', 'ự', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư'),
            'y'    =>    array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'),
            'd'    =>    array('đ', 'Đ'),
        );
        foreach ($chars as $key => $arr)
            foreach ($arr as $val)
                $value = str_replace($val, $key, $value);
        return $value;
    }
}
if (!function_exists('slug')) {
    function slug($value = NULL)
    {
        $value = removeutf8($value);
        $value = str_replace('-', ' ', trim($value));
        $value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
        $value = trim(preg_replace('/\s\s+/', ' ', $value));
        return strtolower(str_replace(' ', '-', trim($value)));
    }
}
if (!function_exists('CodeRender')) {
    function CodeRender($module = '')
    {
        switch ($module) {
            case "products":
                $lastRow = \App\Models\Product::orderBy('id', 'DESC')->first();
                $str = 'SP';
                break;
            case "tours":
                $lastRow = \App\Models\Tour::orderBy('id', 'DESC')->first();
                $str = 'TO';
                break;
        }
        if (!empty($lastRow)) {
            $lastId = (int)$lastRow['id'] + 1;
            $data = $str . str_pad($lastId, 4, '0', STR_PAD_LEFT);
        } else {
            $data = $str . '0000';
        }
        return $data;
    }
}
if (!function_exists('is')) {
    function is($data)
    {
        return (isset($data)) ? $data : '';
    }
}
if (!function_exists('check_array')) {
    function check_array($array)
    {
        if (isset($array)) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('activeMenu')) {
    function activeMenu($uri = '')
    {
        $active = '';
        if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
            $active = 'side-menu--active';
        }
        return $active;
    }
}
if (!function_exists('array_group_by')) {
    function array_group_by(array $arr, callable $key_selector)
    {
        $result = array();
        foreach ($arr as $i) {
            $key = call_user_func($key_selector, $i);
            $result[$key][] = $i;
        }
        return $result;
    }
}
/*Breadcrumb*/
if (!function_exists('breadcrumb_backend')) {
    function breadcrumb_backend($array = [])
    {
        $result = '<nav aria-label="breadcrumb" class="hidden xl:flex">
        <ol class="breadcrumb breadcrumb-light">
            <li class="breadcrumb-item"><a href="' . route('admin.dashboard') . '">App</a></li>';
        if (isset($array) && count($array) > 0 && is_array($array)) {
            foreach ($array as $v) {
                $result .= '<li class="breadcrumb-item"><a href="' . $v['src'] . '">' . $v['title'] . '</a></li>';
            }
        }
        $result .= '</ol>
        </nav>';
        return $result;
    }
}
/*Upload image*/
if (!function_exists('uploadImage')) {
    function uploadImage($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/images/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 666, true);
            }
            // Image::make($image)->insert(url('frontend/images/logo.webp'))->encode('webp', 100)->save($base_path.'/'.$name_gen);
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/images/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
if (!function_exists('uploadImageNone')) {
    function uploadImageNone($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/images/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 666, true);
            }
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/images/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
if (!function_exists('uploadImageFrontend')) {
    function uploadImageFrontend($image = '', $path = '')
    {
        $image_url = '';
        if (!empty($image)) {
            // $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $name_gen = hexdec(uniqid()) . '.webp';
            // $base_path = base_path('upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d'));
            $base_path = base_path('upload/' . $path);
            if (!file_exists($base_path)) {
                mkdir($base_path, 666, true);
            }
            // Image::make($image)->insert(url('frontend/images/logo.webp'))->encode('webp', 100)->save($base_path.'/'.$name_gen);
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            // $image_url = 'upload/images/'.$path.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$name_gen;
            $image_url = 'upload/' . $path . '/' . $name_gen;
        }
        return $image_url;
    }
}
//custom fields
if (!function_exists('fieldsInsert')) {
    function fieldsInsert($module = '', $id = 0, $request = '')
    {
        $field = \App\Models\ConfigColum::select('keyword', 'type', 'id')->where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        if (!$field->isEmpty()) {
            foreach ($field as $item) {
                $keyword = $item->keyword;
                $keyword_convert = str_replace('-', '_', $keyword);
                switch ($item->type) {
                    case ('input'):
                        $meta_key = 'config_colums_input_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('textarea'):
                        $meta_key = 'config_colums_textarea_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('editor'):
                        $meta_key = 'config_colums_editor_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('select'):
                        $meta_key = 'config_colums_select_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('checkbox'):
                        $meta_key = 'config_colums_checkbox_' . $keyword_convert;
                        $meta_value = json_encode($request[$meta_key]);
                        break;
                    case ('radio'):
                        $meta_key = 'config_colums_radio_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                        break;
                    case ('json'):
                        $meta_key = 'config_colums_json_' . $keyword_convert;
                        $meta_value = json_encode($request[$meta_key]);
                        break;
                    default:
                        $meta_key = 'config_colums_input_' . $keyword_convert;
                        $meta_value = $request[$meta_key];
                }
                if (!empty($meta_value) && $meta_value != 'null') {
                    DB::table('config_postmetas')->insert([
                        'module_id' => $id,
                        'module' => $module,
                        'config_colums_id' => $item->id,
                        'meta_key' => $meta_key,
                        'meta_value' => $meta_value,
                        'created_at' => Carbon::now(),
                        'alanguage' => config('app.locale'),
                    ]);
                }
            }
        }
    }
}
