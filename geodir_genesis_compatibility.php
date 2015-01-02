<?php
/*
Plugin Name: GeoDirectory - Genesis Theme Compatibility
Plugin URI: http://wpgeodirectory.com
Description: This plugin lets the GeoDirectory Plugin use the Genesis theme HTML wrappers to fit and work perfectly.
Version: 1.0.5
Author: GeoDirectory
Author URI: http://wpgeodirectory.com

*/ 


// FREMOVE AND RE-ENQUEUE CHILD STYLESHEET
add_action( 'genesis_setup', 'pw_delay_genesis_stylesheet' );

// BECAUSE THIS PLUGIN IS CALLED BEFORE GD WE MUST CALL THIS PLUGIN ONCE GD LOADS
add_action( 'plugins_loaded', 'geodir_genesis_action_calls', 10 );
function geodir_genesis_action_calls(){
	
	/* ACTIONS
	****************************************************************************************/
	// LOAD STYLESHEET
	add_action( 'wp_enqueue_scripts', 'geodir_genesis_styles' );
	
	// Add body class for styling purposes
	add_filter('body_class','geodir_genesis_body_class');
	
	// Force Full Width on signup page
	add_action( 'genesis_meta', 'geodir_genesis_meta' );
	
	// HOME TOP SIDEBAR
	remove_action( 'geodir_home_before_main_content', 'geodir_action_geodir_sidebar_home_top', 10 );
	remove_action( 'geodir_location_before_main_content', 'geodir_action_geodir_sidebar_home_top', 10 );
	add_action( 'genesis_after_header', 'geodir_genesis_home_sidebar', 21 );
	
	// WRAPPER OPEN ACTIONS
	remove_action( 'geodir_wrapper_open', 'geodir_action_wrapper_open', 10 );
	add_action( 'geodir_wrapper_open', 'geodir_genesis_action_wrapper_open', 9 );
	
	// WRAPPER CLOSE ACTIONS
	remove_action( 'geodir_wrapper_close', 'geodir_action_wrapper_close', 10);
	add_action( 'geodir_wrapper_close', 'geodir_genesis_action_wrapper_close', 11);	
	
	// WRAPPER CONTENT OPEN ACTIONS
	remove_action( 'geodir_wrapper_content_open', 'geodir_action_wrapper_content_open', 10 );
	add_action( 'geodir_wrapper_content_open', 'geodir_genesis_action_wrapper_content_open', 9, 3 );
	
	// WRAPPER CONTENT CLOSE ACTIONS
	remove_action( 'geodir_wrapper_content_close', 'geodir_action_wrapper_content_close', 10);
	add_action( 'geodir_wrapper_content_close', 'geodir_genesis_action_wrapper_content_close', 11);
	
	// SIDEBAR RIGHT OPEN ACTIONS
	remove_action( 'geodir_sidebar_right_open', 'geodir_action_sidebar_right_open', 10 );
	add_action( 'geodir_sidebar_right_open', 'geodir_genesis_action_sidebar_right_open', 10, 4 );
	
	// SIDEBAR RIGHT CLOSE ACTIONS
	remove_action( 'geodir_sidebar_right_close', 'geodir_action_sidebar_right_close', 10);
	add_action( 'geodir_sidebar_right_close', 'geodir_genesis_action_sidebar_right_close', 10,1);
	
	// ADD .entry CLASS TO <article> FOR LISTINGS
	add_filter('geodir_post_view_article_extra_class' ,'geodir_genesis_post_view_article_class');
	
	// REPLACE GENESIS BREADCRUMBS WITH GD BREADCRUMBS
	remove_action( 'geodir_detail_before_main_content', 'geodir_breadcrumb', 20 );
	remove_action( 'geodir_listings_before_main_content', 'geodir_breadcrumb', 20 );
	remove_action( 'geodir_author_before_main_content', 'geodir_breadcrumb', 20 );
	remove_action( 'geodir_search_before_main_content', 'geodir_breadcrumb', 20 );
	remove_action( 'geodir_home_before_main_content', 'geodir_breadcrumb', 20 );
	remove_action( 'geodir_location_before_main_content', 'geodir_breadcrumb', 20 );
	add_action( 'genesis_after_header', 'geodir_replace_breadcrumb', 20 );
	
	// REMOVE LEFT SIDEBARS
	remove_action( 'geodir_listings_sidebar_left', 'geodir_action_listings_sidebar_left', 10 );
	remove_action( 'geodir_search_sidebar_left', 'geodir_action_search_sidebar_left', 10 );
	remove_action( 'geodir_author_sidebar_left', 'geodir_action_author_sidebar_left', 10 );
	remove_action( 'geodir_home_sidebar_left', 'geodir_action_home_sidebar_left', 10 );
	
	// ADD LAYOUT-DEPENDANT SIDEBAR
	add_action( 'geodir_secondary_sidebar', 'geodir_secondary_sidebar_action' );
	
} // Close geodir_genesis_action_calls

/* FUNCTIONS
****************************************************************************************/

// FUNCTION TO REMOVE CHILD STYLESHEET AND ENQUEUE AT A LATER PRIORITY
function pw_delay_genesis_stylesheet() {

	// If Parallax Pro theme is active, enqueue at earlier priority
	$priority = 'Parallax Pro Theme' == wp_get_theme() ? 14 : 999;

	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
	add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', $priority );
}

