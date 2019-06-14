jQuery(document).ready(function($) {
    $('.section-future .section-content').matchHeight();
    $('.section-impact .section-content>.first-child').matchHeight();
    if($( window ).width() < 768) {
        $('.section-impact .section-body').prepend('<div class="previous fa fa-angle-left"><span class="screen-reader-text">PREVIOUS</span></div><div class="next fa fa-angle-right"><span class="screen-reader-text">NEXT</span></div>');
        $('.section-impact .section-body .column-holder').css('width', function () {
            var w;
            w = $('.section-impact .section-body .column-holder .section-content').outerWidth();
            return w * 3;
        });
        $('.section-impact .section-body .previous').click(function () {
            var theleft = parseInt($('.section-impact .section-body .column-holder').css('left'));
            theleft = parseInt(theleft, 10);
            thewidth = $('.section-impact .section-body .column-holder .section-content').outerWidth();
            if (theleft < 0) {
                theleft = theleft + thewidth;
            } else {
                theleft = 0 - (thewidth * 2);
            }
            $('.section-impact .section-body .column-holder').css('left', theleft);
        });

        $('.section-impact .section-body .next').click(function () {
            var theleft = $('.section-impact .section-body .column-holder').css('left');
            theleft = parseInt(theleft, 10);
            thewidth = $('.section-impact .section-body .column-holder .section-content').outerWidth();
            if (theleft > 0 - (thewidth * 2)) {
                theleft = theleft - thewidth;
            } else {
                theleft = 0;
            }
            $('.section-impact .section-body .column-holder').css('left', theleft);
        });
    }
});