$('.tp-search,.btnCloseSearch').click(function() {
    $('.header-search').toggleClass('hidden')
});
$('.tp-cart').click(function() {
    $('.offcanvas-overlay').toggleClass('hidden');
    $('#offcanvas-cart').toggleClass('hidden');
});

$(".offcanvas-close, .offcanvas-overlay").on("click", function(e) {
    e.preventDefault();
    $('.offcanvas-overlay').addClass('hidden');
    $('#offcanvas-cart').addClass('hidden ');
});
$(document).on("mouseover", '.variant-image-loop', function(e){
    e.preventDefault();
    var id = $(this).data('feature-image');
    var img = $(this).data('img');
    $('#'+id).attr('src',img);
});
