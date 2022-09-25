@extends('dashboard.layout.dashboard')

@section('title')
<title>Quản lý hình ảnh</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Quản lý hình ảnh",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<iframe src="/{{env('APP_ADMIN')}}/laravel-filemanager"
    style="width: 100%; height: calc(100vh - 63px); overflow: hidden; border: none;"></iframe>
@endsection