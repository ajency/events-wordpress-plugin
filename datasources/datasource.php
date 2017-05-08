<?php

class Event_Codes_Datasource {

    /**
     * @param $atts
     * @return array
     * Function that returns only data for a given argument set, this is the meat of it all
     */
    public function getEventData($atts) {

        $enabling_for = Event_Codes_Datasources::get_active_datasource();
        $check = Event_Codes_Datasources::check_if_active_and_version_supported($enabling_for);
        if($check['is_support']) {

            //pass all filters to the data source
            //query builder etc should be in the ds folder, only returned data shoud be fecthed here in Event object $event

            $view_allowed_values = ['list', 'tabular'];
            if(!in_array($atts['view'],$view_allowed_values)) {
                $atts['style'] = 'list';
            }

            $style_allowed_values = ['basic', 'shadow'];
            if(!in_array($atts['style'],$style_allowed_values)) {
                $atts['style'] = 'basic';
            }

            /*        'post_status' => 'publish',
                        'hide_upcoming' => true,
                        'posts_per_page' => $atts['limit'],
                        'tax_query'=> $atts['event_tax'],
                        'meta_key' => $atts['key'],
                        'orderby' => 'meta_value',
                        'author' => $atts['author'],
                        'order' => $atts['order'],
                    */

            //these aregs are specific to events calender

            $meta_query = [];
            if($atts['past']) {
                $meta_query['range_query'] = array(
                    'key' => '_EventStartDate', // Check the start date field
                    'value' => current_time( 'Y-m-d H:i:s' ), // Set today's date (note the similar format)
                    'compare' => '<', // Return the ones lesser than today's date
                    'type' => 'DATETIME' // Let WordPress know we're working with date
                );
                $order = 'DESC';
                $event_display = 'past';

            } else {
                $meta_query['range_query'] = array(
                    'key' => '_EventStartDate', // Check the start date field
                    'value' => current_time( 'Y-m-d H:i:s' ), // Set today's date (note the similar format)
                    'compare' => '>=', // Return the ones greater than today's date
                    'type' => 'DATETIME' // Let WordPress know we're working with date
                );
                $order = 'ASC';
                $event_display = 'custom';
            }

            if($atts['featured']) {
                $meta_query['featured_query'] = array(
                    'key' => '_tribe_featured',
                    'value' => 1,
                    'compare' => '=',
                );
            }

            $args = array(
                'post_status' => 'publish',
                'posts_per_page' => $atts['count'],
                'offset' => $atts['offset'],
                'meta_key' => '_EventStartDate',
                'orderby' => 'meta_value',
                'order' => $order,
                'meta_query' => $meta_query,
                'eventDisplay' => $event_display
            );


            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/'.$check['data']['file'];
            $class = $check['data']['class_name'];
            $object = new $class();
            return  $object->eventDataTransformation($args,$atts);
        }
    }

    /**
     * @param $atts
     * Function to render shortcode, will inlude html
     * Seperate function made to isolate data from UI
     */
    public function renderShortcodeMarkupAndData($atts) {
        $event_data = $this->getEventData($atts);
        if($event_data['count'] == 0) {
            echo '<div class="aj__no-events">
                    No events available :(
                   </div>';
        } else {
            $shortcode_id = uniqid();
            /*            set_query_var( 'shortcode_id', uniqid() );
                        set_query_var( 'event_data', $event_data );
                        get_template_part( '/events/views/'.$atts['template'].'/'.$atts['view'], 'view' );*/

            include plugin_dir_path( dirname( __FILE__ ) ) . '/events/views/'.$atts['template'].'/'.$atts['view'].'-view.php';
        }
    }

    /**
     * @param $atts
     * Function to render shortcode, will inlude html
     * Seperate function made to isolate data from UI
     */
    public function renderLoadMoreMarkupAndData($events,$atts) {

        foreach($events as $event)  {
            include plugin_dir_path( dirname( __FILE__ ) ) . '/events/views/'.$atts['template'].'/'.$atts['view'].'-view-item.php';
        }
    }


}
