<?php
/**
 * Frimi functions and definitions
 *
 * @package Frimi
 */

global $Frimi;
if (!is_array($Frimi)) {
   $curdir= __DIR__;
   $Frimi = array(
      "site.private" => 1,
      "theme.dir" => $curdir,
      "theme.uri" => get_template_directory_uri(),
      );
}

if (! function_exists('frimi')):
   function frimi ($var) {
      global $Frimi;
      $res="";
      if (isset($Frimi[$var])) 
         $res = $Frimi[$var];
      return $res;
   }
endif;

if (! function_exists('frimi_install')):
   function frimi_install ($var) {
      global $Frimi;
      $curdir = frimi("theme.dir");
      $tabdir=array("$curdir/template");
      foreach ($tabdir as $d => $dir2create) {
         if (!is_dir($dir2create)) mkdir($dir2create, 0777);
      }
      $tabfile=array(
         "$curdir/template/grid-10x10.php",
         "$curdir/frimi.css",
         );
      foreach ($tabfile as $f => $file2create) {
         if (!is_file($file2create)) touch($file2create);
      }

   }
   //frimi_install();
endif;

if (! function_exists('frimi_check_private')):
   function frimi_check_private () {
      $user = wp_get_current_user();
      $uid = $user->ID;
      if ($uid == 0) {
         wp_die();
      }
   };
endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'frimi_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function frimi_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Frimi, use a find and replace
	 * to change 'frimi' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'frimi', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'frimi' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'frimi_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );

        // add redirect if site is private
        if (frimi("site.private")) 
           add_action( 'template_redirect', 'frimi_check_private' );

}
endif; // frimi_setup
add_action( 'after_setup_theme', 'frimi_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function frimi_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'frimi' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'frimi_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function frimi_scripts() {
	wp_enqueue_style( 'frimi-style', get_stylesheet_uri() );

	wp_enqueue_script( 'frimi-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'frimi-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'frimi_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/*
 * APPLH CODE
 */
add_action('admin_menu', 'my_frimi_menu');

function my_frimi_menu () {
	add_theme_page('My Frimi Theme Options', 'Theme Options', 'edit_theme_options', 'frimi-theme-options', 'my_frimi_theme_options_page');
}

function my_frimi_theme_options_page () {
   echo "<h1>HELLO WORLD</h1>";
}

function frimi_head() {
    $themeuri=frimi('theme.uri');
	$frimi_head=
<<<FRIMIHEAD
	<link rel="stylesheet" type="text/css" media="all" href="{$themeuri}/frimi.css">
FRIMIHEAD;

	echo $frimi_head;
	
};

add_action('wp_head', 'frimi_head');


