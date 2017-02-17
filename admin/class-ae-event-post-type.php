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
class Ajency_Events_Post_Type extends Ajency_Events_Base {


    public function ae_register_custom_post_events() {

        $labels = array(
            'name'                => _x( 'Events', 'Events', $this->plugin_name ),
            'singular_name'       => _x( 'Event', 'Event', $this->plugin_name ),
            'menu_name'           => __( 'Events', $this->plugin_name ),
            'parent_item_colon'   => __( 'Parent Event', $this->plugin_name ),
            'all_items'           => __( 'All Events', $this->plugin_name ),
            'view_item'           => __( 'View Event', $this->plugin_name ),
            'add_new_item'        => __( 'Add New Event', $this->plugin_name ),
            'add_new'             => __( 'Add New', $this->plugin_name ),
            'edit_item'           => __( 'Edit Event', $this->plugin_name ),
            'update_item'         => __( 'Update Event', $this->plugin_name ),
            'search_items'        => __( 'Search Event', $this->plugin_name ),
            'not_found'           => __( 'Not Found', $this->plugin_name ),
            'not_found_in_trash'  => __( 'Not found in Trash', $this->plugin_name ),
        );

        $args = array (
            'label'               => __( 'event', $this->plugin_name ),
            'description'         => __( 'Event news and reviews', $this->plugin_name ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
            'taxonomies'          => array( 'post_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-calendar-alt',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'rewrite' 			  => array('slug' => 'events'),
            'capability_type'     => 'page',
        );

        register_post_type( $this->custom_post_type_name, $args );
        /*        add_action( 'save_post', 'wpdocs_save_meta_box' );*/

    }




}
