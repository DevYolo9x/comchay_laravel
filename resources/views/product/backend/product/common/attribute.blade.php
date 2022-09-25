<?php

if ($errors->any()) {
    $catalogue  = old('attribute_catalogue');
    $checkbox  = old('checkbox_val');
    $attribute = old('attribute');
    /*version product */
    $id_version = old('id_version');
    $title_version = old('title_version');
    $image_version = old('image_version');
    $code_version = old('code_version');

    $_stock_status = old('_stock_status');
    $_stock = old('_stock');
    $_outstock_status =  old('_outstock_status');

    $price_version =  old('price_version');
    $price_sale_version =  old('price_sale_version');
    $status_version =  old('status_version');
} else if ($action == 'update') {
    $version_json = json_decode(base64_decode($detail->version_json), true);
    $checkbox = $version_json[0];
    $catalogue  = $version_json[1];
    $attribute = $version_json[2];
    /*version product */
    if ($detail->products_versions) {
        foreach ($detail->products_versions as $key => $val) {
            $id_version[] = $val['id_version'];
            $title_version[] = $val['title_version'];
            $image_version[] = $val['image_version'];
            $code_version[] = $val['code_version'];

            $_stock_status[] = $val['_stock_status'];
            $_stock[] = $val['_stock'];
            $_outstock_status[] = $val['_outstock_status'];

            $price_version[] =  number_format($val['price_version'], '0', ',', '.');
            $price_sale_version[] =  number_format($val['price_sale_version'], '0', ',', '.');
            $status_version[] = $val['status_version'];
        }
    }
}
if (isset($title_version)) {
    $version = count($title_version);
} else {
    $version = 0;
}
?>
<div class=" box p-5 mt-3 space-y-3">
    <div>
        <label class="form-label text-base font-semibold">Bộ lọc sản phẩm</label>
    </div>
    <div class="ibox mb-5 block-version <?php if (!in_array('attribute', $dropdown)) { ?>hidden<?php } ?>" data-countattribute_catalogue="<?php echo count($htmlAttribute) - 1 ?>">
        <div class="ibox-title">
            <div class="grid grid-cols-3 justify-between text-base  items-center">
                <div class="col-span-2">
                    <h5>Chọn bộ lọc thuộc tính cho sản phẩm</h5>
                    <small class="text-danger mt-3 ">Sản phẩm có các phiên bản dựa theo thuộc tính như kích thước
                        hoặc
                        màu sắc,...?(chọn tối đa 2 )</small>
                </div>
                <div class="text-right">
                    <a class="show-version btn btn-danger" href="" <?php echo (!empty($catalogue)) ? 'style="display:none"' : '' ?>>Thêm mới</a>
                    <a class="hide-version  btn btn-danger" href="" <?php echo (!empty($catalogue)) ? '' : 'style="display:none"' ?>>
                        Đóng
                    </a>
                </div>
            </div>
        </div>
        <div class="ibox-content mt-5" style="background: #f5f6f7; <?php echo (!empty($catalogue)) ? '' : 'display:none"' ?>">
            <div class="block-attribute">
                <div class="mb-3 overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="">Sản phẩm biến thể</td>
                                <td style="width: 30%;">Tên thuộc tính</td>
                                <td style="width: 50%;">Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy)</td>
                                <td style="width: 10%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($catalogue)) { ?>
                                <?php foreach ($catalogue as $key => $value) {
                                    if (isset($attribute_json[$key])) { ?>
                                        <tr data-id="<?php echo $value ?>" <?php echo (isset($checkbox[$key]) && $checkbox[$key] == 1) ? 'class="bg-choose"' : '' ?>>
                                            <td class="" data-index="<?php echo $key ?>">
                                                <?php if (isset($checkbox[$key]) && $checkbox[$key] == 1) { ?>
                                                    <input type="checkbox" checked name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="1" class="hidden">
                                                    <div for="" class="label-checkboxitem checked"></div>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="0" class="hidden">
                                                    <div for="" class="label-checkboxitem "></div>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <select class="form-control select3" name="attribute_catalogue[]" tabindex="-1" aria-hidden="true">
                                                    @foreach($htmlAttribute as $k=>$v)
                                                    <option value="{{$k}}" {{ $value == $k ? 'selected' : ''  }}>{{$v}}</option>
                                                    @endforeach
                                                </select>

                                            </td>
                                            <td>
                                                <?php if ($value == 0) { ?>
                                                    <input type="text" class="form-control" disabled="disabled">
                                                <?php } else { ?>
                                                    <select name="attribute[<?php echo $key ?>][]" data-stt="{{$key}}" data-json="<?php echo (isset($attribute_json[$key])) ? base64_encode(json_encode($attribute_json[$key])) : '' ?>" data-condition="<?php echo $value ?>" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes" style="width: 100%;">
                                                    </select>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a type="button" class="text-danger delete-attribute" data-id="">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between" style="padding: 0px 20px 10px 20px;">
                    <a href="javascript:void(0)" data-attribute="<?php echo base64_encode(json_encode($htmlAttribute)) ?>" class="btn btn-danger add-attribute" data-id=""><i class="fa fa-plus"></i> Thêm thuộc
                        tính cho sản phẩm
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <div class="sortable" id="table_version" <?php if ($version <= 0) { ?>style="display:none" <?php } ?>>

                    <?php if ($version > 0) { ?>
                        <?php foreach ($title_version as $key => $value) { ?>
                            <div class="mb-2 dd3-content ">
                                <div class="hidden">
                                    <input type="text" name="id_version[]" value="<?php echo $id_version[$key] ?>">
                                    <input type="text" name="title_version[]" readonly="" value="<?php echo $title_version[$key] ?>" class="form-control" autocomplete="off">
                                </div>
                                <div class="relative">
                                    <div class="form-label mb-0 accordion w-full cursor-pointer">
                                        <?php $title_v = explode('/', $title_version[$key]); ?>
                                        <?php if (!empty($title_v)) { ?>
                                            <?php foreach ($title_v as $k => $v) { ?>
                                                <?php if ($k == 0) { ?>
                                                    <input type="hidden" name="title_version_1[]" value="{{$v}}">
                                                    <span class="text-xs whitespace-nowrap text-pending bg-pending/20 pending  pending-primary/20 rounded-full px-2 py-1 {{slug($v)}}">{{$v}}
                                                    </span>
                                                <?php } else { ?>
                                                    <input type="hidden" name="title_version_2[]" value="{{$v}}">
                                                    <span class="text-xs whitespace-nowrap text-success bg-success/20 pending  pending-success/20 rounded-full px-2 py-1 {{slug($v)}}">{{$v}}
                                                    </span>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <a href="javascript:void(0)" class="text-danger version_remove" data-number="1">Xóa</a>
                                </div>
                                <div class="version_item_size hidden">
                                    <div class="grid grid-cols-2 gap-6 mt-3">
                                        <div class="">
                                            <label class="form-label">Hình ảnh</label>
                                            <div class="flex items-center space-x-3">
                                                <div class="avatar" style="cursor: pointer;flex:none">
                                                    <img src="<?php echo !empty($image_version[$key]) ? $image_version[$key] : url('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">
                                                </div>
                                                <input type="text" name="image_version[]" style="cursor: not-allowed;opacity: 0.56;" value="<?php echo $image_version[$key] ?>" class="form-control" placeholder="Đường dẫn của ảnh" autocomplete="off">
                                            </div>
                                        </div>
                                        <div><label class="form-label">Mã sản phẩm</label><input type="text" name="code_version[]" value="<?php echo $code_version[$key] ?>" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6 mt-3">
                                        <div>
                                            <label class="form-label">Giá</label>
                                            <input type="text" value="<?php echo  $price_version[$key] ?>" name="price_version[]" class="form-control int price" placeholder="">
                                        </div>
                                        <div class="">
                                            <label class="form-label">Giá ưu đãi</label>
                                            <input type="text" value="<?php echo $price_sale_version[$key] ?>" name="price_sale_version[]" class="form-control int price" placeholder="">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h2 class="font-medium text-base mr-auto">Quản lý tồn kho</h2>
                                        <div class="mt-3">
                                            <div class="form-switch">
                                                <select class="form-select selectStock" name="_stock_status[]">
                                                    <option value="1" @if($_stock_status[$key]==1) selected @endif>Có quản lý
                                                        tồn kho</option>
                                                    <option value="0" @if($_stock_status[$key]==0) selected @endif>Không quản
                                                        lý
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="showStock @if($_stock_status[$key]==0) hidden @endif">
                                            <div class="mt-3">
                                                <label class="form-label">Số lượng trong kho</label>
                                                <input type="number" name="_stock[]" min="0" class="form-control" placeholder="" value="<?php echo !empty($_stock[$key]) ? $_stock[$key] : '' ?>">
                                            </div>
                                            <div class="mt-3">
                                                <div class="form-switch">
                                                    <label class="form-label">Đặt hàng khi đã hết hàng</label>
                                                    <select class="form-select" name="_outstock_status[]">
                                                        <option value="0" @if($_outstock_status[$key]==0) selected @endif>Không
                                                            cho đặt hàng khi hết hàng</option>
                                                        <option value="1" @if($_outstock_status[$key]==1) selected @endif>Đồng
                                                            ý
                                                            cho đặt hàng khi đã hết hàng
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>