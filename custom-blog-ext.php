<?php
/*
Plugin Name: Custom Blog Ext
Plugin URI:  
Description: 
Version:     2.0.0
Author:      Antonis Ntoumanis
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cbr-custom-blog-ext
Domain Path: /languages

Custom Blog Ext is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Custom Blog Ext is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Custom Blog Ext. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
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

function cbr_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/CustomBlogExt.php';
}
add_action( 'divi_extensions_init', 'cbr_initialize_extension' );
endif;

