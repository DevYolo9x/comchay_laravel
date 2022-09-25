<div class=" box p-5 mt-3 pt-3 <?php if (!in_array('tags', $dropdown)) { ?>hidden<?php } ?>">
    <div class="<?php if (!in_array('tags', $dropdown)) { ?>hidden<?php } ?>">
        <div class="flex justify-between">
            <label class="form-label text-base font-semibold">Tags</label>
            <div class="edit text-danger hidden">
                <a href="javascript:void(0);" data-tw-toggle="modal" data-tw-target="#myModal">Thêm mới</a>
            </div>
        </div>
        <select class="tom-select tom-select-custom w-full tomselected" data-placeholder="Search..." data-header="Tags"
            multiple="multiple" name="tags[]" tabindex="-1" hidden="hidden">
            <?php if(isset($tags)): ?>
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($tag->id); ?>" <?php echo e((collect($getTags)->contains($tag->id)) ? 'selected':''); ?>>
                <?php echo e($tag->title); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
        <?php /*echo Form::select('tags[]', $tags, '', ['class' => 'tom-select tom-select-custom w-full','data-placeholder'=>"Search...","data-header"=>"Tags",'multiple']); */ ?>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<!-- BEGIN: Modal Content -->
<div id="myModal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Thêm mới Tags
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="col-span-12">
                    <div class="alert-popup alert  alert-danger-soft show flex items-center mb-2 hidden" role="alert">
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" placeholder="">
                    </div>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal"
                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-20" id="formPopup">Save</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Modal Content -->
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/components/tag.blade.php ENDPATH**/ ?>