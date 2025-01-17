jQuery(document).ready(function($) {
    // Add toggle button to each caption
    $('.wp-caption').each(function() {
        var $caption = $(this).find('.wp-caption-text');
        if($caption.length) {
            var $toggle = $('<button class="caption-toggle"><i class="fas fa-info-circle"></i></button>');
            $(this).append($toggle);
            
            // Initially hide caption
            $caption.hide();
            
            // Toggle caption on click
            $toggle.click(function(e) {
                e.preventDefault();
                $caption.slideToggle(200);
                $(this).toggleClass('active');
            });
        }
    });
});