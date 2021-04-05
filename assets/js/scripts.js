jQuery(document).ready(function() {

    var $slider_wrapper = jQuery('.swiper-wrapper');

    if ($slider_wrapper.length) {
        $slider_wrapper.slick({
            autoplay: true,
            autoplaySpeed: 4500,
            arrows: true,
            dots: true,

        });
    }


});