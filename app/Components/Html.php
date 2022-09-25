<?php

if (!function_exists('svl_ismobile')) {

    function svl_ismobile()
    {
        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
        );

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'is tablet';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'is mobile';
        } else {
            // do something for everything else
            return 'is desktop';
        }
    }
}
if (!function_exists('getFunctions')) {
    function getFunctions()
    {
        $data = [];
        $getFunctions = \App\Models\Permission::select('title')->where('publish', 0)->where('parent_id', 0)->get()->pluck('title');
        if (!$getFunctions->isEmpty()) {

            foreach ($getFunctions as $v) {
                $data[] = $v;
            }
        }
        return $data;
    }
}
if (!function_exists('htmlArticle')) {
    function htmlArticle($item = [], $viewed = 'lượt xem')
    {
        $html = '';
        $html .= '<div class="md:flex space-x-0 md:space-x-8 ">
        <div class="w-full md:w-[220px] overflow-hidden">
            <a href="' . route('routerURL', ['slug' => $item->slug]) . '">
                <img src="' . asset($item->image) . '" alt="' . $item->title . '"
                    class="w-full h-[223px] md:h-[160px] object-cover">
            </a>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-base text-c8252c mt-2 md:mt-0">
                <a href="' . route('routerURL', ['slug' => $item->slug]) . '"
                    class="hover:text-d61c1f">' . $item->title . '
                </a>
            </h3>
            <div class="flex items-center space-x-5 my-1">
                <div class="flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                    <span>
                        ' . $item->created_at . '
                    </span>

                </div>
                <div class="flex items-center space-x-1">
                    

                </div>

            </div>
            <div class="line-clamp line-clamp-3">
                ' . $item->description . '
</div>
</div>
</div>';
        return $html;
    }
}
if (!function_exists('htmlAddress')) {
    function htmlAddress($data = [])
    {
        $html = '';
        if (isset($data)) {
            foreach ($data as $k => $v) {
                $html .= ' <li class="showroom-item loc_link result-item" data-brand="' . $v->title . '"
    data-address="' . $v->address . '" data-phone="' . $v->hotline . '" data-lat="' . $v->lat . '"
    data-long="' . $v->long . '">
    <div class="heading" style="display: flex">

        <p class="name-label" style="flex: 1">
            <strong>' . ($k + 1) . '. ' . $v->title . '</strong>
        </p>
    </div>
    <div class="details">
        <p class="address" style="flex:1"><em>' . $v->address . '</em>
        </p>

        <p class="button-desktop button-view hidden-xs">
            <a href="javascript:void(0)" onclick="return false;">Tìm đường</a>
            <a class="arrow-right"><span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
        </p>
        <p class="button-mobile button-view visible-xs">
            <a target="_blank" href="https://www.google.com/maps/dir//' . $v->lat . ',' . $v->long . '">Tìm đường</a>
            <a class="arrow-right" target="_blank"
                href="https://www.google.com/maps/dir//' . $v->lat . ',' . $v->long . '"><span><i
                        class="fa fa-angle-right" aria-hidden="true"></i></span></a>
        </p>
    </div>
</li>';
            }
        }
        return $html;
    }
}
if (!function_exists('htmlItemCart')) {
    function htmlItemCart($k = '', $item = [])
    {
        $html = '';
        if (isset($item)) {
            $stock = '';
            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $options = !empty($item['options']) ? ' - ' . $item['options'] : '';
            if (!empty($options)) {
                $getVersionproduct = \App\Models\Products_version::select(
                    'id',
                    '_stock_status',
                    '_stock',
                    '_outstock_status'
                )->where('productid', $item['id'])->where('title_version', $item["options"])->first();
                if ($getVersionproduct['_stock_status'] == 1) {
                    if ($getVersionproduct['_outstock_status'] == 0) {
                        $stock = $getVersionproduct['_stock'];
                    }
                }
            } else {
                $product = \App\Models\Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->find($item['id']);
                if ($product->inventory == 1) {
                    if ($product->inventoryPolicy == 0) {
                        $stock = $product['inventoryQuantity'];
                    }
                }
            }
            $html .= '<tr class="cart_item" data-rowid="' . $k . '">
    <td class="w-32 p-3 border border-solid  text-center">
        <a href="' . url($slug) . '">
            <img src="' . $item['image'] . '" alt="' . $item['title'] . '"></a>
    </td>
    <td class="p-3 border border-solid  text-center">
        <a href="' . url($slug) . '" class="transition-all hover:text-orange">' . $item['title'] . '</a><br><span>' .
                $options . '</span>
    </td>
    <td class="p-3 border border-solid  text-center">
        <span><span>' . number_format($item['price'], 0, '.', ',') . ' VNĐ</span></span>
    </td>
    <td class="p-3 border border-solid  text-center">

        <div class="flex count border border-solid border-gray-300 p-2 h-11">
            <button class="decrement flex-auto w-5 leading-none cart-minus" aria-label="button"
                style="flex: auto;">-</button>
            <input type="number" min="1" max="' . $stock . '" step="1" value="' . $item['quantity'] . '"
                class="quantity__input flex-auto w-8 text-center focus:outline-none input-appearance-none card-quantity">
            <button class="increment flex-auto w-5 leading-none cart-plus" aria-label="button"
                style="flex: auto;">+</button>
        </div>
    </td>
    <td class="p-3 border border-solid  text-center"><span>' . number_format($item['price'] * $item['quantity'], 0, '.', ',')
                . ' VNĐ</span></td>
    <td class="p-3 border border-solid  text-center">

        <a href="javascript:void(0)" class="inline-block mx-1 text-d61c1f transition-all cart-remove"><svg
                xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg></a>
    </td>
</tr>';
        }
        return $html;
    }
}
if (!function_exists('htmlItemCartHeader')) {
    function htmlItemCartHeader($k = '', $item = [])
    {
        $html = '';
        if (isset($item)) {

            $slug = !empty($item['slug']) ? $item['slug'] : '';
            $options = !empty($item['options']) ? '-' . $item['options'] : '';
            $html .= '<li class="flex flex-wrap group mb-8" data-rowid="' . $k . '">
    <div class="mr-5 relative">
        <a href="' . $slug . '"><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" loading="lazy" width="90"
                height="100" /></a>
        <button
            class="absolute top-3 left-3 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all hover:text-orange cart-remove">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
    <div class="flex-1">
        <h4>
            <a class="font-light text-sm md:text-base text-dark hover:text-orange transition-all tracking-wide"
                href="' . $slug . '">' . $item['title'] . '' . $options . '</a>
        </h4>
        <span class="font-light text-sm text-dark transition-all tracking-wide">' . $item['quantity'] . ' x
            <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ' . '</span></span>
    </div>
</li>';
        }
        return $html;
    }
}
if (!function_exists('htmlItemProduct')) {
    function htmlItemProduct($k = '', $item = [], $type = 'ishome')
    {
        $html = '';
        $price = getPrice(array('price' => $item->price, 'price_sale' => $item->price_sale, 'price_contact' =>
        $item->price_contact));
        /*$version = getBlockAttr($item['version_json']);
        $count_version = !empty($version['version']) ? count($version['version']) : 0; */
        $html .= '<div class="product-item space-y-2 p-0 lg:p-3 px-3 mb-8">
    <div class="product-img relative overflow-hidden">
        <a href="' . route('routerURL', ['slug' => $item->slug]) . '"><img
                id="' . $item->catalogueid . '' . $type . '-tab' . $item->id . '" class="w-full object-cover"
                src="' . asset($item->image) . '" alt="' . $item->title . '"></a>';
        if (!empty($price['percent'])) {
            $html .= '<span
            class="tag-percent absolute rounded-full w-10 h-10 bg-d61c1f text-white top-1 left-1 text-center text-sm">-' . $price['percent'] . '</span>';
        }
        $html .= '<div class="product-actions">
            <div class="flex justify-center">
                <button type="button"
                    class="btnQuickView quick-view-modal bg-black hover:bg-d61c1f text-white font-bold p-2 rounded"
                    data-id="' . $item->id . '">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                <a href="' . route('routerURL', ['slug' => $item->slug]) . '"
                    class="btnAddToCart bg-black hover:bg-d61c1f text-white font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="product-title">
        <h3 class="font-medium text-center">
            <a href="' . route('routerURL', ['slug' => $item->slug]) . '" class="hover:text-d61c1f">' . $item->title . '</a>
        </h3>
    </div>
    <div class="product-price flex justify-center items-center">';
        $html .= '<span
            class="current-price text-d61c1f md:text-lg mr-1 font-semibold">' . $price['price_final'] . '</span>';
        if (!empty($price['price_old'])) {
            $html .= '<del class="original-price"><s>' . $price['price_old'] . '</s></del>';
        }
        $html .= '</div>
    <div class="list-variants-img hidden lg:block">
        <ul class="text-center">';
        if (count($item->products_versions) > 0) {
            foreach ($item->products_versions as $val) {
                if (!empty($val->image_version)) {
                    $html .= '<li>
                <a class="variant-image-loop" data-feature-image="' . $item->catalogueid . '' . $type . '-tab' . $item->id . '"
                    href="" title="" data-img="' . url($val->image_version) . '">
                    <img src="' . url($val->image_version) . '" alt="' . $val->title_version . '">
                </a>
            </li>';
                }
            }
        }
        $html .= '</ul>
    </div>
</div>';
        return $html;
    }
}

