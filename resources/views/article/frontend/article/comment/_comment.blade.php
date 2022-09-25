<?php
    $list_images_cmt = [];
    foreach ($comment_view['listComment'] as $v) {
        if (!empty($v->images)) {
            $tmp_images_cmt = json_decode($v->images, TRUE);
            if (!empty($tmp_images_cmt)) {
                foreach ($tmp_images_cmt as $v) {
                    $list_images_cmt[] = $v;
                }
            }
        }
    }
?>
<?php
$totalComment = $averagePoint= 0;
if (isset($comment_view) && is_array($comment_view) && count($comment_view)) {
    $averagePoint = round($comment_view['averagePoint']);
    $totalComment = $comment_view['totalComment'];

}
?>
<style>
.input-group {
    display: flex;
    align-items: center;
}

.btn {
    display: inline-flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    border-width: 1px;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    font-weight: 500;
    transition-duration: 200ms;
    background-color: #2db2ff;
    height: 44px;
    border: 0px;
    display: flex;
    align-items: center;
    color: #fff;
    border-radius: 4px !important;
}

.btn i {
    color: #fff;

}

.btn span {
    color: #fff;
    margin-left: 5px
}

.input-group-btn {
    margin-bottom: 0px;
    width: 200px;
    position: absolute;
}

#my-image,
#my-image-sub {
    display: none;
}

#valueImageAvatar,
#valueImageAvatarSub {
    cursor: no-drop;
    padding-left: 210px;
    background: transparent;
}
</style>
<form method="post" class="comment clearfix" id="form-comment" style="margin-bottom: 10px;">
    <div class="title clearfix">
        <h3 class="pull-left">{{count($detail->comments)}} Comment</h3>
        <?php /*<ul class="nav nav-tabs pull-right">
            <li class="active"><a>Hot</a></li>
            <li><a>Fresh</a></li>
        </ul>*/?>
    </div>
    <div class="tab-content">
        <div class="error_comment" style="margin-bottom:0px">
            <div class="alert alert-success" style="display: none">
                <p class="js_text_success" style="margin:0px"></p>
            </div>
            <div class="alert alert-danger" style="display: none">
                <p class="js_text_danger" style="margin:0px"></p>
            </div>
        </div>
        <div id="hot" class="tab-pane fade in active">
            <div class="image pull-left">
                <img src="{{asset('frontend/image/profile5.png')}}" alt="" class="img-responsive img-responsive-result"
                    style="width:50px;height:50px;object-fit: cover;    border-radius: 4px;"></img>
            </div>
            <div class="content-right">
                <div class="flex-comment">
                    <input name="fullname" type="text" class="input-block-level" placeholder="Your name*">
                    <input name="email" type="text" class="input-block-level" placeholder="Your phone*">
                </div>
                <textarea name="message" placeholder="Write comment..." id="comment" class="input-block-level" rows="3"
                    tabindex="4" aria-required="true"></textarea>
                <div class="flex-bottom" style="display: flex;justify-content: space-between;">
                    <!-- upload image -->
                    <div class="input-group" style="position: relative;grid-template-columns: auto;">
                        <label for="my-image" class="input-group-btn">
                            <span class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> <span>Upload avatar</span>
                            </span>
                        </label>
                        <input type="text" id="valueImageAvatar" disabled>
                        <input id="my-image" class="form-control" type="file" name="filepath"
                            onchange="mainThamUrl(this)">
                    </div>
                    <!-- end: upload image -->
                    <input name="submit" type="submit" id="form-comment-submit" class="submit pull-right"
                        value="comment">
                </div>
            </div>
        </div>

    </div>
</form>
<div class="tour-review" style="padding-top:0px">
    <div class="comment clearfix" style="padding-top:30px" id="getListCommentArticle">
        @include('article.frontend.article.comment._data')
    </div>
</div>

@push('javascript')
<script>
/*lấy tên file khi upload ảnh xong*/
function mainThamUrl(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.img-responsive-result').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$('#my-image').change(function(e) {
    var fileName = e.target.files[0].name;
    console.log(fileName);
    $('#valueImageAvatar').val(fileName);;
});
/*end*/
/*START: submit comment*/
$('#form-comment-submit').click(function(e) {
    e.preventDefault();
    var fullname = $('#form-comment input[name="fullname"]').val();
    var email = $('#form-comment input[name="email"]').val();
    var message = $('#form-comment textarea[name="message"]').val();
    var module_id = "{{$detail->id}}";
    var avatar = $("#my-image")[0].files[0];
    let form = new FormData();
    form.append('fullname', fullname);
    form.append('email', email);
    form.append('message', message);
    form.append('module_id', module_id);
    form.append('avatar', avatar);
    $.ajax({
        type: 'POST',
        url: "<?php echo route('commentFrontend.postArticle') ?>",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        success: function(responsive) {
            if (responsive == 200) {
                $('.error_comment .alert-danger').hide();
                $('.error_comment .alert-success').show();
                $('.error_comment .js_text_success').html("Successfully!");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                $('.error_comment .alert-danger').show();
                $('.error_comment .alert-success').hide();
                $('.error_comment .js_text_danger').html("ERROR");
            }
        },
        error: function(jqXhr, json, errorThrown) {
            // this are default for ajax errors
            var errors = jqXhr.responseJSON;
            $('.error_comment .alert-danger').show();
            var errorsHtml = "";
            $.each(errors.errors, function(index, value) {
                errorsHtml += value + "/ ";
            });
            if (errorsHtml.length > 0) {
                $('.error_comment .js_text_danger').html(errorsHtml);
            } else {
                $('.error_comment .js_text_danger').html(errors.message);
            }
        },


    });

});
/*END: submit comment*/
/*comment reply*/
$(document).on('click', '.handleReply', function(e) {
    e.preventDefault();
    let _this = $(this);
    let text = _this.text();
    if (text == "Leave comments") {
        _this.parent().find('.reply-comment').html('');
        _this.html('Reply');
    } else {
        let param = {
            'parentid': _this.attr('data-id'),
            'name': _this.attr('data-name'),
        };
        let reply = get_comment_html(param);
        $('.reply-comment').html('');
        $('.js_btn_reply').html('Reply');
        _this.parent().find('.reply-comment').html(reply);
        _this.attr('data-comment', 0);
        _this.html('Leave comments');
    }

});

