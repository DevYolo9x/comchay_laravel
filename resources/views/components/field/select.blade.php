<?php
$listType = json_decode($dataField->data, true);
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  '';
if ($errors->any()) {
    $content = old('config_colums_select_' . $keyword_convert);
} else {
    if (!empty($detail)) {
        $ConfigPostmeta = \App\Models\ConfigPostmeta::select('meta_value')->where(['module_id' => $detail->id, 'module' => $module, 'config_colums_id' => $dataField->id])->first();
        if ($ConfigPostmeta) {
            $content = $ConfigPostmeta->meta_value;
        }
    }
}
?>
<div class="mt-3 box p-5">
    <label class="form-label text-base font-semibold">{{$dataField->title}}</label>
    <select class="form-control w-full tom-select-custom tom-select tomselected" name="config_colums_select_<?php echo $keyword_convert ?>">
        <option value="">Chọn</option>
        @if(!empty($listType))
        @if(!empty($listType['title']))
        @foreach ($listType['title'] as $k => $val)
        <option value="<?php echo $val ?>" <?php if ($content == $val) { ?>selected<?php } ?>><?php echo $val ?></option>
        @endforeach
        @endif
        @endif
    </select>

</div>