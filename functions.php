<?php
/*---------------------------------------------------------------------------------------*/
/* This file will be referenced every time a template/page loads on your Wordpress site  */
/* This is the place to define custom functions and specialty code											 */
/*---------------------------------------------------------------------------------------*/


// -------------------------------------------------------------------------
// Define the version so we can easily replace it throughout the theme
// -------------------------------------------------------------------------
define('BRANDGUIDELINES_VERSION', 1.0);


// -------------------------------------------------------------------------
// Enqueue styles and scripts (scripts placed in footer)
// -------------------------------------------------------------------------
function theme_enqueue_scripts_and_styles() {	
	
	// Stylesheets	
	wp_enqueue_style( 'normalize-css', get_template_directory_uri() . '/assets/css/normalize.css' );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/dist/css/main.css', array(), null );
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/dist/js/all.min.js', array(), '', true );
	wp_localize_script( 'main', 'themeSearch', [
		'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
		'nonce'       => wp_create_nonce( 'live_search_nonce' ),
		'recommended' => theme_get_recommended_pages(),
	] );

}

// -------------------------------------------------------------------------
// Recommended pages shown before a search query is typed
// -------------------------------------------------------------------------
function theme_get_recommended_pages() {
	$pages = [];

	// Pin the Downloads page first
	$downloads = get_page_by_path( 'downloads' );
	if ( $downloads ) {
		$pages[] = [
			'title' => get_the_title( $downloads ),
			'url'   => get_permalink( $downloads ),
			'type'  => 'Recommended',
		];
	}

	// Fill remaining slots with top-level pages by menu order
	$query = new WP_Query( [
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post__not_in'   => $downloads ? [ $downloads->ID ] : [],
	] );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() && count( $pages ) < 5 ) {
			$query->the_post();
			$pages[] = [
				'title' => get_the_title(),
				'url'   => get_the_permalink(),
				'type'  => 'Page',
			];
		}
		wp_reset_postdata();
	}

	return $pages;
}

// -------------------------------------------------------------------------
// Live search AJAX
// -------------------------------------------------------------------------
function theme_live_search() {
	check_ajax_referer( 'live_search_nonce', 'nonce' );

	$query = sanitize_text_field( $_POST['query'] ?? '' );

	if ( strlen( $query ) < 2 ) {
		wp_send_json_success( [ 'results' => [] ] );
	}

	$search = new WP_Query( [
		's'              => $query,
		'posts_per_page' => 8,
		'post_status'    => 'publish',
		'post_type'      => [ 'post', 'page' ],
	] );

	$results = [];
	if ( $search->have_posts() ) {
		while ( $search->have_posts() ) {
			$search->the_post();
			$results[] = [
				'title'   => get_the_title(),
				'url'     => get_the_permalink(),
				'excerpt' => wp_trim_words( get_the_excerpt(), 20 ),
				'type'    => get_post_type_object( get_post_type() )->labels->singular_name,
			];
		}
		wp_reset_postdata();
	}

	wp_send_json_success( [ 'results' => $results ] );
}
add_action( 'wp_ajax_live_search', 'theme_live_search' );
add_action( 'wp_ajax_nopriv_live_search', 'theme_live_search' );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts_and_styles' );



 add_filter('upload_mimes', 'add_custom_upload_mimes');
  function add_custom_upload_mimes($existing_mimes) {
  	$existing_mimes['otf'] = 'application/vnd.ms-opentype';
  	$existing_mimes['woff'] = PHP_VERSION_ID >= 80112 ? 'font/woff' : 'application/font-woff';
  	$existing_mimes['woff2'] = PHP_VERSION_ID >= 80112 ? 'font/woff2' : 'application/font-woff2';
  	$php_7_ttf_mime_type = PHP_VERSION_ID >= 70300 ? 'application/font-sfnt' : 'application/x-font-ttf';
  	$existing_mimes['ttf'] = PHP_VERSION_ID >= 70400 ? 'font/sfnt' : $php_7_ttf_mime_type;
  	$existing_mimes['svg'] = 'image/svg+xml';
  	$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
  	$existing_mimes['json'] = 'application/json';
  	return $existing_mimes;
  }


/** WYSIWYG Style **/

