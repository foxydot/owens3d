<?php
if (!class_exists('MSDLab_Fixed_Header_Support')) {
    class MSDLab_Fixed_Header_Support
    {
        //Properties
        private $options;

        //Methods
        function __construct($options)
        {
            global $current_screen;
            //"Constants" setup
            //Actions
            //add_action('msdlab_title_area', array(&$this, 'do_header_buffer'),10);

            //Filters
        }

        function do_header_buffer(){
            print '<div class="header-buffer"></div>';
        }
    }
}