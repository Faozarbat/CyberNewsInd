jQuery(document).ready(function($) {
    // FlexSlider Init
    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: true,
        directionNav: true,
        prevText: "",
        nextText: ""
    });

    // LightSlider Init
    $('#lightSliderMobile').lightSlider({
        item: 1,
        loop: true,
        slideMove: 1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        auto: true,
        pause: 4000
    });

    // Swiper Init
    var headlineSwiper = new Swiper('.headline-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
        },
    });
});