function wpb_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {  

// Define the style_formats array

	$style_formats = array(  
/*
* Each array child is a format with it's own settings
* Notice that each array has title, block, classes, and wrapper arguments
* Title is the label which will be visible in Formats menu
* Block defines whether it is a span, div, selector, or inline style
* Classes allows you to define CSS classes
* Wrapper whether or not to add a new block-level element around any selected elements
*/
		array(  
			'title' => 'Large Intro',  
			'block' => 'p',  
			'classes' => 'large-intro',
			
		),  
		array(  
			'title' => 'Intro',  
			'block' => 'p',  
			'classes' => 'intro',
			
		),  
        array(  
			'title' => 'Font Page Size',  
			'block' => 'p',  
			'classes' => 'type-page-size',
			
		),  
		array(  
			'title' => 'Notice',  
			'block' => 'p',  
			'classes' => 'notice',
			
		),
		array(
			'title' => 'Align Center',
			'block' => 'p',
			'classes' => 'align-center',
		),
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 


/* Editor Styles */

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'after_setup_theme', 'my_theme_add_editor_styles' );

/* Add custom fonts to TinyMCE editor */
function my_theme_add_editor_fonts_to_tinymce( $init ) {
    $fonts = get_field('fonts', 'options');
    if ($fonts) {
        $fontchoice = $fonts['font_choice'];
        if ($fontchoice != 'google') {
            $boldwoff = $fonts['bold_woff'];
            $boldwoff2 = $fonts['bold_woff2'];
            $regularwoff = $fonts['regular_woff'];
            $regularwoff2 = $fonts['regular_woff2'];
            
            $font_css = '';
            if ($boldwoff || $boldwoff2) {
                $font_css .= '@font-face {';
                $font_css .= 'font-family: ' . ($boldwoff ? $boldwoff['title'] : $boldwoff2['title']) . ';';
                $font_css .= 'src: ';
                if ($boldwoff) $font_css .= "url('" . $boldwoff['url'] . "') format('WOFF')";
                if ($boldwoff && $boldwoff2) $font_css .= ', ';
                if ($boldwoff2) $font_css .= "url('" . $boldwoff2['url'] . "') format('WOFF2')";
                $font_css .= ';}';
            }
            if ($regularwoff || $regularwoff2) {
                $font_css .= '@font-face {';
                $font_css .= 'font-family: ' . ($regularwoff ? $regularwoff['title'] : $regularwoff2['title']) . ';';
                $font_css .= 'src: ';
                if ($regularwoff) $font_css .= "url('" . $regularwoff['url'] . "') format('WOFF')";
                if ($regularwoff && $regularwoff2) $font_css .= ', ';
                if ($regularwoff2) $font_css .= "url('" . $regularwoff2['url'] . "') format('WOFF2')";
                $font_css .= ';}';
            }
            
            if (!empty($font_css)) {
                if (isset($init['content_style'])) {
                    $init['content_style'] .= ' ' . $font_css;
                } else {
                    $init['content_style'] = $font_css;
                }
            }
        }
    }
    return $init;
}
add_filter( 'tiny_mce_before_init', 'my_theme_add_editor_fonts_to_tinymce' );

/** Admin Styles **/

function theme_admin_styles() { 
    wp_enqueue_style('theme_main_admin_style', get_theme_file_uri('admin.css')); 
}
add_action('admin_enqueue_scripts', 'theme_admin_styles');


add_filter( 'relevanssi_live_search_base_styles', '__return_false' );


// wp-admin/admin-post.php?action=acf_sync

add_action( 'admin_post_acf_sync', function () {

	$field_groups = acf_get_field_groups();

	// Apply our callback to all field groups
	array_map( function ( $field_group ) {

		// Load up the fields on the field group.
		$field_group['fields'] = acf_get_fields( $field_group );

		// Write the local JSON file for the field group.
		acf_write_json_field_group( $field_group );

	}, $field_groups );

	echo 'done!';
} );


// -------------------------------------------------------------------------
// TEMPORARY: Clean up old revisions - Keep only 5 revisions per post/page
// Remove this function after running it once
// -------------------------------------------------------------------------
// function cleanup_old_revisions() {
// 	// Set revision limit to 5
// 	if (!defined('WP_POST_REVISIONS')) {
// 		define('WP_POST_REVISIONS', 5);
// 	}
	
// 	global $wpdb;
	
// 	// Get all published posts and pages
// 	$posts = $wpdb->get_col(
// 		"SELECT ID FROM {$wpdb->posts} 
// 		WHERE post_type IN ('post', 'page') 
// 		AND post_status = 'publish'"
// 	);
	
// 	$total_deleted = 0;
	
// 	foreach ($posts as $post_id) {
// 		$post = get_post($post_id);
		
// 		if (!$post || !wp_revisions_enabled($post)) {
// 			continue;
// 		}
		
// 		// Get all revisions for this post (oldest first)
// 		$revisions = wp_get_post_revisions($post_id, array('order' => 'ASC'));
		
// 		if (empty($revisions)) {
// 			continue;
// 		}
		
// 		$revisions_to_keep = 5;
// 		$revision_count = count($revisions);
		
// 		// If we have more than 5 revisions, delete the oldest ones
// 		if ($revision_count > $revisions_to_keep) {
// 			$delete_count = $revision_count - $revisions_to_keep;
// 			$revisions_to_delete = array_slice($revisions, 0, $delete_count);
			
// 			foreach ($revisions_to_delete as $revision) {
// 				// Skip autosaves
// 				if (strpos($revision->post_name, 'autosave') !== false) {
// 					continue;
// 				}
				
// 				wp_delete_post_revision($revision->ID);
// 				$total_deleted++;
// 			}
// 		}
// 	}
	
// 	// Log the result (optional - remove if you don't want this)
// 	if ($total_deleted > 0) {
// 		error_log("Cleaned up {$total_deleted} old revisions. Kept 5 most recent revisions per post/page.");
// 	}
// }
// // Run on admin page load (remove this action after running once)
// add_action('admin_init', 'cleanup_old_revisions');


// -------------------------------------------------------------------------
// Set up theme defaults and register support for various WordPress features
// -------------------------------------------------------------------------
function init_theme_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	register_nav_menus( array(
		'mainmenu'  => __( 'Main Menu', 'brandguidelines' ),
		'footermenu'  => __( 'Footer Menu', 'brandguidelines' )
	) );

}
add_action( 'after_setup_theme', 'init_theme_setup' );