// ADD ENTRY CLASS TO ARTICLES CREATED BY GEODIRECTORY
function geodir_genesis_post_view_article_class() {
	$post_view_article_class = 'entry';
	return $post_view_article_class;
}

// ENQUEUE STYLESHEET & ADD BODY CLASS
function geodir_genesis_styles() {
    wp_register_style( 'geodir-genesis-style', plugins_url( '/css/plugin.css', __FILE__ ) );
    wp_enqueue_style( 'geodir-genesis-style' );
}

function geodir_genesis_body_class($classes) {
	$classes[] = 'geodir-genesis';
	return $classes;
}

// FORCE FULL WIDTH LAYOUT ON SIGNUP PAGE
function geodir_genesis_meta() {
	if ( isset($_GET['geodir_signup']) ) {
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}
}

// REPLACE HOME TOP SIDEBAR AFTER HEADER
function geodir_genesis_home_sidebar() {
	if ( geodir_is_page('location') || ( is_front_page() && get_option('geodir_set_as_home') ) && !isset($_GET['geodir_signup']) ) {
		echo '<div class="gd-genesis-home-top">';
		dynamic_sidebar('geodir_home_top');
		echo '</div>';
	}
}

// WRAPPER OPEN FUNCTIONS
function geodir_genesis_action_wrapper_open() {
	echo '<div class="geodir-genesis-outer">';
	if ( isset($_GET['geodir_signup']) ) {
		echo '<div class="geodir-signup-wrapper">';
	}
}

// WRAPPER CLOSE FUNCTIONS
function geodir_genesis_action_wrapper_close() {
	if ( isset($_GET['geodir_signup']) ) {
		echo '</div>'; // Closes .geodir-signup-wrapper
		echo '</div>'; // Closes .content-sidebar-wrap (because no sidebar exists to close it)
	}
	echo '</div>'; // Closes .geodir-genesis-outer
}

// WRAPPER CONTENT OPEN FUNCTIONS
function geodir_genesis_action_wrapper_content_open($type='',$id='',$class=''){
	do_action( 'genesis_before_content_sidebar_wrap' );
	echo '<div class="content-sidebar-wrap">';
	do_action( 'genesis_before_content' );
	echo '<main class="content '. $class .'" itemprop="mainContentOfPage" role="main">';
	if ( geodir_is_page('add-listing') ) {
		echo '<article class="entry">';
	}
}

// WRAPPER CONTENT CLOSE FUNCTIONS
function geodir_genesis_action_wrapper_content_close(){
	if ( geodir_is_page('add-listing') ) {
		echo '</article>';
	}
	echo '</main>';
	//do_action( 'genesis_after_content' );
}

// SIDEBAR RIGHT OPEN FUNCTIONS
function geodir_genesis_action_sidebar_right_open($type='',$id='',$class='',$itemtype=''){
	do_action( 'genesis_before_sidebar_widget_area' );
	echo '<aside class="sidebar sidebar-primary widget-area" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
}

// SIDEBAR RIGHT CLOSE FUNCTIONS
function geodir_genesis_action_sidebar_right_close($type=''){
	echo '</aside>';
	do_action( 'genesis_after_sidebar_widget_area' );
	echo '</div>'; // closes .content-sidebar-wrap
	//do_action( 'genesis_after_content_sidebar_wrap' );
	do_action( 'geodir_secondary_sidebar' );
}

// GENERATE SECONDARY SIDEBAR IF THREE COLUMN LAYOUT
function geodir_secondary_sidebar_action() {
	$site_layout = genesis_site_layout();
	if ( !isset($_GET['geodir_signup']) ) {
		if ( in_array( $site_layout, array( 'sidebar-content-sidebar', 'content-sidebar-sidebar', 'sidebar-sidebar-content' ) ) ) {
			do_action( 'genesis_before_sidebar_alt_widget_area' );
			echo '<aside class="sidebar sidebar-secondary widget-area" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
			// Check which page we are on and output the correct sidebar else output Genesis secondary sidebar
			if ( geodir_is_page('listing') && get_option('geodir_show_listing_left_section') ) {
				dynamic_sidebar('geodir_listing_left_sidebar');
			}
			else if ( geodir_is_page('search') && get_option('geodir_show_search_left_section') ) {
				dynamic_sidebar('geodir_search_left_sidebar');
			}
			else if ( geodir_is_page('author') && get_option('geodir_show_author_left_section') ) {
				dynamic_sidebar('geodir_author_left_sidebar');
			}
			else if ( is_front_page() || geodir_is_page('location') && get_option('geodir_show_home_left_section') ) {
				dynamic_sidebar('geodir_home_left');
			}
			else {
				dynamic_sidebar( 'sidebar-alt' );
			}
			echo '</aside>';
			do_action( 'genesis_after_sidebar_alt_widget_area' );
		}
	}
}

// REPLACE GENESIS BREADCRUMBS FUNCTION
function geodir_replace_breadcrumb() {
	if ( is_front_page() && get_option('geodir_set_as_home') && !isset($_GET['geodir_signup']) ) {
	} else {
		echo '<div class="geodir-breadcrumb-bar"><div class="wrap">';
		geodir_breadcrumb();
		echo '</div></div>';
	}
}





