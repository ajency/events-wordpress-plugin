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
class Ajency_Events_Admin extends Ajency_Events_Base {

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

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

        global $post;

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( $this->custom_post_type_name === $post->post_type ) {
                wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ajency-events-admin.css', array(), $this->version, 'all' );
                wp_enqueue_style('jquery-datetimepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css');
            }
        }

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

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

        global $post;

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( $this->custom_post_type_name === $post->post_type ) {
                wp_enqueue_script('jquery');
                wp_enqueue_script('jquery-datetimepicker' ,  'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js');
                wp_enqueue_script('gplaces' , "http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places");
                wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ajency-events-admin.js', array( 'jquery' ), $this->version, false );
            }
        }

	}




}