// -------------------------------------------------------------------------
// Remove WP Admin Menu Items
// -------------------------------------------------------------------------
function remove_menus(){
  remove_menu_page( 'edit-comments.php' ); 
  global $submenu;
	if ( isset( $submenu[ 'themes.php' ] ) ) {
	    foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
	        foreach ($menu_item as $value) {
	            if (strpos($value,'customize') !== false) {
	                //unset( $submenu[ 'themes.php' ][ $index ] );
	            }
	        }
	    }
	}
}
add_action( 'admin_menu', 'remove_menus' );

/*-----------------------------------------------------------------------------------*/
/* ACF Performance Mode
/*-----------------------------------------------------------------------------------*/

add_action('acf/init', 'my_acfe_modules');
function my_acfe_modules(){

    // enable performance mode with ultra engine (default)
    acf_update_setting('acfe/modules/performance', true);
    
}



/*-----------------------------------------------------------------------------------*/
/* ACF Options Page
/*-----------------------------------------------------------------------------------*/

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {
    
    // Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {

      // Add parent.
      $parent = acf_add_options_page(array(
          'page_title'  => __('Theme General Settings'),
          'menu_title'  => __('Theme Settings'),
          'redirect'    => false,
      ));

    }
}


function my_acf_color_picker_palette_primary() {
	
?>


<script type="text/javascript">
(function($) {
	
	acf.add_filter('color_picker_args', function( args, $field ){
	
	// find a specific field
	var $field = $('palette');	
		
	// do something to args
	args.palettes = [

		<?php if(have_rows('palette', 'options')):?>
			<?php while(have_rows('palette', 'options')):the_row();?>
				<?php $colour = get_sub_field('colour');?>
				'<?php echo $colour;?>',
			<?php endwhile;?>
		<?php endif;?>

	]
	
	
	// return
	return args;
			
});
	
})(jQuery);	
</script>
<?php
		
}

add_action('acf/input/admin_footer', 'my_acf_color_picker_palette_primary');


function klf_tinymce_custom_colors($init) {
    $custom_colors = [];

    // Check if the ACF repeater field 'palette' exists in the options page
    if (have_rows('palette', 'option')) {
        while (have_rows('palette', 'option')) {
            the_row();
            $color = get_sub_field('colour'); // Get the color value

            if ($color) {
                $color = ltrim($color, '#'); // Remove the '#' from the HEX code
                $custom_colors[] = "'{$color}', '{$color}'"; // Use HEX as label
            }
        }
    }

    // Convert array to a string
    if (!empty($custom_colors)) {
        $init['textcolor_map'] = '[' . implode(', ', $custom_colors) . ']';
    }

    // Enable the text color picker in the toolbar
    $init['textcolor_rows'] = 6; // Adjust rows as needed

    return $init;
}
add_filter('tiny_mce_before_init', 'klf_tinymce_custom_colors');



/*-----------------------------------------------------------------------------------*/
/* Custom Login
/*-----------------------------------------------------------------------------------*/


// LOGO


function custom_loginlogo() {
    $logo = get_field('logo', 'option');
    
    if ($logo) {
        echo '<style type="text/css">
            h1 a { background-image: url(' . esc_url($logo['url']) . ') !important; }
        </style>';
    }
}
add_action('login_head', 'custom_loginlogo');

// PW Protect Login Logo


function custom_pw_logo() {
    $logo = get_field('logo', 'option');
    
    if ($logo) {
        echo '<style type="text/css">
            h1 a { background-image: url(' . esc_url($logo['url']) . ') !important; }
        </style>';
    }
}
add_action('password_protected_login_head', 'custom_pw_logo');

// Adding Image to login screen


function custom_login_html() {
	$background = get_field('login_background_image', 'options');
    // Add your HTML modifications here
    echo '<div class="image-wrap"><img src=' . esc_url($background['url']) . ' /></div>';
}

add_action('login_header', 'custom_login_html');

//PW Protect Login Image

function pw_protect_login() {
	$background = get_field('login_background_image', 'options');
    // Add your HTML modifications here
    echo '<div class="image-wrap"><img src=' . esc_url($background['url']) . ' /></div>';
}

