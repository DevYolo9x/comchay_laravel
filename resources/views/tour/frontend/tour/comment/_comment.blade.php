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

$arrayRate5 = $arrayRate4 = $arrayRate3 = $arrayRate2 = $arrayRate1 = 0;
$arrayRate5PT = $arrayRate4PT = $arrayRate3PT = $arrayRate2PT = $arrayRate1PT = 0;
if (isset($comment_view) && is_array($comment_view) && count($comment_view)) {
    $averagePoint = round($comment_view['averagePoint']);
    $totalComment = $comment_view['totalComment'];
    $arrayRate5 = $comment_view['arrayRate'][5];
    if ($arrayRate5 > 0) {
        $arrayRate5PT = ($arrayRate5 / $totalComment) * 100;
    }
    $arrayRate4 = $comment_view['arrayRate'][4];
    if ($arrayRate4 > 0) {
        $arrayRate4PT = ($arrayRate4 / $totalComment) * 100;
    }
    $arrayRate3 = $comment_view['arrayRate'][3];
    if ($arrayRate3 > 0) {
        $arrayRate3PT = ($arrayRate3 / $totalComment) * 100;
    }
    $arrayRate2 = $comment_view['arrayRate'][2];
    if ($arrayRate2 > 0) {
        $arrayRate2PT = ($arrayRate2 / $totalComment) * 100;
    }
    $arrayRate1 = $comment_view['arrayRate'][1];
    if ($arrayRate1 > 0) {
        $arrayRate1PT = ($arrayRate1 / $totalComment) * 100;
    }
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
    height: 35px;
    border: 0px;
    display: flex;
    align-items: center;
    color: #fff;
    border-radius: 17px !important;
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

.flex-bottom {
    display: flex;
    justify-content: space-between;
}

@media (max-width: 767px) {
    .flex-bottom {
        display: block;
    }

    .tour-review form .content-right input[type="submit"] {
        float: left;
        width: 201px;
        margin-top: 20px;
    }

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
    padding-top: 0px;
    padding-bottom: 0px;
}

.arrayRate5::before {
    width: <?php echo $arrayRate5PT ?>%;

}

.arrayRate4::before {
    width: <?php echo $arrayRate4PT ?>%;

}

.arrayRate3::before {
    width: <?php echo $arrayRate3PT ?>%;

}

.arrayRate2::before {
    width: <?php echo $arrayRate2PT ?>%;

}

.arrayRate1::before {
    width: <?php echo $arrayRate1PT ?>%;

}

#menu4 .flex-comment {
    display: flex;
    width: 100%;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
}

#menu4 .flex-comment input {
    font-size: 16px;
    color: #909090;
    width: 100%;
    border: 1px #dedede solid;
    background: #f8f8f8;
    border-radius: 4px;
}

.rating-symbol {
    margin-left: 2px
}

.fa.fa-star-o,
.fa.fa-star {
    color: #FFD52E !important;
    font-size: 16px
}

.write-review__stars .fa-star,
.write-review__stars .fa-star-o {
    font-size: 40px;
    margin: 0px 5px;
}
</style>


<div id="menu4" class="tour-review">
    <h3>Review</h3>
    <form method="post" class="clearfix" id="form-comment">
        <div class="image">
            <img src="{{asset('frontend/image/profile.png')}}" alt="" class="img-responsive img-responsive-result"
                style="width:60px;height:60px;object-fit: cover;border-radius: 100%;"></img>
        </div>
        <div class="content-right">
            <div class="error_comment" style="grid-template-columns: auto;">
                <div class="alert alert-success" style="display: none;">
                    <p class="js_text_success" style="margin-bottom: 0px"></span>
                </div>
                <div class="alert alert-danger" style="display: none;">
                    <p class="js_text_danger" style="margin-bottom: 0px"></span>
                </div>
            </div>
            <div class="rate">
                <label>Your rate:</label>
                <input type="hidden" class="rating-disabled" value="5" name="rating" />
            </div>
            <div class="flex-comment">
                <input name="fullname" type="text" class="input-block-level" placeholder="Your name*">
                <input name="email" type="text" class="input-block-level" placeholder="Your phone*">
            </div>
            <textarea name="message" placeholder="What are you thoughts about this tour?" id="comment"
                class="input-block-level" rows="4" tabindex="4" aria-required="true"></textarea>

            <div class="flex-bottom" style="">
                <!-- upload image -->
                <div class="input-group" style="position: relative;grid-template-columns: auto;">
                    <label for="my-image" class="input-group-btn">
                        <span class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> <span>Upload avatar</span>
                        </span>
                    </label>
                    <input type="text" id="valueImageAvatar" disabled>
                    <input id="my-image" class="form-control" type="file" name="filepath" onchange="mainThamUrl(this)">
                </div>
                <!-- end: upload image -->
                <input name="submit" type="submit" id="form-comment-submit" class="submit" value="Send Review">
            </div>

        </div>
    </form>
    <div class="comment clearfix" id="getListCommentTour">

        @include('tour.frontend.tour.comment._data')

    </div>
</div>
@push('javascript')
<script type="text/javascript" src="{{asset('product/rating/bootstrap-rating.min.js')}}"></script>
<link href="{{asset('product/rating/bootstrap-rating.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<script>
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
    $('#valueImageAvatar').val(fileName);
});

$("input.rating-disabled").rating({
    filled: 'fa fa-star rating-color',
    empty: 'fa fa-star-o'
});
</script>
<script>
/*lấy tên file khi upload ảnh xong*/
$('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    console.log(fileName);
    $('#valueImageAvatar').val('Select file image: ' + fileName);;
});
/*end*/
/*START: submit comment*/
$('#form-comment input[name="rate"]').click(function() {
    let value = $(this).val();
    $('#form-comment input[name="rating"]').val(value);
})
$('#form-comment-submit').click(function(e) {
    e.preventDefault();
    var rating = $('#form-comment input[name="rating"]').val();
    var fullname = $('#form-comment input[name="fullname"]').val();
    var email = $('#form-comment input[name="email"]').val();
    var message = $('#form-comment textarea[name="message"]').val();
    var module_id = "{{$detail->id}}";
    var avatar = $("#my-image")[0].files[0];
    let form = new FormData();
    form.append('rating', rating);
    form.append('fullname', fullname);
    form.append('email', email);
    form.append('message', message);
    form.append('module_id', module_id);
    form.append('avatar', avatar);
    $.ajax({
        type: 'POST',
        url: "<?php echo route('commentFrontend.postTour') ?>",
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
            $('html, body').animate({
                scrollTop: $("#menu4").offset().top
            }, 200);
        },


    });

});
/*END: submit comment*/
$(document).on('click', '.paginate_cmt a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var sort = 'id';
    get_list_object(page, sort, true);
});

function get_list_object(page = 1, sort = 'id', animate = true) {
    setTimeout(function() {
        $.post('<?php echo route('getListComment.frontendTour') ?>', {
                page: page,
                module_id: '{{$detail->id}}',
                sort: sort,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('#getListCommentTour').html(data);
                console.log(animate);
                if (animate === true) {
                    $('html, body').animate({
                        scrollTop: $("#menu4").offset().top
                    }, 200);
                }

            }
        );
    }, 210);
}
</script>



@endpush