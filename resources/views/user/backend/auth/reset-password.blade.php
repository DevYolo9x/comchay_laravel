<!DOCTYPE html>
<html class="bg-black">

<head>
    <meta charset="UTF-8">
    <title>Admin | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="{{ asset('backend/css/app.css')}}" />

</head>

<body class="login">
    <div class="container">
        <div class="w-full min-h-screen p-5 md:p-20 flex items-center justify-center">
            <div class="w-96 ">
                <img class="mx-auto w-16" alt="Rocketman - Tailwind HTML Admin Template"
                    src="{{asset('backend/images/logo.svg')}}">
                <div class="text-white dark:text-slate-300 text-2xl font-medium text-center mt-2">Quên mật khẩu?</div>
                <div
                    class="box px-5 py-8 mt-10 max-w-[450px] relative before:content-[''] before:z-[-1] before:w-[95%] before:h-full before:bg-slate-200 before:border before:border-slate-200 before:-mt-5 before:absolute before:rounded-lg before:mx-auto before:inset-x-0 before:dark:bg-darkmode-600/70 before:dark:border-darkmode-500/60">
                    <form action="{{route('admin.reset-password')}}" method="post" id="resetform">
                        @csrf
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible show flex items-center mb-2" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" icon-name="alert-triangle" data-lucide="alert-triangle"
                                class="lucide lucide-alert-triangle w-6 h-6 mr-2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z">
                                </path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            <b class="mr-1">Success! </b> {{session('success')}}
                            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" icon-name="x" data-lucide="x"
                                    class="lucide lucide-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible show flex items-center mb-2" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon"
                                class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                                <polygon
                                    points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <b class="mr-1">Error! </b> {{session('error')}}
                            <button type="button" class="btn-close text-white" data-tw-dismiss="alert"
                                aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x"
                                    class="lucide lucide-x w-4 h-4">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        @endif
                        <input type="text" class="form-control py-3 px-4 block" placeholder="Email"
                            value="{{old('email')}}" name="email">
                        <div class="mt-5 xl:mt-8 text-center">
                            <button class="btn btn-primary w-full xl:mr-3" type="submit">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="{{asset('backend/js/app.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- END: JS Assets-->
    <div class="lds-dual-ring hidden"></div>
    <script>
    $("#resetform").submit(function(event) {
        $('.lds-dual-ring').removeClass('hidden');

    });
    </script>
</body>

</html>
<style>
.lds-dual-ring {
    width: 80px;
    height: 80px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 999999999999;
}

.lds-dual-ring:after {
    content: " ";
    display: block;
    width: 64px;
    height: 64px;
    margin: 8px;
    border-radius: 50%;
    border: 6px solid #fff;
    border-color: red transparent red transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}

@keyframes lds-dual-ring {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }

}
</style>