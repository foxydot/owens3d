<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Developer Tools.
include_once( get_stylesheet_directory() . '/lib/inc/devel.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/inc/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_msdlab_child_localization_setup' );
function genesis_msdlab_child_localization_setup(){
	load_child_theme_textdomain( 'genesis-msdlab-child', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/inc/helper-functions.php' );
include_once( get_stylesheet_directory() . '/lib/inc/msd-functions.php' ); //should this go to plugin?
include_once( get_stylesheet_directory() . '/lib/inc/fixed-header-support.php' );
include_once( get_stylesheet_directory() . '/lib/inc/genesis_blog_grid.php' );
include_once( get_stylesheet_directory() . '/lib/inc/custom-class-support.php' );
new MSDLab_Custom_Class_Support();
//include_once( get_stylesheet_directory() . '/lib/inc/custom-page-support.php' );
//new MSDLab_Custom_Page_Support();

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Rconteur' );
define( 'CHILD_THEME_URL', 'http://msdlab.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );


// Enqueue stuff.
include_once( get_stylesheet_directory() . '/lib/inc/register-scripts.php' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

/***Tools Plugin**/
//instantiate sub packages
if(class_exists('MSDLab_Theme_Tweaks')){
    $options = array();
    $ttweaks = new MSDLab_Theme_Tweaks($options);
}
if(class_exists('MSDLab_Genesis_Bootstrap')){
    $options = array(
        'sidebar' => array(
            'xs' => 12,
            'sm' => 12,
            'md' => 4,
            'lg' => 4
        ),
        'sidebar_alt' => array(
            'xs' => 0,
            'sm' => 0,
            'md' => 4,
            'lg' => 4
        ),
    );
    $bootstrappin = new MSDLab_Genesis_Bootstrap($options);
}



if(class_exists('MSDLab_Genesis_Tweaks')){
    $options = array(
        'preheader' => 'genesis_header_right'
    );
    //$gtweaks = new MSDLab_Genesis_Tweaks($options);
}
if(class_exists('MSDLab_Subtitle_Support')){
    global $subtitle_support;
    $options = array(
    	'post_type' => array('team','press_release'),
    );
    $subtitle_support = new MSDLab_Subtitle_Support($options);
}
if(class_exists('MSDLab_Chapter_Title_Support')){
    global $chaptertitle_support;
    $options = array();
    $chaptertitle_support = new MSDLab_Chapter_Title_Support($options);
}


/*** HEADER ***/
add_action('wp_head','msdlab_maybe_wrap_inner');
add_filter( 'genesis_search_text', 'msdlab_search_text' ); //customizes the serach bar placeholder
add_filter('genesis_search_button_text', 'msdlab_search_button'); //customize the search form to add fontawesome search button.
//add_filter('genesis_search_form', 'msdlab_sliding_search_form');

/**
 * Move secodary nav into pre-header
 */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav' );


//add_action('genesis_header','msdlab_header_right' );

/*** NAV ***/
/**
 * Move nav into header
 */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'msdlab_do_nav');

/*** SIDEBARS ***/
add_filter('widget_text', 'do_shortcode');//shortcodes in widgets

/*** CONTENT ***/
add_filter('genesis_breadcrumb_args', 'msdlab_breadcrumb_args'); //customize the breadcrumb output
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); //move the breadcrumbs
add_filter( 'genesis_post_info', 'msdlab_post_info_filter' );
add_action('template_redirect','msdlab_maybe_move_title');

//remove_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
//add_action('msdlab_title_area','msdlab_do_section_title');
add_action('genesis_header', 'genesis_do_breadcrumbs', 11); //to outside of the loop area
add_action('genesis_after_header',array('MSDLab_Fixed_Header_Support','do_header_buffer'));
add_action('genesis_after_header','msdlab_do_title_area');

remove_action('genesis_entry_content', 'genesis_do_post_image',8);
//add_action('genesis_entry_header','msd_post_image',4);//add the image above the entry

add_filter( 'excerpt_length', 'msdlab_excerpt_length', 999 );
add_filter('excerpt_more', 'msdlab_read_more_link');
add_filter( 'the_content_more_link', 'msdlab_read_more_link' );

//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 ); //remove the info (date, posted by,etc.)
remove_action( 'genesis_entry_footer', 'genesis_post_meta'); //remove the meta (filed under, tags, etc.)

//add_filter( 'genesis_next_link_text', 'msdlab_older_link_text', 20);
//add_filter( 'genesis_prev_link_text', 'msdlab_newer_link_text', 20);

remove_action( 'genesis_after_endwhile', 'genesis_prev_next_post_nav' );
add_action( 'genesis_after_endwhile', 'msdlab_prev_next_post_nav' );


/*** FOOTER ***/
add_theme_support( 'genesis-footer-widgets', 1 ); //adds automatic footer widgets
//add the menu
//add_action('genesis_before_footer','msdlab_do_footer_menu', 20);

//add_action('genesis_before_footer','msdlab_do_footer_widget', 1);

remove_action('genesis_footer','genesis_do_footer'); //replace the footer
add_action('genesis_footer','msdlab_do_social_footer');//with a msdsocial support one

/*** SITEMAP ***/
//add_action('after_404','msdlab_sitemap');

/*** MEDIA ***/
/**
 * Add new image sizes
 */
add_image_size('facebook', 200, 200, TRUE);
add_image_size('linkedin', 180, 110, TRUE);

/* Display a custom favicon */
add_filter( 'genesis_pre_load_favicon', 'msdlab_favicon_filter' );
function msdlab_favicon_filter( $favicon_url ) {
    return get_stylesheet_directory_uri().'/lib/images/favicon.gif';
}

/*** ORIG ***/

// Add support for after entry widget.
//add_theme_support( 'genesis-after-entry-widget-area' );

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_msdlab_child_author_box_gravatar' );
function genesis_msdlab_child_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_msdlab_child_comments_gravatar' );
function genesis_msdlab_child_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

remove_theme_support( 'genesis-inpost-layouts' );


/**
 * Remove Genesis Page Templates
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/remove-genesis-page-templates
 *
 * @param array $page_templates
 * @return array
 */
function be_remove_genesis_page_templates( $page_templates ) {
    unset( $page_templates['page_archive.php'] );
    unset( $page_templates['page_blog.php'] );
    return $page_templates;
}
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );

add_filter('default_page_template_title', function() {
    return __('Tertiary Page', 'genesis');
});

//override bootstrap hook
add_filter('genesis_attr_content', 'raconteur_bootstrap_content', 11);

function raconteur_bootstrap_content($attributes)
{
	$layout = genesis_site_layout();
	$template = get_page_template();
	switch ($layout) {
		case 'full-width-content':
			$attributes['class'] = preg_replace('/row/','',$attributes['class']);
			break;
	}
	return $attributes;
}