<?php
namespace App\Components;
use View;
use Cache;
use Illuminate\Http\Request;

class System
{
    function fcSystem()
    {
            $fcSystem = [];
            $system = \App\Models\General::select('keyword','content','content_en')->get();
            if (isset($system)) {
                foreach ($system as $val) {
                    if(config('app.locale') == 'vi'){
                        $language = $val['content'];
                    }else{
                        $language = $val['content_en'];
                    }
                    $fcSystem[$val['keyword']] = $language;
                }
            }
            $segments = request()->segments();
            $last  = end($segments);
            $first = reset($segments);
            if($first == 'tag' || $first == 'thuong-hieu' || $first == 'destination'){
                $fcSystem['language_vi'] = route('components.language', ['vi']);
                $fcSystem['language_en'] = route('components.language', ['en']);
            }else{
                $fcSystem['language_vi'] = !empty($first)?asset('vi/'.$last):route('components.language', ['vi']);
                $fcSystem['language_en'] = !empty($first)?asset('en/'.$last):route('components.language', ['en']);
            }

            return $fcSystem;
    }

}