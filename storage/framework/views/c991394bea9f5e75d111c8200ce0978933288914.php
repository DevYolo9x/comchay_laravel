<!-- <script src="<?php echo e(asset('frontend/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/main.js')); ?>"></script> -->


<script src="<?php echo e(asset('frontend/js/assets/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/assets/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/js/assets/wow.min.js')); ?>"></script>

<script src="https://unpkg.com/flowbite@1.5.2/dist/flowbite.js"></script>
<script src="https://unpkg.com/flowbite@1.5.2/dist/datepicker.js"></script>

<script src="<?php echo e(asset('frontend/js/assets/main.js')); ?>"></script>
<script>
    //hieu ung wow------------------------------------------
    wow = new WOW({
        animateClass: "animated",
        offset: 100,
        callback: function(box) {
            console.log("WOW: animating <" + box.tagName.toLowerCase() + ">");
        },
    });
    wow.init();
</script><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/homepage/common/script.blade.php ENDPATH**/ ?>