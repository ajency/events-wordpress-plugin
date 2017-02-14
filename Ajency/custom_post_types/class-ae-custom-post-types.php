<?php

class Ajency_Events_Custom_Post_Types {

    public function ae_register_custom_post_events() {

        $ae = Ajency_Events::getInstance();

        $labels = array(
            'name'                => _x( 'Events', 'Events', $ae->get_plugin_name() ),
            'singular_name'       => _x( 'Event', 'Event', $ae->get_plugin_name() ),
            'menu_name'           => __( 'Events', $ae->get_plugin_name() ),
            'parent_item_colon'   => __( 'Parent Event', $ae->get_plugin_name() ),
            'all_items'           => __( 'All Events', $ae->get_plugin_name() ),
            'view_item'           => __( 'View Event', $ae->get_plugin_name() ),
            'add_new_item'        => __( 'Add New Event', $ae->get_plugin_name() ),
            'add_new'             => __( 'Add New', $ae->get_plugin_name() ),
            'edit_item'           => __( 'Edit Event', $ae->get_plugin_name() ),
            'update_item'         => __( 'Update Event', $ae->get_plugin_name() ),
            'search_items'        => __( 'Search Event', $ae->get_plugin_name() ),
            'not_found'           => __( 'Not Found', $ae->get_plugin_name() ),
            'not_found_in_trash'  => __( 'Not found in Trash', $ae->get_plugin_name() ),
        );

        $args = array (
            'label'               => __( 'event', $ae->get_plugin_name() ),
            'description'         => __( 'Event news and reviews', $ae->get_plugin_name() ),
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

        $ae = $ae->getInstance();
        register_post_type( $ae->get_custom_post_type_name(), $args );
        /*        add_action( 'save_post', 'wpdocs_save_meta_box' );*/

    }

    function ae_register_metaboxes() {
        $ae = Ajency_Events::getInstance();
        add_meta_box( 'ae_register_metabox_dates', 'Event Duration', array( &$this,'ae_register_metabox_dates'), $ae->get_custom_post_type_name(), 'side', 'default', array( 'id' => '_start') );
        add_meta_box( 'ae_register_metabox_location', 'Event Location', array( &$this,'ae_register_metabox_location'), $ae->get_custom_post_type_name(), 'side', 'default', array('id'=>'_end') );
        add_meta_box( 'ae_register_metabox_featured_event', 'Event Featured', array( &$this,'ae_register_metabox_featured_event'), $ae->get_custom_post_type_name(), 'side', 'default', array('id'=>'_3132') );
        add_meta_box( 'ae_register_metabox_display_address', 'Display Address', array( &$this,'ae_register_metabox_display_address'), $ae->get_custom_post_type_name(), 'side', 'default', array('id'=>'_3132') );
    }

    function ae_register_admin_notices() {

        $ae = Ajency_Events::getInstance();
        //TODO add messages to string error msgs
        // If there are no errors, then we'll exit the function
        if ( ! ( $errors = get_transient( 'ae_errors' ) ) ) {
            return;
        }
        // Otherwise, build the list of errors that exist in the settings errores
        $message = '<div id="acme-message" class="error below-h2"><p><ul>';
        foreach ( $errors as $error ) {
            $message .= '<li>' . __($error['message'],$ae->get_custom_post_type_name()) . '</li>';
        }
        $message .= '</ul></p></div><!-- #error -->';
        // Write them out to the screen
        echo $message;
        // Clear and the transient and unhook any other notices so we don't see duplicate messages
        delete_transient( 'ae_errors' );
        remove_action( 'admin_notices', 'ae_register_admin_notices' );
    }


    function ae_register_metabox_featured_event($post, $args) {

        global $post;

        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );

        $event_featured = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::FEATURED, true );

        echo '<label for="_event_featured">Feature This Event : </label>';

        $checked = isset($event_featured) && $event_featured == 1 ? 'checked' : 0;

