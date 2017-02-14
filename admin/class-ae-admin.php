<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Ajency_Events_Admin {

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/eventcodes-admin.css', array(), $this->version, 'all' );
/*        wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');*/
        wp_enqueue_style('jquery-datetimepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css');

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script('jquery');
/*        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');*/
        wp_enqueue_script('jquery-datetimepicker' ,  'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js');
        /*wp_enqueue_script('gmaps' , 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize');*/
        wp_enqueue_script('gplaces' , "http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places");
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/eventcodes-admin.js', array( 'jquery' ), $this->version, false );

        /* add_action('wp_footer','add_datepicker_in_footer',10);*/


	}

/*    function add_datepicker_in_footer()
    {

        return
            "<script type='text/javascript'>
        jQuery(document).ready(function(){
            jQuery('#date').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>";
    }*/

}
