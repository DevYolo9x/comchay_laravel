@extends('dashboard.layout.dashboard')

@section('title')
<title>Quản lý Banner & Slide</title>
@section('content')
<!-- Content Header (Page header) -->
<section class="content">
    <h1 class=" text-lg font-medium mt-10">
        Banner & Slide
    </h1>
    <form form role="form" action="{{route('users.store')}}" method="post">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="file-manager">
                            <a href="javascript:void(0);" data-tw-toggle="modal"
                                data-tw-target="#basic-modal-upload-image"
                                class="btn btn-primary btn-block btn-upload w-full">Upload hình ảnh</a>
                            <div class="hr-line-dashed"></div>
                            <div class="flex items-center justify-between">
                                <h5 style="font-size:20px">Nhóm Slide</h5>
                                @if(env('APP_ENV') == "local")
                                <a href="javascript:void(0);" data-tw-toggle="modal"
                                    data-tw-target="#basic-modal-add-group">+ Thêm mới</a>
                                @endif
                            </div>
                        </div>
                        <ul class="folder-list" id="folder-list" style="padding: 0">
                            @foreach($slideGroup as $v)
                            <li class="mt-2">
                                <div class="flex items-center justify-between">
                                    <a href="javascript:void(0)" class="slide-catalogue"
                                        data-id="{{$v->id}}">{{$v->title}}
                                    </a>

                                    <div>
                                        <a type="button" class="slide-group-edit text-danger mr-2"
                                            href="javascript:void(0)" data-id="{{$v->id}}" data-title="{{$v->title}}"
                                            data-tw-toggle="modal" data-tw-target="#basic-modal-edit-group"> Sửa</a>

                                        @if(env('APP_ENV') == "local")
                                        <a type="button" class="slide-group-delete ajax-delete text-danger"
                                            href="javascript:void(0)"
                                            data-title="Lưu ý: Dữ liệu sẽ không thể khôi phục. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!"
                                            data-module="category_slides" data-id="{{$v->id}}" data-child="1"
                                            style="color:#676a6c;"> Xóa</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-span-9 space-y-5" id="listData">
                @foreach($slideGroup as $key => $val)
                @if(count($val->slides) > 0)
                <div class="row" id="listData{{$val->id}}">
                    <h2 class="text-2xl text-slate-600 dark:text-slate-500 font-medium leading-none mb-3">
                        {{$val->title}}</h2>
                    <div class="grid grid-cols-12 gap-6 pb-4">
                        @foreach($val->slides as $key => $v)
                        <div class="file-box col-span-3" id="slide-<?php echo $v->id; ?>">
                            <div class="file">
                                <div href="#">
                                    <span class="corner"></span>
                                    <div class="image">
                                        <img alt="image" class="img-responsive" src="<?php echo $v->src; ?>">
                                    </div>
                                    <div class="file-name">
                                        <span class="name"><span style="font-weight:bold;">Chú thích</span>:
                                            <?php echo (!empty($v->title)) ? $v->title : ''; ?></span>
                                        <br>
                                        <a class="link" style="color:#676a6c;" href="<?php echo url($v->link)?>"
                                            target="_blank"><span style="font-weight:bold;">Link</span>:
                                            <?php echo (!empty($v->link)) ? '<i style="color:blue;">' . url($v->link) . '</i>' : ''; ?></a>
                                        <br>
                                        <span class="description"><span style="font-weight:bold;">Ghi chú</span>:
                                            <?php echo (!empty($v->description)) ? $v->description : '<span class="text-danger"-</span>'; ?></span>

                                        <div class="file-action flex justify-between items-center"
                                            style="margin-top:10px;">
                                            <a data-json="<?php echo base64_encode(json_encode($v)) ?>"
                                                data-target="#myModalEdit" href="" title="" class="edit-slide"
                                                data-tw-toggle="modal" data-tw-target="#basic-modal-edit-slide"
                                                data-id="<?php echo $v->id; ?>">Chỉnh sửa</a>
                                            <a href="javascript:void(0)" type="button" class="ajax-delete"
                                                data-parent="file-box"
                                                data-title="Lưu ý: Dữ liệu sẽ không thể khôi phục. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!"
                                                data-module="slides" data-id="<?php echo $v->id; ?>" style="color:red;">
                                                Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <hr>
                </div>

                @endif
                @endforeach


            </div>
        </div>

    </form>


</section>

