<!--START: dropzone upload image -->
<label class="form-label text-base font-semibold">Album Ảnh</label>
<div class="dropzone dz-clickable" id="myDropzone">
    <div class="dz-message" data-dz-message="">
        <div class="text-lg font-medium">Drop files here or click to upload.</div>
        <div class="text-slate-500"> This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded. </div>
    </div>
</div>
@push('javascript')
<script src="{{asset('library/dropzone/dropzone.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('library/dropzone/dropzone.min.css')}}" type="text/css" />
<!-- sortable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script>
    $(function() {
        $("#myDropzone").sortable({
            items: '.dz-preview',
            cursor: 'move',
            opacity: 0.5,
            containment: '#myDropzone',
            distance: 20,
            tolerance: 'pointer'
        });
    })
</script>
<!-- end sortable -->
<script>
    Dropzone.autoDiscover = false;
    var acceptedFileTypes = ".jpeg,.jpg,.png,.gif";
    var fileList = new Array;
    var i = 0;
    var callForDzReset = false;
    $("#myDropzone").dropzone({
        url: "{{route('dropzone_upload')}}",
        addRemoveLinks: true,
        maxFiles: 100,
        acceptedFiles: 'image/*',
        maxFilesize: 5,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time + '-' + file.name;
        },
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        init: function() {
            @if($action == 'update')
            /*update load image*/
            myDropzone = this;
            $.ajax({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('dropzone_image')}}",
                type: 'post',
                data: {
                    id: "<?php echo $detail->id ?>",
                    module: "<?php echo $module ?>"
                },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(key, value) {
                        var mockFile = {
                            name: value.name,
                            size: value.size
                        };
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile, value.path);
                        myDropzone.emit("complete", mockFile);
                        $(".dz-image").eq(key).append(
                            '<input type="hidden" name="album[]" value="' +
                            value.name + '">')
                    });
                }
            });
            /*end:  update load image*/
            @endif
            /*thêm path image khi upload thành công */
            this.on("success", function(file, serverFileName) {
                $(file.previewTemplate).find('.dz-remove').attr('data-path', serverFileName);
                $(file.previewTemplate).find('.dz-image').append(
                    '<input type="hidden" name="album[]" value="' + serverFileName + '">')
                file.serverFn = serverFileName;
                fileList[i] = {
                    serverFileName
                };
                i++;
            });
            /*END: thêm path image khi upload thành công*/
        },
        removedfile: function(file) {
            if ($('.dz-preview').length === 1) {
                $('.dz-message').removeClass('hidden');
            } else {
                $('.dz-message').addClass('hidden');
            }
            /*var name = file.upload.filename;*/
            /*
            var name = file.serverFn;
            $.ajax({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                },
                type: 'POST',
                url: '{{ route("dropzone_delete") }}',
                data: {
                    filename: name
                },
                success: function(data) {
                    console.log("Delete image successfully uploaded");
                },
                error: function(e) {
                    console.log(e);
                }
            });
            */
            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file
                .previewElement) : void 0;
        },
    });
</script>
<style>
    .dropzone {
        min-height: 150px;
        border: 2px dashed rgb(226, 232, 240, 0.6);
        background: white;
        padding: 20px 20px;
    }

    .dz-image img {
        height: 120px;
        width: 120px;
        object-fit: cover;
    }
</style>
@endpush

<!-- end: dropzone upload image -->