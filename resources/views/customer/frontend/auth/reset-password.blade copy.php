@extends('homepage.layout.auth')
@section('content')
<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Quên mật khẩu</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                quay lại
                <a href="<?php echo route('customer.login') ?>" class="font-medium text-indigo-600 hover:text-indigo-500"> đăng nhập</a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="" method="POST" id="form-auth">
            @csrf
            <div class="rounded-md shadow-sm">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative mb-5" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">
                        {{session('success')}}
                    </span>
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline">
                        {{session('error')}}
                    </span>
                </div>
                @endif
                <div class="mb-5 space-y-1">
                    <label for="email-address">Email</label>
                    <input id="email-address" name="email" value="{{old('email')}}" type="email" autocomplete="email" class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>

            </div>

            <div>
                <button id="submit-auth" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Gửi
                </button>
                <button id="submit-auth-loading" type="button" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                    Loading...
                </button>
            </div>
        </form>
    </div>
</div>
@include('customer/frontend/auth/common/customers')
@endsection