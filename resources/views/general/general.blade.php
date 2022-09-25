@extends('dashboard.layout.dashboard')

@section('title')
<title>Cấu hình hệ thống</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình hệ thống",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10 mb-5">
        Cấu hình hệ thống
    </h1>
    @include('components.alert-success')
    <form method="post" action="{{route('generals.store')}}" class="form-horizontal box">
        @csrf
        <div class="grid">
            <!-- BEGIN: Basic Tab -->
            <div id="basic-tab" class="p-5">
                <div class="preview">
                    <ul class="nav nav-link-tabs flex-wrap" role="tablist">
                        <?php if (isset($tab) && is_array($tab) && count($tab)) { ?>
                            <?php $i = 0;
                            foreach ($tab as $key => $val) {
                                $i++; ?>

                                <li id="example-<?php echo $key ?>-tab" class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 <?php if ($i == 1) { ?>active<?php } ?>" data-tw-toggle="pill" data-tw-target="#example-tab-<?php echo $key ?>" type="button" role="tab" aria-controls="example-tab-<?php echo $key ?>" aria-selected="true"><?php echo $val['label']; ?></button>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="tab-content ">
                        <?php if (isset($tab) && is_array($tab) && count($tab)) { ?>
                            <?php $i = 0;
                            foreach ($tab as $key => $val) {
                                $i++; ?>
                                <div id="example-tab-<?php echo $key ?>" class="tab-pane leading-relaxed p-5 <?php if ($i == 1) { ?>active<?php } ?>" role="tabpanel" aria-labelledby="example-<?php echo $key ?>-tab">

                                    <div class="grid grid-cols-12 gap-6 mt-5">
                                        <div class=" col-span-12 lg:col-span-4">
                                            <h2 class="text-lg font-semibold leading-none mb-3">
                                                <?php echo $val['label']; ?></h2>
                                            <div class="">
                                                <?php echo $val['description']; ?>
                                            </div>
                                        </div>
                                        <div class=" col-span-12 lg:col-span-8">
                                            <?php if (isset($val['value']) && is_array($val['value']) && count($val['value'])) { ?>
                                                <div class="ibox m0">
                                                    <div class="ibox-content">
                                                        <?php foreach ($val['value'] as $keyItem => $valItem) { ?>
                                                            <div class="mb-4">
                                                                <div class="flex justify-between">
                                                                    <label class="font-extrabold">
                                                                        <span><?php echo $valItem['label']; ?><?php echo (isset($valItem['title'])) ? '<a target="_blank" style="font-weight:normal;text-decoration:underline;font-size:12px;font-style:italic;" href="' . $valItem['link'] . '" title="">(' . $valItem['title'] . ')</a>' : ''; ?></span>
                                                                    </label>
                                                                    <?php if (isset($valItem['id'])) { ?>
                                                                        <span style="color:#9fafba;">
                                                                            <span id="<?php echo $valItem['id']; ?>"><?php echo strlen(slug(isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '')) ?></span>
                                                                            <?php echo (isset($valItem['extend'])) ? $valItem['extend'] : ''; ?></span>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php
                                                                if ($valItem['type'] == 'text') {
                                                                    echo Form::text('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control ' . ((isset($valItem['class'])) ? $valItem['class'] : '') . '']);
                                                                } else if ($valItem['type'] == 'textarea') {
                                                                    echo Form::textarea('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control ' . ((isset($valItem['class'])) ? $valItem['class'] : '') . '']);
                                                                } else if ($valItem['type'] == 'images') {
                                                                    echo Form::text('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control 1' . ((isset($valItem['class'])) ? $valItem['class'] : '') . '', 'onclick' => 'openKCFinderSystem(this)']);
                                                                } else if ($valItem['type'] == 'files') {
                                                                    echo Form::text('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control 1' . ((isset($valItem['class'])) ? $valItem['class'] : '') . '', 'onclick' => "openKCFinderSystem(this, 'files')"]);
                                                                } else if ($valItem['type'] == 'media') {
                                                                    echo Form::text('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control 1' . ((isset($valItem['class'])) ? $valItem['class'] : '') . '', 'onclick' => "openKCFinderSystem(this, 'media')"]);
                                                                } else if ($valItem['type'] == 'editor') {
                                                                    echo Form::textarea('config[' . $key . '_' . $keyItem . ']', isset($systems[$key . '_' . $keyItem]) ? htmlspecialchars_decode($systems[$key . '_' . $keyItem]) : '', ['id' => '' . $key . '_' . $keyItem . '', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);
                                                                } else if ($valItem['type'] == 'dropdown') {
                                                                    echo Form::select('config[' . $key . '_' . $keyItem . ']', $valItem['value'], isset($systems[$key . '_' . $keyItem]) ? $systems[$key . '_' . $keyItem] : '', ['class' => 'form-control', 'style' => 'width: 100%;']);
                                                                }
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>


                                </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="text-right pr-5 pb-5">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </div>

                </div>

            </div>

            <!-- END: Basic Tab -->
    </form>

</div>
</div>





@endsection