<!--START: add group slide -->
<div class="modal inmodal" id="basic-modal-add-group" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <i data-lucide="monitor" style="height:94px;width:100px;color:#dddddd"></i>

                <h4 class="modal-title mb-1">Thêm mới nhóm Banner &amp; Slide</h4>
                <small class="font-bold">Kích thước banner hiển thị tốt nhất <span class="text-danger"
                        style="font-size:16px;">1920x760</span> pixel, các banner nên có kích thước bằng
                    nhau.</small>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger-soft show flex items-center mb-5" role="alert" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="alert-octagon" data-lucide="alert-octagon"
                        class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="title_error"></span>
                </div>
                <form class="m-t slide-group" role="form" method="post" action="{{route('slides.category_store')}}">

                    <div class="form-group">
                        <label class="form-label text-base font-semibold">Tên nhóm Slide</label>
                        <input type="text" placeholder="" id="title" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label text-base font-semibold">Từ khóa</label>
                        <input type="text" placeholder="" id="keyword" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-tw-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add-group">Tạo mới</button>
            </div>
        </div>
    </div>
</div>
<!--END: add group slide -->
<!--START: edit group slide -->
<div class="modal inmodal" id="basic-modal-edit-group" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <i data-lucide="monitor" style="height:94px;width:100px;color:#dddddd"></i>

                <h4 class="modal-title mb-1">Sửa nhóm Banner &amp; Slide</h4>
                <small class="font-bold">Kích thước banner hiển thị tốt nhất <span class="text-danger"
                        style="font-size:16px;">1920x760</span> pixel, các banner nên có kích thước bằng nhau.</small>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger-soft show flex items-center mb-5" role="alert" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="alert-octagon" data-lucide="alert-octagon"
                        class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="title_error"></span>
                </div>
                <form class="m-t slide-group" role="form" method="post" action="{{route('slides.category_update')}}">
                    <div class="form-group">
                        <label class="form-label text-base font-semibold">Tên nhóm Slide</label>
                        <input type="text" placeholder="" class="title form-control" class="form-control">
                        <input type="hidden" placeholder="" class="id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-tw-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary edit-group">Cập nhập</button>
            </div>
        </div>
    </div>
</div>
<!--END: add edit slide -->
<!--START: upload image to slide group -->
<div id="basic-modal-upload-image" class="modal inmodal " tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated fadeIn">
            <div class="modal-header space-y-2">
                <i data-lucide="monitor" style="height:94px;width:100px;color:#dddddd"></i>
                <h4 class="modal-title mb-1">Upload hình ảnh</h4>
                <small class="font-bold">Kích thước banner hiển thị tốt nhất <span class="text-danger"
                        style="font-size:16px;">1920x760</span> pixel, các banner nên có kích thước bằng
                    nhau.</small>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger-soft show flex items-center mb-5" role="alert" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="alert-octagon" data-lucide="alert-octagon"
                        class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="title_error"></span>
                </div>
                <form class="m-t slide-group" role="form" method="post" action="">
                    <div class="form-group flex items-center">
                        <label style="width:110px;margin-right:10px;">Chọn nhóm slide</label>
                        <div class="col-sm-6">
                            <select name="catalogueid" class="form-control catalogueid">
                                <option value="0">[Chọn nhóm slide]</option>

                                @foreach($slideGroup as $v)
                                <option value="{{$v->id}}">{{$v->title}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="text-right" style="margin-bottom:5px;"><a
                            onclick="openKCFinderSlide(this);return false;" href="javascript:void(0)" title=""
                            class="upload-picture text-primary">Chọn hình</a></div>
                    <div class="click-to-upload ">
                        <div class="icon">
                            <a type="button" class="upload-picture" onclick="openKCFinderSlide(this);return false;">
                                <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                    <path
                                        d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="small-text">Sử dụng nút <b>Chọn hình</b> để thêm hình.</div>
                    </div>
                    <div class="upload-list" style="padding: 5px; margin-top: 15px; display: none;">
                        <div class="grid gap-6 grid-cols-12">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-tw-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add-slide">Tạo mới</button>
            </div>
        </div>
    </div>
</div>
<!--END: upload image to slide group -->
<!--START: edit slide -->
<div class="modal inmodal" id="basic-modal-edit-slide" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <i data-lucide="monitor" style="height:94px;width:100px;color:#dddddd"></i>

                <h4 class="modal-title mb-1">Cập nhập Banner &amp; Slide</h4>
                <small class="font-bold">Kích thước banner hiển thị tốt nhất <span class="text-danger"
                        style="font-size:16px;">1920x760</span> pixel, các banner nên có kích thước bằng
                    nhau.</small>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger-soft show flex items-center mb-5" role="alert" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="alert-octagon" data-lucide="alert-octagon"
                        class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span class="title_error"></span>
                </div>
                <form class="m-t update-group" role="form" method="post" action="">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-tw-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update-slide">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<!--END: edit slide -->
<style>
#basic-modal-edit-slide .img-thumbnail {
    width: 100%;
    height: 100%;
}
.modal.show{
    z-index: 10 !important;
}
</style>
@include('slide.backend.style')
@include('slide.backend.script')
@endsection
