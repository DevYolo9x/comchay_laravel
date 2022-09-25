@extends('homepage.layout.auth')
@section('content')
<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Đăng nhập tài khoản</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                hoặc
                <a href="<?php echo route('customer.register') ?>" class="font-medium text-indigo-600 hover:text-indigo-500"> đăng ký</a>
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{route('customer.login-store')}}" method="POST" id="form-auth">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="rounded-md shadow-sm">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative mb-5" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">
                        {{session('success')}}
                    </span>
                </div>
                @endif
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline">
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </span>
                </div>
                @endif
                <div class="mb-5 space-y-1">
                    <label for="email-address">Email</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="" value="{{old('email')}}">
                </div>
                <div class="space-y-1">
                    <label for="password mb-1">Mật khẩu</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="" value="{{old('password')}}">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
                </div>

                <div class="text-sm">
                    <a href="{{route('customer.reset-password')}}" class="font-medium text-indigo-600 hover:text-indigo-500"> Quên mật khẩu </a>
                </div>
            </div>

            <div>
                <button id="submit-auth" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Đăng nhập
                </button>
                <button id="submit-auth-loading" type="button" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                    Loading...
                </button>
                <p class="m-5 text-center text-sm text-gray-600">
                    hoặc
                    <a href="javascript:void()" class="font-medium text-indigo-600 hover:text-indigo-500"> đăng nhập bằng</a>
                </p>

                @include('customer/frontend/auth/common/social')

            </div>
        </form>
    </div>
</div>
@include('customer/frontend/auth/common/customers')
@endsection