jQuery(document).ready(function($) {
    // Copy URL Button
    $('.copy-url').click(function(e) {
        e.preventDefault();
        var copyText = $(this).data('url');
        
        // Create temporary input
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(copyText).select();
        
        // Execute copy command
        document.execCommand("copy");
        tempInput.remove();
        
        // Show feedback
        var $button = $(this);
        $button.text('URL Disalin!');
        setTimeout(function() {
            $button.text('Salin URL');
        }, 2000);
    });

    // Social Share Buttons
    $('.share-facebook').click(function(e) {
        e.preventDefault();
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + $(this).data('url'), 
            'facebook-share', 'width=580,height=296');
    });

    $('.share-twitter').click(function(e) {
        e.preventDefault();
        window.open('https://twitter.com/intent/tweet?url=' + $(this).data('url') + '&text=' + $(this).data('title'),
            'twitter-share', 'width=580,height=296');
    });

    $('.share-whatsapp').click(function(e) {
        e.preventDefault();
        window.open('https://api.whatsapp.com/send?text=' + $(this).data('title') + ' ' + $(this).data('url'),
            'whatsapp-share', 'width=580,height=296');
    });
});