<?php $__env->startSection('title'); ?>
<title>Chi tiết comment</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách comment",
        "src" => route('comments.index'),
    ],
    [
        "title" => "Chi tiết comment",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Chi tiết comment

        <?php if($detail->module == 'tours'): ?>
        <?php if(!empty($detail->tour)): ?>
        tour :<a href="<?php echo e(route('routerURL',['slug' => $detail->tour->slug])); ?>" class="text-primary" style="color: rgb(11, 116, 229);" target="_blank"><?php echo e($detail->tour->title); ?></a>
        <?php endif; ?>
        <?php elseif($detail->module == 'products'): ?>
        <?php if(!empty($detail->product)): ?>
        sản phẩm :<a href="<?php echo e(route('routerURL',['slug' => $detail->product->slug])); ?>" class="text-primary" style="color: rgb(11, 116, 229);" target="_blank"><?php echo e($detail->product->title); ?></a>
        <?php endif; ?>
        <?php elseif($detail->module == 'articles'): ?>
        <?php if(!empty($detail->article)): ?>
        bài viết :<a href="<?php echo e(route('routerURL',['slug' => $detail->article->slug])); ?>" class="text-primary" style="color: rgb(11, 116, 229);" target="_blank"><?php echo e($detail->article->title); ?></a>
        <?php endif; ?>
        <?php elseif($detail->module == 'briefings'): ?>
        <?php if(!empty($detail->briefings)): ?>
        chủ đề :<a href="<?php echo e(route('chude.index',['slug' => slug($detail->briefings->title),'id' => $detail->briefings->id])); ?>" class="text-primary" style="color: rgb(11, 116, 229);" target="_blank"><?php echo e($detail->briefings->title); ?></a>
        <?php endif; ?>
        <?php if(!empty($detail->article)): ?>
        bài viết :<a href="<?php echo e(route('routerURL',['slug' => $detail->article->slug])); ?>" class="text-primary" style="color: rgb(11, 116, 229);" target="_blank"><?php echo e($detail->article->title); ?></a>
        <?php endif; ?>
        <?php endif; ?>
    </h1>
    <?php echo $__env->make('components.alert-success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-5">
            <div class=" box p-5">
                <div class="mt-3 flex flex-col justify-center ">
                    <label class="form-label text-base font-semibold text-center">Đánh giá</label>
                    <div class="form-switch flex justify-center">
                        <?php for ($i = 1; $i <= $detail->rating; $i++) { ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M12 3L14.6198 8.81653L21 9.49342L16.239 13.7651L17.5623 20L12 16.8235L6.43769 20L7.761 13.7651L3 9.49342L9.38015 8.81653L12 3Z" stroke="#FFD52E" fill="#FFD52E"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2L14.9109 8.50806L22 9.26543L16.71 14.045L18.1803 21.0211L12 17.467L5.81966 21.0211L7.29 14.045L2 9.26543L9.08906 8.50806L12 2ZM12 4.29426L9.72422 9.38228L4.18197 9.97439L8.31771 13.7111L7.16819 19.165L12 16.3864L16.8318 19.165L15.6823 13.7111L19.818 9.97439L14.2758 9.38228L12 4.29426Z" fill="#FFD52E"></path>
                                </svg>
                            </span>
                        <?php } ?>
                        <?php for ($i = 1; $i <= 5 - $detail->rating; $i++) { ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M12 3L14.6198 8.81653L21 9.49342L16.239 13.7651L17.5623 20L12 16.8235L6.43769 20L7.761 13.7651L3 9.49342L9.38015 8.81653L12 3Z" stroke="#dddddd" fill="#dddddd"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2L14.9109 8.50806L22 9.26543L16.71 14.045L18.1803 21.0211L12 17.467L5.81966 21.0211L7.29 14.045L2 9.26543L9.08906 8.50806L12 2ZM12 4.29426L9.72422 9.38228L4.18197 9.97439L8.31771 13.7111L7.16819 19.165L12 16.3864L16.8318 19.165L15.6823 13.7111L19.818 9.97439L14.2758 9.38228L12 4.29426Z" fill="#dddddd"></path>
                                </svg>
                            </span>
                        <?php } ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Cho phép hiển thị</label>
                    <div class="form-switch mt-2">
                        <input <?php echo ($detail->publish == 0) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox" data-module="<?php echo e($module); ?>" data-id="<?php echo $detail->id; ?>" data-title="publish" id="publish-<?php echo $detail->id; ?>">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Họ và tên</label>
                    <div class="form-switch">
                        <?php echo e($detail->fullname); ?>

                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số điện thoại</label>
                    <div class="form-switch">
                        <?php echo e($detail->phone); ?>

                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nội dung</label>
                    <div class="form-switch">
                        <?php echo $detail->message ?>
                    </div>
                </div>
                <form role="form" class="" action="<?php echo e(route('comments.update',['id'=>$detail->id])); ?>" method="post" id="form-comment">
                    <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo csrf_field(); ?>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Trả lời bình luận</label>
                        <div class="form-switch mt-2">
                            <textarea class="form-control" rows="10" name="message" placeholder="Trả lời bình luận" required></textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="error_comment"></div>
                        <div class="write_review_images" style="display: none;"></div>
                        <div class="write_review_buttons">
                            <input type="hidden" value="" name="images">
                            <input class="write_review_file" type="file" multiple="">
                            <button type="button" class=" write-review__button write-review__button--image btn btn-outline-secondary w-24 mr-1">
                                <img src="https://salt.tikicdn.com/ts/upload/1b/7a/3b/d8ff2d5d709c730e12e11ba0b70a1285.jpg"><span>Thêm
                                    ảnh</span>
                            </button>
                            <button type="submit" class="write-review__button write-review__button--submit btn btn-primary w-24"><span>Trả
                                    lời</span></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-span-12 lg:col-span-7 space-y-5">
            <?php if(!$child->isEmpty()): ?>
            <div class="box p-5 ">
                <ul class="nav nav-link-tabs flex-wrap" role="tablist">

                    <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-1" aria-selected="true">Bình luận phản
                            hồi</button>
                    </li>
                    <li id="example-2-tab" class="nav-item flex-1" role="presentation" style="display:none">
                        <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-2" type="button" role="tab" aria-controls="example-tab-2" aria-selected="true">Ảnh bình
                            luận</button>
                    </li>
                </ul>
                <div class="tab-content ">
                    <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab">
                        <!-- BEGIN: Timeline Wrapper -->
                        <div class="mt-5 px-5 -mb-5 pb-5 relative overflow-hidden before:content-[''] before:absolute before:w-px before:bg-slate-200/60 before:dark:bg-darkmode-400 before:mr-auto before:left-0  before:ml-3  before:h-full before:mt-8 ">
                            <?php $__currentLoopData = $dataChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative z-10 bg-white dark:bg-darkmode-600 py-2 text-center text-slate-500 text-xs">
                                <?php echo e($k); ?>

                            </div>
                            <?php $__currentLoopData = $v; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- BEGIN: Timeline Content Latest -->
                            <div class="pl-6  before:content-[''] before:absolute before:w-20 before:h-px before:mt-8 before:left-[60px] before:bg-slate-200 before:dark:bg-darkmode-400 before:rounded-full before:inset-x-0 before:mx-auto before:z-[-1] ">
                                <div class=" bg-white dark:bg-darkmode-400 shadow-sm border border-slate-200 rounded-md p-5 flex flex-col sm:flex-row items-start gap-y-3 mt-5 before:content-[''] before:absolute before:w-6 before:h-6 before:bg-primary/20 before:rounded-full before:inset-x-0  before:mr-auto  after:content-[''] after:absolute after:w-6 after:h-6 after:bg-primary after:rounded-full after:inset-x-0  after:mr-auto after:border-4 after:border-white/60 after:dark:border-darkmode-300 ">
                                    <div class="mr-3">
                                        <div class="image-fit w-12 h-12">
                                            <?php if($c->type == "QTV"): ?>
                                            <img alt="<?php echo e($c->fullname); ?>" class="rounded-full" src="https://ui-avatars.com/api/?name=Quản-Trị-Viên">
                                            <?php else: ?>
                                            <?php if(!empty($c->avatar)): ?>
                                            <img alt="<?php echo e($c->fullname); ?>" class="rounded-full" src="<?php echo e(asset($c->avatar)); ?>">
                                            <?php else: ?>
                                            <img alt="<?php echo e($c->fullname); ?>" class="rounded-full" src="https://ui-avatars.com/api/?name=<?php echo e($c->fullname); ?>">

                                            <?php endif; ?>


                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="space-y-3 flex-1 w-full">
                                        <div class="flex justify-between text-primary font-medium items-center">
                                            <div>
                                                <?php echo e($c->fullname); ?>

                                                <?php if($c->type == "QTV"): ?>
                                                <a class="btn btn-danger btn-flat btn-sm ml-1"><?php echo e($c->type); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-switch">
                                                <input <?php echo ($c->publish == 0) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox" data-module="<?php echo e($module); ?>" data-id="<?php echo $c->id; ?>" data-title="publish" id="publish-<?php echo $c->id; ?>">
                                            </div>
                                        </div>
                                        <div>
                                            <?php echo e($c->message); ?>

                                        </div>
                                        <?php $listImageCmt = json_decode($c->images, TRUE); ?>
                                        <?php if(!empty($listImageCmt)): ?>
                                        <div class="flex flex-wrap">
                                            <?php $__currentLoopData = $listImageCmt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img src="<?php echo e($image); ?>" alt="..." class="margin" style="width: 80px;height: 80px;object-fit: cover;border:1px solid #dddddd;margin-left:5px">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="text-slate-500 text-xs mt-1.5"><?php echo e($c->created_at); ?></div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Timeline Content Latest -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <!-- END: Timeline Wrapper -->
                    </div>
                    <div id="example-tab-2" class="tab-pane leading-relaxed p-5 " role="tabpanel" aria-labelledby="example-2-tab">
                        <?php $list_images_cmt = json_decode($detail->images, TRUE); ?>
                        <?php if(isset($list_images_cmt)): ?>
                        <div class="flex flex-wrap">
                            <?php $__currentLoopData = $list_images_cmt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kimage=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="margin-bottom: 15px;object-fit: cover;border:1px solid #dddddd;margin-left:5px">
                                <div class="review-images__item">
                                    <div class="review-images__img" style="background-image: url('<?php echo $image ?>');">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
            <div class="mt-5">
                <?php echo e($child->links()); ?>

            </div>
            <?php endif; ?>


        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<style>
    /* review_images */
    .review-images__heading {
        margin: 0px 0px 16px;
        font-size: 17px;
        line-height: 24px;
        font-weight: 500;
    }



    .review-images__item {
        width: 120px;
        height: 120px;
        margin: 0px 16px 0px 0px;
        cursor: pointer;
        max-width: 100%;
    }

    .review-images__img {
        background-size: cover;
        border-radius: 4px;
        height: 100%;
        width: 100%;
        background-position: center center;
    }

    .review-images__item:last-child {
        position: relative;
        z-index: 1;
        margin: 0px;
    }

    .review-images__total {
        background-color: rgba(36, 36, 36, 0.7);
        font-size: 17px;
        font-weight: 500;
        position: absolute;
        inset: 0px;
        line-height: 120px;
        text-align: center;
        color: rgb(255, 255, 255);
        border-radius: 4px;
    }

    .write_review_buttons {
        flex: 1 1 0%;
        align-items: flex-end;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
        padding: 0px 0px 16px;
        margin: 0px;
    }

    .write-review__input {
        border: 1px solid rgb(238, 238, 238);
        padding: 12px;
        border-radius: 4px;
        resize: none;
        width: 100%;
        outline: 0px;
        margin: 12px 0px 12px;
    }

    .write_review_file {
        position: absolute;
        height: 0px;
        width: 0px;
        visibility: hidden;
        opacity: 0;
        clip: rect(0px, 0px, 0px, 0px);
    }

    .write-review__button {
        width: 49%;
        height: 36px;
        border: 0px;
        background: 0px center;
        padding: 0px;
        line-height: 36px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        outline: 0px;
    }

    .write-review__button--image {
        color: rgb(11, 116, 229);
        border: 1px solid rgb(11, 116, 229);
    }

    .write-review__button--image img {
        width: 15px;
        margin: 0px 4px 0px 0px;
    }

    .write-review__button--submit {
        background-color: rgb(11, 116, 229);
        color: rgb(255, 255, 255);
    }

    .write_review_images {
        text-align: left;
        margin: 0px 0px 12px;
    }

    .write-review__image {
        display: inline-block;
        width: 48px;
        height: 48px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        margin: 0px 12px 0px 0px;
        border: 1px solid rgb(224, 224, 224);
        border-radius: 4px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .write-review__image-close {
        width: 21px;
        height: 21px;
        background-color: rgb(255, 255, 255);
        border-radius: 50%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        line-height: 21px;
        font-size: 18px;
        display: none;
        text-align: center;
    }

    .write-review__image:hover .js_delete_image_cmt {
        display: block;
    }

    .write-review__image:hover::after {
        content: "";
        position: absolute;
        inset: 0px;
        background-color: rgba(36, 36, 36, 0.7);
    }

    .write-review__info {
        flex: 1 1 0%;
        align-items: flex-end;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
        margin: 12px 0px 0px;
    }

    .write-review__info input {
        width: 49%;
        height: 36px;
        background: 0px center;

        line-height: 36px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        outline: 0px;
    }

    .fa.fa-star-o,
    .fa.fa-star {
        color: #fbc634 !important;
        font-size: 30px;
    }

    .js_delete_image_cmt {
        width: 21px;
        height: 21px;
        background-color: rgb(255, 255, 255);
        border-radius: 50%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        line-height: 21px;
        font-size: 18px;
        display: none;
        text-align: center;
    }
</style>
<script>
    //upload image comment
    var inputFile = $('input.write_review_file');
    var uploadURI = '<?php echo route('components.uploadImagesComment') ?>';
    var processBar = $('#progress-bar');
    $('input.write_review_file').change(function(event) {
        var filesToUpload = inputFile[0].files;
        if (filesToUpload.length > 0) {
            var formData = new FormData();
            for (var i = 0; i < filesToUpload.length; i++) {
                var file = filesToUpload[i];
                formData.append('file[]', file, file.name);
            }
            // console.log(formData);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: uploadURI,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.error_comment').removeClass('alert alert-danger');
                    $('.write_review_images').show();
                    var json = JSON.parse(data);
                    $('.write_review_images').append(json.html);
                    load_src_img();
                },
                error: function(jqXhr, json, errorThrown) {
                    // this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    $('.error_comment').removeClass('alert alert-success').addClass(
                        'alert alert-danger');
                    $('.error_comment').html('').html(errors.message);
                },
            });
        }
    });

    function load_src_img() {
        var outputText = '';
        $('.write_review_images img').each(function() {
            var divHtml = $(this).attr('src');
            outputText += divHtml + '-+-';
        });
        $('#form-comment input[name="images"]').attr('value', outputText.slice(0, -3));
    }

    $(document).on('click', '.write-review__image-close', function() {
        var me = $(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: uploadURI,
            type: 'post',
            data: {
                file: me.attr('data-file'),
                delete: 'delete'
            },
            success: function() {
                $('.error_comment').removeClass('alert alert-danger').removeClass('alert alert-danger');
                me.parent().remove();
                load_src_img();
            },
            error: function(jqXhr, json, errorThrown) {
                // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = "";
                $.each(errors["errors"], function(index, value) {
                    errorsHtml += value + "/ ";
                });
                $('.error_comment').removeClass('alert alert-success').addClass('alert alert-danger');
                $(".error_comment").html(errorsHtml).show();
            },
        });
    });
    $(document).on('click', '.write-review__button--image', function(e) {
        $(".write_review_file").click();
    });
    //end upload images
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/comment/backend/edit.blade.php ENDPATH**/ ?>