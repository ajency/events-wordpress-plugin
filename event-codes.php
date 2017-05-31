<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wpdwarves.com
 * @package           Event_Codes
 *
 * @wordpress-plugin
 * Plugin Name:       Event Codes - Shortcodes that work with other event plugins
 * Plugin URI:        http://wpdwarves.com/event-codes-shortcodes-that-work-with-other-event-plugins
 * Description:       List your events anywhere by adding shortcodes to The Events Calendar Plugin (Free Version) by Modern Tribe.
 * Version:           0.5
 * Author:            WPdwarves
 * Author URI:        http://wpdwarves.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       event-codes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'EVENT_CODES_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-event-codes-activator.php
 */
function activate_event_codes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-codes-activator.php';
	Event_Codes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-event-codes-deactivator.php
 */
function deactivate_event_codes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event-codes-deactivator.php';
	Event_Codes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_event_codes' );
register_deactivation_hook( __FILE__, 'deactivate_event_codes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event-codes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_event_codes() {
	$plugin = new Event_Codes();
	$plugin->run();
}
run_event_codes();
