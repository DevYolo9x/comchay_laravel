<!--Start: title SEO -->
<?php $__env->startSection('title'); ?>
<title>Quản trị website</title>
<?php $__env->stopSection(); ?>
<!--END: title SEO -->
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Dashboard",
        "src" => route('admin.dashboard'),
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<!--Start: add javascript only index.html -->
<?php $__env->startSection('css-dashboard'); ?>

<?php $__env->stopSection(); ?>
<!--END: add javascript only index.html -->

<!-- START: main -->
<?php $__env->startSection('content'); ?>
<<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-6">
                    <div class=" report-box mt-12 sm:mt-4">
                        <div class="box py-0 xl:py-5 grid grid-cols-4 gap-0 divide-y xl:divide-y-0 divide-x divide-dashed divide-slate-200 dark:divide-white/5">
                            <?php if (in_array('orders', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 ">
                                    <a href="<?php echo e(route('orders.index')); ?>" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-warning bg-warning/20 border border-warning/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="shopping-bag"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalOrder); ?></div>
                                        <div class="text-slate-500 mt-1">Đơn hàng</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('products', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 ">
                                    <a href="<?php echo e(route('products.index')); ?>" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-warning bg-warning/20 border border-warning/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="shopping-bag"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalProduct); ?></div>
                                        <div class="text-slate-500 mt-1">Sản phẩm</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('tours', $dropdown)) { ?>
                                <!-- <div class="report-box__item py-5 xl:py-0 px-5 col-span-12 sm:col-span-6 xl:col-span-3">
                                <a href="<?php echo e(route('tour_books.index')); ?>" class="report-box__content">
                                    <div class="flex">
                                        <div
                                            class="report-box__item__icon text-primary bg-primary/20 border border-primary/20 flex items-center justify-center rounded-full">
                                            <i data-lucide="shopping-bag"></i>

                                        </div>
                                    </div>
                                    <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalTourBook); ?></div>
                                    <div class="text-slate-500 mt-1">Book Tour</div>
                                </a>
                            </div> -->
                                <div class="report-box__item py-5 xl:py-0 px-5 ">
                                    <a href="<?php echo e(route('tours.index')); ?>" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-primary bg-primary/20 border border-primary/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="package"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalTour); ?></div>
                                        <div class="text-slate-500 mt-1">Tour</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('articles', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5 sm:!border-t-0">
                                    <a href="<?php echo e(route('articles.index')); ?>" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-pending bg-pending/20 border border-pending/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="credit-card"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalArticle); ?></div>
                                        <div class="text-slate-500 mt-1">Bài viết</div>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (in_array('contacts', $dropdown)) { ?>
                                <div class="report-box__item py-5 xl:py-0 px-5">
                                    <a href="<?php echo e(route('contacts.index')); ?>" class="report-box__content">
                                        <div class="flex">
                                            <div class="report-box__item__icon text-success bg-success/20 border border-success/20 flex items-center justify-center rounded-full">
                                                <i data-lucide="hard-drive"></i>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-medium leading-7 mt-6"><?php echo e($totalContact); ?></div>
                                        <div class="text-slate-500 mt-1">Liên hệ</div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                <?php /*<div class="col-span-12 mt-7">
                    <div class=" block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Book tour
                        </h2>

                    </div>
                    <div class=" box p-5 mt-12 sm:mt-4">
                        <div class="md:flex items-center">
                            <div class="mr-auto">
                                <div class="flex items-center">
                                    <div class="text-2xl font-medium">$141,120.00</div>

                                </div>
                                <div class="text-slate-500 mt-1">Total Assets</div>
                            </div>
                            <select
                                class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 dark:border-darkmode-400"
                                aria-label="General report filter">
                                <option selected>All Transactions</option>
                                <option>Cash In</option>
                                <option>Cash Out</option>
                            </select>
                        </div>
                        <div class="mt-6">
                            <div class="h-[260px]">
                                <canvas id="report-line-chart-1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>*/ ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tour_books_index')): ?>
                <?php if (in_array('tour_books', $dropdown)) { ?>
                    <div class="col-span-12 mt-7">
                        <div class=" block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Book tour
                            </h2>
                        </div>
                        <div class=" box p-5 mt-12 sm:mt-4">
                            <div class="md:flex items-center">
                                <select class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 dark:border-darkmode-400" id="bookTourSearch">
                                    <option value="week" selected>7 ngày qua</option>
                                    <option value="month">Tháng này</option>
                                    <option value="month_before">Tháng trước</option>
                                    <option value="year">Năm nay</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <div class="chartreport">
                                    <canvas id="myChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_index')): ?>
                <?php if (in_array('orders', $dropdown)) { ?>
                    <div class="col-span-12 mt-7">
                        <div class=" block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Đơn hàng
                            </h2>
                        </div>
                        <div class=" box p-5 mt-12 sm:mt-4">
                            <div class="md:flex items-center">
                                <select class="form-select w-40 md:ml-auto mt-3 md:mt-0 dark:bg-darkmode-600 dark:border-darkmode-400" id="orderSearch">
                                    <option value="week" selected>7 ngày qua</option>
                                    <option value="month">Tháng này</option>
                                    <option value="month_before">Tháng trước</option>
                                    <option value="year">Năm nay</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <div class="chartreport">
                                    <canvas id="myChartOrder" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
    </div>


    <?php $__env->stopSection(); ?>
    <!-- END: main -->
    <!--Start: add javascript only index.html -->
    <?php $__env->startPush('javascript'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function loadChart(data) {
            let timeFormat = 'DD/MM/YYYY';
            let config = {
                type: 'bar',
                data: {
                    datasets: [{
                        label: "Đơn hàng",
                        data: data,
                        backgroundColor: 'red'
                    }]
                }
            };
            $("div.chartreport").html('').append(
                '<canvas id="myChart"  height="100"></canvas>');

            var ctx = document.getElementById("myChart").getContext("2d");
            window.myLine = new Chart(ctx, config);
        }

        function sortFunction(a, b) {
            var dateA = new Date(a.x).getTime();
            var dateB = new Date(b.y).getTime();
            return dateA > dateB ? 1 : -1;
        };
    </script>
    <script>
        let data = [
            <?php foreach ($data as $val) { ?> {
                    x: "<?php echo $val['x'] ?>",
                    y: <?php echo $val['y'] ?>
                },
            <?php } ?>
        ];
        loadChart(data);
    </script>
    <!-- ajax search click -->
    <script>
        $(document).on('change', '#orderSearch', function() {
            let value = $(this).val();
            $.ajax({
                type: 'POST',
                url: BASE_URL_AJAX + "dashboard/search/bookTour",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    value: value
                },
                success: function(response) {
                    let data = [];
                    $.each(response.data, function(i, val) {
                        data.push({
                            x: val.x,
                            y: val.y
                        });
                    });
                    data.sort(function(a, b) {
                        return new Date(a.x) - new Date(b.x);
                    });
                    loadChart(data);
                    //endchartjs
                },
                error: function(jqXhr, json, errorThrown) {
                    swal({
                        title: "ERROR",
                        text: "Lỗi hiển thị",
                        type: "error"
                    });
                },
            });
            return false;
        });
    </script>
    <?php $__env->stopPush(); ?>
    <!--END: add css only index.html -->
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/dashboard/home/index.blade.php ENDPATH**/ ?>