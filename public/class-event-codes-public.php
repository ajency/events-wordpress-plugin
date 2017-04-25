<?php

class Event_Codes_Public {

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

	public function enqueue_styles() {


		$options =  get_option('event_codes_settings');
		$template = $options['template'] == 1 ? 'bootstrap' : 'normal';
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'style-'.$template.'.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'custom.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(  $this->plugin_name,  'event_codes', array(
				'root' => esc_url_raw( rest_url() ),
				'nonce' => wp_create_nonce( 'wp_rest' ),
				'current_user_id' => get_current_user_id(),
				'homeUrl' => esc_url(home_url())
			)
		);

	}

}
