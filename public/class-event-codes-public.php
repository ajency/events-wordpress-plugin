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
		if(empty($options)){
			$options = [];
			$options['template'] = 0;
		}
		$template = $options['template'] == 1 ? 'bootstrap' : 'normal';
		wp_enqueue_style( 'event_codes', plugin_dir_url( __FILE__ ) . 'css/style-'.$template.'.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( 'event_codes', plugin_dir_url( __FILE__ ) . 'custom.js', array( 'jquery' ), $this->version, false );
		$data = $this->construct_local_js_object();
		wp_localize_script( 'event_codes',  'event_codes',$data);
	}

	public function construct_local_js_object() {
		//Added a place holder function incase we need to pass additional data like nonce or home url for future
		$data = Event_Codes_Common::get_wp_api_version();
		$data['api_nonce'] = wp_create_nonce('api_nonce');
		return $data;
	}

}
