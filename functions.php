<?php
ini_set('display_errors',0); 
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/cons_error_log.txt');
error_reporting(E_ALL^E_NOTICE^E_STRICT);

// Names and stuff
define('URL',get_bloginfo('url'));
define('NAME',get_bloginfo('name'));
define('DESCRIPTION',get_bloginfo('description'));
define('RSS',get_bloginfo('rss2_url'));

// Define folder constants
define('ROOT', 	get_bloginfo('template_url'));
define('JS', 	ROOT . '/js');
define('CSS', 	ROOT . '/css');
define('IMG', 	ROOT . '/images');

add_filter('the_category','the_category_filter',10,2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'parent_post_rel_link');
remove_action('wp_head', 'feed_links_extra');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'wp_generator');


require_once(TEMPLATEPATH . '/lib/func.php');

// Export functionality
require_once(TEMPLATEPATH . '/lib/exporter.php');

// Widget functionality
require_once(TEMPLATEPATH . '/lib/widget.php');

require_once(TEMPLATEPATH . '/lib/export_timeline.php');
require_once(TEMPLATEPATH . '/lib/export_statistics.php');

// Boostrap Helper Function
require_once(TEMPLATEPATH . '/lib/wp_bootstrap_navwalker.php');
require_once(TEMPLATEPATH . '/lib/wp_bootstrap_comment.php');


add_action( 'wp_enqueue_scripts', 'opengov_scripts' );
function opengov_scripts(){
	
	if( !is_admin()){
		wp_enqueue_script("jquery");

		wp_enqueue_style( 'opensans', 	'http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700&subset=latin,greek' );
		wp_enqueue_style( 'bootstrap', 	CSS.'/bootstrap.min.css' );
		wp_enqueue_style( 'awesome', 	CSS.'/font-awesome.min.css' );
		wp_enqueue_style( 'main-css', 	CSS.'/main.css' );
		wp_enqueue_style( 'overline',	ROOT.'/style.css' );
		
		wp_enqueue_script( 'bootstrap-js', 	JS . '/bootstrap.min.js', array( 'jquery' ) , '1.2.0' , true );
		wp_enqueue_script( 'viewport-ie', 	JS . '/ie10-viewport-bug-workaround.js', array( 'jquery' ) , '1.2.0' , true );	
		wp_enqueue_script( 'placeholder', 	JS . '/jquery.placeholder.min.js', array( 'jquery' ) , '1.2.0' , true );	
		wp_enqueue_script( 'slimscroll', 	JS . '/jquery.slimscroll.min.js', array( 'jquery' ) , '1.2.0' , true );	
		wp_enqueue_script( 'sparkline', 	JS . '/sparkline.js', array( 'jquery' ) , '1.2.0' , true );	
		wp_enqueue_script( 'main-js', 			JS . '/main.js', array( 'jquery' ) , '1.0.0' , true );	

	}
}

add_action( 'widgets_init', 'consultations_widgets_init' );
function consultations_widgets_init() {
	
	register_sidebar( array(
        'name' => __( 'Single Sidebar', 'opengov' ),
        'id' => 'sidebar-single',
        'description' => __( 'Widgets in this area will be shown on single posts only.', 'opengov' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );
	
	register_sidebar( array(
        'name' => __( 'Footer Left Sidebar', 'opengov' ),
        'id' => 'footer-left',
        'description' => __( 'Footer Left area', 'opengov' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name' => __( 'Footer Center Sidebar', 'opengov' ),
        'id' => 'footer-center',
        'description' => __( 'Footer Center area', 'opengov' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );
	register_sidebar( array(
        'name' => __( 'Footer Right Sidebar', 'opengov' ),
        'id' => 'footer-right',
        'description' => __( 'Footer Right area', 'opengov' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
    ) );

}

/* Setup Menu ************************/
function menu_setup() {
	register_nav_menu('main-menu', __( 'Main Menu', 'opengov'));
	function fallbackfmenu(){ echo 'Ορίστε Πρώτα Μενού'; }	
}

add_action( 'after_setup_theme', 'menu_setup' );
// Init Backend Functions
require_once('admin/menu.php');

?>
