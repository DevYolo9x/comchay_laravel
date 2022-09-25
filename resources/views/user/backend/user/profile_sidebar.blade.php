<div class="col-span-12 xl:col-span-4">
    <div class="box  p-5">
        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
            <div class="font-medium truncate text-base">Thông tin tài khoản
            </div>
        </div>
        <div>
            <div class="flex border-b border-slate-200 border-dashed pb-5 mb-5 last:border-b-0 last:pb-0 last:mb-0">
                <img class=" rounded-full bg-slate-200 dark:bg-darkmode-400 flex items-center justify-center text-base font-medium"
                    src="{{!empty(Auth::user()->image)?url(Auth::user()->image):asset('images/404.png')}}"
                    alt="user image" style="width: 100px;height: 100px;object-fit: cover;">
                <div>
                    <div class="ml-5">
                        <div class="font-medium text-base">Họ và tên</div>
                        <div class=" text-slate-500">{{Auth::user()->name}}</div>
                    </div>
                    <div class="ml-5 mt-1">
                        <div class="font-medium text-base">Email</div>
                        <div class=" text-slate-500">{{Auth::user()->email}}</div>
                    </div>
                    <div class="ml-5 mt-1">
                        <div class="font-medium text-base">Địa chỉ</div>
                        <div class=" text-slate-500">{{Auth::user()->address}}</div>
                    </div>
                    <div class="ml-5 mt-1">
                        <div class="font-medium text-base">Số điện thoại</div>
                        <div class=" text-slate-500">{{Auth::user()->phone}}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>