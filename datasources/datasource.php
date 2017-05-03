<?php

class Event_Codes_Datasource {

    /**
     * @param $atts
     * @return array
     * Function that returns only data for a given argument set, this is the meat of it all
     */
    public function getEventData($atts) {



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
        $args = array(
            'post_status' => 'publish',
            'hide_upcoming' => false,
            'posts_per_page' => $atts['count'],
            'offset' => $atts['offset'],
            'meta_key' => '_EventStartDate',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array( // WordPress has all the results, now, return only the events after today's date
                array(
                    'key' => '_EventStartDate', // Check the start date field
                    'value' => date("Y-m-d"), // Set today's date (note the similar format)
                    'compare' => '>=', // Return the ones greater than today's date
                    'type' => 'DATE' // Let WordPress know we're working with date
                )
            ),
            'eventDisplay' => 'list'
        );

        //TODO For now this is almost hardcoded for the events calendar, will need some sort of detection or preference in the future
        //Who do we need to pass args here
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/the-events-calender-4.4/class-event-codes-tec.php';
        $ec44 = new Event_Codes_The_Events_Calender_4_4();
        return  $ec44->eventDataTransformation($args,$atts);
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
                    No events added yet :(
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