function get_comment_html(param = '') {
    let comment = '';
    comment += '<form action="">';
    comment += '<div class="reply_comment_error" style="margin-bottom:0px">';
    comment += '<div class="alert alert-success" style="display: none">';
    comment += '<p class="js_text_success" style="margin:0px"></p>';
    comment += '</div>';
    comment += '<div class="alert alert-danger" style="display: none">';
    comment += '<p class="js_text_danger" style="margin:0px"></p>';
    comment += '</div>';
    comment += '</div>';
    comment += '<div>';
    comment += '<input type="text" name="fullname" class="fullname_reply_cmt" placeholder="Name *">';
    comment += '<input type="text" name="email" class="email_reply_cmt" placeholder="Email *">';
    comment += '</div>';
    comment +=
        '<div style="position: relative;grid-template-columns: auto;"><textarea name="message" class="message_reply_cmt" cols="30" rows="8" placeholder="Your review *"></textarea></div>';
    comment += '<div class="input-group" style="position: relative;grid-template-columns: auto;">';
    comment += '<label for="my-image-sub" class="input-group-btn" style="position: absolute;">';
    comment += '<span class="btn btn-primary" >';
    comment += '<i class="fa fa-picture-o"></i> <span style="color: #fff;">Upload avatar</span>';
    comment += '</span>';
    comment += '</label>';
    comment += '<input type="text" id="valueImageAvatarSub" disabled>';
    comment += '<input id="my-image-sub" class="form-control" type="file" name="filepathSub">';
    comment += '</div>';


    comment += '<input type="submit" class="js_reply_comment_submit" value="Reply comment" data-parent-id="' + param
        .parentid +
        '">';
    comment += '</form>';
    return comment;
}
$(document).on('change', '#my-image-sub', function(e) {
    var fileName = e.target.files[0].name;
    console.log(fileName);
    $('#valueImageAvatarSub').val('Select file image: ' + fileName);;
});
$(document).on('click', '.js_reply_comment_submit', function(e) {
    e.preventDefault(e);
    var parent_id = $(this).attr('data-parent-id');
    let fullname = $('.fullname_reply_cmt').val();
    let email = $('.email_reply_cmt').val();
    let message = $('.message_reply_cmt').val();
    var avatar = $("#my-image-sub")[0].files[0];
    let form = new FormData();
    form.append('parent_id', parent_id);
    form.append('fullname', fullname);
    form.append('email', email);
    form.append('message', message);
    form.append('avatar', avatar);
    $.ajax({

        type: 'POST',
        url: "<?php echo route('replyComment.post') ?>",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        cache: false,
        contentType: false,
        processData: false,
        data: form,
        success: function(responsive) {
            if (responsive == 200) {
                $('.reply_comment_error .alert-danger').hide();
                $('.reply_comment_error .alert-success').show();
                $('.reply_comment_error .js_text_success').html("Successfully!");
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                $('.reply_comment_error .alert-danger').show();
                $('.reply_comment_error .alert-success').hide();
                $('.reply_comment_error .js_text_danger').html("ERROR!");
            }
        },
        error: function(jqXhr, json, errorThrown) {
            // this are default for ajax errors
            var errors = jqXhr.responseJSON;
            $('.reply_comment_error .alert-danger').show();
            var errorsHtml = "";
            $.each(errors.errors, function(index, value) {
                errorsHtml += value + "/ ";
            });
            if (errorsHtml.length > 0) {
                $('.reply_comment_error .js_text_danger').html(errorsHtml);
            } else {
                $('.reply_comment_error .js_text_danger').html(errors.message);
            }
        },
    });
    return false;
});
/*end*/

$(document).on('click', '.paginate_cmt a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var sort = 'id';
    get_list_object(page, sort, true);
});

function get_list_object(page = 1, sort = 'id', animate = true) {
    setTimeout(function() {
        $.post('<?php echo route('getListComment.frontendArticle') ?>', {
                page: page,
                module_id: '{{$detail->id}}',
                sort: sort,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#getListCommentArticle').html(data);
                $('.lds-show').addClass('hidden');
                if (animate === true) {
                    $('html, body').animate({
                        scrollTop: $(".blog-comment").offset().top
                    }, 200);
                }

            }
        );
    }, 210);
}
</script>
@endpush