<div class=" box p-5 mt-3 pt-3">
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Quản lý thiết lập hiển thị</label>
        <div class="form-check">
            <input id="radio-switch-1" class="form-check-input" type="radio" name="publish" <?php echo (old('publish') == 0) ? 'checked' : ((isset($detail) && $detail->publish == 0) ? 'checked' : '') ?> value="0">
            <label class="form-check-label" for="radio-switch-1">Cho phép hiển thị trên website</label>
        </div>
        <div class="form-check mt-1">
            <input id="radio-switch-2" class="form-check-input" type="radio" name="publish" <?php echo (old('publish') == 1) ? 'checked' : ((isset($detail) && $detail->publish == 1) ? 'checked' : '') ?> value="1">
            <label class="form-check-label" for="radio-switch-2">Tắt chức năng hiển thị trên website.</label>
        </div>
    </div>
</div>