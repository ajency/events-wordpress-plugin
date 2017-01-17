<?php

class Ajency_Events_Custom_Post_Types {

    public function register_custom_post_events() {

		$labels = array(
			'name'                => _x( 'Events', 'Events', 'ajency-event' ),
			'singular_name'       => _x( 'Event', 'Event', 'ajency-event' ),
			'menu_name'           => __( 'Events', 'ajency-event' ),
			'parent_item_colon'   => __( 'Parent Event', 'ajency-event' ),
			'all_items'           => __( 'All Events', 'ajency-event' ),
			'view_item'           => __( 'View Event', 'ajency-event' ),
			'add_new_item'        => __( 'Add New Event', 'ajency-event' ),
			'add_new'             => __( 'Add New', 'ajency-event' ),
			'edit_item'           => __( 'Edit Event', 'ajency-event' ),
			'update_item'         => __( 'Update Event', 'ajency-event' ),
			'search_items'        => __( 'Search Event', 'ajency-event' ),
			'not_found'           => __( 'Not Found', 'ajency-event' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'ajency-event' ),
			);

		$args = array(
			'label'               => __( 'event', 'ajency-event' ),
			'description'         => __( 'Event news and reviews', 'ajency-event' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', ), 
			'taxonomies'          => array( 'tags' ),
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

		register_post_type( 'ajency_event', $args );
	}

    function register_events_datetime_meta () {
        add_meta_box('events_datetime_meta', 'Event Date and Time', 'events_datetime_meta', 'ajency-event');
    }

    function events_datetime_meta () {
        global $post;
        $custom = get_post_custom($post->ID);
        $meta_sd = $custom["ajency_events_startdate"][0];
        $meta_ed = $custom["ajency_events_enddate"][0];
        $meta_st = $meta_sd;
        $meta_et = $meta_ed;

        $date_format = get_option('date_format'); // Not required in my code
        $time_format = get_option('time_format');

        if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

        $clean_sd = date("D, M d, Y", $meta_sd);
        $clean_ed = date("D, M d, Y", $meta_ed);
        $clean_st = date($time_format, $meta_st);
        $clean_et = date($time_format, $meta_et);

        echo '<input type="hidden" name="ajency-events-nonce" id="ajency-events-nonce" value="' .
            wp_create_nonce( 'ajency-events-nonce' ) . '" />';

        ?>
        <div class="ajency-events-datetime-meta">
            <ul>
                <li><label>Start Date</label><input name="ajency_events_startdate" class="ajency-date" value="<?php echo $clean_sd; ?>" /></li>
                <li><label>Start Time</label><input name="ajency_events_starttime" value="<?php echo $clean_st; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
                <li><label>End Date</label><input name="ajency_events_enddate" class="ajency-date" value="<?php echo $clean_ed; ?>" /></li>
                <li><label>End Time</label><input name="ajency_events_endtime" value="<?php echo $clean_et; ?>" /><em>Use 24h format (7pm = 19:00)</em></li>
            </ul>
        </div>
        <?php
    }
}
