  
  <?php $__env->startSection('content'); ?>
  <div id="main" class="main-contact ">
      <div class="container mx-auto px-3">
          <div class="breadcrumb mb-3  py-[10px]">
              <ul class="flex flex-wrap">
                  <li class="pr-[5px]"><a href="<?php echo e(url('')); ?>"><?php echo e($fcSystem['title_7']); ?></a> /</li>
                  <li><?php echo e($page->title); ?></li>
              </ul>
          </div>
          <div class="map">
              <?php echo $fcSystem['contact_map'] ?>
          </div>
          <div class="contact-btottom mt-5 md:mt-8">
              <div class="flex flex-wrap justify-between -mx-3">
                  <div class="w-full md:w-2/3 px-3">
                      <form action="" id="form-submit-contact">
                          <?php echo csrf_field(); ?>
                          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg " style="display: none">
                              <strong class="font-bold">ERROR!</strong>
                              <span class="block sm:inline"></span>
                          </div>
                          <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">
                              <div class="flex items-center mb-">
                                  <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                          <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                      </svg>
                                  </div>
                                  <div>
                                      <span class="font-bold"></span>
                                  </div>
                              </div>
                          </div>
                          <div class="flex flex-wrap justify-between -mx-3">
                              <div class="w-full md:w-1/2 px-3">
                                  <label class="inline-block w-full text-gray-500"><?php echo e($fcSystem['title_8']); ?> *</label>
                                  <input type="text" name="fullname" class="pl-4 w-full h-[50px] border border-gray-300 mt-2 bg-gray-100 rounded-sm">
                              </div>
                              <div class="w-full md:w-1/2 px-3">
                                  <label class="inline-block w-full text-gray-500">Email *</label>
                                  <input type="text" name="email" class="pl-4 w-full h-[50px] border border-gray-300 mt-2 bg-gray-100 rounded-sm">
                              </div>

                          </div>
                          <div class="mt-5">
                              <label class="inline-block w-full text-gray-500"><?php echo e($fcSystem['title_5']); ?></label>
                              <input type="text" name="phone" class="pl-4 w-full h-[50px] border border-gray-300 mt-2 bg-gray-100 rounded-sm">
                          </div>
                          <div class="mt-5">
                              <label class="inline-block w-full text-gray-500"><?php echo e($fcSystem['title_4']); ?></label>
                              <input type="text" name="address" class="pl-4 w-full h-[50px] border border-gray-300 mt-2 bg-gray-100 rounded-sm">
                          </div>
                          <div class="mt-5">
                              <label class="inline-block w-full text-gray-500"><?php echo e($fcSystem['title_9']); ?></label>
                              <textarea name="message" cols="30" rows="10" class="p-4 w-full h-[100px] border border-gray-300 mt-2 bg-gray-100 rounded-sm"></textarea>
                              <button type="submit" class="btn-submit-contact write-review__button write-review__button--submit bg-Orangefc5 text-white h-[50px] mt-[15px] text-f15 rounded-[5px] uppercase w-24">
                                  <span><?php echo e($fcSystem['title_10']); ?> </span>
                              </button>
                          </div>

                      </form>
                  </div>
                  <div class="w-full md:w-1/3 px-3 mt-[15px] md:mt-0">
                      <div class="bg-gray-100 border border-gray-200 p-[10px] md:p-[25px]">
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-Orangefc5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path>
                                  </svg>
                                  <span>
                                      <?php echo e($fcSystem['title_4']); ?>

                                  </span>
                              </h4>
                              <p class="text-gray-500"><?php echo $fcSystem['contact_address'] ?></p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-Orangefc5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path>
                                  </svg>
                                  <span><?php echo e($fcSystem['title_5']); ?></span>

                              </h4>
                              <p class="text-gray-500"><?php echo $fcSystem['contact_hotline'] ?></p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-Orangefc5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
                                  </svg>
                                  <span>Email</span>
                              </h4>
                              <p class="text-gray-500"><?php echo $fcSystem['contact_email'] ?></p>
                          </div>
                          <div class="mb-[20px]">
                              <h4 class="text-f15 font-bold flex items-center">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 text-Orangefc5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                  <span><?php echo e($fcSystem['title_11']); ?></span>
                              </h4>
                              <p class="text-gray-500"><?php echo $fcSystem['contact_time'] ?></p>

                          </div>
                          <div class="border-t border-gray-200 pt-5 mt-5">
                              <ul class="flex flex-wrap justify-center">
                                  <li>
                                      <a href="<?php echo e($fcSystem['social_facebook']); ?>" target="_blank" class="w-[35px] h-[35px] leading-[35px] text-center bg-gray-700 text-white inline-block rounded-full mx-[2px] hover:bg-Orangefc5 transition-all relative">
                                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30" class="w-6 h-6 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 " style=" fill:#fff;">
                                              <path d="M12,27V15H8v-4h4V8.852C12,4.785,13.981,3,17.361,3c1.619,0,2.475,0.12,2.88,0.175V7h-2.305C16.501,7,16,7.757,16,9.291V11 h4.205l-0.571,4H16v12H12z">
                                              </path>
                                          </svg>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="<?php echo e($fcSystem['social_twitter']); ?>" target="_blank" class="w-[35px] h-[35px] leading-[35px] text-center bg-gray-700 text-white inline-block rounded-full mx-[2px] hover:bg-Orangefc5 transition-all relative">
                                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30" class="w-5 h-5 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 " style=" fill:#fff;">
                                              <path d="M28,6.937c-0.957,0.425-1.985,0.711-3.064,0.84c1.102-0.66,1.947-1.705,2.345-2.951c-1.03,0.611-2.172,1.055-3.388,1.295 c-0.973-1.037-2.359-1.685-3.893-1.685c-2.946,0-5.334,2.389-5.334,5.334c0,0.418,0.048,0.826,0.138,1.215 c-4.433-0.222-8.363-2.346-10.995-5.574C3.351,6.199,3.088,7.115,3.088,8.094c0,1.85,0.941,3.483,2.372,4.439 c-0.874-0.028-1.697-0.268-2.416-0.667c0,0.023,0,0.044,0,0.067c0,2.585,1.838,4.741,4.279,5.23 c-0.447,0.122-0.919,0.187-1.406,0.187c-0.343,0-0.678-0.034-1.003-0.095c0.679,2.119,2.649,3.662,4.983,3.705 c-1.825,1.431-4.125,2.284-6.625,2.284c-0.43,0-0.855-0.025-1.273-0.075c2.361,1.513,5.164,2.396,8.177,2.396 c9.812,0,15.176-8.128,15.176-15.177c0-0.231-0.005-0.461-0.015-0.69C26.38,8.945,27.285,8.006,28,6.937z"></path>
                                          </svg>

                                      </a>
                                  </li>
                                  <li>
                                      <a href="<?php echo e($fcSystem['social_instagram']); ?>" target="_blank" class="w-[35px] h-[35px] leading-[35px] text-center bg-gray-700 text-white inline-block rounded-full mx-[2px] hover:bg-Orangefc5 transition-all relative">
                                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30" class="w-5 h-5 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 " style=" fill:#fff;">
                                              <path d="M 9.9980469 3 C 6.1390469 3 3 6.1419531 3 10.001953 L 3 20.001953 C 3 23.860953 6.1419531 27 10.001953 27 L 20.001953 27 C 23.860953 27 27 23.858047 27 19.998047 L 27 9.9980469 C 27 6.1390469 23.858047 3 19.998047 3 L 9.9980469 3 z M 22 7 C 22.552 7 23 7.448 23 8 C 23 8.552 22.552 9 22 9 C 21.448 9 21 8.552 21 8 C 21 7.448 21.448 7 22 7 z M 15 9 C 18.309 9 21 11.691 21 15 C 21 18.309 18.309 21 15 21 C 11.691 21 9 18.309 9 15 C 9 11.691 11.691 9 15 9 z M 15 11 A 4 4 0 0 0 11 15 A 4 4 0 0 0 15 19 A 4 4 0 0 0 19 15 A 4 4 0 0 0 15 11 z"></path>
                                          </svg>
                                      </a>
                                  </li>
                                  <li>
                                      <a href="<?php echo e($fcSystem['social_youtube']); ?>" target="_blank" class="w-[35px] h-[35px] leading-[35px] text-center bg-gray-700 text-white inline-block rounded-full mx-[2px] hover:bg-Orangefc5 transition-all relative">
                                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30" class="w-5 h-5 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 " style=" fill:#fff;">
                                              <path d="M 15 4 C 10.814 4 5.3808594 5.0488281 5.3808594 5.0488281 L 5.3671875 5.0644531 C 3.4606632 5.3693645 2 7.0076245 2 9 L 2 15 L 2 15.001953 L 2 21 L 2 21.001953 A 4 4 0 0 0 5.3769531 24.945312 L 5.3808594 24.951172 C 5.3808594 24.951172 10.814 26.001953 15 26.001953 C 19.186 26.001953 24.619141 24.951172 24.619141 24.951172 L 24.621094 24.949219 A 4 4 0 0 0 28 21.001953 L 28 21 L 28 15.001953 L 28 15 L 28 9 A 4 4 0 0 0 24.623047 5.0546875 L 24.619141 5.0488281 C 24.619141 5.0488281 19.186 4 15 4 z M 12 10.398438 L 20 15 L 12 19.601562 L 12 10.398438 z"></path>
                                          </svg>
                                      </a>
                                  </li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>
  <?php $__env->stopSection(); ?>
  <?php $__env->startPush('javascript'); ?>
  <script type="text/javascript">
      $(document).ready(function() {
          $(".btn-submit-contact").click(function(e) {
              e.preventDefault();
              var _token = $("#form-submit-contact input[name='_token']").val();
              var fullname = $("#form-submit-contact input[name='fullname']").val();
              var phone = $("#form-submit-contact input[name='phone']").val();
              var email = $("#form-submit-contact input[name='email']").val();
              var address = $("#form-submit-contact input[name='address']").val();
              var message = $("#form-submit-contact textarea[name='message']").val();
              $.ajax({
                  url: "<?php echo route('contactFrontend.store') ?>",
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
                      if (data.status == 200) {
                          $("#form-submit-contact .print-error-msg").css('display', 'none');
                          $("#form-submit-contact .print-success-msg").css('display', 'block');
                          $("#form-submit-contact .print-success-msg span").html(
                              "<?php echo $fcSystem['message_2'] ?>");
                          setTimeout(function() {
                              location.reload();
                          }, 3000);
                      } else {
                          $("#form-submit-contact .print-error-msg").css('display', 'block');
                          $("#form-submit-contact .print-success-msg").css('display', 'none');
                          $("#form-submit-contact .print-error-msg span").html(data.error);
                      }
                  }
              });
          });
      });
  </script>
  <?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/contact/frontend/index.blade.php ENDPATH**/ ?>