
<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                <?php echo $__env->make('homepage.common.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-span-12 lg:col-span-9 mt-5 md:mt-0 order-0 lg:order-1">
                <div class="breadcrumb py-[10px]">
                    <ul class="flex flex-wrap">
                        <li><a href="<?php echo e(url('')); ?>"><?php echo e($fcSystem['title_7']); ?></a></li>
                        <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><span class="text-gray-500 mx-2">/</span></li>
                        <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-Orangefc5"><?php echo e($v->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php echo $__env->make('briefing.frontend.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="">
                    <h1 class="font-bold text-global text-lg"><?php echo e($detail->title); ?></h1>
                    <!-- START: tiêu đề -->
                    <div class="mt-3 border-b-8" style="border-color:rgb(51, 102, 153);">
                        <div class="grid grid-cols-12 md:gap-4 text-xs" style="background:#E4EAF2">
                            <div class="col-span-2 border-r border-[#D1DCEB]">
                                <div class="p-2">
                                    <?php if($detail->type == 'admin'): ?>
                                    <strong><?php echo e($detail->user->name); ?></strong>
                                    <?php else: ?>
                                    <strong><?php echo e($detail->customer->name); ?></strong>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-span-10">
                                <?php if(!empty($detail->updated_at)): ?>
                                <div class="p-2"><b>Cập nhật:</b> <?php echo e($detail->updated_at); ?></div>
                                <?php else: ?>
                                <div class="p-2"><b>Ngày đăng:</b> <?php echo e($detail->created_at); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 md:gap-4">
                            <div class="col-span-2 border-r border-[#D1DCEB] border-l">
                                <div class="p-2 text-xs space-y-1 font-medium">
                                    <?php if($detail->type == 'admin'): ?>
                                    <p>Nhóm: Quản trị viên</p>
                                    <p>Số bài đăng: <?php echo e(sobaidang('admin',$detail->userid_created)); ?></p>
                                    <p>Thảo luận: <?php echo e(sothaoluan($detail->userid_created,'admin')); ?></p>
                                    <?php else: ?>
                                    <p>Nhóm: <?php echo e($detail->customer->title); ?></p>
                                    <p>Số bài đăng: <?php echo e(sobaidang('customer',$detail->userid_created)); ?></p>
                                    <p>Thảo luận: <?php echo e(sothaoluan($detail->userid_created,'customer')); ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="col-span-10 border-r border-[#D1DCEB]">
                                <div class=" sm:rounded-lg p-2 article-detail-content ">
                                    <?php echo $detail->description ?>
                                </div>
                            </div>
                        </div>
                        <div class=" flex justify-end p-2 space-x-2" style="background:#E4EAF2">
                            <a href="<?php echo e(route('chude.indexComment',['id' => $detail->id,'slug' => slug($detail->title)])); ?>" class=" text-white px-4 py-1 text-sm leading-snug  rounded  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" style="background:rgb(51, 102, 153)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"></path>
                                </svg>
                                <span class="ml-1">Trích dẫn</span>
                            </a>
                            <?php if($detail->type == 'customer'): ?>
                            <?php if(Auth::guard('customer')->user()->id == $detail->userid_created): ?>
                            <a href="<?php echo e(route('chude.edit',['id' => $detail->id,'slug' => slug($detail->title)])); ?>" class=" text-white px-4 py-1 text-sm leading-snug  rounded  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" style="background:rgb(51, 102, 153)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                                <span class="ml-1">Sửa</span>
                            </a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="reply-comment">
                        </div>
                    </div>
                    <!-- END: tiêu đề -->


                    <?php if(count($detail->comments) > 0): ?>
                    <?php $__currentLoopData = $detail->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!-- START: item -->
                    <div class="border-b-8" style="border-color:rgb(51, 102, 153);">
                        <div class="grid grid-cols-12 md:gap-4 text-xs" style="background:#E4EAF2">
                            <div class="col-span-2 border-r border-[#D1DCEB]">
                                <?php if(Auth::guard('customer')->user()->id == $item->customerid): ?>
                                <div class="p-2 text-yellow-500"><strong><?php echo e($item->fullname); ?></strong></div>

                                <?php else: ?>
                                <div class="p-2"><strong><?php echo e($item->fullname); ?></strong></div>

                                <?php endif; ?>
                            </div>
                            <div class="col-span-10">
                                <?php if(!empty($item->updated_at)): ?>
                                <div class="p-2"><b>Cập nhật:</b> <?php echo e($item->updated_at); ?></div>
                                <?php else: ?>
                                <div class="p-2"><b>Ngày đăng:</b> <?php echo e($item->created_at); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 md:gap-4">
                            <div class="col-span-2 border-r border-[#D1DCEB] border-l">
                                <div class="p-2 text-xs space-y-1 font-medium">
                                    <?php if($item->type == 'admin'): ?>
                                    <p>Nhóm: Quản trị viên</p>
                                    <p>Số bài đăng: <?php echo e(sobaidang('admin',$item->customerid)); ?></p>
                                    <p>Thảo luận: <?php echo e(sothaoluan($item->customerid,'admin')); ?></p>
                                    <?php else: ?>
                                    <p>Nhóm: <?php echo e($item->customer->title); ?></p>
                                    <p>Số bài đăng: <?php echo e(sobaidang('customer',$item->customerid)); ?></p>
                                    <p>Thảo luận: <?php echo e(sothaoluan($item->customerid,'customer')); ?></p>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="col-span-10 border-r border-[#D1DCEB]">
                                <div class="p-2 article-detail-content ">
                                    <?php echo $item->message ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end p-2 space-x-2" style="background:#E4EAF2">
                            <a href="<?php echo e(route('chude.indexComment',['id' => $detail->id,'slug' => slug($detail->title)])); ?>" class=" text-white px-4 py-1 text-sm leading-snug  rounded  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" style="background:rgb(51, 102, 153)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"></path>
                                </svg>
                                <span class="ml-1">Trích dẫn</span>
                            </a>
                            <?php if($item->type == 'customer'): ?>
                            <?php if(Auth::guard('customer')->user()->id == $item->customerid): ?>
                            <a href="<?php echo e(route('chude.editComment',['id' => $detail->id,'slug' => slug($detail->title),'comment_id' => $item->id])); ?>" class=" text-white px-4 py-1 text-sm leading-snug  rounded  hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex items-center" style="background:rgb(51, 102, 153)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>

                                <span class="ml-1">Sửa</span>
                            </a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="reply-comment">
                        </div>
                    </div>
                    <!-- END: item -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <div class="flex justify-end mt-3 md:gap-6">
                        <a href="<?php echo e(route('chude.indexComment',['id' => $detail->id,'slug' => slug($detail->title)])); ?>" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"></path>
                            </svg>
                            <span>Gửi ý kiến</span>
                        </a>
                        <a href="<?php echo e(route('chude.create',['id' => $detailCatalog->id])); ?>" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span>Chủ đề mới</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $('table').wrap('<div class="table-responsive"></div>');
</script>
<style>
    .table-responsive {
        width: 100%;
        overflow-y: hidden;
    }

    .table-responsive::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .table-responsive::-webkit-scrollbar {
        width: 2px;
        background-color: #F5F5F5;
        height: 10px;
    }

    table {
        width: 100%;
        overflow-wrap: break-word;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 2px rgba(0, 0, 0, .3);
        background-color: rgb(51, 102, 153);
    }

    s .article-detail-content h2 {
        font-weight: 700;
        font-size: 16px;
    }

    .article-detail-content h3 {
        font-weight: 600;
        font-size: 15px;
    }

    .article-detail-content h4,
    .article-detail-content h5 {
        font-weight: 500;
        font-size: 14px;
    }

    .article-detail-content img {
        max-width: 100% !important;
        height: auto !important;
    }

    .article-detail-content ul {
        padding-left: 20px;
        list-style: disc;
    }

    .article-detail-content p,
    .article-detail-content h2,
    .article-detail-content h3,
    .article-detail-content h4,
    .article-detail-content h5 {
        margin-bottom: 10px
    }

    table {
        border-collapse: collapse;
        margin: 0 0 1.5rem;
        /* Prevents HTML tables from becoming too wide */
        width: 100%;
        max-width: 100% !important
    }

    table {
        text-align: center;
        width: 100% !important;
    }

    table td {
        border: 1px solid #d8e5f0;
        padding: 10px;
        text-align: left;
    }

    table td {
        padding: 0.4rem;

    }

    thead th {
        border-bottom: 2px solid #666666;
        padding-bottom: 0.5rem;
    }

    th {
        padding: 0.4rem;
        text-align: left;
    }

    /*th:first-child,*/
    /*td:first-child {*/
    /*    padding-left: 0;*/
    /*}*/

    /*th:last-child,*/
    /*td:last-child {*/
    /*    padding-right: 0;*/
    /*}*/
</style>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php /*
<script src="{{ asset('library/ckeditor-frontend/ckeditor.js') }}" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".ck-editor").each(function() {
            //colorbutton,
            CKEDITOR.replace(this.id, {
                filebrowserUploadUrl: "{{route('image.store', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form',
                height: 400,
                removeButtons: "",
                extraPlugins: "colorbutton, panelbutton, link, justify, lineheight, youtube, videodetector, image, imageresize, font, codemirror, copyformatting, find, qrc, slideshow, preview, hkemoji, contents, googledocs, codesnippet",
                entities: false,
                entities_latin: false,
                allowedContent: true,
                toolbarGroups: [{
                        name: "clipboard",
                        groups: ["clipboard", "undo"],
                    },
                    {
                        name: "editing",
                        groups: ["find", "selection", "spellchecker"],
                    },
                    {
                        name: "links",
                    },
                    {
                        name: "insert",
                    },
                    {
                        name: "forms",
                    },
                    {
                        name: "tools",
                    },
                    {
                        name: "document",
                        groups: ["mode", "document", "doctools"],
                    },
                    {
                        name: "colors",
                    },
                    {
                        name: "others",
                    },
                    {
                        name: "fonts",
                    },
                    "/",
                    {
                        name: "basicstyles",
                        groups: ["basicstyles", "cleanup"],
                    },
                    {
                        name: "paragraph",
                        groups: ["list", "indent", "blocks", "align", "bidi"],
                    },
                    {
                        name: "styles",
                    },
                ],

            })
        });
    })
</script>
<div class="py-12 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 hidden" id="modal" style="background:#0000007a;">
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3">
        <div class="relative py-8 px-5  bg-white shadow-md rounded border border-gray-400">
            <h2 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">{{$detail->title}}</h2>
            <div class="modal-body">
                <form action="" id="form-comment">
                    <div class="error_comment">
                        <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative my-3 alert alert-success" style="display: none">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline js_text_success">
                            </span>
                        </div>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3 alert alert-danger" style="display: none">
                            <strong class="font-bold">ERROR!</strong>
                            <span class="block sm:inline js_text_danger">
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col ">
                        <label class="w-[100px] font-bold mb-3">Nội dung</label>
                        <div>
                            <?php echo Form::textarea('message', '', ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
                        </div>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="button" id="form-comment-submit" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            <span>Gửi ý kiến mới</span>
                        </button>
                    </div>
                </form>

            </div>
            <button id="form-comment-submit" class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>
</div>
<script>

    let modal = document.getElementById("modal");

    function modalHandler(val) {
        $('#modal').toggleClass('hidden')
    }

</script>
<script type="text/javascript">
    $('#form-comment-submit').click(function(e) {
        e.preventDefault();
        var message = CKEDITOR.instances['ckDescription'].getData();;
        var module_id = "{{$detail->id}}";
        let form = new FormData();
        form.append('message', message);
        form.append('module_id', module_id);
        $.ajax({
            type: 'POST',
            url: "<?php echo route('chude.comment') ?>",
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
</script>
*/ ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/briefing/frontend/briefing/index.blade.php ENDPATH**/ ?>