<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://kaiserrobin.eu
 * @since             1.0.0
 * @package           Bugsnatcher
 *
 * @wordpress-plugin
 * Plugin Name:       BugSnatcher
 * Plugin URI:        http://wpcr.kaiser-code.eu/info/plugin/bugsnatcher
 * Description:       Catches errors and uncaught exceptions, fails silently and messages you instead.
 * Version:           1.0.0
 * Author:            Robin Kaiser
 * Author URI:        http://kaiserrobin.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bugsnatcher
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Determine plugin data from head comment
 */
$plugin_data = get_file_data( __FILE__, array(
	'version' => 'Version',
	'slug' => 'Text Domain',
	'name' => 'Plugin Name',
), 'plugin' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bugsnatcher-activator.php
 */
function activate_bugsnatcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bugsnatcher-activator.php';
	Bugsnatcher_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bugsnatcher-deactivator.php
 */
function deactivate_bugsnatcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bugsnatcher-deactivator.php';
	Bugsnatcher_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bugsnatcher' );
register_deactivation_hook( __FILE__, 'deactivate_bugsnatcher' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bugsnatcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 *
 * @param $plugin_data
 */
function run_bugsnatcher( $plugin_data ) {
	$plugin = new Bugsnatcher( $plugin_data );
	$plugin->run();
}
run_bugsnatcher( $plugin_data );
