<div class="flex space-x-2">


    <?php if(empty($catalogue)): ?>
    <select class="form-control ajax-delete-all mr10" style="width: 150px;;height:42px" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="<?php echo e($module); ?>">
        <option>Hành động</option>
        <option value="">Xóa</option>
    </select>
    <?php endif; ?>
    <form action="" class="flex space-x-2" id="search" style="margin-bottom: 0px;">
        <?php if(isset($configIs)): ?>
        <select class="form-control mr10 filter" name="type" style="width: 200px;height:42px">
            <option value="" selected>Chọn hiển thị</option>
            <?php $__currentLoopData = $configIs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($value->type); ?>" <?php if (!empty(request()->get('type')) && request()->get('type') == $value->module) { ?>selected<?php } ?>><?php echo e($value->title); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php endif; ?>
        <?php if(isset($htmlOption)): ?>
        <div style="width:250px;" class="mr10">
            <?php echo Form::select('catalogueid', $htmlOption, request()->get('catalogueid'), ['class' => 'form-control tom-select tom-select-custom', 'data-placeholder' => "Select your favorite actors", 'style' => 'height:42px']); ?>
        </div>
        <?php endif; ?>
        <input type="search" name="keyword" class="keyword form-control filter" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>" style="width: 200px;">
        <button class="btn btn-primary">
            <i data-lucide="search"></i>
        </button>
    </form>

</div><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/components/search.blade.php ENDPATH**/ ?>