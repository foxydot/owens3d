<?php
if (!class_exists('MSDLab_Video_Background_Support')) {
    class MSDLab_Video_Background_Support
    {
        //Properties
        private $options;

        //Methods
        function __construct($options)
        {
            global $current_screen;
            //"Constants" setup
            //Actions
            add_action('genesis_before_header', array(&$this, 'do_video_background'),10);

            //Filters
        }

        function do_video_background(){
            if(is_admin()){return;}
            if(wp_is_mobile()){return;}
            if(!is_front_page() && get_section() != 'solutions'){return;}
            $select = $_GET['bkg'];
            switch($select){
                case 8:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/AdobeStock_133304947_Video_HD_Preview.mp4';
                    break;
                case 7:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/AdobeStock_115600019_Video_HD_Preview.mp4';
                    break;
                case 6:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/AdobeStock_31821334_Video_HD_Preview.mp4';
                    break;
                case 5:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/12370370-preview.mp4';
                    break;
                case 4:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/bluest_1.15.mp4';
                    break;
                case 3:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/bluest_1min.mp4';
                    break;
                case 2:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/bluest_45sec.mp4';
                    break;
                case 1:
                default:
                    $videosrc = get_stylesheet_directory_uri().'/lib/images/infinite_sky.mp4';
                    break;
            }
            print '<!-- The video -->
<video autoplay muted loop id="bkgVideo">
  <source src="'.$videosrc.'" type="video/mp4">
</video>
<style>
#bkgVideo {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    min-height: 120%;
    min-width: 120%;
    z-index: -1000;
}

</style>';
        }
    }
}