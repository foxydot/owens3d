<?php
/**
 * Created by PhpStorm.
 * User: CMO
 * Date: 8/1/18
 * Time: 3:08 PM
 */
remove_all_actions( 'msdlab_title_area' );
add_action( 'msdlab_title_area', 'msdlab_do_search_title' );
add_action( 'genesis_entry_header', 'genesis_do_post_title');
remove_action( 'genesis_entry_header', 'genesis_post_info',12);
add_action('genesis_entry_content','msdlab_read_search');

remove_all_actions('genesis_after_content_sidebar_wrap');

/**
 * Echo the title with the search term.
 *
 * @since 1.9.0
 */
function msdlab_do_search_title() {

    $title = sprintf( '<h2 class="entry-title">%s %s</h2>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'genesis' ) ), get_search_query() );

    echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

}

function msdlab_read_search(){
    global $post;
    $button = sprintf('<a class="btn button alignright" href="%s">%s</a>',get_the_permalink($post),__('View'));
    echo $button;
}

genesis();