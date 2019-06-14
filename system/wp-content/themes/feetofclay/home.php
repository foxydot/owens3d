<?php
/**
*
*
* Template Name: Blog Home Page
*
*/
add_action('genesis_after_endwhile','msdlab_sectionize_blog');

function msdlab_sectionize_blog() {
	global $post;
	$page_for_posts = get_option( 'page_for_posts' );
	$post = get_post($page_for_posts);
}

remove_action('msdlab_title_area', array(&$subtitle_support, 'msdlab_do_post_subtitle')); //move the title out of the content area


genesis();