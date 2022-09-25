@extends('homepage.layout.home')
@section('content')
<nav class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600">Trang chủ</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="javascript:void(0)" class="text-gray-500 hover:text-gray-600">Liên hệ</a></li>
            </ol>
        </nav>
    </div>
</nav>
<div class="py-9 bg-gray-light px-4">
    <div class="container mx-auto">
        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12 md:col-span-6">
                <h1 class="font-bold uppercase text-2xl">{{$fcSystem['homepage_company']}}</h1>

                <div class="space-y-1 mt-5">
                    <div>
                        <a class=" text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out flex items-center space-x-1" href="javascript:void(0)">
                            <b>
                                Địa chỉ:
                            </b>
                            <span>
                                {{$fcSystem['contact_address']}}
                            </span>
                        </a>
                    </div>
                    <div>
                        <a class=" text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out flex items-center space-x-1" href="tel:{{$fcSystem['contact_hotline']}}">
                            <b>
                                Số điện thoại:
                            </b>
                            <span>{{$fcSystem['contact_hotline']}}</span>
                        </a>
                    </div>
                    <div>
                        <a class=" text-gray-600 hover:text-gray-700 focus:text-gray-700 transition duration-150 ease-in-out flex items-center space-x-1" href="mailto:{{$fcSystem['contact_email']}}">
                            <b>
                                Email:
                            </b>
                            <span>
                                {{$fcSystem['contact_email']}}
                            </span>

                        </a>
                    </div>
                </div>
                <div class="mt-5">
                    <form>
                        @csrf
                        <div class="print-error-msg alert" style="display: none;">
                            <ul></ul>
                        </div>
                        <div class="mt-2">
                            <input type="text" class="  border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  ovn_keyword" name="fullname" aria-describedby="emailHelp" placeholder="Họ và tên">
                        </div>
                        <div class="mt-2">
                            <input type="email" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  ovn_keyword" name="email" placeholder="Email">
                        </div>
                        <div class="mt-2">
                            <input type="text" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  ovn_keyword" name="phone" placeholder="Số điện thoại">
                        </div>
                        <div class="mt-2">
                            <input type="text" class="border w-full h-11 px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  ovn_keyword" name="address" placeholder="Địa chỉ">
                        </div>
                        <div class="mt-2">
                            <textarea rows="6" class="border w-full px-3 focus:outline-none focus:ring focus:ring-red-300  hover:outline-none hover:ring hover:ring-red-300  ovn_keyword" name="message" placeholder="Nội dung"></textarea>
                        </div>
                        <button type="submit" class="btn-submit py-4 px-1 md:px-8 rounded-lg block bg-d61c1f border border-solid border-d61c1f uppercase font-semibold text-base hover:bg-d61c1f hover:border-d61c1f text-white transition-all leading-none ">Gửi
                            thông tin liên hệ</button>
                    </form>

                </div>
            </div>
            <div class="col-span-12 md:col-span-6">
                <?php echo $fcSystem['contact_map'] ?>

            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')

<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var fullname = $("input[name='fullname']").val();
            var phone = $("input[name='phone']").val();
            var email = $("input[name='email']").val();
            var address = $("input[name='address']").val();
            var message = $("textarea[name='message']").val();
            $.ajax({
                url: "<?php echo url('lien-he') ?>",
                type: 'POST',
                data: {
                    _token: _token,
                    fullname: fullname,
                    phone: phone,
                    email: email,
                    address: address,
                    message: message
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $(".print-error-msg").html('').removeClass('alert-danger').addClass(
                            'alert-success');
                        $(".print-error-msg").css('display', 'block');
                        $(".print-error-msg").html(data.success);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $(".print-error-msg").html('').addClass('alert-danger');
                        $(".print-error-msg").css('display', 'block');
                        $(".print-error-msg").html(data.error);
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").html('').addClass('alert-danger');
            $(".print-error-msg").css('display', 'block');
            let error = '';
            $.each(msg, function(key, value) {
                error += value + ' /';
                $(".print-error-msg").html(error);
            });
        }
    });
</script>
<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
</style>
@endpush