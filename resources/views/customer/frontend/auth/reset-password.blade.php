@extends('homepage.layout.auth')
@section('content')
<section class="h-screen">
    <div class="px-6 h-full text-gray-800">
        <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
            <div class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0">
                <img src="{{asset('frontend/images/draw2.webp')}}" class="w-full" alt="Sample image" />
            </div>
            <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                <form action="" method="POST" id="form-auth">
                    @csrf
                    <div class="flex flex-row items-center justify-center lg:justify-start">
                        <p class="text-lg mb-0 mr-4 font-bold">Quên mật khẩu</p>
                    </div>
                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative my-3" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">
                            {{session('success')}}
                        </span>
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
                        <strong class="font-bold">ERROR!</strong>
                        <span class="block sm:inline">
                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </span>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-5" role="alert">
                        <strong class="font-bold">ERROR!</strong>
                        <span class="block sm:inline">
                            {{session('error')}}
                        </span>
                    </div>
                    @endif
                    <!-- Email input -->
                    <div class="my-3">
                        <input type="text" name="email" class="form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="{{old('email')}}" placeholder="Email" />
                    </div>
                    <!-- Password input -->
                    <div class="text-center lg:text-left">
                        <button type="submit" class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Gửi
                        </button>
                        <?php /*<p class="text-sm font-semibold mt-2 pt-1 mb-0">
                            Bạn chưa có tài khoản?
                            <a href="{{route('customer.register')}}" class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out">Đăng ký</a>
                        </p>*/ ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection