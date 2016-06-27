<?php
/**
 *
 * @link              http://www.communitycommons.org
 * @since             1.0.0
 * @package           CC_Help
 *
 * @wordpress-plugin
 * Plugin Name:       CC Help
 * Description:       Adds support content and contact form.
 * Version:           1.0.0
 * Author:            Michael Barbaro, David Cavins
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cc-help
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Load the main class
 *
 * @since    1.0.0
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-cc-help.php' );

// Start it up.
CC_Help::get_instance();

// Define a constant that we can use to construct file paths throughout the component
function cc_help_base_path() {
	return plugin_dir_url( __FILE__ );
}


function cc_help_get_version() {
	return '1.0.0';
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cc-help-activator.php';

/** This action is documented in includes/class-cc-help-activator.php */
register_activation_hook( __FILE__, array( 'CC_Help_Activator', 'activate' ) );
