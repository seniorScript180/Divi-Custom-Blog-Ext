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


    // jQuery('.popup-with-form').magnificPopup({
    //     type: 'inline',
    //     preloader: false,
    //     focus: '#name',

    //     // When elemened is focused, some mobile browsers in some cases zoom in
    //     // It looks not nice, so we disable it:
    //     callbacks: {
    //         beforeOpen: function() {
    //             if (jQuery(window).width() < 700) {
    //                 this.st.focus = false;
    //             } else {
    //                 this.st.focus = '#name';
    //             }
    //         }
    //     }
    // });

    if (jQuery('#hidden-popup-form').length) {

        jQuery('.popup-trigger').magnificPopup({
            items: {
                src: '#hidden-popup-form',
                type: 'inline'
            }
        });

    }



});