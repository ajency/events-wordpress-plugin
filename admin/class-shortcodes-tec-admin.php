<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ajency.in
 * @since      1.0.0
 *
 * @package    Shortcodes_Tec
 * @subpackage Shortcodes_Tec/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Shortcodes_Tec
 * @subpackage Shortcodes_Tec/admin
 * @author     Ajency.in <wp@ajency.in>
 */
class Shortcodes_Tec_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shortcodes_Tec_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shortcodes_Tec_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/shortcodes-tec-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Shortcodes_Tec_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Shortcodes_Tec_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/shortcodes-tec-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Check if plugin Events Calender Exists and throw markup asking user to install the plugin
	 *
	 * @since    1.0.0
	 */
	public function check_the_event_calender() {

		if ( ! is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) and current_user_can( 'activate_plugins' ) ) {
			$url = 'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true';
			$title = __('The Events Calendar', 'shortcodes_tec');
			echo '<div class="error"><p>' . sprintf(__('To begin using Shortcodes for The Events Calendar, please install the latest version of <a href="%s" class="thickbox" title="%s">The Events Calendar</a>.', 'shortcodes_tec'), esc_url($url), $title) . '</p></div>';
		}
	}

	public function add_submenu_for_shortcodes() {

		add_submenu_page(
			'edit.php?post_type=tribe_events',
			'Shortcodes',
			'Shortcodes',
			'manage_options',
			'shortcodes-tec',
			array($this,'shortcodes_page_content')
		);
	}

	public function shortcodes_page_content() {
		include dirname( __FILE__ ) . '/partials/info-page.php';
	}

}