        echo '<input type="checkbox" name="_event_featured" value="1" '.$checked.' />';

    }


    function ae_register_metabox_display_address($post, $args) {
        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );
        $event_loc_edited = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LOCATION_EDITED, true );
        echo '<textarea rows="4" id="_event_loc_edited" name="_event_loc_edited">'.$event_loc_edited.'</textarea>';

    }


    function ae_register_metabox_dates($post, $args) {

        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );

        $event_startdate = get_post_meta( $post->ID, '_event_startdate', true );
        $event_enddate = get_post_meta( $post->ID, '_event_enddate', true );

        echo '<label for="_event_startdate">Start Date Time : </label>';
        echo '<input id="_event_startdate" name="_event_startdate" value="'.$event_startdate.'" />';

        echo '<br><label for="_event_enddate">End Date Time : </label>';
        echo '<input id="_event_enddate" name="_event_enddate" value="'.$event_enddate.'" />';

    }


    function ae_register_metabox_location() {

        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );


        $event_loc_obj = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LOCATION_OBJECT, true );

        $event_loc  = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LOCATION, true );

        $event_loc_cordinates[Ajency_Events_Custom_Fields::LAT]  = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LAT, true );
        $event_loc_cordinates[Ajency_Events_Custom_Fields::LNG] = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LNG, true );
        $event_loc_cordinates[Ajency_Events_Custom_Fields::LAT_EDITED] = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LAT_EDITED, true );
        $event_loc_cordinates[Ajency_Events_Custom_Fields::LNG_EDITED] = get_post_meta( $post->ID, Ajency_Events_Custom_Fields::LNG_EDITED, true );


        echo '<label for="event_location">Location Search : </label>';

        echo '<input width="100%" type="text" id="_event_loc" name="_event_loc" value="' . $event_loc  . '" />';

        $event_loc_fields = Ajency_Events_Location_Object_Fields::getConstants();
        foreach ($event_loc_fields as $field) {
            echo '<input class="field" name="_event_loc_obj['.$field.']"  id="_event_loc_obj['.$field.']" hidden="true" value='.$event_loc_obj[$field].'></input>';
        }


        $event_loc_fields = Ajency_Events_Custom_Fields::getHiddenConstants();
        foreach ($event_loc_fields as $field) {
            echo '<input class="field" name="'.$field.'"  id="'.$field.'" hidden="true" value='.$event_loc_cordinates[$field].'></input>';
        }
        echo '<div id="map" style="width: 100%; height: 300px;"></div>';
    }



    function ae_display_error($id,$message){
        add_settings_error(
            $id,
            $id,
            __($message,'eventcodes'),
            'error'
        );
        set_transient( 'ae_errors', get_settings_errors(), 30 );
    }

    function ae_meta_box_input_valid($post){

        $valid = false;
        if(self::ae_validate_meta_box_dates_input($post['_event_startdate'],$post['_event_enddate']))
        {
            $valid = true;
        }
        return $valid;
    }

    function ae_validate_meta_box_required_fields($required_fields,$post_object){

    }

    function ae_validate_meta_box_dates_input($startdate,$enddate){

        if(empty($startdate)){
            //TODO move out in a lang file
            self::ae_display_error('start-greater-end','Your event requires a startdate');
            return false;
        }

        if(!empty($enddate) && (strtotime($startdate) >= strtotime($enddate)))
        {
            //TODO move out in a lang file
            self::ae_display_error('start-greater-end','Your event cannot start after it ends');
            return false;
        }

        return true;

    }

    function ae_save_events_meta( $post_id, $post ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;
        if ( !isset( $_POST['ae_nonce'] ) )
            return;
        if ( !wp_verify_nonce( $_POST['ae_nonce'], plugin_basename( __FILE__ ) ) )
            return;
        // Is the user allowed to edit the post or page?
        if ( !current_user_can( 'edit_post', $post->ID ) )
            return;

        //Save only if all validation rules pass
        if(self::ae_meta_box_input_valid($_POST))
        {
            $metabox_ids = Ajency_Events_Custom_Fields::getConstants();

            foreach ($metabox_ids as $key ) {

                $write_meta = false;
                $value = $_POST[$key];

                //Ensures date format
                if(!empty($value) && ($key == Ajency_Events_Custom_Fields::STARTDATE || $key == Ajency_Events_Custom_Fields::ENDDATE)) {
                    $value = date('Y-m-d H:i:s',strtotime($value));
                }

                //Ensures no value keys are removed from location object
                if($key == Ajency_Events_Custom_Fields::LOCATION_OBJECT) {
                    foreach (Ajency_Events_Location_Object_Fields::getConstants() as $field) {

                        if(empty($value[$field]))
                        {
                            unset($value[$field]);
                        }
                    }

                }


                //TODO handle this to remove the meta
                if($key == Ajency_Events_Custom_Fields::FEATURED && empty($value)) {
                    delete_post_meta( $post->ID, $key );
                    $write_meta = false; // handle it with its own unset because of the way checkboxes pass data from HTML
                }

                if (!empty($value)) {
                    $write_meta = true;
                }

                //Write to DB
                if($write_meta){
                    //TODO Write function for multiple
                    if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
                        update_post_meta( $post->ID, $key, $value );
                    } else { // If the custom field doesn't have a value
                        add_post_meta( $post->ID, $key, $value );
                    }
                }
            }

        }
    }

}
