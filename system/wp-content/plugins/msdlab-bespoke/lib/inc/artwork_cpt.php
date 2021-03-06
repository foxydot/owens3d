<?php
if (!class_exists('MSDArtworkCPT')) {
	class MSDArtworkCPT {
		//Properties
		var $cpt = 'artwork';
		var $javascript = false;
		//Methods
		/**
		 * PHP 4 Compatible Constructor
		 */
		public function MSDArtworkCPT(){$this->__construct();}

		/**
		 * PHP 5 Constructor
		 */
		function __construct(){
			global $current_screen;
			//Actions
			add_action( 'init', array(&$this,'register_taxonomies') );
			add_action( 'init', array(&$this,'register_cpt') );
			add_action( 'init', array(&$this,'register_metaboxes') );
			//add_action('admin_head', array(&$this,'plugin_header'));
			add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
			add_action('admin_print_styles', array(&$this,'add_admin_styles') );
			add_action('admin_footer',array(&$this,'info_footer_hook') );

			//Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );

            add_filter('template_include', array(&$this,'theme_redirect'),99);

            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
			add_filter( 'genesis_attr_artwork', array(&$this,'custom_add_artwork_attr') );


			//Shortcodes
			add_shortcode('artwork',array(&$this,'shortcode_handler'));

			//add cols to manage panel
			add_filter( 'manage_edit-'.$this->cpt.'_columns', array(&$this,'my_edit_columns' ));
			add_action( 'manage_'.$this->cpt.'_posts_custom_column', array(&$this,'my_manage_columns'), 10, 2 );
		}


		function register_taxonomies(){

			$labels = array(
				'name' => _x( 'Artwork categories', 'artwork-category' ),
				'singular_name' => _x( 'Artwork category', 'artwork-category' ),
				'search_items' => _x( 'Search artwork categories', 'artwork-category' ),
				'popular_items' => _x( 'Popular artwork categories', 'artwork-category' ),
				'all_items' => _x( 'All artwork categories', 'artwork-category' ),
				'parent_item' => _x( 'Parent artwork category', 'artwork-category' ),
				'parent_item_colon' => _x( 'Parent artwork category:', 'artwork-category' ),
				'edit_item' => _x( 'Edit artwork category', 'artwork-category' ),
				'update_item' => _x( 'Update artwork category', 'artwork-category' ),
				'add_new_item' => _x( 'Add new artwork category', 'artwork-category' ),
				'new_item_name' => _x( 'New artwork category name', 'artwork-category' ),
				'separate_items_with_commas' => _x( 'Separate artwork categories with commas', 'artwork-category' ),
				'add_or_remove_items' => _x( 'Add or remove artwork categories', 'artwork-category' ),
				'choose_from_most_used' => _x( 'Choose from the most used artwork categories', 'artwork-category' ),
				'menu_name' => _x( 'Artwork categories', 'artwork-category' ),
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'show_in_nav_menus' => true,
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.

				'rewrite' => array('slug'=>'artwork-category','with_front'=>false),
				'query_var' => true,

				'capabilities' => array(
                    'manage_terms' => 'manage_categories',
                    'edit_terms' => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_page',
				),
			);

			register_taxonomy( 'artwork_category', array($this->cpt), $args );


            $labels = array(
                'name' => _x( 'Artwork series', 'artwork-series' ),
                'singular_name' => _x( 'Artwork series', 'artwork-series' ),
                'search_items' => _x( 'Search artwork series', 'artwork-series' ),
                'popular_items' => _x( 'Popular artwork series', 'artwork-series' ),
                'all_items' => _x( 'All artwork series', 'artwork-series' ),
                'parent_item' => _x( 'Parent artwork series', 'artwork-series' ),
                'parent_item_colon' => _x( 'Parent artwork series:', 'artwork-series' ),
                'edit_item' => _x( 'Edit artwork series', 'artwork-series' ),
                'update_item' => _x( 'Update artwork series', 'artwork-series' ),
                'add_new_item' => _x( 'Add new artwork series', 'artwork-series' ),
                'new_item_name' => _x( 'New artwork series name', 'artwork-series' ),
                'separate_items_with_commas' => _x( 'Separate artwork series with commas', 'artwork-series' ),
                'add_or_remove_items' => _x( 'Add or remove artwork series', 'artwork-series' ),
                'choose_from_most_used' => _x( 'Choose from the most used artwork series', 'artwork-series' ),
                'menu_name' => _x( 'Artwork series', 'artwork-series' ),
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true,

                'rewrite' => array('slug'=>'artwork-series','with_front'=>false),
                'query_var' => true,

                'capabilities' => array(
                    'manage_terms' => 'manage_categories',
                    'edit_terms' => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_page',
                ),
            );

            register_taxonomy( 'artwork_series', array($this->cpt), $args );


			$labels = array(
				'name' => _x( 'Artwork tags', 'artwork-tag' ),
				'singular_name' => _x( 'Artwork tag', 'artwork-tag' ),
				'search_items' => _x( 'Search artwork tags', 'artwork-tag' ),
				'popular_items' => _x( 'Popular artwork tags', 'artwork-tag' ),
				'all_items' => _x( 'All artwork tags', 'artwork-tag' ),
				'parent_item' => _x( 'Parent artwork tag', 'artwork-tag' ),
				'parent_item_colon' => _x( 'Parent artwork tag:', 'artwork-tag' ),
				'edit_item' => _x( 'Edit artwork tag', 'artwork-tag' ),
				'update_item' => _x( 'Update artwork tag', 'artwork-tag' ),
				'add_new_item' => _x( 'Add new artwork tag', 'artwork-tag' ),
				'new_item_name' => _x( 'New artwork tag name', 'artwork-tag' ),
				'separate_items_with_commas' => _x( 'Separate artwork tags with commas', 'artwork-tag' ),
				'add_or_remove_items' => _x( 'Add or remove artwork tags', 'artwork-tag' ),
				'choose_from_most_used' => _x( 'Choose from the most used artwork tags', 'artwork-tag' ),
				'menu_name' => _x( 'Artwork tags', 'artwork-tag' ),
			);

			$args = array(
				'labels' => $labels,
				'public' => true,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'show_tagcloud' => true,
				'hierarchical' => false,

				'rewrite' => array('slug'=>'artwork-tag','with_front'=>false),
				'query_var' => true,

				'capabilities' => array(
					'manage_terms' => 'manage_categories',
					'edit_terms' => 'manage_categories',
					'delete_terms' => 'manage_categories',
					'assign_terms' => 'edit_page',
				),
			);

			register_taxonomy( 'artwork_tag', array($this->cpt), $args );
		}

		function register_cpt() {

			$labels = array(
				'name' => _x( 'Artwork', 'artwork' ),
				'singular_name' => _x( 'Artwork', 'artwork' ),
				'add_new' => _x( 'Add New', 'artwork' ),
				'add_new_item' => _x( 'Add New Artwork', 'artwork' ),
				'edit_item' => _x( 'Edit Artwork', 'artwork' ),
				'new_item' => _x( 'New Artwork', 'artwork' ),
				'view_item' => _x( 'View Artwork', 'artwork' ),
				'search_items' => _x( 'Search Artwork', 'artwork' ),
				'not_found' => _x( 'No artwork found', 'artwork' ),
				'not_found_in_trash' => _x( 'No artwork found in Trash', 'artwork' ),
				'parent_item_colon' => _x( 'Parent Artwork:', 'artwork' ),
				'menu_name' => _x( 'Artwork', 'artwork' ),
			);

			$args = array(
				'labels' => $labels,
				'hierarchical' => false,
				'description' => 'Artwork',
				'supports' => array( 'title','editor', 'excerpt', 'author', 'thumbnail' ),
				'taxonomies' => array( 'artwork_category', 'artwork_tag' ),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 20,

				'show_in_nav_menus' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => true,
				'has_archive' => true,
				'query_var' => true,
				'can_export' => true,
				'rewrite' => array('slug'=>'artwork','with_front'=>false),
				'capability_type' => 'page',
				'menu_icon' => 'dashicons-admin-customizer',
			);

			register_post_type( $this->cpt, $args );
		}


		function register_metaboxes(){
			global $artwork_info,$multimedia_info;
			$artwork_info = new WPAlchemy_MetaBox(array
			(
				'id' => '_artwork_information',
				'title' => 'Artwork Info',
				'types' => array($this->cpt),
				'context' => 'normal',
				'priority' => 'high',
				'template' => plugin_dir_path(dirname(__FILE__)).'/template/metabox-artwork.php',
				'autosave' => TRUE,
				'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
				'prefix' => '_artwork_' // defaults to NULL
			));
		}


		function add_admin_scripts() {
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
			}
		}

		function add_admin_styles() {
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
			}
		}

		function info_footer_hook()
		{
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				?><script type="text/javascript">
                    jQuery('#postdivrich').before(jQuery('#_artwork_info_metabox'));
				</script><?php
			}
		}

		function my_edit_columns( $columns ) {
			$mycolumns = array(
				'cb' => '<input type="checkbox" />',
				'title' => __( 'Title' ),
				$this->cpt.'_category' => __( 'Categories' ),
				$this->cpt.'_tag' => __( 'Tags' ),
			);
			$columns = array_merge($mycolumns,$columns);

			return $columns;
		}


		function my_manage_columns( $column, $post_id ) {
			global $post;

			switch( $column ) {
				/* If displaying the 'logo' column. */
				case $this->cpt.'_category' :
				case $this->cpt.'_tag' :
					$taxonomy = $column;
					if ( $taxonomy ) {
						$taxonomy_object = get_taxonomy( $taxonomy );
						$terms = get_the_terms( $post->ID, $taxonomy );
						if ( is_array( $terms ) ) {
							$out = array();
							foreach ( $terms as $t ) {
								$posts_in_term_qv = array();
								if ( 'post' != $post->post_type ) {
									$posts_in_term_qv['post_type'] = $post->post_type;
								}
								if ( $taxonomy_object->query_var ) {
									$posts_in_term_qv[ $taxonomy_object->query_var ] = $t->slug;
								} else {
									$posts_in_term_qv['taxonomy'] = $taxonomy;
									$posts_in_term_qv['term'] = $t->slug;
								}

								$label = esc_html( sanitize_term_field( 'name', $t->name, $t->term_id, $taxonomy, 'display' ) );
								$out[] = $this->get_edit_link( $posts_in_term_qv, $label );
							}
							/* translators: used between list items, there is a space after the comma */
							echo join( __( ', ' ), $out );
						} else {
							echo '<span aria-hidden="true">&#8212;</span><span class="screen-reader-text">' . $taxonomy_object->labels->no_terms . '</span>';
						}
					}
					break;
				default :
					break;
			}
		}

		function get_edit_link( $args, $label, $class = '' ) {
			$url = add_query_arg( $args, 'edit.php' );

			$class_html = '';
			if ( ! empty( $class ) ) {
				$class_html = sprintf(
					' class="%s"',
					esc_attr( $class )
				);
			}

			return sprintf(
				'<a href="%s"%s>%s</a>',
				esc_url( $url ),
				$class_html,
				$label
			);
		}


		function change_default_title( $title ){
			global $current_screen;
			if  ( $current_screen->post_type == $this->cpt ) {
				return __('Artwork Title','artwork');
			} else {
				return $title;
			}
		}

		function cpt_display(){
            global $post,$artwork_info;
			if(is_cpt($this->cpt)) {
				if (is_single()){
                    $artwork_info->the_meta();
                    $fields = get_post_meta($post->ID,'_artwork_information_fields',true);
                    foreach ($fields as $field){
                        $$field = get_post_meta($post->ID,$field,true);
                        if(strlen($$field) == 0){
                            $$field = false;
                        }
                    }
                    if(has_post_thumbnail($post->ID)){
                        $thumbnail = genesis_get_image(array("post_id"=>$post->ID));
                    }
                    if($_artwork_gallery) {
                        $gallery[] = do_shortcode($_artwork_gallery);
                    }

//get the categories
                    $terms = get_the_terms( get_the_ID(), 'artwork_category' );

                    if ( $terms && ! is_wp_error( $terms ) ) :

                        $cat_links = array();

                        foreach ( $terms as $term ) {
                            $cat_links[] = $term->name;
                        }

                        $cats = join( ", ", $cat_links );
                    endif;

//get the series
                    $series_links = self::get_the_series();

                    $info[] = '<div class="details">';
                    $info[] = '<h3>Details</h3>';
                    if($post->post_content != '') {
                        $info[] = '<div class="post-content">'.do_shortcode($post->post_content).'</div>';
                    }
                    if(count($series_links)>0){
                        $info[] = '<li>Series: '.join( ", ", $series_links ).'</li>';
                    }
                    $info[] = $cats;
                    if($_artwork_price) {
                        $info[] = '<li>' . $_artwork_price . '</li>';
                    }
                    if($_artwork_date) {
                        $info[] = '<li>' . $_artwork_date . '</li>';
                    }
                    if($_artwork_height || $_artwork_width || $_artwork_depth) {
                        $info[] = '<li>' . $_artwork_height . 'H x ' . $_artwork_width . 'W x ' .  $_artwork_depth . 'D </li>';
                    }
                    $info[] = '</div>';
                    if($_artwork_video){
                        $info[] = '<div class="process">';
                        $info[] = '<h3>The Process</h3>';
                        $info[] = apply_filters('the_content',$_artwork_video);
                        $info[] = '</div>';
                    }
                    $ret[] = '<div class="container">';
                    $ret[] = '<div class="artwork-thumbnail col-sm-6 col-xs-12">'.$thumbnail.'</div>';
                    $ret[] = '<div class="artwork-gallery col-sm-6 col-xs-12">'.implode("\n",$gallery).'</div>';
                    if(has_term('available-for-purchase','artwork_category')){
                        $ret[] = '<div class="col-sm-6 col-xs-12">'.implode("\n",$info).'</div><div class="col-sm-6 col-xs-12">'.do_shortcode('[gravityform id="1" title="true" description="true"]').'</div>';
                    } else {
                        $ret[] = '<div class="col-xs-12">'.implode("\n",$info).'</div>';
                    }
                    $ret[] = '</div>';
				} else {
					//display for aggregate here
				}
				print implode("\n",$ret);
				if($this->javascript){
				    add_action('wp_footer',array($this,'add_page_javascript'));
                }
			}
		}

		function shortcode_handler($atts){
			extract(shortcode_atts( array(
				'count' => -1,
                'tax'   => 'artwork_series',
			), $atts ));
			$args = array(
				'post-type' => $this->cpt,
				'posts_per_page' => $count,
                'tax' => $tax,
			);
            add_action('wp_footer',array($this,'add_page_css'));
			return $this->msdlab_artwork_special($args);
		}


		function msdlab_artwork_special($args){
			global $post;
			$origpost = $post;
			$defaults = array(
				'posts_per_page' => -1,
				'post_type' => $this->cpt,
			);
			$args = array_merge($defaults,$args);
			//set up result array

			$results = array();
			$results = get_posts($args);
			//get terms in tax
            //$terms = get_terms($args['tax']);
            $terms = apply_filters('taxonomy-images-get-terms','',array('taxonomy'=>$args['tax']));
            //first do the groups
            foreach($terms AS $term) {
                $ret[] = genesis_markup( array(
                    'html5'   => '<article %s>',
                    'xhtml'   => '<div class="artwork status-publish has-post-thumbnail entry">',
                    'context' => 'artwork',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '<div class="wrap">',
                    'xhtml' => '<div class="wrap">',
                    'echo' => false,
                ) );

                $ret[] = genesis_markup( array(
                    'html5' => '<main>',
                    'xhtml' => '<div class="main">',
                    'echo' => false,
                ) );

                $ret[] = genesis_markup( array(
                    'html5' => '<header>',
                    'xhtml' => '<div class="header">',
                    'echo' => false,
                ) );
                $ret[] = wp_get_attachment_image( $term->image_id, 'child_thumbnail', false, array('itemprop'=>'image') );

                $ret[] = genesis_markup( array(
                    'html5' => '</header>',
                    'xhtml' => '</div>',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '<content>',
                    'xhtml' => '<div class="content">',
                    'echo' => false,
                ) );

                $ret[] = '<h3 class="entry-title" itemprop="name"><strong>Series:</strong> '.apply_filters('the_title',$term->name).'</h3>';

                $ret[] = genesis_markup( array(
                    'html5' => '</content>',
                    'xhtml' => '</div>',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '<footer>',
                    'xhtml' => '<div class="footer">',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '</footer>',
                    'xhtml' => '</div>',
                    'echo' => false,
                ) );
                $ret[] = '
                           <a href="'.get_term_link( $term, array( $args['tax'] ) ).'" class="full-cover-button"><span class="screen-reader-text">Read More</span></a>';  //add some ajax here
                $ret[] = genesis_markup( array(
                    'html5' => '</main>',
                    'xhtml' => '</div>',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '</div>',
                    'xhtml' => '</div>',
                    'echo' => false,
                ) );
                $ret[] = genesis_markup( array(
                    'html5' => '</article>',
                    'xhtml' => '</div>',
                    'context' => 'artwork',
                    'echo' => false,
                ) );
            }

			//format result
			$i = 0;
			foreach($results AS $result){
			    $_artwork_price = $_artwork_date = $_artwork_height = $_artwork_width = $_artwork_depth = false;
				$post = $result;
				$is_series_item = false;
				foreach($terms AS $term) {
                    if (has_term($term->term_id, $args['tax'], $post)) {
                        $is_series_item = true;
                    }
                }
                if($is_series_item){continue;}
				$i++;

				$fields = get_post_meta($post->ID,'_artwork_information_fields',true);
				foreach ($fields as $field){
				    $$field = get_post_meta($post->ID,$field,true);
				    if(strlen($$field) == 0){
				        $$field = false;
                    }
                }
                $series_links = self::get_the_series();
				$ret[] = genesis_markup( array(
					'html5'   => '<article %s>',
					'xhtml'   => '<div class="artwork status-publish has-post-thumbnail entry">',
					'context' => 'artwork',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '<div class="wrap">',
					'xhtml' => '<div class="wrap">',
					'echo' => false,
				) );

				$ret[] = genesis_markup( array(
					'html5' => '<main>',
					'xhtml' => '<div class="main">',
					'echo' => false,
				) );

				$ret[] = genesis_markup( array(
					'html5' => '<header>',
					'xhtml' => '<div class="header">',
					'echo' => false,
				) );
				$ret[] = get_the_post_thumbnail($result->ID,'child_thumbnail',array('itemprop'=>'image'));

				$ret[] = genesis_markup( array(
					'html5' => '</header>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '<content>',
					'xhtml' => '<div class="content">',
					'echo' => false,
				) );

                $ret[] = '<h3 class="entry-title" itemprop="name">'.apply_filters('the_title',$post->post_title).'</h3>';
                if(count($series_links)>0){
                    $ret[] = '<li>Series: '.join( ", ", $series_links ).'</li>';
                }
                if($_artwork_price) {
                    $ret[] = '<li>' . $_artwork_price . '</li>';
                }
                if($_artwork_date) {
                    $ret[] = '<li>' . $_artwork_date . '</li>';
                }
                if($_artwork_height || $_artwork_width || $_artwork_depth) {
                    $ret[] = '<li>' . $_artwork_height . 'H x ' . $_artwork_width . 'W x ' .  $_artwork_depth . 'D </li>';
                }
				$ret[] = genesis_markup( array(
					'html5' => '</content>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '<footer>',
					'xhtml' => '<div class="footer">',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '</footer>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
                $ret[] = '
                           <a href="'.get_post_permalink($post->ID).'" class="full-cover-button"><span class="screen-reader-text">Read More</span></a>';  //add some ajax here
                $ret[] = genesis_markup( array(
					'html5' => '</main>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '</div>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$ret[] = genesis_markup( array(
					'html5' => '</article>',
					'xhtml' => '</div>',
					'context' => 'artwork',
					'echo' => false,
				) );
			}

			$ret['clear'] = '<div class="clearfix"></div>';
			//return
			$post = $origpost;
			return implode("\n",$ret);
		}


		function custom_loop(){
			global $wp_query;
			$recents = $wp_query;

			if($recents->have_posts()) {
				global $post, $artwork_info;
				print self::custom_loop_content($recents);
				do_action('genesis_after_endwhile');
			}
		}

		function custom_loop_content($recents = false){
			if(!is_object($recents)){
				global $wp_query;
				$recents = $wp_query;
			}
			global $post,$artwork_info;
			$ret[] = '<section class="filtered '.$class.'">
<div class="wrap">';
//start loop
			ob_start();
			while($recents->have_posts()) {
                $_artwork_price = $_artwork_date = $_artwork_height = $_artwork_width = $_artwork_depth = false;
                $recents->the_post();
                $fields = get_post_meta($post->ID,'_artwork_information_fields',true);
                foreach ($fields as $field){
                    $$field = get_post_meta($post->ID,$field,true);
                    if(strlen($$field) == 0){
                        $$field = false;
                    }
                }
                $series_links = self::get_the_series();
				$item = array();
				$item[] = genesis_markup( array(
					'html5'   => '<article %s>',
					'xhtml'   => '<div class="artwork status-publish has-post-thumbnail entry">',
					'context' => 'artwork',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '<div class="wrap">',
					'xhtml' => '<div class="wrap">',
					'echo' => false,
				) );

				$item[] = genesis_markup( array(
					'html5' => '<main>',
					'xhtml' => '<div class="main">',
					'echo' => false,
				) );

				$item[] = genesis_markup( array(
					'html5' => '<header>',
					'xhtml' => '<div class="header">',
					'echo' => false,
				) );
				$item[] = get_the_post_thumbnail($result->ID,'child_thumbnail',array('itemprop'=>'image'));

				$item[] = genesis_markup( array(
					'html5' => '</header>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '<content>',
					'xhtml' => '<div class="content">',
					'echo' => false,
				) );


                $item[] = '<h3 class="entry-title" itemprop="name">'.apply_filters('the_title',$post->post_title).'</h3>';
                if(count($series_links)>0){
                    $item[] = '<li>Series: '.join( ", ", $series_links ).'</li>';
                }
                if($_artwork_price) {
                    $item[] = '<li>' . $_artwork_price . '</li>';
                }
                if($_artwork_date) {
                    $item[] = '<li>' . $_artwork_date . '</li>';
                }
                if($_artwork_height || $_artwork_width || $_artwork_depth) {
                    $item[] = '<li>' . $_artwork_height . 'H x ' . $_artwork_width . 'W x ' .  $_artwork_depth . 'D </li>';
                }
                $item[] = genesis_markup( array(
					'html5' => '</content>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '<footer>',
					'xhtml' => '<div class="footer">',
					'echo' => false,
				) );
				$item[] = '
                     <a href="' . get_permalink( $post->ID ) . '" class="full-cover-button"><span class="screen-reader-text">Read More</span></a>';  //add some ajax here

				$item[] = genesis_markup( array(
					'html5' => '</footer>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '</main>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '</div>',
					'xhtml' => '</div>',
					'echo' => false,
				) );
				$item[] = genesis_markup( array(
					'html5' => '</article>',
					'xhtml' => '</div>',
					'context' => 'artwork',
					'echo' => false,
				) );
				print implode("\n",$item);
			} //end loop
			$ret[] = ob_get_contents();
			ob_end_clean();
			$ret[] = '</div></section>';
			return implode( "\n", $ret );
		}

		/**
		 * Callback for dynamic Genesis 'genesis_attr_$context' filter.
		 *
		 * Add custom attributes for the custom filter.
		 *
		 * @param array $attributes The element attributes
		 * @return array $attributes The element attributes
		 */
		function custom_add_artwork_attr( $attributes ){
			$attributes['class'] .= ' equalize col-xs-12 col-sm-6 col-md-4';
			$attributes['itemtype']  = 'http://schema.org/ArtworkArticle';
			// return the attributes
			return $attributes;
		}


        function theme_redirect($return_template) {
            global $wp,$wp_query;
            if(is_single() && $wp->query_vars["post_type"] == $this->cpt) {
                $templatefilename = 'single-' . $this->cpt . '.php';
            } elseif($wp->query_vars["artwork_series"]) {
                $templatefilename = 'taxonomy-artwork_series.php';
            } elseif (is_archive() && $wp->query_vars["post_type"] == $this->cpt) {
                $templatefilename = 'archive-' . $this->cpt . '.php';
            }
            if($templatefilename) {
                if (file_exists(STYLESHEETPATH . '/' . $templatefilename)) {
                    $return_template = STYLESHEETPATH . '/' . $templatefilename;
                } else {
                    $return_template = plugin_dir_path(dirname(__FILE__)) . 'template/' . $templatefilename;
                }
            }

            return $return_template;
        }


        function custom_query( $query ) {
            if(!is_admin()){
                if(is_page()){
                    return $query;
                }
                if($query->is_main_query()) {
                    if($query->query["post_type"]){
                        return $query;
                    }
                    $post_types = $query->get('post_type');             // Get the current post types in the query

                    if(!is_array($post_types) && !empty($post_types))   // Check that the current posts types are stored as an array
                        $post_types = explode(',', $post_types);

                    if(empty($post_types))
                        $post_types = array('post'); // If there are no post types defined, be sure to include posts so that they are not ignored

                    if ($query->is_search) {
                        $searchterm = $query->query_vars['s'];
                        // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
                        $query->query_vars['s'] = "";

                        if ($searchterm != "") {
                            $query->set('meta_value', $searchterm);
                            $query->set('meta_compare', 'LIKE');
                        };
                        $post_types[] = $this->cpt;                         // Add your custom post type

                    } elseif ($query->is_archive) {
                        $post_types[] = $this->cpt;                         // Add your custom post type
                    }

                    $post_types = array_map('trim', $post_types);       // Trim every element, just in case
                    $post_types = array_filter($post_types);            // Remove any empty elements, just in case

                    $query->set('post_type', $post_types);              // Add the updated list of post types to your query
                }
            }
        }

        function add_page_css(){
            $css[] = 'article.artwork main {position: relative;}';
            $css[] = 'article.artwork main .full-cover-button {position: absolute;top:0;bottom:0;left:0;right:0;display:block;}';

		    print '<style id="artwork-aggregate-css">'.implode("\n",$css).'</style>';
        }

        function get_the_series(){
            $terms = get_the_terms( get_the_ID(), 'artwork_series' );

            if ( $terms && ! is_wp_error( $terms ) ) :

                $series_links = array();

                foreach ( $terms as $term ) {
                    $series_links[] = '<a href="'.get_term_link( $term, array( 'artwork_series') ).'">'.$term->name.'</a>';
                }

            endif;
                return $series_links;
        }
	} //End Class
} //End if class exists statement