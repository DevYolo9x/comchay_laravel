<?php $dropdown = getFunctions(); ?>
<div id="menu-items">

    <div id="faq-accordion-2" class="accordion accordion-boxed">
        <?php
        if (in_array('products', $dropdown)) {
            $category_products = \App\Models\CategoryProduct::where('alanguage', config('app.locale'))->get();
            $products = \App\Models\Product::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('articles', $dropdown)) {
            $category_articles = \App\Models\CategoryArticle::where('alanguage', config('app.locale'))->get();
            $articles = \App\Models\Article::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('media', $dropdown)) {
            $category_media = \App\Models\CategoryMedia::where('alanguage', config('app.locale'))->get();
            $media = \App\Models\Media::where('alanguage', config('app.locale'))->get();
        }

        if (in_array('tours', $dropdown)) {
            $tour_categories = \App\Models\TourCategory::where('alanguage', config('app.locale'))->get();
            $tours = \App\Models\Tour::where('alanguage', config('app.locale'))->get();
        }
        if (in_array('briefing_categories', $dropdown)) {
            $briefing_categories = \App\Models\BriefingCategory::get();
        }
        $array = array(
            'category_products' => 'Danh mục sản phẩm',
            'products' => 'Sản phẩm',
            'category_articles' => 'Danh mục bài viết',
            'articles' => 'Bài viết',
            'category_media' => 'Danh mục media',
            'media' => 'Hình ảnh - video',
            'tour_categories' => 'Điểm đến',
            'tours' => 'Danh sách tour',
            'briefing_categories' => 'Danh mục giao ban',
        )
        ?>
        <?php $i = 0; ?>
        @foreach($array as $key => $value)
        <?php $i++; ?>
        <!-- Start: module -->
        @if(!empty($$key) && count($$key) > 0)
        <div class="accordion-item bg-white" style="padding: 10px 10px 11px 14px;">
            <div id="faq-accordion-content-<?php echo $i ?>" class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-<?php echo $i ?>" aria-expanded="false" aria-controls="faq-accordion-collapse-<?php echo $i ?>">{{$value}}</button>
            </div>
            <div id="faq-accordion-collapse-<?php echo $i ?>" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-<?php echo $i ?>" data-tw-parent="#faq-accordion-2">
                <div class="item-list-body" id="<?php echo $key ?>_box">
                    @foreach($$key as $v)
                    <p><input type="checkbox" class="<?php echo $key ?>" value="{{$v->id}}">
                        {{str_repeat('|----', (($v->level > 0) ? ($v->level - 1) : 0)) . $v->title;}}
                    </p>
                    @endforeach
                </div>
                @can('menus_create')
                <div class="flex mt-3">
                    <label class="btn btn-sm btn-default mr-2">
                        <input type="checkbox" name="clickAllMenu" class="hidden">&nbsp;<span>Chọn toàn bộ</span>
                    </label>
                    <button type="button" class="btn btn-sm btn-primary add-menu-item" data-module="<?php echo $key ?>">Thêm vào menu</button>
                </div>
                @endcan
            </div>
        </div>
        @endif
        <!-- end: module -->
        @endforeach
        <div class="accordion-item bg-white" style="padding: 10px 10px 11px 14px;">
            <div id="faq-accordion-content-5" class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="false" aria-controls="faq-accordion-collapse-5">Liên kết tự tạo
                </button>
            </div>
            <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                <div class="alert alert-danger p-2 mb-3" style="display: none;"></div>
                <div class="">
                    <div>
                        <label>Tiêu đề</label>
                        <input type="text" id="linktext" class="form-control" placeholder="">
                    </div>
                    <div class="mt-3">
                        <label>URL</label>
                        <input type="url" id="url" class="form-control" placeholder="https://">
                    </div>
                </div>
                @can('menus_create')
                <div class="mt-3">
                    <button type="button" class="pull-right btn btn-primary btn-sm" id="add-custom-link">Thêm vào
                        menu</button>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>