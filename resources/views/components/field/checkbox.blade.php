<?php
$listType = json_decode($dataField->data, true);
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  [];
if ($errors->any()) {
    $content = old('config_colums_checkbox_' . $keyword_convert);
} else {
    if (!empty($detail)) {
        $ConfigPostmeta = \App\Models\ConfigPostmeta::select('meta_value')->where(['module_id' => $detail->id, 'module' => $module, 'config_colums_id' => $dataField->id])->first();
        if ($ConfigPostmeta) {
            $content = json_decode($ConfigPostmeta->meta_value, TRUE);
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
            <input type="checkbox" name="config_colums_checkbox_<?php echo $keyword_convert ?>[]" value="<?php echo $val ?>" {{ (collect($content)->contains($val)) ? 'checked':'' }}>
            <span><?php echo $val ?></span>
        </label>
        @endforeach
        @endif
        @endif

    </div>
</div>