add_action('password_protected_login_head', 'pw_protect_login');


/*-----------------------------------------------------------------------------------*/
/* Login Stylesheet
/*-----------------------------------------------------------------------------------*/

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/login.css' );
    // wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


// -------------------------------------------------------------------------
// Change excerpt word count length
// -------------------------------------------------------------------------
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



// -------------------------------------------------------------------------
// Custom Footer Text in Dashboard
// -------------------------------------------------------------------------


function replace_admin_footer_text($footer_text) {
    // Replace the default text with your custom text
    $footer_text = '<svg width="54" height="44" viewBox="0 0 54 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_29_691)">
<path d="M8 36.0002C8 36.0002 9.2 34.8002 10.1 34.2002C11 33.7002 11.7 33.8002 11.7 33.8002L14.9 39.9002C14.9 39.9002 16.3 39.8002 16.7 40.3002C17.2 40.7002 16.7 41.2002 16.3 41.6002C15.8 42.0002 14.6 42.8002 14.4 42.8002C14.2 42.8002 13.6 42.8002 13.2 42.4002C12.8 42.1002 12 41.2002 11.7 40.8002C11.4 40.7002 8 36.0002 8 36.0002Z" fill="#E03422"/>
<path d="M29.2004 34.3002C29.2004 34.3002 29.1004 35.1002 28.7004 36.1002C28.3004 37.1002 26.9004 39.7002 26.6004 40.1002C26.4004 40.5002 25.6004 41.2002 25.8004 42.1002C26.0004 43.0002 27.9004 43.5002 28.5004 43.5002C29.2004 43.5002 29.5004 43.3002 29.6004 42.8002C29.6004 42.3002 29.3004 41.7002 29.3004 41.6002C29.3004 41.5002 29.5004 41.0002 29.5004 40.9002C29.6004 40.8002 31.7004 38.1002 32.1004 37.7002C32.5004 37.3002 33.7004 35.6002 33.7004 35.6002C33.7004 35.6002 33.2004 34.7002 32.2004 34.5002C31.3004 34.2002 29.2004 34.3002 29.2004 34.3002Z" fill="#E03422"/>
<path d="M52.5003 15.7C52.3003 15.6 51.3003 15.4 50.5003 15.3C49.7003 15.1 48.5003 14.9 47.7003 14.6C46.9003 14.3 46.1003 14 45.4003 13.7C44.7003 13.3 44.3003 12.7 44.0003 12.1C43.6003 11.4 43.0003 9.1 42.8003 8.3C42.6003 7.4 42.4003 6.9 42.7003 6.7C43.0003 6.5 44.5003 6.7 44.6003 6.7C44.8003 6.8 45.5003 6.9 45.6003 6.7C45.8003 6.5 45.6003 6.2 45.4003 6C45.2003 5.8 44.0003 4.8 43.6003 4.4C43.2003 4 42.4003 3 41.2003 3.2C39.9003 3.3 39.7003 4.4 39.3003 5.2C38.9003 6 38.5003 7 38.3003 7.1C38.1003 7.2 37.9003 7.4 37.4003 6.7C37.0003 6 36.7003 4 36.5003 3C36.3003 2 35.9003 0 35.4003 0C34.9003 0 34.7003 1.2 34.5003 2.2C34.3003 3.2 33.8003 5.3 33.4003 6.8C32.9003 8.3 32.2003 10 31.2003 12.1C30.2003 14.1 29.1003 15 27.6003 16C26.1003 17 24.1003 17.5 22.7003 17.5C21.3003 17.5 20.9003 17.4 19.9003 17.2C18.9003 17 15.0003 16.3 11.7003 16.8C8.30033 17.3 6.70033 18.5 6.70033 18.5C6.70033 18.5 4.80033 16.3 4.60033 13.5C4.20033 10.7 5.00033 8 5.00033 8C5.00033 8 4.90033 8.1 4.50033 8.6C4.10033 9.1 2.70033 11.3 2.20033 13.1C1.80033 14.8 1.70033 15.6 2.00033 18.1C2.40033 20.6 4.30033 22.8 4.30033 22.8C4.30033 22.8 4.30033 23.3 4.40033 24C4.50033 24.6 4.70033 25.8 4.70033 25.8C4.90033 27.5 4.90033 28.8 4.50033 30.1C4.10033 31.4 2.80033 34.7 1.20033 37.5C-0.399668 40.3 0.100332 41.4 0.100332 41.4C0.100332 41.4 2.20033 43 2.40033 43.1C2.50033 43.2 3.00033 43.5 3.50033 43C4.00033 42.6 3.70033 40.6 3.70033 40.6C3.70033 40.6 5.40033 38.3 6.80033 36.6C8.20033 34.9 8.80033 34.3 9.70033 33.7C10.5003 33.1 11.1003 33.2 11.6003 33.3C12.2003 33.4 13.9003 33.4 16.4003 33.5C18.8003 33.6 24.6003 33.5 25.6003 33.5C26.6003 33.5 31.2003 33.3 32.3003 33.5C33.4003 33.7 33.7003 34.1 33.9003 34.5C34.2003 34.9 35.0003 36.7 36.2003 38.7C37.4003 40.7 39.5003 42.3 39.7003 42.4C39.9003 42.5 40.3003 42.8 40.8003 42.8C41.2003 42.8 42.2003 42.4 42.8003 41.9C43.4003 41.5 44.2003 40.4 43.4003 40C42.7003 39.6 41.3003 39.9 41.3003 39.9C41.3003 39.9 40.9003 39.2 40.1003 37.6C39.3003 36 38.0003 32.5 37.9003 32.1C37.8003 31.6 37.7003 30.2 38.4003 28.4C39.1003 26.5 40.0003 25.6 41.2003 24.6C42.4003 23.7 43.2003 23.7 45.0003 23.7C46.8003 23.7 47.5003 23.5 47.7003 23.4C47.9003 23.3 47.9003 23 47.9003 23C47.9003 23 45.7003 22.7 45.5003 22.7C45.3003 22.7 44.5003 22.4 43.5003 22.1C42.9003 21.9 42.8003 21.9 42.8003 21.9L43.0003 21.7C44.6003 22 46.8003 22 47.4003 22C48.0003 22 49.1003 22 50.5003 21C51.8003 20.1 51.9003 19.2 51.9003 19.2C51.9003 19.2 52.2003 19 52.4003 18.7C52.7003 18.4 53.0003 17.9 53.0003 17.2C53.1003 16.5 52.7003 15.9 52.5003 15.7ZM41.1003 15.2C40.2003 15.5 39.6003 15.3 39.5003 15.4C39.4003 15.4 40.2003 15.2 40.4003 14.6C40.6003 14 40.1003 13.4 39.7003 13.3C39.3003 13.2 38.5003 13.3 38.2003 14.1C37.9003 14.9 38.6003 15.3 38.6003 15.3C38.6003 15.3 38.1003 15.3 37.9003 15.1C37.7003 14.9 37.5003 14.3 37.5003 14.3C37.9003 13.4 38.4003 12.9 40.1003 12.9C41.8003 12.9 42.2003 14.2 42.2003 14.2C42.2003 14.2 42.0003 14.9 41.1003 15.2Z" fill="#E03422"/>
</g>
<defs>
<clipPath id="clip0_29_691">
<rect width="54" height="44" fill="white"/>
</clipPath>
</defs>
</svg> Crafted with ❤️ by Red Dog.';

    return $footer_text;
}

