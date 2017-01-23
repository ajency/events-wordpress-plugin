<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ajency.in
 * @since             1.0.0
 * @package           Ajency_Events
 *
 * @wordpress-plugin
 * Plugin Name:       Ajency Events
 * Plugin URI:        http://ajency.in/
 * Description:       Event Management With Wordpress.
 * Version:           1.0.0
 * Author:            Ajency.in
 * Author URI:        http://ajency.in/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ajency-events
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_ajency_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajency-events-activator.php';
	Ajency_Events_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_ajency_events() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajency-events-deactivator.php';
	Ajency_Events_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ajency_events' );
register_deactivation_hook( __FILE__, 'deactivate_ajency_events' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ajency-events.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ajency_events() {

	$plugin = new Ajency_Events();
	$plugin->run();

}
run_ajency_events();
