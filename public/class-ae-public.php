<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Ajency_Events_Public extends Ajency_Events_Base {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/styles.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ajency_events-public.js', array( 'jquery' ), $this->version, false );

	}

    public function events_single_template($single_template) {
        global $wp_query, $post;
        if ($post->post_type == $this->custom_post_type_name){
            $single_template = $this->load_template_location('single');
        }
        return $single_template;
    }

    public function events_archive_template($archive_template) {
        global $wp_query, $post;

        if ( is_post_type_archive($this->custom_post_type_name) )
            $archive_template = $this->load_template_location('archive');
        return $archive_template;
    }

    public function load_template_location($template) {
        $template = $template.'.php';
        if(file_exists(get_stylesheet_directory() . '/events/' . $template)) {
            $template = get_stylesheet_directory() . '/events/' . $template;
        } else {
            $template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/'.$template;
        }

        return $template;
    }

    function excerpt_read_more_link($output) {
        global $post;
        if ($post->post_type != $this->custom_post_type_name)
        {
            $output .= '<p><a href="'. get_permalink($post->ID) . '">read more</a></p>';
        }
        return $output;
    }
}