add_filter('admin_footer_text', 'replace_admin_footer_text');



// -------------------------------------------------------------------------
// Custom Dashboard Pages
// -------------------------------------------------------------------------


function hello_content() {
    // Your custom welcome message goes here
    echo '<div class="dashboard-page">';
    echo '<h2>Hello!</h2>';
    echo '<p>Welcome to your digital guidelines. You can edit your content via the pages tab on the left.</p>';
    echo '</div>';
}

function hello_page() {
    remove_menu_page('index.php'); // Remove the default dashboard menu
    add_menu_page(
        'Hello',
        'Hello',
        'read', // Capability required to access the page
        'hello',
        'hello_content',
        'dashicons-smiley',
        2 // Menu position
    );
}

add_action('admin_menu', 'hello_page');




function redirect_after_login($redirect_to, $request, $user) {
    // Check if the user is an administrator and redirect to your custom dashboard
    if (isset($user->roles) && is_array($user->roles) && in_array('administrator', $user->roles)) {
        return admin_url('admin.php?page=hello');
    }

    // Redirect to the default dashboard for other user roles
    return home_url();
}

add_filter('login_redirect', 'redirect_after_login', 10, 3);


// -------------------------------------------------------------------------
// Remove the WordPress version from  .css/.js files
// -------------------------------------------------------------------------

function sdt_remove_ver_css_js( $src, $handle ) 
{
  $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!
  if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
      $src = remove_query_arg( 'ver', $src );
  return $src;
}
add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );



// -------------------------------------------------------------------------
//	Remove customizer options.
// -------------------------------------------------------------------------
function ja_remove_customizer_options( $wp_customize ) {
   $wp_customize->remove_section( 'static_front_page' );
   $wp_customize->remove_section( 'title_tagline'     );
   $wp_customize->remove_section( 'menus'             );
   $wp_customize->remove_section( 'themes'            );
   $wp_customize->remove_control( 'custom_css' 				);
}
add_action( 'customize_register', 'ja_remove_customizer_options', 30 );




// -------------------------------------------------------------------------
// Filter/modify the content
// -------------------------------------------------------------------------
function filter_the_content( $content ) {
  // Remove p tags from images, scripts, and iframes.
  $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
  return $content;
}
//add_filter( 'the_content', 'filter_the_content' );


