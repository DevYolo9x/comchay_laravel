<!-- BEGIN: Data List -->

<div class="">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th style="width:40px;">
                    <input type="checkbox" id="checkbox-all">
                </th>
                <th>STT</th>
                <th style="width:300px;">Tiêu đề</th>
                <th>Giá</th>
                <th>Vị trí</th>
                <th>Ngày tạo</th>
                <th>Người tạo</th>
                <th>Hiển thị</th>
                @include('components.table.is_thead')
                <th class="whitespace-nowrap">#</th>
            </tr>
        </thead>
        <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
            @foreach($data as $v)
            <?php $getPrice = getPrice(array('price' => $v->price, 'price_sale' => $v->price_sale, 'price_contact' => $v->price_contact)); ?>
            <tr class="odd " id="post-<?php echo $v->id; ?>">
                <td>
                    <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                </td>
                <td>
                    {{$data->firstItem()+$loop->index}}
                </td>

                <td>
                    <div class="flex">
                        <div class="w-10 h-10 image-fit zoom-in mr-2">
                            @if(!empty($v->image))
                            <img class=" rounded-full" src="{{asset($v->image)}}">
                            @else
                            <img class=" rounded-full" src="{{asset('images/404.png')}}">
                            @endif
                        </div>
                        <div class="flex-1">
                            <a href="{{route('routerURL',['slug' => $v->slug])}}" target="_blank" class=" text-primary font-medium"><?php echo $v->title; ?></a>
                            <div class="list-catalogue">
                                @foreach($v->catalogues_relationships as $kc=>$c)
                                <a class="text-danger" href="{{route('products.index',['catalogue_id' => $c->id])}}"><?php echo !empty($kc == 0) ? '' : ',' ?>{{$c->title}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </td>
                <td class="">
                    <?php if ($getPrice['price_old']) { ?>
                        <old style="text-decoration: line-through;"><?php echo $getPrice['price_old'] ?><br></old>
                    <?php } ?>
                    <?php echo $getPrice['price_final'] ?>
                </td>
                @include('components.order',['module' => 'products'])
                <td>
                    @if($v->created_at)
                    {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                    @endif
                </td>
                <td>
                    {{$v->user->name}}
                </td>
                <td class="w-40">
                    @include('components.publishTable',['module' => 'products','title' => 'publish','id' =>
                    $v->id])
                </td>
                @include('components.table.is_tbody')
                <td class="table-report__action w-56 ">
                    <div class="flex justify-center items-center">
                        @can('products_create')
                        <a class="flex items-center mr-3" href="{{ route('products.copy',['id'=>$v->id]) }}">
                            <i data-lucide="file-minus" class="w-4 h-4 mr-1"></i> Copy
                        </a>
                        @endcan
                        @can('products_edit')
                        <a class="flex items-center mr-3" href="{{ route('products.edit',['id'=>$v->id]) }}">
                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                        </a>
                        @endcan
                        @can('products_destroy')
                        <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="products" data-child="0" data-title="Lưu ý: Khi bạn xóa bài viết, bài viết sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                        </a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
<div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
    {{$data->links()}}
</div>
<!-- END: Pagination -->