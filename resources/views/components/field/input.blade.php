<?php
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  '';
if ($errors->any()) {
    $content = old('config_colums_input_' . $keyword_convert);
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
    <label class="form-label text-base font-semibold"><?php echo $dataField->title ?></label>
    <input type="text" name="config_colums_input_<?php echo $keyword_convert ?>" value="<?php echo $content ?>" class="form-control mt-3" placeholder="<?php echo $dataField->title ?>">
</div>