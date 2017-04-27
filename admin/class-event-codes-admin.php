<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ajency.in
 * @since      1.0.0
 *
 * @package    Event_Codes
 * @subpackage Event_Codes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Event_Codes
 * @subpackage Event_Codes/admin
 * @author     Ajency.in <wp@ajency.in>
 */
class Event_Codes_Admin {

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
		 * defined in Event_Codes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Codes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/event-codes-admin.css', array(), $this->version, 'all' );

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
		 * defined in Event_Codes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Event_Codes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/event-codes-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function allowed_datasources() {

		return [
			'the-events-calendar/the-events-calendar.php' => [
				'versions' => ['4.4.4' , '4.4.3'],
				'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true',
				'plugin_name' => 'The Events Calendar',
			]
		];
	}

		/**
	 * Check if plugin Events Calender Exists and throw markup asking user to install the plugin
	 *
	 * @since    1.0.0
	 */
	public function check_datasources($module) {

		$return = [];
		$return['success'] = false;
		$allowed_sources = $this->allowed_datasources();
		$enabling_array = $allowed_sources[$module];
		$module_path =  WP_PLUGIN_DIR.'/'.$module;
		//We check if the module is in the plugins folder
		if(file_exists($module_path)) {
			//If so, we then check if its active and is of one of our tested versions
			$plugin_data = get_plugin_data($module_path, false, false );
			if (is_plugin_active( $module ) AND in_array($plugin_data['Version'],$enabling_array['versions']))
			{
				$return['success'] = true;
			}
		}
		$return['data'] = $enabling_array;
		return $return;
	}

	/**
	 * Check if plugin Events Calender Exists and throw markup asking user to install the plugin
	 *
	 * @since    1.0.0
	 */
	public function check_datasources_admin_message() {

		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$enabling = $this->check_datasources($enabling_for);
		if (!$enabling['success'])
		{
			$url = $enabling['data']['install_url'];
			$title = __($enabling['data']['plugin_name'], 'event_codes');
			echo '<div class="error"><p>' . sprintf(__('To begin using Event Codes, please install <a href="%s" class="thickbox" title="%s">The Events Calendar</a>. We support versions '.implode(', ',$enabling['data']['versions']), 'event_codes'), esc_url($url), $title) . '</p></div>';
		}
	}

	public function add_submenu_for_shortcodes() {

		$enabling_for = $this->check_datasources('the-events-calendar/the-events-calendar.php');
		if($enabling_for['success']) {

		add_submenu_page(
			'edit.php?post_type=tribe_events',
			'Event Codes',
			'Event Codes',
			'manage_options',
			'event-codes',
			array($this,'theme_tabs')
		);
		add_action( 'admin_print_styles', array( $this, 'enqueue_submenu_styles' ) );
		}

	}

	public function enqueue_submenu_styles() {
		wp_enqueue_style( 'event-codes-submenu', plugin_dir_url( __FILE__ ) . 'css/event-codes-submenu.css' );
	}

	function theme_tabs() {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<div id="icon-themes" class="icon32"></div>
			<h2>Event Codes Theme Options</h2>
			<!--			--><?php /*settings_errors(); */?>


			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'about';
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?post_type=tribe_events&page=event-codes&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">Event Codes</a>
				<a href="?post_type=tribe_events&page=event-codes&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
			</h2>


			<form action='options.php' method='post'>
				<?php

				if( $active_tab == 'about' ) {

					include dirname( __FILE__ ) . '/partials/info-page.php';

				} else if( $active_tab == 'settings' ) {
					settings_fields( 'event_codes_section' );
					do_settings_sections( 'event_codes_settings' );
					submit_button();
				} // end if/else
				?>
			</form>

		</div><!-- /.wrap -->
		<?php
	} //

	function settings_init(  ) {
		add_settings_section("event_codes_section", "Section", null, "event_codes_settings");
		add_settings_field("event_codes_settings", "Enable Bootstrap", array($this,"template_select_checkbox_display"), "event_codes_settings", "event_codes_section");
		register_setting("event_codes_section", "event_codes_settings");
	}

	function template_select_checkbox_display()
	{
		$options =  get_option('event_codes_settings');
		?>
		<input type="checkbox" name="event_codes_settings[template]" value="1" <?php checked(1, $options['template'], true); ?>>
					Check this option if your theme supports Bootstrap 3.0
		</input>
		<?php
	}


	function settings_section_callback(  ) {
		echo __( 'This section description', 'event_codes' );
	}

}
