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
class Ajency_Events_Post_Type_Columns extends Ajency_Events_Base {


    // ADD NEW COLUMN
    function ae_columns_head($columns) {

        unset(
            $columns['author'],
            $columns['comments'],
            $columns['date']
        );
        $new_columns = array(
            'featured_image' => __('Featured Image', $this->plugin_name),
            'event_startdate' => __('Enddate', $this->plugin_name),
            'event_enddate' => __('Startdate', $this->plugin_name),
            'location' => __('Location', $this->plugin_name),
            'event_featured' => __('Featured', $this->plugin_name),
        );
        return array_merge($columns, $new_columns);
    }

    // SHOW THE FEATURED IMAGE
    function ae_columns_content($column_name, $post_ID) {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/shortcodes/class-ae-shortcodes-query-builder.php';

        $qb = new Ajency_Events_Shortcodes_Query_Builder();
        $meta_values = $qb->get_post_custom_multiple([$post_ID],[
            Ajency_Events_Constants::FIELD_STARTDATE,
            Ajency_Events_Constants::FIELD_ENDDATE,
            Ajency_Events_Constants::FIELD_LOCATION_EDITED,
            Ajency_Events_Constants::FIELD_LAT_EDITED,
            Ajency_Events_Constants::FIELD_LNG_EDITED,
        ]);

        /*        print "<pre>";
                print_r($meta_values[0]['_event_startdate']);
                die;*/



        if ($column_name == 'featured_image') {

            $post_thumbnail_id = get_post_thumbnail_id($post_ID);
            if ($post_thumbnail_id) {
                $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id);
                $post_featured_image = $post_thumbnail_img[0];
            }

            if ($post_featured_image) {
                // HAS A FEATURED IMAGE
                echo '<img width="50px" height="50px" src="' . $post_featured_image . '" />';
            }
            else {
                // NO FEATURED IMAGE, SHOW THE DEFAULT ONE
                echo '<img src="' . get_bloginfo( 'template_url' ) . '/images/default.jpg" />';
            }
        } else if ($column_name == 'event_startdate') {

            if(isset($meta_values[$post_ID]['_event_startdate'])){
                echo __(date(Ajency_Events_Constants::DATE_DISPLAY_FORMAT,strtotime($meta_values[$post_ID]['_event_startdate'])));
            } else {
                echo "Not Set";
            }

        } else if ($column_name == 'event_enddate') {

            if(isset($meta_values[$post_ID]['_event_enddate'])){
                echo __(date(Ajency_Events_Constants::DATE_DISPLAY_FORMAT,strtotime($meta_values[$post_ID]['_event_enddate'])));
            } else {
                echo "Not Set";
            }

        }  else if ($column_name == 'location') {

            if(isset($meta_values[$post_ID]['_event_loc_edited'])){
                echo __($meta_values[$post_ID]['_event_loc_edited']).' <a target="_blank" href="http://maps.google.com/?q='.$meta_values[$post_ID]['_event_loc_lat_edited'].','.$meta_values[$post_ID]['_event_loc_lng_edited'].'"><br>'.__('View Map').'</a>';
            } else {
                echo "Not Set";
            }

        }  else if ($column_name == 'event_featured') {

            if($meta_values[$post_ID]['_event_featured'] == 1) {
                echo "Yes";
            } else {
                echo "No";
            }

        }/*  else if ($column_name == 'title') {

            echo "<a href=>dfgdgfdfg</a>";
        }*/
    }
}
