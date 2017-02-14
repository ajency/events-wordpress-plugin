<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
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
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Ajency_Events {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
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

    protected static $instance = null;


    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }


    protected $custom_post_type_name;

    public function __construct() {

		$this->plugin_name = 'eventcodes';
		$this->version = '1.0.0';
		$this->custom_post_type_name = 'eventcode';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();


        $this->load_dashboard();
        $this->load_shortcodes();
        $this->register_custom_post_types();
        $this->load_templates();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ae-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ae-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ae-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-eventcodes-public.php';

        /**
         *
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/class-ae-render-template.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/custom_post_types/class-ae-custom-post-types.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/custom_post_types/class-ae-custom-post-types-columns.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/custom_post_types/class-ae-event-fields.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/custom_post_types/class-ae-event-loc-object-fields.php';


        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/shortcodes/class-ae-shortcodes.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/dashboard/class-ae-dashboard-config.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Ajency/templates/class-ae-templates.php';

		$this->loader = new Ajency_Events_Loader();

	}

  	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ajency_Events_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ajency_Events_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ajency_Events_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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


    public function get_custom_post_type_name(){
        return $this->custom_post_type_name;
    }

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
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

    public function load_shortcodes() {

        $ae_shortcodes = new Ajency_Events_Shortcodes();
        $this->loader->add_action( 'init', $ae_shortcodes, 'load_shortcodes' );
    }

    public function register_custom_post_types() {

        $ae_custom_post_types = new Ajency_Events_Custom_Post_Types();
        $ae_custom_post_types_cols = new Ajency_Events_Custom_Post_Types_Columns();
        $this->loader->add_action( 'init', $ae_custom_post_types, 'ae_register_custom_post_events' );
        $this->loader->add_action( 'add_meta_boxes', $ae_custom_post_types, 'ae_register_metaboxes' );


        $this->loader->add_action( 'save_post', $ae_custom_post_types, 'ae_save_events_meta', 1, 2);
        $this->loader->add_action( 'admin_notices', $ae_custom_post_types, 'ae_register_admin_notices', 1, 2);

        $this->loader->add_action( 'manage_eventcode_posts_columns', $ae_custom_post_types_cols, 'ae_columns_head');
        $this->loader->add_filter( 'manage_eventcode_posts_custom_column', $ae_custom_post_types_cols, 'ae_columns_content', 10, 2);

        /*$this->loader->add_filter( 'manage_ae_posts_columns', $ae_custom_post_types_cols, 'ST4_columns_content', 10, 2);
        */

    }

    private function load_templates() {

        $ae_templates = new Ajency_Events_Templates();
        $this->loader->add_filter( 'single_template', $ae_templates, 'events_single_template' );
        $this->loader->add_filter( 'archive_template', $ae_templates, 'events_archive_template' );
    }

    private function load_dashboard() {

        $ae_config = new Ajency_Events_Dashboard_Settings();
        $this->loader->add_action( 'admin_menu', $ae_config, 'load_dashboard_config_menu' );
    }
}
