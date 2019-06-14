<?php
/**
 * Genesis Sample.
 *
 * This file adds the default theme settings to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_filter( 'genesis_theme_settings_defaults', 'genesis_msdlab_child_defaults' );
/**
* Updates theme settings on reset.
*
* @since 2.2.3
*/
function genesis_msdlab_child_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 0;
	$defaults['content_archive_thumbnail'] = 0;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';

	return $defaults;

}

add_action( 'after_switch_theme', 'genesis_msdlab_child_setting_defaults' );
/**
* Updates theme settings on activation.
*
* @since 2.2.3
*/
function genesis_msdlab_child_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,
			'content_archive'           => 'full',
			'content_archive_limit'     => 0,
			'content_archive_thumbnail' => 0,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );

	}

	update_option( 'posts_per_page', 6 );

}


add_action('dynamic_sidebar_before','czbg2018_wrap_footer_widget_area',10,2);
function czbg2018_wrap_footer_widget_area($index,$has_widgets){
    if(strstr($index,'footer') && $has_widgets){
        print '<div class="container">';
    }
}
add_action('dynamic_sidebar_after','czbg2018_close_wrap_footer_widget_area',10,2);
function czbg2018_close_wrap_footer_widget_area($index,$has_widgets){
    if(strstr($index,'footer') && $has_widgets){
        print '</div>';
    }
}