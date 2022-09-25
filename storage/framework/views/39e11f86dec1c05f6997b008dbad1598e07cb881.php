 <?php if(!$configIs->isEmpty()): ?>
 <?php $__currentLoopData = $configIs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <td class="w-40">
     <?php echo $__env->make('components.isModule',['module' => $module,'title' => $item->type,'id' =>
     $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 </td>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/components/table/is_tbody.blade.php ENDPATH**/ ?>