if (!function_exists('htmlItemTour')) {
    function htmlItemTour($k = '', $item = [])
    {
        $html = '';
        $infoTour = json_decode($item->infoTour, TRUE);
        $price = getPrice(array('price' => $item->price, 'price_sale' => $item->price_sale, 'price_contact' =>
        $item->price_contact));
        $image = !empty($item->image) ? $item->image : 'images/404.png';
        $rate = (int)$item->rate * 20;
        $style2 = !empty($item->isfooter) ? 'style2' : '';
        $html .= '<div class="item-inner">
    <div class="transition product-layout">
        <div class="product-item-container ">
            <div class="item-block so-quickview">
                <div class="image">
                    <a href="' . route('routerURL', ['slug' => $item->slug]) . '" target="_self">';
        if (!empty($item->image)) {

            $html .= '<img src="' . asset($image) . '" alt="' . $item->title . '"
                            class="img-responsive img-responsive-custom">';
        } else {
            $html .= '<img src="' . asset('images/404.png') . '" alt="' . $item->title . '"
                            class="img-responsive img-responsive-custom">';
        }
        $html .= '</a>';
        if (!empty($item->isfooter)) {
            $html .= '<span class="label-hot"><i class="fa fa-fire" aria-hidden="true"></i>Hot tour</span>';
        }

        if ($item->rate == 4 || $item->rate == 5) {
            $html .= '<span class="label-rate ' . $style2 . '"><i class="fa fa-star" aria-hidden="true"></i>high
                        rate</span>';
        }
        $html .= '
                </div>
                <div class="item-content clearfix">
                    <h3><a href="' . route('routerURL', ['slug' => $item->slug]) . '">' . $item->title . '</a></h3>
                    <div class="reviews-content">
                        <div class="star">
                            <span style="width: ' . $rate . 'px"></span>
                        </div>
                        <a href="' . route('routerURL', ['slug' => $item->slug]) . '" class="review-link"
                            rel="nofollow">(' . count($item->comments) . ' reviews)</a>
                    </div>
                    <ul>
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $item->getCategory->title . '</li>';
        if (!empty($infoTour) && !empty($infoTour[0])) {
            $html .= '<li><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $infoTour[0] . '</li>';
        }
        if (!empty($infoTour) && !empty($infoTour[0])) {
            $html .= '<li><i class="fa fa-user-circle" aria-hidden="true"></i> ' . $infoTour[1] . '</li>';
        }
        $html .= '
                    </ul>
                    <div class="item-bot clearfix">
                        <div class="price pull-left">
                            from <label>' . $price['price_final'] . '</label><span>person</span>
                        </div>
                        <a href="' . route('routerURL', ['slug' => $item->slug]) . '" class="book-now pull-right">Book
                            now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
        return $html;
    }
}
if (!function_exists('htmlItemTourCategory')) {
    function htmlItemTourCategory($k = '', $item = [])
    {
        $html = '';
        $infoTour = json_decode($item->infoTour, TRUE);
        $price = getPrice(array('price' => $item->price, 'price_sale' => $item->price_sale, 'price_contact' =>
        $item->price_contact));
        $style2 = !empty($item->isfooter) ? 'style2' : '';
        $rate = ($item->rate * 20) . '%';
        $html .= '<div class="product-layout col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <div class="product-item-container item">
        <div class="item-block so-quickview">
            <div class="image">
                <a href="' . route('routerURL', ['slug' => $item->slug]) . '" target="_self">';
        if (!empty($item->image)) {
            $html .= '<img src="' . asset($item->image) . '" alt="' . $item->title . '"
                        class="img-responsive img-tour-custom">';
        } else {
            $html .= '<img src="' . asset('images/404.png') . '" alt="' . $item->title . '"
                        class="img-responsive img-tour-custom">';
        }
        $html .= '</a>';
        if (!empty($item->isfooter)) {
            $html .= '<span class="label-hot"><i class="fa fa-fire" aria-hidden="true"></i>Hot tour</span>';
        }
        if ($rate > 4) {
            $html .= '<span class="label-rate ' . $style2 . '"><i class="fa fa-star" aria-hidden="true"></i>high
                    rate</span>';
        }
        $html .= '
            </div>
            <div class="item-content clearfix">
                <h3><a href="' . route('routerURL', ['slug' => $item->slug]) . '">' . $item->title . '</a>
                </h3>
                <div class="reviews-content">
                    <div class="star">
                        <span style="width: ' . $rate . '"></span>
                    </div>
                    <a href="' . route('routerURL', ['slug' => $item->slug]) . '" class="review-link"
                        rel="nofollow">(' . count($item->comments) . ' reviews)</a>
                </div>
                <ul>
                    <li><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $item->getCategory->title . '</li>';
        if (!empty($infoTour) && !empty($infoTour[0])) {
            $html .= '<li><i class="fa fa-clock-o" aria-hidden="true"></i> ' . $infoTour[0] . '</li>';
        }
        if (!empty($infoTour) && !empty($infoTour[0])) {
            $html .= '<li><i class="fa fa-user-circle" aria-hidden="true"></i> ' . $infoTour[1] . '</li>';
        }
        $html .= '
                </ul>
                <div class="des des-2-overflow">' . strip_tags($item->description) . '</div>
                <div class="item-bot">
                    <div class="price pull-left">
                        from <label>' . $price['price_final'] . '</label>';
        if (!empty($price['price_old'])) {

            $html .= '<del>' . $price['price_old'] . '</del>';
        }


        $html .= '<span>person</span>
                    </div>
                    <a href="' . route('routerURL', ['slug' => $item->slug]) . '" class="book-now last:pull-right">Book
                        now</a>
                </div>
            </div>
        </div>
    </div>
</div>';
        return $html;
    }
}
if (!function_exists('htmlSize')) {
    function htmlSize($val = [], $product_image = '')
    {
        $html = '';
        $disabled = '';
        $stock = $val['_stock'];
        if ($val['_stock_status'] == 1) {
            if ($val['_outstock_status'] == 0) {
                if (empty($val['_stock'])) {
                    $disabled = 'disabled';
                }
            }
        }
        if ($val['_stock_status'] == 0) {
            if ($val['_outstock_status'] == 1) {
                if (empty($val['_stock'])) {
                    $stock = '';
                }
            }
        }
        if (!empty($disabled)) {
            $class = $disabled;
        } else {
            $class = 'sizes hover:border-d61c1f hover:text-d61c1f cursor-pointer';
        }
        $title = explode('/', $val['title_version']);
        if (!empty($title) && count($title) == 2) {
            $title = $title[1];
        } else {
            $title = $title[0];
        }
        if (!empty($val['image_version'])) {
            $image = $val['image_version'];
        } else {
            $image = $product_image;
        }

        $price = getPrice(array('price' => $val['price_version'], 'price_sale' => $val['price_sale_version'], 'price_contact' =>
        0));
        $html .= '<div data-image="' . $image . '" data-code="' . $val['code_version'] . '"
    class=" ' . $class . ' item px-3 py-2 mb-2 inline-block mr-2 border" data-title-version="' . $val['title_version'] . '"
    data-price-old="' . $price['price_old'] . '" data-price-final="' . $price['price_final'] . '"
    data-percent="' . $price['percent'] . '" data-price-cart="' . $price['price_final_none_format'] . '"
    data-stock="' . $stock . '">' . $title . '</div>';
        return $html;
    }
}
