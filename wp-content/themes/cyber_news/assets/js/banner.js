// Di assets/js/banner.js
jQuery(document).ready(function($) {
    // Banner Parallax
    if($(window).width() < 768) {
        setTimeout(function() {
            $('#sidebar-banner-mobile-top-header-parallax').fadeIn();
        }, 2000);
    }

    $('.close-button').click(function(e) {
        e.preventDefault();
        $(this).closest('.banner-container').fadeOut();
    });

    // Parallax effect on scroll
    $(window).scroll(function() {
        if($(window).width() < 768) {
            var scrolled = $(window).scrollTop();
            $('.sidebar-banner-mobile-top-header-parallax-wrap').css('transform', 'translateY(' + (scrolled * 0.3) + 'px)');
        }
    });

    // Floating Banner
    setTimeout(function() {
        $('.floating-banner').fadeIn();
    }, 3000);
});