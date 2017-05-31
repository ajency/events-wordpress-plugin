<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://wpdwarves.com
 * @since      1.0.0
 *
 * @package    Event_Codes
 * @subpackage Event_Codes/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Event_Codes
 * @subpackage Event_Codes/includes
 * @author     Ajency.in <wp@ajency.in>
 */
class Event_Codes {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Event_Codes_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'event-codes';
		$this->version = '0.5';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Event_Codes_Loader. Orchestrates the hooks of the plugin.
	 * - Event_Codes_i18n. Defines internationalization functionality.
	 * - Event_Codes_Admin. Defines all hooks for the admin area.
	 * - Event_Codes_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-codes-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-codes-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-event-codes-common.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-event-codes-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-event-codes-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'events/class-event-codes-shortcode.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'events/class-event-codes-shortcode-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'events/class-event-codes-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'events/class-event-codes-event.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'events/class-event-codes-events.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/class-event-codes-datasources.php';

		$this->loader = new Event_Codes_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Event_Codes_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Event_Codes_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {

		$plugin_admin = new Event_Codes_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'check_datasources_admin_message' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_submenu_for_shortcodes', 99999999999999999999999999999 );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_init' );


		$plugin_public = new Event_Codes_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$event_shortcodes = new Event_Codes_Shortcode( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $event_shortcodes, 'load_shortcodes' );

		$event_api = new Event_Codes_API( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'rest_authentication_errors', $event_api, 'event_codes_api_auth' );
		$this->loader->add_action( 'rest_api_init', $event_api, 'event_codes_api' );


#		if(!function_exists('rest_url')) {
			//Additional admin-ajax actions for depricated versions
		//TODO
			$this->loader->add_action( 'wp_ajax_dummy_data', $event_api, 'dummy_data' );
#		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Event_Codes_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
