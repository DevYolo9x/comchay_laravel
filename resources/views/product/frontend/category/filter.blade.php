<?php
    // $brandFilter = Cache::remember('brandFilter', 60, function () {
    //     return ;
    // });
    $brandFilter = \App\Models\Brand::where(['publish' => 0,'alanguage'=> config('app.locale')])->select('id','title')->orderBy('order','asc')->orderBy('id','desc')->get();
?>
<div>
    <div class="flex items-center space-x-2 pb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
        </svg>
        <span class="font-bold text-gray-600">Bộ lọc</span>
    </div>
    <!-- THương hiệu -->
    @if (count($brandFilter) > 0)
    <div class="flex flex-col pb-6 ">
        <div class="w-full py-4">
            <div class="flex justify-between items-center ">
                <h4 class="text-xl font-medium">Thương hiệu</h4>
            </div>
        </div>
        <ol class="items flex flex-wrap gap-4">
            @foreach ($brandFilter as $key => $val)
            <li class="attr item px-4 py-2 text-center bg-white hover:bg-red-100 rounded-md cursor-pointer border">
                <input class="checkbox-item filter mr-2 input_attr hidden" type="checkbox" name="brands[]"
                    value="{{$val->id}}">
                <span>{{$val->title}}</span>
            </li>
            @endforeach
        </ol>
    </div>
    @endif

    @if (check_array($attribute_catalogue))
    @foreach ($attribute_catalogue as $key => $val)
    @if (count($val) > 1)
    <div class="flex flex-col pb-6 ">
        <div class="w-full py-4">
            <div class="flex justify-between items-center ">
                <h4 class="text-xl font-medium">{{$key}}</h4>
            </div>
        </div>
        <ol class="items flex flex-wrap gap-4" data-keyword="{{$val['keyword_cata']}}">
            @foreach ($val as $k => $v)
            @if($k != 'keyword_cata')
            <li class="attr item px-4 py-2 text-center bg-white hover:bg-red-100 rounded-md cursor-pointer border">
                <input class="checkbox-item filter mr-2 input_attr hidden" type="checkbox" name="attr[]" value="{{$k}}">
                <span>{{$v}}</span>
            </li>
            @endif
            @endforeach
        </ol>
    </div>
    @endif
    @endforeach
    @endif
    <input id="choose_attr" class="filter hidden" type="text" name="attr">
</div>
@push('javascript')
<script>
$(document).ready(function() {
    $(function() {
        $(document).on('change', '.SortBy', function() {
            var sort_by = $(this).val();
            window.location.href = "<?php echo $seo['canonical']?>?sort=" + sort_by;
        });
    });

    $(document).on('click', '.attr', function() {
        if ($(this).find('input.input_attr:checked').length) {
            $(this).find('input.input_attr').prop('checked', false);
            $(this).removeClass('checked');
        } else {
            $(this).find('input.input_attr').prop('checked', true);
            $(this).addClass('checked');
        }
        let attr = '';
        $('#selected_attr .listFilter').html('');
        $('input.input_attr:checked').each(function(key, index) {
            let id = $(this).val();
            let text = $(this).parent().find('span').text();
            $('#selected_attr .listFilter').append(
                '<span class="flex items-center p-2 rounded bg-red-100 del cursor-pointer" data-id="' +
                id + '"><span>' +
                text +
                '</span><button class="w-[20px] ml-3 h-5 rounded-full flex justify-center bg-red-200 items-center"><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4 text-gray-100\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path></svg> </button></span>'
            );
            $('#selected_attr').removeClass('hidden')
        });
        $('input[name="attr[]"]:checked').each(function(key, index) {
            let id = $(this).val();
            let text = $(this).parent().find('span').text();
            let attr_id = $(this).parent().parent().attr('data-keyword');
            attr = attr + attr_id + ';' + id + ';';
        });
        if ($('input.input_attr:checked').length > 0) {
            $('select[name="sortBy"]').removeClass('SortBy');
            $('select[name="sortBy"]').addClass('filter');
        } else {
            $('#selected_attr').addClass('hidden');
            $('select[name="sortBy"]').addClass('SortBy');
            $('select[name="sortBy"]').removeClass('filter');
        }
        $('#choose_attr').val(attr).change();
    })

    var time;
    $(document).on('keyup change', '.filter', function() {
        let page = $('.pagination .active span').text();
        $('#selected_attr').removeClass('hidden');
        time = setTimeout(function() {
            get_list_object(page);
        }, 500);
        return false;
    });
    $(document).on('click', '.pagination_custom .pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        get_list_object(page);
    });
    $(document).on('click', '#selected_attr .del', function() {
        let _this = $(this);
        let id = _this.attr('data-id');
        let attr = '';
        $('input.input_attr:checked').each(function(key, index) {
            let id_check = $(this).val();
            if (id == id_check) {
                $(this).prop('checked', false);
                $(this).parent().removeClass('checked');
                _this.remove();
            } else {
                let attr_id = $(this).parent().parent().attr('data-keyword');
                attr = attr + attr_id + ';' + id_check + ';';
            }
        });

        if ($('input.input_attr:checked').length > 0) {
            $('select[name="sortBy"]').removeClass('SortBy');
            $('select[name="sortBy"]').addClass('filter');
        } else {
            $('#selected_attr').addClass('hidden');
            $('select[name="sortBy"]').addClass('SortBy');
            $('select[name="sortBy"]').removeClass('filter');
        }
        $('#choose_attr').val(attr).change();
    })

    function get_list_object(page = 1) {
        var checked_brand = [];
        $('input[name="brands[]"]:checked').each(function() {
            checked_brand.push($(this).val());
        });
        // var brandChecked = checked_brand.join(',');
        let keyword = $('.keyword').val();
        let sort = $('select[name="sortBy"]').val();
        let attr = $('input[name="attr"]').val();
        let ajaxUrl = BASE_URL_AJAX + 'ajax/product/product-filter';
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                keyword: keyword,
                attr: attr,
                brand: checked_brand,
                sort: sort,
                page: page,
                catalogueid: <?php echo $detail->id?>
            },
            success: function(data) {
                let json = JSON.parse(data);
                $('#data_product').html(json.html);
                $('.total-ajax').text(json.total);
                $('html, body').animate({
                    scrollTop: $("#scrollTop").offset().top
                }, 300);
            }
        });
    }
});
</script>
@endpush
