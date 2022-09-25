@extends('dashboard.layout.dashboard')
@section('title')
<title>Chi tiết đặt tour</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách đặt tour",
            "src" => route('tour_books.index'),
        ],
        [
            "title" => "Chi tiết đặt tour",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <div class=" flex flex-col sm:flex-row items-center mt-8">
        <h2 class="flex items-center text-lg font-medium mr-auto">
            Thông tin đặt tour <i class="w-4 h-4 mx-2 !stroke-2" data-lucide="arrow-right"></i> #{{$detail->code}}
        </h2>

    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Order Detail Side Menu -->
        <div class="col-span-12 md:col-span-4">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết giao dịch</div>
                </div>
                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i>
                    CODE: <button class="underline decoration-dotted ml-1">{{$detail->code}}</button>
                </div>
                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Ngày đặt: {{$detail->created_at}} </div>


            </div>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Thông tin khách hàng đặt tour</div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <b>Full Name:</b> <span class=" decoration-dotted ml-1">{{$detail->fullname}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Email Adress:</b> <span class=" decoration-dotted ml-1">{{$detail->email}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Phone:</b> <span class=" decoration-dotted ml-1">{{$detail->phone}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Travel Date:</b> <span class=" decoration-dotted ml-1">{{$detail->date}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Adult:</b> <span class=" decoration-dotted ml-1">{{$detail->adult}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Children:</b> <span class=" decoration-dotted ml-1">{{$detail->children}}</span>
                    </div>
                    <div class="">
                        <div>
                            <b>Your Enquiry:</b>
                        </div>
                        <div>
                            {{$detail->message}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Order Detail Side Menu -->
        <!-- BEGIN: Order Detail Content -->
        <?php $cart = json_decode($detail->cart, TRUE); ?>
        <div class="col-span-12 md:col-span-8">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Tour</div>
                </div>
                <div>
                    <div
                        class="flex flex-col md:flex-row items-center py-4 first:pt-0 last:border-0 last:pb-0 border-b border-dashed border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center md:mr-auto">

                            <div>
                                <div class="font-medium"><a class="text-primary"
                                        href="{{route('routerURL',['slug'=> $detail->tour->slug])}}"
                                        target="_blank">{{$detail->tour->title}}</a></div>

                                <?php
                                        $price = getPrice(array('price' => $detail->tour->price, 'price_sale' => $detail->tour->price_sale, 'price_contact' => $detail->tour->price_contact));

                                ?>
                                <div class="text-slate-500 mt-1">
                                    <del><?php echo $price['price_old']?></del>
                                    <?php echo $price['price_final']?>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END: Order Detail Content -->
    </div>
</div>
@endsection
