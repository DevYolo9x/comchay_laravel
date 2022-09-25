<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
    var BASE_URL = '<?php echo url(''); ?>/';
    var BASE_URL_AJAX = '<?php echo url(''); ?>/<?php echo env('APP_ADMIN')?>/';
    </script>
    @yield('title')
    <!-- head-->
    @include('dashboard.common.head')
</head>

<body class="main">

    <div class="flex">
        <!-- sidebar -->
        @include('dashboard.common.sidebar')
        <!--right-side -->
        <aside class="wrapper">
            <!-- header-->
            @include('dashboard.common.header')
            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </aside>
    </div>
    <!-- footer -->
    @include('dashboard.common.footer')
    @stack('javascript')
    <style>
    .no-print {
        top: 50% !important;
    }
    </style>
</body>

</html>