function brand_nspca_filter_paragraph_styles( $content ) {
    if ( ! is_string( $content ) || $content === '' ) {
        return $content;
    }

    // Strip Word-pasted paragraph styles, but keep text alignment as classes.
    $content = preg_replace_callback(
        '/<p([^>]*)\s+style=("|\')(.*?)\2/i',
        function ( $matches ) {
            $attrs = $matches[1];
            $style = $matches[3];

            if ( preg_match( '/\btext-align\s*:\s*(left|center|right|justify)\b/i', $style, $align_match ) ) {
                $class = 'align-' . strtolower( $align_match[1] );

                if ( preg_match( '/\bclass=("|\')(.*?)\1/i', $attrs, $class_match ) ) {
                    if ( strpos( $class_match[2], $class ) === false ) {
                        $attrs = preg_replace(
                            '/\bclass=("|\')(.*?)\1/i',
                            'class=$1' . trim( $class_match[2] . ' ' . $class ) . '$1',
                            $attrs,
                            1
                        );
                    }
                } else {
                    $attrs .= ' class="' . esc_attr( $class ) . '"';
                }

                $style = preg_replace( '/\s*text-align\s*:\s*(left|center|right|justify)\s*;?/i', '', $style );
                $style = trim( $style, '; ' );

                if ( $style !== '' ) {
                    return '<p' . $attrs . ' style="' . esc_attr( $style ) . '"';
                }

                return '<p' . $attrs;
            }

            return '<p' . $attrs;
        },
        $content
    );

    return $content;
}

add_filter( 'the_content', 'brand_nspca_filter_paragraph_styles', 20 );
add_filter( 'acf_the_content', 'brand_nspca_filter_paragraph_styles', 20 );


// -------------------------------------------------------------------------
// Modify TinyMCE editor to remove H1.
// -------------------------------------------------------------------------
function tiny_mce_remove_unused_formats($init) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
	return $init;
}
//add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );




// -------------------------------------------------------------------------
// Add quick-collapse feature to ACF Flexible Content fields
// -------------------------------------------------------------------------
add_action('acf/input/admin_head', function() { ?>
    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                var collapseButtonClass = 'collapse-all';

                // Add a clickable link to the label line of flexible content fields
                $('.acf-field-flexible-content > .acf-label')
                    .append('<a class="' + collapseButtonClass + '" style="position: absolute; top: 0; right: 0; cursor: pointer;">Collapse All</a>');

                // Simulate a click on each flexible content item's "collapse" button when clicking the new link
                $('.' + collapseButtonClass).on('click', function() {
                    $('.acf-flexible-content .layout:not(.-collapsed) .acf-fc-layout-controls .-collapse').click();
                });
            });
        })(jQuery);
    </script><?php
});



// -------------------------------------------------------------------------
// Generate Random String
// -------------------------------------------------------------------------
function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
}

function column_wrapper_attrs($background_colour, $text_colour, $border_radius) {
		$classes = [];
		$styles  = [];

		if ($background_colour || $border_radius) {
				$classes[] = 'inset-column';
		}
		if ($background_colour) {
				$styles[] = 'background-color: ' . $background_colour;
		}
		if ($text_colour) {
				$styles[] = 'color: ' . $text_colour;
		}
		if ($border_radius) {
				$styles[] = 'border-radius: ' . (int) $border_radius . 'px';
		}

		$attrs = '';
		if ($classes) {
				$attrs .= ' class="' . implode(' ', $classes) . '"';
		}
		if ($styles) {
				$attrs .= ' style="' . implode('; ', $styles) . '"';
		}
		return $attrs;
}




// -------------------------------------------------------------------------
// Hide wordpress content editor on specific pages.
// -------------------------------------------------------------------------
//add_action( 'admin_init', 'hide_editor' );

function hide_editor() {
  // Get the Post ID.
  $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
  if( !isset( $post_id ) ) return;

  // Hide the editor on the page titled 'Homepage'
  $homepagename = get_the_title($post_id);
  if($homepagename == 'Homepage'){ 
    //remove_post_type_support('page', 'editor');
  }

  // Hide the editor on a page with a specific page template
  // Get the name of the Page Template file.
  $template_file = get_post_meta($post_id, '_wp_page_template', true);

  if($template_file == 'my-page-template-filename.php'){ // the filename of the page template
    //remove_post_type_support('page', 'editor');
  }
}




// -------------------------------------------------------------------------
// Hide TAGS
// -------------------------------------------------------------------------
add_action('admin_menu', 'custom_remove_sub_menus');
function custom_remove_sub_menus() {
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
}

add_action( 'admin_menu' , 'custom_remove_metaboxes' );
function custom_remove_metaboxes() {
    remove_meta_box( 'tagsdiv-post_tag' , 'post' , 'normal' ); 
}





