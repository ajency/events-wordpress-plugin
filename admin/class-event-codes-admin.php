<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpdwarves.com
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

	/**
	 * Check if plugin Events Calender Exists and throw markup asking user to install the plugin
	 *
	 * @since    1.0.0
	 */
	public function check_datasources_admin_message() {

		//TODO provision for multipe data sources
		$active_ds = Event_Codes_Datasources::get_active_datasource();
		$check = Event_Codes_Datasources::check_if_active_and_version_supported($active_ds);
		if(!$check['is_support']) {
			$url = $check['data']['install_url'];
			$title = $check['data']['plugin_name'];
			$version = $check['data']['version'];
			$version_url = 'https://downloads.wordpress.org/plugin/the-events-calendar.'.$version.'.zip';
			$plugin_page_url = '#';
			echo '<div class="error"><p>' . sprintf( esc_html( __( 'To begin using Event Codes, please install version %s'.$version.'%s of %sThe Events Calendar%s. To know about previous versions supported by us visit our %splugin page%s.', 'event-codes' ) ), '<a target="_blank" href="' . esc_url( $version_url ) . '" title="' . esc_attr( $title.' '.$version ) . '">', '</a>' , '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . esc_attr( $title ) . '">', '</a>', '<a href="' . esc_url( $plugin_page_url ) . '" title="' . esc_attr( 'Event Codes' ) . '">', '</a>' ) . '</p></div>';
		}
		#<a href=https://downloads.wordpress.org/plugin/the-events-calendar.'.$check['data']['version'].'.zip>'. $check['data']['version'] .'</a>
	}

	public function add_submenu_for_shortcodes() {

		//TODO provision for multipe data sources
		$active_ds = Event_Codes_Datasources::get_active_datasource();;
		$check = Event_Codes_Datasources::check_if_active_and_version_supported($active_ds);

		if($check['is_support']) {

		add_submenu_page(
			'edit.php?post_type=tribe_events',
			__('Event Codes','event-codes'),
			__('Event Codes','event-codes'),
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


			<h2>
			<?php echo sprintf( esc_html( __('Event Codes - Shortcodes that work with other event plugins.','event-codes'))); ?>
			</h2>
			<!--			--><?php /*settings_errors(); */?>


			<?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'about';
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?post_type=tribe_events&page=event-codes&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>"><?php echo sprintf( esc_html( __('Event Codes','event-codes'))); ?></a>
				<a href="?post_type=tribe_events&page=event-codes&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php echo sprintf( esc_html( __('Settings','event-codes'))); ?></a>
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
		add_settings_section("event_codes_section", sprintf( esc_html( __("This section gives you quick access to settings that will help you get a better plugin experience.",'event-codes'))), null, "event_codes_settings");
		add_settings_field("event_codes_settings", sprintf( esc_html( __('Enable Bootstrap','event-codes'))), array($this,"template_select_checkbox_display"), "event_codes_settings", "event_codes_section");
		register_setting("event_codes_section", "event_codes_settings");
	}

	function template_select_checkbox_display()
	{
		$options =  get_option('event_codes_settings');
		if(empty($options)){
			$options = [];
			$options['template'] = 0;
		}
		?>
		<input type="checkbox" name="event_codes_settings[template]" value="1" <?php checked(1, $options['template'], true); ?>>
					<?php echo sprintf( esc_html( __('Check this option if your theme supports Bootstrap 3.0'))); ?>
		</input>
		<?php
	}

}
