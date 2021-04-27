<?php
/*
Plugin Name: Custom Blog Ext
Plugin URI:  
Description: 
Version:     4.0.3
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


/**
 * Included Classes
 */
require_once plugin_dir_path( __FILE__ ) .  'includes/AdditionalFunction.php';


function cbr_initialize_extension() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/CustomBlogExt.php';
}
add_action( 'divi_extensions_init', 'cbr_initialize_extension' );
endif;

