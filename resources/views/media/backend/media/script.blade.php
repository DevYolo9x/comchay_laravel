@push('javascript')
<script>
function openKCFinderMedia(field, type) {
    window.KCFinder = {
        callBack: function(url) {
            field.value = url;
            window.KCFinder = null;
        }

    };
    if (typeof(type) == 'undefined') {
        type = 'images';
    }

    window.open(BASE_URL + 'library/kcfinder-3.12/browse.php?type=' + type + '&dir=images/public', 'kcfinder_image',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=1180, height=800'
    );
}
$(document).on('click', '.choose_video_type', function() {
    let _this = $(this);
    let value = _this.val();
    if (value == 1) {
        console.log(123);
        $('#video-link').attr('disabled', 'disabled').val('');
        $('#video-iframe').removeAttr('disabled');
    } else if (value == 0) {
        console.log(3);
        $('#video-iframe').attr('disabled', 'disabled').val('');
        $('#video-link').removeAttr('disabled');
    }


});
$(document).on('change', '.layout', function() {
    let _this = $(this);
    let catid = _this.val();
    media_loading(catid);
    return false;
});
$(document).ready(function() {
    if (typeof(layoutid) != 'undefined' && layoutid != '') {
        if (layoutid == 2) {
            $('.album').removeClass('hidden');
            if (post == 'post') {
                $('.upload-list').removeClass('hidden');
            }
            $('.video').addClass('hidden');
            $('.file-upload').addClass('hidden');
        } else if (layoutid == 1) {
            $('.video').removeClass('hidden');
            $('.album').addClass('hidden');
            $('.file-upload').addClass('hidden');

        } else if (layoutid == 3) {
            $('.file-upload').removeClass('hidden');
            $('.album').addClass('hidden');
            $('.video').addClass('hidden');
        }
    }
})

function media_loading(catalogueid = 0, post = '') {
    let _this = $(this);
    $.post(BASE_URL_AJAX + "media/get-select-type", {
            catalogueid: catalogueid,
            "_token": $('meta[name="csrf-token"]').attr("content"),
        },
        function(data) {
            if (data == 2) {
                $('.album').removeClass('hidden');
                if (post == 'post') {
                    $('.upload-list').removeClass('hidden');
                }
                $('.video').addClass('hidden');
                $('.file-upload').addClass('hidden');
            } else if (data == 1) {
                $('.video').removeClass('hidden');
                $('.album').addClass('hidden');
                $('.file-upload').addClass('hidden');

            } else if (data == 3) {
                $('.file-upload').removeClass('hidden');
                $('.album').addClass('hidden');
                $('.video').addClass('hidden');
            }
            $('input[name="layoutid"]').val(data);
        });
}
</script>
@endpush
