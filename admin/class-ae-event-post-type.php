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
            'label'               => __( 'Event', $this->plugin_name ),
            'description'         => __( 'Events', $this->plugin_name ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ),
          /*  'taxonomies'          => array( 'post_tag' ),*/
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
/*            'rewrite' 			  => array('slug' => 'events'),*/
            'capability_type'     => 'page',
        );

        register_post_type( $this->custom_post_type_name, $args );


        // Add new taxonomy, NOT hierarchical (like tags)
        $event_type_labels = array(
            'name'                       => _x( 'Event Types', 'taxonomy general name', 'textdomain' ),
            'singular_name'              => _x( 'Event Type', 'taxonomy singular name', 'textdomain' ),
            'search_items'               => __( 'Search Event Types', 'textdomain' ),
            'popular_items'              => __( 'Popular Event Types', 'textdomain' ),
            'all_items'                  => __( 'All Event Types', 'textdomain' ),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __( 'Edit Event Type', 'textdomain' ),
            'update_item'                => __( 'Update Event Type', 'textdomain' ),
            'add_new_item'               => __( 'Add New Event Type', 'textdomain' ),
            'new_item_name'              => __( 'New Event Type Name', 'textdomain' ),
            'separate_items_with_commas' => __( 'Separate Event Types with commas', 'textdomain' ),
            'add_or_remove_items'        => __( 'Add or remove Event Types', 'textdomain' ),
            'choose_from_most_used'      => __( 'Choose from the most used Event Types', 'textdomain' ),
            'not_found'                  => __( 'No Event Types found.', 'textdomain' ),
            'menu_name'                  => __( 'Event Types', 'textdomain' ),
        );

        $event_type_args = array(
            'hierarchical'          => false,
            'labels'                => $event_type_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'event-types' ),
        );

        register_taxonomy( 'event-types', 'eventcode', $event_type_args );

    }




}
