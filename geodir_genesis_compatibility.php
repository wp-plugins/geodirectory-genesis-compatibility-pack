<?php
/*
Plugin Name: GeoDirectory - Genesis Theme Compatibility
Plugin URI: http://wpgeodirectory.com
Description: This plugin lets the GeoDirectory Plugin use the Genesis theme HTML wrappers to fit and work perfectly.
Version: 1.0.3
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
	
	// HOME TOP SIDEBAR
	remove_action( 'geodir_home_before_main_content', 'geodir_action_geodir_sidebar_home_top', 10 );
	add_action( 'genesis_after_header', 'geodir_genesis_home_sidebar', 21 );
	add_action( 'geodir_before_search_form', 'geodir_genesis_search_container_open' );
	add_action( 'geodir_after_search_form', 'geodir_genesis_search_container_close' );
	
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
	add_action( 'genesis_after_header', 'geodir_replace_breadcrumb', 20 );
	
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
    // Register the style like this for a plugin:
    wp_register_style( 'geodir-genesis-style', plugins_url( '/css/plugin.css', __FILE__ ) );
    wp_enqueue_style( 'geodir-genesis-style' );
}

function geodir_genesis_body_class($classes) {
	$classes[] = 'geodir-genesis';
	return $classes;
}

// REPLACE HOME TOP SIDEBAR AFTER HEADER
function geodir_genesis_home_sidebar() {
	// 	if ( ( is_front_page() && get_option('geodir_set_as_home') ) || geodir_is_page('location') && !$_GET['geodir_signup'] ) {

		if ( geodir_is_page('location') || ( is_front_page() && get_option('geodir_set_as_home') ) && !$_GET['geodir_signup'] ) {
			echo '<div class="gd-genesis-home-top">';
        	dynamic_sidebar('geodir_home_top');
			echo '</div>';
		}
}

// ADD OPENING WRAP TO SEARCHBAR
function geodir_genesis_search_container_open() {
	echo '<div class="wrap">';
}

// ADD CLOSING WRAP TO SEARCHBAR
function geodir_genesis_search_container_close() {
	echo '</div>';
}

// WRAPPER OPEN FUNCTIONS
function geodir_genesis_action_wrapper_open() {
	echo '<div class="content-sidebar-wrap">';
	if ( $_GET['geodir_signup'] ) {
		echo '<div class="geodir-signup-wrapper">';
	}
}

// WRAPPER CLOSE FUNCTIONS
function geodir_genesis_action_wrapper_close() {
	if ( $_GET['geodir_signup'] ) {
		echo '</div">';
	}
	echo '</div>';
	// Check for 3 column layout and add sidebar-alt
	$site_layout = genesis_site_layout();
	if ( $site_layout == 'sidebar-content-sidebar' || $site_layout == 'content-sidebar-sidebar' || $site_layout == 'sidebar-sidebar-content' ) {
		echo '<aside class="sidebar sidebar-secondary widget-area" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
		dynamic_sidebar( 'sidebar-alt' );
		echo '</aside>';
	}
}

// WRAPPER CONTENT OPEN FUNCTIONS
function geodir_genesis_action_wrapper_content_open($type='',$id='',$class=''){
		echo '<main class="content '. $class .'" itemprop="mainContentOfPage" role="main">';
		if ( geodir_is_page('add-listing') ) {
			echo '<article class="entry">';
		}
}

// WRAPPER CONTENT CLOSE FUNCTIONS
function geodir_genesis_action_wrapper_content_close(){
	echo '</main>';
	if ( geodir_is_page('add-listing') ) {
		echo '</article>';
	}
}

// SIDEBAR RIGHT OPEN FUNCTIONS
function geodir_genesis_action_sidebar_right_open($type='',$id='',$class='',$itemtype=''){
	echo '<aside class="sidebar sidebar-primary widget-area" itemtype="http://schema.org/WPSideBar" itemscope="itemscope" role="complementary">';
}

// SIDEBAR RIGHT CLOSE FUNCTIONS
function geodir_genesis_action_sidebar_right_close($type=''){
	echo '</aside>';
}

// REPLACE GENESIS BREADCRUMBS FUNCTION
function geodir_replace_breadcrumb() {
	echo '<div class="geodir-breadcrumb-bar"><div class="wrap">';
	geodir_breadcrumb();
	echo '</div></div>';
}





