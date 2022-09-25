@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách đặt lịch hẹn</title>
@endsection
@section('breadcrumb')
<?php
    $array = array([
            "title" => "Danh sách đặt lịch hẹn",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách đặt lịch hẹn
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module])
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Thông tin</th>
                        <th class="whitespace-nowrap">Cửa hàng</th>
                        <th class="whitespace-nowrap">Ngày hẹn</th>
                        <th class="whitespace-nowrap">Ngày gửi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>"
                                class="checkbox-item">
                        </td>
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <p><?php echo $v->fullname; ?></p>
                            <p><?php echo $v->phone; ?></p>
                            <p><?php echo $v->email; ?></p>
                        </td>
                        <td>
                            <p><?php echo $v->address; ?></p>
                        </td>
                        <td>
                            <p><?php echo $v->message; ?></p>
                        </td>
                        <td>
                            {{$v->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            {{$data->links()}}
        </div>
        <!-- END: Pagination -->
    </div>
</div>



@endsection