jQuery(document).ready(function($) {
    if($( window ).width() > 1024) {
        $('.entry-content>div.first-child').addClass('slide-container');
    } else {
        $('.entry-content>div.first-child').removeClass('slide-container');
    }
});