// -------------------------------------------------------------------------
//	 Add in core buttons that are disabled by default
// -------------------------------------------------------------------------
function my_mce_buttons_2( $buttons ) {	
	
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';
	$buttons[] = 'underline';

	return $buttons;
}
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );







// -------------------------------------------------------------------------
//	 Limit excerpt length for news articles in listing
// -------------------------------------------------------------------------
function limit_article_listing_single_item_excerpt($excerpt){
	if(strlen($excerpt) >75){  
		return substr($excerpt, 0, strpos($excerpt, ' ', 75)) .'...'; 
	} 
	else { 
		return $excerpt; 
	} 												
}


// -------------------------------------------------------------------------
// Custom Password Protection Form with Error Messages and Attempt Limiting
// -------------------------------------------------------------------------

// Handle password submission and track attempts
function handle_password_attempts() {
	// Only process if this is a password submission
	if ( ! isset( $_POST['post_password'] ) || ! isset( $_REQUEST['action'] ) || $_REQUEST['action'] !== 'postpass' ) {
		return;
	}
	
	// Get the post ID from redirect_to or referer
	$post_id = 0;
	if ( isset( $_POST['post_id'] ) ) {
		$post_id = intval( $_POST['post_id'] );
	} elseif ( isset( $_POST['redirect_to'] ) ) {
		$post_id = url_to_postid( $_POST['redirect_to'] );
	} elseif ( wp_get_referer() ) {
		$post_id = url_to_postid( wp_get_referer() );
	}
	
	if ( ! $post_id ) {
		return;
	}
	
	$post = get_post( $post_id );
	if ( ! $post || empty( $post->post_password ) ) {
		return;
	}
	
	$cookie_name = 'pw_attempts_' . $post_id;
	$attempts = isset( $_COOKIE[ $cookie_name ] ) ? intval( $_COOKIE[ $cookie_name ] ) : 0;
	
	// Check if already blocked (3 attempts reached)
	if ( $attempts >= 3 ) {
		wp_safe_redirect( add_query_arg( 'pw_error', 'blocked', get_permalink( $post_id ) ) );
		exit;
	}
	
	// Validate password
	require_once ABSPATH . WPINC . '/class-phpass.php';
	$hasher = new PasswordHash( 8, true );
	$submitted_password = wp_unslash( $_POST['post_password'] );
	$is_correct = $hasher->CheckPassword( $post->post_password, $hasher->HashPassword( $submitted_password ) );
	
	if ( ! $is_correct ) {
		// Increment attempts
		$attempts++;
		$expire = time() + ( 15 * MINUTE_IN_SECONDS ); // Block for 15 minutes
		setcookie( $cookie_name, $attempts, $expire, COOKIEPATH, COOKIE_DOMAIN, is_ssl() );
		
		// Redirect with error - prevent WordPress from processing
		$error_param = $attempts >= 3 ? 'blocked' : 'incorrect';
		wp_safe_redirect( add_query_arg( 'pw_error', $error_param, get_permalink( $post_id ) ) );
		exit;
	} else {
		// Password correct - clear attempts cookie and let WordPress handle it normally
		setcookie( $cookie_name, '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl() );
	}
}
add_action( 'login_init', 'handle_password_attempts', 1 );

// Custom password form with error messages
function custom_password_form( $output, $post = 0 ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return $output;
	}
	
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$error_message = '';
	$is_blocked = false;
	$attempts = 0;
	
	// Check for error messages
	if ( isset( $_GET['pw_error'] ) ) {
		$cookie_name = 'pw_attempts_' . $post->ID;
		$attempts = isset( $_COOKIE[ $cookie_name ] ) ? intval( $_COOKIE[ $cookie_name ] ) : 0;
		
		if ( $_GET['pw_error'] == 'blocked' || $attempts >= 3 ) {
			$is_blocked = true;
			$error_message = '<div class="password-form-error" role="alert"><p class="error-message">' . __( 'Too many incorrect attempts. Please try again in 15 minutes.' ) . '</p></div>';
		} elseif ( $_GET['pw_error'] == 'incorrect' ) {
			$remaining = 3 - $attempts;
			$error_message = '<div class="password-form-error" role="alert"><p class="error-message">' . __( 'Password incorrect, try again.' ) . ' ' . sprintf( __( '(%d attempt(s) remaining)' ), $remaining ) . '</p></div>';
		}
	}
	
	// Check if password is already correct (to avoid showing form)
	if ( ! post_password_required( $post ) ) {
		return $output;
	}
	
	// Build form
	$form_class = $is_blocked ? 'post-password-form blocked' : 'post-password-form';
	$disabled = $is_blocked ? ' disabled' : '';
	
	$output = '<div class="password-protected-form-wrapper">
		<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="' . $form_class . '" method="post">
			<input type="hidden" name="post_id" value="' . esc_attr( $post->ID ) . '" />
			<input type="hidden" name="redirect_to" value="' . esc_attr( get_permalink( $post->ID ) ) . '" />
			' . $error_message . '
			<p class="password-form-message">' . sprintf( __( 'This section includes approved, ready to use templates which should only be amended by a professional designer. Examples of these can be viewed in the ‘Brand in Action’ section. A password can be provided to Designers on request by emailing %s.' ), '<a href="' . esc_url( 'mailto:design@corlann.ie' ) . '">' . esc_html( 'design@corlann.ie' ) . '</a>' ) . '</p>
			<div class="password-form-fields">
				<label for="' . $label . '">' . __( 'Password:' ) . '</label>
				<input name="post_password" id="' . $label . '" type="password" size="20" class="password-input" placeholder="' . esc_attr__( 'Enter password' ) . '"' . $disabled . ' required />
				<input type="submit" name="Submit" value="' . esc_attr__( 'Enter' ) . '" class="btn password-submit"' . $disabled . ' />
			</div>
		</form>
	</div>';
	
	return $output;
}
add_filter( 'the_password_form', 'custom_password_form', 10, 2 );


