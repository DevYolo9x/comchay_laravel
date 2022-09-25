<?php $__env->startSection('title'); ?>
<title>Danh sách comment</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách comment",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách comment
    </h1>
    <?php echo $__env->make('components.alert-success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <form action="" class="grid grid-cols-12 gap-1 space-x-2  mt-5" id="search" style="margin-bottom: 0px;">
        <div class="col-span-2">
            <select class="form-control ajax-delete-all  " data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="<?php echo e($module); ?>">
                <option>Hành động</option>
                <option value="">Xóa</option>
            </select>
        </div>
        <?php $array_star = ['' => 'Đánh giá', '1' => '1 sao', '2' => '2 sao', '3' => '3 sao', '4' => '4 sao', '5' => '5 sao',]; ?>
        <?php $array_module = ['' => 'Chọn module', 'articles' => 'Bài viết', 'products' => 'Sản phẩm', 'tours' => 'Tours']; ?>
        <div class="col-span-2">
            <?php echo Form::select('rating', $array_star, request()->get('rating'), ['class' => 'form-control']); ?>
        </div>
        <?php /*<div class="col-span-2">
            <?php echo Form::select('module_id', $getProduct, request()->get('module_id'), ['class' => 'form-control tom-select tom-select-custom w-full','data-placeholders'=>'Chon san phẩm']); ?>
</div>*/ ?>
        <div class="col-span-2 hidden">
            <?php echo Form::select('module', $array_module, request()->get('module'), ['class' => 'form-control']); ?>
        </div>

        <div class="col-span-3">
            <?php echo Form::text('date', request()->get('date'), ['class' => 'form-control',  'autocomplete' => 'off']); ?>
        </div>
        <div class="col-span-3 flex">
            <input type="search" name="keyword" class="keyword form-control filter w-full mr-1" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
            <button class="btn btn-primary btn-sm">
                <i data-lucide="search"></i>
            </button>
        </div>
    </form>
    <div class="grid grid-cols-12 gap-6 mt-3">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th style="width:40px;">STT</th>
                        <th>Tên khách hàng</th>
                        <th class="hidden" style="width:200px;">Nội dung</th>
                        <th>Module</th>
                        <th style="width:200px;">Chủ đề</th>
                        <th class="hidden">Đánh giá</th>
                        <th>Hiển thị</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        <td class="sorting_1"><?php echo e($data->firstItem()+$loop->index); ?></td>
                        <td>
                            <?php echo  $v->fullname; ?>
                            <br> <?php echo e($v->phone); ?>

                            <br> <?php echo e($v->created_at); ?>

                        </td>
                        <td class="hidden">
                            <?php echo e($v->message); ?>

                        </td>
                        <td>
                            <?php echo e($v->module); ?>

                        </td>
                        <td>
                            <?php if($v->module == 'tours'): ?>
                            <?php if(!empty($v->tour)): ?>
                            <a href="<?php echo e(route('routerURL',['slug' => $v->tour->slug])); ?>" class="text-primary" target="_blank"><?php echo e($v->tour->title); ?></a>
                            <?php endif; ?>
                            <?php elseif($v->module == 'products'): ?>
                            <?php if(!empty($v->product)): ?>
                            <a href="<?php echo e(route('routerURL',['slug' => $v->product->slug])); ?>" class="text-primary" target="_blank"><?php echo e($v->product->title); ?></a>
                            <?php endif; ?>
                            <?php elseif($v->module == 'articles'): ?>
                            <?php if(!empty($v->article)): ?>
                            <a href="<?php echo e(route('routerURL',['slug' => $v->article->slug])); ?>" class="text-primary" target="_blank"><?php echo e($v->article->title); ?></a>
                            <?php endif; ?>

                            <?php endif; ?>
                        </td>
                        <td class="hidden">
                            <div class="flex">
                                <?php for ($i = 1; $i <= $v->rating; $i++) { ?>
                                    <i data-lucide="star" class="w-4 h-4" style="color:#ea9d02;fill:#ea9d02;"></i>
                                <?php } ?>
                                <?php for ($i = 1; $i <= 5 - $v->rating; $i++) { ?>
                                    <i data-lucide="star" class="w-4 h-4" style="color:#ea9d02"></i>
                                <?php } ?>
                            </div>
                        </td>

                        <td class="w-40">
                            <?php echo $__env->make('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('comments_edit')): ?>
                                <a class="flex items-center mr-3" href="<?php echo e(route('comments.edit',['id'=>$v->id])); ?>">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('comments_destroy')): ?>
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            <?php echo e($data->links()); ?>

        </div>
        <!-- END: Pagination -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script type="text/javascript" src="<?php echo e(asset('library/daterangepicker/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('library/daterangepicker/daterangepicker.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('library/daterangepicker/daterangepicker.css')); ?>" />
<script type="text/javascript">
    $(function() {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " to "
            }
        });
    });
</script>
<style>
    table {
        table-layout: fixed;
    }

    table td {
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/comment/backend/index.blade.php ENDPATH**/ ?>