<?php

if (!class_exists('MSDLab_Custom_Page_Support')) {
    class MSDLab_Custom_Page_Support {
        //Properties
        private $options;

        //Methods
        /**
         * PHP 4 Compatible Constructor
         */
        public function MSDLab_Custom_Page_Support(){$this->__construct();}

        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            //Actions
            add_action('genesis_after_header',array(&$this,'add_header_image'),11);

            //Filters
        }

        function add_header_image(){
            global $post;
            if(is_page()){
                if(has_post_thumbnail()){
                    print '<div class="page-header-image">';
                    print genesis_get_image();
                    print '</div>';
                }
            }
        }
    } //End Class
} //End if class exists statement