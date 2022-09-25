<section class="py-[100px] md:py-[150px] location">
    <h3 class="text-center text-f21 font-medium text-blue003 mb-[50px] tracking-[4px]">{{$fcSystem['title_20']}}
    </h3>
    <div class="content-store-location pt-0">
        <div class="flex flex-wrap justify-between h-full items-center ">
            <div class="w-full md:w-2/5 px-6 mb-[50px] md:mb-0">
                <div class="content-contact scrollbar">
                    <?php
                    $address = \App\Models\Address::select('title', 'address', 'email', 'hotline', 'time')
                        ->where(['alanguage' => config('app.locale'), 'publish' => 0])
                        ->get();
                    ?>
                    @if(count($address) > 0)
                    @foreach($address as $key=>$item)
                    <div class="border-b border-gray-200 pb-5 mb-5">
                        <h3 class="text-f13 uppercase mb-[15px]">{{$item->title}}</h3>
                        <p class="text-f12 text-gray524">{{$item->address}}</p>
                        <p class="text-f12 text-gray524">{{$item->hotline}}</p>
                        <p class="text-f12 text-gray524">{{$item->time}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="w-full md:w-3/5">
                <div class="img mt-4 md:mt-0">
                    <img src="{{asset($fcSystem['banner_1'])}}" alt="{{$fcSystem['title_20']}}" class="w-full">
                </div>
            </div>
        </div>
    </div>
</section>
@push('css')
<style>
    /* css contact */
    .banner-content::after {
        content: '';
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), color-stop(57%, rgba(0, 0, 0, .56)), to(rgba(0, 0, 0, .8)));
        background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, .56) 57%, rgba(0, 0, 0, .8) 100%);
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, .56) 57%, rgba(0, 0, 0, .8) 100%);
        position: absolute;
        width: 100%;
        height: 55%;
        right: 0;
        bottom: 0;
    }

    .main-contact .content-store-location {
        margin-left: calc(100% - 1140px - ((100% - 1140px)/ 2) + 15px);
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    @media (max-width: 1024px) {
        .main-contact .content-store-location {
            margin-left: 0;
        }
    }

    .scrollbar {
        height: 483px;
        overflow-y: scroll;
    }

    .scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar {
        width: 6px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar-thumb {
        background-color: #000000;
    }
</style>
@endpush