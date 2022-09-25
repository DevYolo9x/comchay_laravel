@extends('homepage.layout.home')
@section('content')
<main>
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                @include('homepage.common.aside')
            </div>
            <div class="col-span-12 lg:col-span-9 space-y-6 mt-5 md:mt-0 order-0 lg:order-1">
                <div>
                    <div class="flex justify-between items-center border-b border-global">
                        <h2 class="h2-category h2-main text-global font-bold text-lg  tracking-tighter relative pb-1"><span class="uppercase"> GỬI CHỦ ĐỀ THẢO LUẬN MỚI</span></h2>
                    </div>
                    <form class="mt-3 space-y-3" method="post" action="">
                        @csrf




                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Email</label>
                            <input type="text" name="" class="flex-1 form-control block w-full py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding rounded transition ease-in-out m-0 focus:outline-none" value="{{Auth::guard('customer')->user()->email}}" disabled />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Mật khẩu cũ</label>
                            <input type="password" name="current_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="{{old('title')}}" placeholder="" />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Mật khẩu mới</label>
                            <input type="password" name="old_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="{{old('title')}}" placeholder="" />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Nhập lại mật khẩu mới</label>
                            <input type="password" name="new_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="{{old('title')}}" placeholder="" />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="submit" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                <span>Đổi mật khẩu</span>
                            </button>
                            <button type="reset" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                <span>Nhập lại</span>
                            </button>
                        </div>
                    </form>
                    <div class="mt-3">
                        <?php echo $fcSystem['title_sale'] ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>
</main>

@endsection

@push('javascript')


@endpush