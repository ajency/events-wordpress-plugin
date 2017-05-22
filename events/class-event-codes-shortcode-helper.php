<?php

/*
 * Class should not be modified
 * If modified need to check across all datasources
 */
class Event_Codes_Shortcode_Helper {

    /**
     * @param $atts
     * Function to render shortcode, will inlude html
     * Seperate function made to isolate data from UI
     */
    public function render_shortcode_markup_and_data($atts, $load_more_api = false)
    {

        //TODO - Handle multiple datasource config
        $active_ds = Event_Codes_Datasources::get_active_datasource();
        //TODO - Switch to handle multiple datasources, let all the messy logic be in this file and function
        $check = Event_Codes_Datasources::check_if_active_and_version_supported($active_ds);

        //Do we support this version and plugin?
        if ($check['is_support']) {
            $this->_load_dependencies($check['code_name']);

            $ds_class = $this->_ds_class_name($check['code_name']);
            $ds = new $ds_class;

            //based on shortcode attributes consturct the WP_Query args
            $args = $ds->construct_query_arguments($atts);

            //Send Args to ds function which feteches data and returns our own Events object format
            $event_data = $ds->event_data_transformation($args, $atts);

            //If the query did fetch events
            if ($event_data === false) {
                return false; //unsupported
            } else if ($event_data->count > 0) {

                if ($load_more_api == false) {

                    //We need a unique id if multiple shortcodes are placed on a page, used for load more ajax functionality
                    $shortcode_id = uniqid();
                    include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view.php';
                } else {

                    //In case of API we cannot just echo our content
                    //We need to save content to a variable along with other data and show it in the UI for load more
                    $load_more_api_data['markup'] = $this->return_load_more_events_markup_and_data($event_data, $atts);
                    $load_more_api_data['atts'] = $atts;
                    $load_more_api_data['results_count'] = $event_data->count;
                    return $load_more_api_data;
                }

            } else {
                include plugin_dir_path(dirname(__FILE__)) . '/events/views/not-available.php';

            }
        }
        return false; //unsupported
    }

    public function return_load_more_events_markup_and_data($event_data,$atts) {
        ob_start();
        foreach ($event_data->events as $event) {
            include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view-item.php';
        }
        return ob_get_clean();
    }

    public function _load_dependencies($code_name){
        //Bring out the datasource
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/class-event-codes-datasource.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'datasources/sources/class-event-codes-datasource-' . $code_name.'.php';
    }

    public function _ds_class_name($code_name) {
        return 'Event_Codes_Datasource_'.ucfirst($code_name);
    }

}