// -------------------------------------------------------------------------
// Add lock icon to password protected menu items
// -------------------------------------------------------------------------
class Custom_Nav_Walker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes .'>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );
		
		// Check if this menu item points to a password protected post/page
		$post_id = null;
		
		// Method 1: Check by object_id (most reliable)
		if ( ! empty( $item->object_id ) ) {
			$is_post_type = ( isset( $item->type ) && $item->type == 'post_type' ) || 
			                ( isset( $item->object ) && in_array( $item->object, array( 'page', 'post' ) ) );
			
			if ( $is_post_type ) {
				$post_id = $item->object_id;
			}
		}
		
		// Method 2: Fallback - get post ID from URL if object_id not available
		if ( ! $post_id && ! empty( $item->url ) ) {
			$post_id = url_to_postid( $item->url );
		}
		
		if ( $post_id ) {
			// Get post password directly from database to work for all users
			global $wpdb;
			$post_password = $wpdb->get_var( $wpdb->prepare(
				"SELECT post_password FROM {$wpdb->posts} WHERE ID = %d AND post_status = 'publish'",
				$post_id
			) );
			
			if ( ! empty( $post_password ) ) {
				// Get the post object to check if password has been entered
				$post = get_post( $post_id );
				
				if ( $post ) {
					// Check if password has been entered correctly (page is unlocked)
					$is_unlocked = ! post_password_required( $post );
					
					// Customize icons here - you can use SVG, icon fonts, or emoji
					$locked_icon = apply_filters( 'menu_lock_icon_html', '<span class="dashicons dashicons-lock"></span>', 'locked' );
					$unlocked_icon = apply_filters( 'menu_lock_icon_html', '<span class="dashicons dashicons-unlock"></span>', 'unlocked' );

					if ( $is_unlocked ) {
						// Show unlocked icon if password has been entered
						$item_output .= ' <span class="menu-lock-icon menu-unlock-icon" aria-label="Password Entered">' . $unlocked_icon . '</span>';
					} else {
						// Show locked icon if password hasn't been entered
						$item_output .= ' <span class="menu-lock-icon" aria-label="Password Protected">' . $locked_icon . '</span>';
					}
				}
			}
		}
		
		$item_output .= '</a>';
		$item_output .= isset( $args->after ) ? $args->after : '';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}


// -------------------------------------------------------------------------
// Load theme styles inside the Gutenberg editor iframe
// -------------------------------------------------------------------------
add_action( 'after_setup_theme', function() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/normalize.css' );
	add_editor_style( 'dist/css/main.css' );
} );


// -------------------------------------------------------------------------
// ACF JSON sync paths
// -------------------------------------------------------------------------
add_filter( 'acf/settings/save_json', fn() => get_template_directory() . '/acf-json' );
add_filter( 'acf/settings/load_json', function( $paths ) {
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
} );

// -------------------------------------------------------------------------
// Register ACF Blocks
// -------------------------------------------------------------------------
add_action( 'init', function() {
	$blocks = [
		'one-column',
		'two-columns',
		'three-columns',
		'four-columns',
		'five-columns',
		'colour-palette',
		'downloads',
		'photography-themes',
	];
	foreach ( $blocks as $block ) {
		register_block_type( get_template_directory() . '/blocks/' . $block );
	}
} );

add_filter( 'acf/register_block_type_args', function( $args ) {
	$args['mode'] = 'auto';
	return $args;
} );


// -------------------------------------------------------------------------
// Restrict block inserter to theme blocks only
// -------------------------------------------------------------------------
add_filter( 'allowed_block_types_all', function( $allowed_blocks, $block_editor_context ) {
	return [
		'acf/one-column',
		'acf/two-columns',
		'acf/three-columns',
		'acf/four-columns',
		'acf/five-columns',
		'acf/colour-palette',
		'acf/downloads',
		'acf/photography-themes',
	];
}, 10, 2 );

