jQuery(document).ready(function($) {
    // Hamburger Menu Toggle
    $('.hamburger-button').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('active');
        $('.menu-utama').slideToggle(300);
    });

    // Responsive Menu
    function setupResponsiveMenu() {
        if ($(window).width() < 768) {
            // Mobile Menu
            $('.menu-utama .menu-item-has-children > a').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).siblings('.sub-menu').slideToggle(300);
                $(this).parent().toggleClass('active');
            });
        } else {
            // Desktop Menu
            $('.menu-utama').show();
            $('.menu-utama .sub-menu').show();
        }
    }

    // Initial setup
    setupResponsiveMenu();

    // Setup on resize
    $(window).resize(function() {
        setupResponsiveMenu();
    });
});