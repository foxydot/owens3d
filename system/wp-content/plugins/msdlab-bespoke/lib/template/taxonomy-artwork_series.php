<?php
if(genesis_test()):
    /**
     * Genesis Framework.
     *
     * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
     * Please do all modifications in the form of a child theme.
     *
     * @package Genesis\Templates
     * @author  StudioPress
     * @license GPL-2.0+
     * @link    http://my.studiopress.com/themes/genesis/
     */

    // Initialize Genesis.
    add_action('wp_footer',array('MSDArtworkCPT','add_page_css'));
    remove_action('genesis_loop','genesis_do_loop');
    add_action('genesis_loop',array('MSDArtworkCPT','custom_loop'));
    genesis();
else:
    print 'not genesis, sorry.';
endif;