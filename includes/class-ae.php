<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ae-base.php';
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
class Ajency_Events extends Ajency_Events_Base {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;


    public function __construct() {

        parent::__construct();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();



        $this->load_templates();
        $this->load_dashboard();
        $this->load_shortcodes();
        $this->register_custom_post_types();
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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ae-public.php';

        /**
         *
         */

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ae-base.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ae-event-post-type.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ae-event-post-type-columns.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ae-event-post-type-meta-boxes.php';


        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-ae-constants.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-ae-event-loc-object-fields.php';


        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/class-ae-shortcode-table.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ae-dashboard-settings.php';

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
     * gets the current post type in the WordPress Admin
     */
    function get_current_post_type() {
        global $post, $typenow, $current_screen;

        //we have a post so we can just get the post type from that
        if ( $post && $post->post_type )
            return $post->post_type;

        //check the global $typenow - set in admin.php
        elseif( $typenow )
            return $typenow;

        //check the global $current_screen object - set in sceen.php
        elseif( $current_screen && $current_screen->post_type )
            return $current_screen->post_type;

        //lastly check the post_type querystring
        elseif( isset( $_REQUEST['post_type'] ) )
            return sanitize_key( $_REQUEST['post_type'] );

        //we do not know the post type!
        return null;
    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

            $plugin_admin = new Ajency_Events_Admin();
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 10,1);
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 10, 1);

    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ajency_Events_Public();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'excerpt_more', $plugin_public, 'excerpt_read_more_link' );

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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

    private function load_shortcodes() {

        $ae_shortcodes = new Ajency_Events_Shortcode_Table();
        $this->loader->add_action( 'init', $ae_shortcodes, 'load_shortcodes' );
    }

    private function register_custom_post_types() {

        $ae_custom_post_types = new Ajency_Events_Post_Type();
        $ae_custom_post_types_cols = new Ajency_Events_Post_Type_Columns();
        $this->loader->add_action( 'init', $ae_custom_post_types, 'ae_register_custom_post_events' );

        $ae_metaboxes = new Ajency_Events_Post_Type_Meta_Boxes();
        $this->loader->add_action( 'add_meta_boxes', $ae_metaboxes, 'ae_register_metaboxes' );
        $this->loader->add_action( 'in_admin_header', $ae_metaboxes, 'ae_rename_metaboxes' ,9999 );


        $this->loader->add_action( 'save_post', $ae_metaboxes, 'ae_save_events_meta', 1, 2);
        $this->loader->add_action( 'admin_notices', $ae_metaboxes, 'ae_register_admin_notices', 1, 2);

        $this->loader->add_action( 'manage_eventcode_posts_columns', $ae_custom_post_types_cols, 'ae_columns_head');
        $this->loader->add_filter( 'manage_eventcode_posts_custom_column', $ae_custom_post_types_cols, 'ae_columns_content', 10, 2);

        /*$this->loader->add_filter( 'manage_ae_posts_columns', $ae_custom_post_types_cols, 'ST4_columns_content', 10, 2);
        */
    }

    private function load_templates() {

        $ae_templates = new Ajency_Events_Public();
        $this->loader->add_filter( 'single_template', $ae_templates, 'events_single_template' );
        $this->loader->add_filter( 'archive_template', $ae_templates, 'events_archive_template' );
    }


/*    function get_custom_post_type_template( $archive_template ) {
        global $post;

        if ( is_post_type_archive ( 'eventcode' ) ) {
            $archive_template = dirname( __FILE__ ) . '/post-type-template.php';
            print $archive_template;
        }
        return $archive_template;
    }*/


    private function load_dashboard() {

        $ae_config = new Ajency_Events_Dashboard_Settings();
        $this->loader->add_action( 'admin_menu', $ae_config, 'load_dashboard_config_menu' );
    }
}
