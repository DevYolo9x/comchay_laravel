<?php
$listType = json_decode($dataField->data, true);
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  '';
if ($errors->any()) {
    $content = old('config_colums_radio_' . $keyword_convert);
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
    <div class="flex flex-col">
        @if(!empty($listType))
        @if(!empty($listType['title']))
        @foreach ($listType['title'] as $key => $val)
        <label class="form-label">
            <input type="radio" name="config_colums_radio_<?php echo $keyword_convert ?>" value="<?php echo $val ?>" <?php if ($content == $val) { ?>checked<?php } ?>>
            <span><?php echo $val ?></span>
        </label>
        @endforeach
        @endif
        @endif

    </div>
</div>