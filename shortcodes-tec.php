<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ajency.in
 * @since             1.0.0
 * @package           Shortcodes_Tec
 *
 * @wordpress-plugin
 * Plugin Name:       Shortcodes for The Events Calendar
 * Plugin URI:        http://ajency.in/shortcodes-the-events-calendar/
 * Description:       List your events anywhere by adding shortcodes to The Events Calendar Plugin (Free Version) by Modern Tribe..
 * Version:           1.0.0
 * Author:            Ajency.in
 * Author URI:        http://ajency.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shortcodes-tec
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shortcodes-tec-activator.php
 */
function activate_shortcodes_tec() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-tec-activator.php';
	Shortcodes_Tec_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shortcodes-tec-deactivator.php
 */
function deactivate_shortcodes_tec() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-tec-deactivator.php';
	Shortcodes_Tec_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_shortcodes_tec' );
register_deactivation_hook( __FILE__, 'deactivate_shortcodes_tec' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-tec.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shortcodes_tec() {
	$plugin = new Shortcodes_Tec();
	$plugin->run();
}
run_shortcodes_tec();
