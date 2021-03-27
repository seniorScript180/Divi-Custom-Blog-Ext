<?php
/*
Plugin Name: Custom Blog Ext
Plugin URI:  
Description: 
Version:     2.0.5
Author:      Antonis Ntoumanis
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: custom-blog-ext
Domain Path: /languages
*/


if ( ! function_exists( 'cbr_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */


require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://premium.brickofbinary.com/wp-update-server/?action=get_metadata&slug=custom-blog-ext',
	__FILE__, //Full path to the main plugin file or functions.php.
	'custom-blog-ext'
);

function cbr_load_textdomain() {

	//load_plugin_textdomain( 'custom-blog-ext', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	

}
//add_action( 'init', 'cbr_load_textdomain' );



function cbr_initialize_extension() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/CustomBlogExt.php';
}
add_action( 'divi_extensions_init', 'cbr_initialize_extension' );
endif;

