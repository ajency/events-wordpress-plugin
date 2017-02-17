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
class Ajency_Events_Post_Type_Meta_Boxes extends Ajency_Events_Base {


    function ae_register_metaboxes() {
        add_meta_box( 'ae_register_metabox_dates', Ajency_Events_Constants::META_BOX_LABEL_EVENT_DURATION, array( &$this,'ae_register_metabox_dates'), $this->custom_post_type_name, 'side', 'default', array( 'id' => '_start') );
        add_meta_box( 'ae_register_metabox_location', Ajency_Events_Constants::META_BOX_LABEL_EVENT_LOCATION, array( &$this,'ae_register_metabox_location'), $this->custom_post_type_name, 'side', 'default', array('id'=>'_end') );
        add_meta_box( 'ae_register_metabox_featured_event', Ajency_Events_Constants::META_BOX_LABEL_EVENT_FEATURED, array( &$this,'ae_register_metabox_featured_event'), $this->custom_post_type_name, 'side', 'default', array('id'=>'_3132') );
        add_meta_box( 'ae_register_metabox_display_address', Ajency_Events_Constants::META_BOX_LABEL_EVENT_DISPLAY_ADDRESS, array( &$this,'ae_register_metabox_display_address'), $this->custom_post_type_name, 'side', 'default', array('id'=>'_3132') );
    }

    function ae_register_metabox_featured_event($post, $args) {

        global $post;

        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );

        $event_featured = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_FEATURED, true );

        echo '<label for="_event_featured">Feature This Event : </label>';

        $checked = isset($event_featured) && $event_featured == 1 ? 'checked' : 0;

        echo '<input type="checkbox" name="_event_featured" value="1" '.$checked.' />';

    }


    function ae_register_metabox_display_address($post, $args) {
        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );
        $event_loc_edited = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LOCATION_EDITED, true );
        echo 'Copy Map location : <input type="checkbox" id="copy_event_loc" checked />';
        echo '<textarea name="_event_loc_edited" id="_event_loc_edited" rows="5" cols="60" style="width:99%">'.$event_loc_edited.'</textarea>';
        echo '<a id="edit-copy_event_loc">Edit</a>';
    }


    function ae_register_metabox_dates($post, $args) {

        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );

        $event_startdate = get_post_meta( $post->ID, '_event_startdate', true );
        $event_enddate = get_post_meta( $post->ID, '_event_enddate', true );

        if($event_startdate){
            $event_startdate = date(Ajency_Events_Constants::DATE_DISPLAY_FORMAT, strtotime($event_startdate));
        }

        if($event_enddate) {
            $event_enddate = date(Ajency_Events_Constants::DATE_DISPLAY_FORMAT, strtotime($event_enddate));
        }

        echo '<label for="_event_startdate">Start Date Time : </label>';
        echo '<input id="_event_startdate" name="_event_startdate" value="'.$event_startdate.'" />';

        echo '<br><label for="_event_enddate">End Date Time : </label>';
        echo '<input id="_event_enddate" name="_event_enddate" value="'.$event_enddate.'" />';

    }


    function ae_register_metabox_location() {

        global $post;
        wp_nonce_field( plugin_basename( __FILE__ ), 'ae_nonce' );


        $event_loc_obj = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LOCATION_OBJECT, true );

        $event_loc  = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LOCATION, true );

        $event_loc_cordinates[Ajency_Events_Constants::FIELD_LAT]  = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LAT, true );
        $event_loc_cordinates[Ajency_Events_Constants::FIELD_LNG] = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LNG, true );
        $event_loc_cordinates[Ajency_Events_Constants::FIELD_LAT_EDITED] = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LAT_EDITED, true );
        $event_loc_cordinates[Ajency_Events_Constants::FIELD_LNG_EDITED] = get_post_meta( $post->ID, Ajency_Events_Constants::FIELD_LNG_EDITED, true );


        echo '<label for="event_location">Location Search : </label>';

        echo '<input style="width:99%" type="text" id="_event_loc" name="_event_loc" value="' . $event_loc  . '" />';

        $event_loc_fields = Ajency_Events_Location_Object_Fields::getConstants();
        foreach ($event_loc_fields as $field) {
            echo '<input class="field" name="_event_loc_obj['.$field.']"  id="_event_loc_obj['.$field.']" hidden="true" value='.$event_loc_obj[$field].'></input>';
        }


        $event_loc_fields = Ajency_Events_Constants::getHiddenConstants();
        foreach ($event_loc_fields as $field) {
            echo '<input class="field" name="'.$field.'"  id="'.$field.'" hidden="true" value='.$event_loc_cordinates[$field].'></input>';
        }
        echo '<div id="map" style="width: 100%; height: 300px;"></div>';
    }

    function ae_validate_meta_box_startdate_input($startdate,$enddate){

        if(empty($startdate)){
            //TODO move out in a lang file
            self::ae_display_error('start-date-missing','Your event requires a startdate');
            return false;
        }

        if(!empty($enddate) && (strtotime($startdate) >= strtotime($enddate)))
        {
            //TODO move out in a lang file
            self::ae_display_error('end-date-greater','Your event cannot start after it ends');
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

        $metabox_ids = Ajency_Events_Constants::getConstants();

        foreach ($metabox_ids as $key ) {

            $value = $_POST[$key];

            switch ($key) {
                case Ajency_Events_Constants::FIELD_STARTDATE:

                    if(self::ae_validate_meta_box_startdate_input($_POST[Ajency_Events_Constants::FIELD_STARTDATE],$_POST[Ajency_Events_Constants::FIELD_ENDDATE]))
                    {
                        $value = date(Ajency_Events_Constants::DATE_SAVE_FORMAT, strtotime($value));
                    } else {
                        $value = false;
                    }


                    break;
                case Ajency_Events_Constants::FIELD_ENDDATE:


                    /*print "<pre>";
                    print_r($_POST);*/

                    if(self::ae_validate_meta_box_startdate_input($_POST[Ajency_Events_Constants::FIELD_STARTDATE],$_POST[Ajency_Events_Constants::FIELD_ENDDATE]) && !empty($value))
                    {
                        $value = date(Ajency_Events_Constants::DATE_SAVE_FORMAT, strtotime($value));
                    } else {
                        $value = false;
                    }


                    break;
                case Ajency_Events_Constants::FIELD_LOCATION_OBJECT:

                    foreach (Ajency_Events_Location_Object_Fields::getConstants() as $field) {

                        if(empty($value[$field]))
                        {
                            unset($value[$field]);
                        }
                    }

                    break;
                case Ajency_Events_Constants::FIELD_FEATURED:

                    if(empty($value)) {
                        $value = false; // handle it with its own unset because of the way checkboxes pass data from HTML
                    }

                    break;

                default:
                    //Let every thing else pass
                    //TODO - Do we want to validate lat long as float?
            }

            //If value is empty or false and value key exists the delete
            $existing_value = get_post_meta( $post->ID, $key, FALSE );
            if(empty($value) && $existing_value){
                delete_post_meta( $post->ID, $key );
            } else if ($existing_value && !empty($value)) {
                update_post_meta( $post->ID, $key, $value );
            } else if(!empty($value)) {
                add_post_meta( $post->ID, $key, $value );
            }
        }


    }

    function ae_register_admin_notices() {

        //TODO add messages to string error msgs
        // If there are no errors, then we'll exit the function
        if ( ! ( $errors = get_transient( 'ae_errors' ) ) ) {
            return;
        }
        // Otherwise, build the list of errors that exist in the settings errores


        $message = '<div id="message" class="error below-h2"><p><ul>';
        $errors = array_column($errors,'message','setting');

        foreach ( $errors as $error ) {
            $message .= '<li>' . __($error,$this->custom_post_type_name) . '</li>';
        }
        $message .= '</ul></p></div><!-- #error -->';
        // Write them out to the screen
        echo $message;
        // Clear and the transient and unhook any other notices so we don't see duplicate messages
        delete_transient( 'ae_errors' );
        remove_action( 'admin_notices', 'ae_register_admin_notices' );
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


}
