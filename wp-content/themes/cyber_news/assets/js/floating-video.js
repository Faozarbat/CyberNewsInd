jQuery(document).ready(function($) {
    if($('.video-wrapper').length) {
        var videoWrapper = $('.video-wrapper');
        var videoOffset = videoWrapper.offset().top;
        var videoHeight = videoWrapper.height();
        var headerHeight = $('.header-fixed').height();
        
        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop();
            
            if(scrollTop > (videoOffset + videoHeight) && !videoWrapper.hasClass('floating')) {
                videoWrapper.addClass('floating');
                $('.responsive-video').addClass('minimized');
            }
            
            if(scrollTop < videoOffset && videoWrapper.hasClass('floating')) {
                videoWrapper.removeClass('floating');
                $('.responsive-video').removeClass('minimized');
            }
        });

        // Tombol close untuk floating video
        videoWrapper.append('<button class="close-floating-video">×</button>');
        
        $('.close-floating-video').click(function() {
            videoWrapper.removeClass('floating');
            $('.responsive-video').removeClass('minimized');
        });
    }
});