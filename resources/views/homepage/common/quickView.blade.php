<div id="modal-quick-view"
    class="modal  fixed opacity-0 transition-opacity duration-300 ease-linear md:w-11/12 md:max-w-1000 hidden z-40 left-8 right-8 md:left-1/2 top-1/2 transform -translate-y-1/2 md:-translate-x-1/2 p-2 md:p-7 bg-white">
</div>
<div class="modal-overlay hidden fixed inset-0 bg-black opacity-50 z-10"></div>
@push('javascript')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
/*  modal menu style */
.modal.modal-open {
    display: block;
    opacity: 1;
}
</style>
<script src="{{ asset('frontend/library/product.js') }}"></script>
<script>
function loadSlide() {
    var swiper = new Swiper(".mySwiper", {
        loop: false,
        spaceBetween: 15,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        loop: false,
        spaceBetween: 5,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
}
</script>
<script>
/*START: quick view */
$(".quick-view-modal").on("click", function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: BASE_URL_AJAX + "ajax/product/quick-view",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: $(this).attr('data-id'),
        },
        success: function(data) {
            console.log(data);
            var $this = $(this);
            $("#modal-quick-view").html('').html(data.html);
            $("body").addClass("modal-open");
            $("#modal-quick-view").addClass("modal-open");
            $(".modal-overlay").fadeIn();
            loadSlide();
            loadSize();
            loadColors();
            if ($this.parent().hasClass("modal-menu-toggle")) {
                $this.addClass("close");
            }
        },
        error: function(jqXhr, json, errorThrown) {
            toastr.error(jqXhr.responseJSON.error, 'Error!')
        },
    });
});
/*END: quick view */
var
    $body = $("body");
$modalToggle = $(".modal-toggle"),
    $modal = $(".modal"),
    $modalOverlay = $(".modal-overlay"),
    $modalMenuToggle = $(".modal-menu-toggle");
$(document).on("click", ".modal-close, .modal-overlay", function(e) {
    e.preventDefault();
    $body.removeClass("modal-open");
    $modal.removeClass("modal-open");
    $modalOverlay.fadeOut();
    $modalMenuToggle.find("a").removeClass("close");
});
</script>
@include('product.frontend.product.common.style')
@endpush