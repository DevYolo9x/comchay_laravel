<div class="w-full md:w-1/3 px-3">
    <div class="item mt-0 md:mt-[10px]">
        <h3 class="footer_title pb-3 text-white opacity-80 text-f15 font-semibold">
            {{$fcSystem['title_0']}}
        </h3>
        <div class="form-footer">
            <p class="text-f15 text-white opacity-70 mb-4">
                {{$fcSystem['title_1']}}
            </p>
            <form action="" class="relative form-subscribe">
                @csrf
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg "
                    style="display: none">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline"></span>
                </div>
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg"
                    style="display: none">
                    <div class="flex items-center mb-">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold"></span>
                        </div>
                    </div>
                </div>
                <input type="text" placeholder="{{$fcSystem['title_2']}}" name="email"
                    class="h-[40px] w-full bg-transparent text-f14 pl-[10px] text-white" />
                <button class="h-[40px] absolute w-[40px] right-0 text-center btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>

                </button>
            </form>
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $(".btn-submit").click(function(e) {
        e.preventDefault();
        var _token = $(".form-subscribe input[name='_token']").val();
        var email = $(".form-subscribe input[name='email']").val();
        $.ajax({
            url: "<?php echo route('subcribersContact')?>",
            type: 'POST',
            data: {
                _token: _token,
                email: email,
                type: "email",
            },
            success: function(data) {
                if (data.status == 200) {
                    $(".form-subscribe .print-error-msg").css('display', 'none');
                    $(".form-subscribe .print-success-msg").css('display', 'block');
                    $(".form-subscribe .print-success-msg span").html(
                        "<?php echo $fcSystem['message_1']?>");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    $(".form-subscribe .print-error-msg").css('display', 'block');
                    $(".form-subscribe .print-success-msg").css('display', 'none');
                    $(".form-subscribe .print-error-msg span").html(data.error);
                }
            }
        });
    });
});
</script>
@endpush