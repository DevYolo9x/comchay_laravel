@extends('dashboard.layout.dashboard')
@section('title')
<title>Quản lý hiển thị module</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Quản lý hiển thị module",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10 mb-5">
        Quản lý hiển thị module
    </h1>
    @include('components.alert-success')
    <div class="grid">
        <!-- BEGIN: Basic Tab -->
        <div id="basic-tab" class="p-5">
            <div class="preview">
                <ul class="nav nav-link-tabs flex-row" role="tablist">
                    <?php if (isset($table) && is_array($table) && count($table)) { ?>
                    <?php $i = 0; foreach ($table as $key => $val) { $i++; ?>
                    <li id="example-<?php echo $key ?>-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 <?php if ($i == 1) { ?>active<?php } ?>"
                            data-tw-toggle="pill" data-tw-target="#example-tab-<?php echo $key ?>" type="button"
                            role="tab" aria-controls="example-tab-<?php echo $key ?>"
                            aria-selected="true"><?php echo $val; ?></button>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php if (isset($table) && is_array($table) && count($table)) { ?>
                    <?php $i = 0; foreach ($table as $key => $val) { $i++; ?>
                    <div id="example-tab-<?php echo $key ?>"
                        class="tab-pane leading-relaxed p-5 <?php if ($i == 1) { ?>active<?php } ?>" role="tabpanel"
                        aria-labelledby="example-<?php echo $key ?>-tab">
                        <form>
                            <?php Form::text('title', '', ['class' => 'form-control']) ?>
                            <?php Form::text('module', '', ['class' => 'form-control'])  ?>
                        </form>
                    </div>
                    <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- END: Basic Tab -->
    </div>
</div>
@endsection
