<?php
/***************************************
 *	 CREATE GLOBAL VARIABLES
 ***************************************/
define( 'HOME_URI', home_url() );
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_IMAGES', THEME_URI . '/dist-assets/images' );
define( 'DEV_CSS', THEME_URI . '/dev-assets/css' );
define( 'DEV_JS', THEME_URI . '/dev-assets/js' );
define( 'DIST_CSS', THEME_URI . '/dist-assets/css' );
define( 'DIST_JS', THEME_URI . '/dist-assets/js' );
define( 'FILES_DIR', THEME_URI . '/dist-assets/files' );

/***************************************
 * Include helpers
 ***************************************/
include 'inc/bootstrap_navwalker.php';
//include 'inc/gravityforms.php'; /* Einkommentieren, falls GravityForms verwendet wird */

/***************************************
 * 		Theme Support and Options
 ***************************************/
function compresso_theme_setup() {
  /* Theme Supports */
  add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'script', 'style', 'navigation-widgets' ) );
  add_theme_support( 'title-tag' );
  add_theme_support( 'menus' );
  add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'align-wide' );
  add_theme_support( 'responsive-embeds' );
  add_theme_support( 'post-thumbnails' );

  /* Menüs aktivieren */
  register_nav_menu( 'main_menu', 'Hauptmenü' );

  /* Adminbar permanent ausblenden */
  //add_filter('show_admin_bar', '__return_false');

  /* Bildgrössen definieren */
  //add_image_size( 'full_width', 1920, 9999, false );
}
add_action( 'after_setup_theme', 'compresso_theme_setup' );

/***************************************
 * 	FRONTEND: Enqueue scripts and styles.
 ***************************************/
function compresso_startup_styles_and_scripts() {
  /* Speed Up with "&display=swap -> https://developers.google.com/web/updates/2016/02/font-display */
  wp_enqueue_style( 'compresso_fonts', 'https://fonts.googleapis.com/css?family=Ubuntu&display=swap', null, false );
  /* Styles and Scripts laden */
  $modificated_css = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/dist-assets/css/public.min.css' ) );
  $modificated_js = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/dist-assets/js/public.min.js' ) );
  wp_register_style( 'compresso_style', DIST_CSS . '/public.min.css', array( 'compresso_fonts' ), $modificated_css );
  wp_register_script( 'compresso_script', DIST_JS . '/public.min.js', array( 'jquery' ), $modificated_js, true );
  /*
    Globale Variabeln zur JavaScript Datei hinzufügen. Dadurch können im JavaScript File auf PHP Variabeln zugegriffen werden:
    Als Beispiel:
    console.log( compresso_vars.home_uri )
  */
  $compresso_vars = array(
    'home_uri' => HOME_URI
  );
  wp_localize_script( 'compresso_script', 'compresso_vars', $compresso_vars );
  /* CSS und JS Datei ausgeben */
  wp_enqueue_style( 'compresso_style' );
  wp_enqueue_script( 'compresso_script' );
}
add_action( 'wp_enqueue_scripts', 'compresso_startup_styles_and_scripts' );

/***************************************
 * 	BACKEND: Enqueue scripts and styles.
 ***************************************/
function compresso_startup_styles_and_scripts_backend() {
  /* Styles and Scripts laden */
  $modificated_css = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/dist-assets/css/admin.min.css' ) );
  $modificated_js = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/dist-assets/js/admin.min.js' ) );
  wp_register_style( 'compresso_backend_style', DIST_CSS . '/admin.min.css', array(), $modificated_css );
  wp_register_script( 'compresso_backend_script', DIST_JS . '/admin.min.js', array( 'jquery' ), $modificated_js, true );
  /*
    Globale Variabeln zur JavaScript Datei hinzufügen. Dadurch können im JavaScript File auf PHP Variabeln zugegriffen werden:
    Als Beispiel:
    console.log( compresso_backend_vars.home_uri )
  */
  $compresso_backend_vars = array(
    'home_uri' => HOME_URI
  );
  wp_localize_script( 'compresso_backend_script', 'compresso_vars', $compresso_backend_vars );
  /* CSS und JS Datei ausgeben */
  wp_enqueue_style( 'compresso_backend_style' );
  wp_enqueue_script( 'compresso_backend_script' );
}
add_action( 'admin_enqueue_scripts', 'compresso_startup_styles_and_scripts_backend' );

/***************************************
 * 	Einstellungen für Advanced Custom Fields
 ***************************************/
function compresso_acf_init() {
  /* ACF Optionsseiten hinzufügen */
  if( function_exists( 'acf_add_options_sub_page' ) ) {
    $args = array(
      'page_title' => 'Theme Einstellungen',
      'menu_title' => 'Einstellungen',
      'menu_slug' => 'compresso-theme-settings',
      'parent_slug' => 'themes.php',
    );
    acf_add_options_sub_page($args);
  }
  /* ACF Google Maps API Key für das Google Maps Feld hinzufügen */
  //acf_update_setting( 'google_api_key', 'xxx' );
}
add_action( 'acf/init', 'compresso_acf_init' );

/***************************************
 * Remove Menus from Backend
 ***************************************/
function compresso_remove_menus() {
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
//add_action( 'admin_menu', 'compresso_remove_menus' );

/***************************************
 * Remove default Taxonmoies (Categories and Tags) <-- not visible in Sitemap better Google Indexing
 ***************************************/
function compresso_unregister_taxonomy() {
  unregister_taxonomy_for_object_type( 'post_tag', 'post' );
  unregister_taxonomy_for_object_type( 'category', 'post' );
}
add_action( 'init', 'compresso_unregister_taxonomy' );