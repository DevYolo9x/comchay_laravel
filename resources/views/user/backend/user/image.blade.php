<label class="form-label text-base font-semibold">Ảnh đại diện</label>
<div class="flex items-center space-x-3">
    @if($action == 'profile')
    <img src="{{!empty(Auth::user()->image)?url(Auth::user()->image):asset('images/404.png')}}" id="mainThmb-image"
        class="mb-3 w-44 h-44 rounded-full" style="height:176px;object-fit: cover;">
    <input type="hidden" name="image_old" value="{{!empty(Auth::user()->image)?Auth::user()->image:''}}">
    @endif
    @if($action == 'update')
    <img src="<?php echo !empty($detail->image) ? url($detail->image) : asset('images/404.png'); ?>" id="mainThmb-image"
        class="mb-3 w-44 h-44 rounded-full" style="height:176px;object-fit: cover;">
    <input type="hidden" name="image_old" value="<?php echo !empty($detail->image)? $detail->image : ''; ?>">
    @endif
    @if($action == 'create')
    <img src="<?php echo asset('images/404.png'); ?>" id="mainThmb-image" class="mb-3 w-44 h-44 rounded-full"
        style="height:176px;object-fit: cover;">
    @endif

    <div class="input-file-container">
        <input class="hidden input-file" id="my-image" onchange="mainThamUrl(this,'image')" name="image" type="file">
        <label class="btn btn-primary w-full mr-2 mb-2 input-file-trigger" for="my-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="image"
                data-lucide="image" class="lucide lucide-image w-4 h-4 mr-2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg> Select a file...
        </label>
        <p class="file-return"></p>
    </div>
</div>
@push('javascript')
<script>
/*lấy hình ảnh khi upload */
function mainThamUrl(input, image) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#mainThmb-' + image).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
/*lấy tên file khi upload ảnh xong*/
$('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.file-return').html('Select file image: ' + fileName);;
});
</script>
@endpush
