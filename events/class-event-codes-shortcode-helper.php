<?php

/*
 * Class should not be modified
 * If modified need to check across all datasources
 */
class Event_Codes_Shortcode_Helper {

    /*
     * We are assuming only one datasource can be used at a time
     * In ver 1 it's the events calender
     */
    private $active_data_source;

    /**
     * @return mixed
     */
    public function getActiveDataSource()
    {
        return $this->active_data_source;
    }

    /**
     * @param mixed $active_data_source
     */
    public function setActiveDataSource($active_data_source)
    {
        $this->active_data_source = $active_data_source;
    }

    /**
     * @param $atts
     * Function to render shortcode, will inlude html
     * Seperate function made to isolate data from UI
     */
    public function renderShortcodeMarkupAndData($atts, $load_more_api = false) {

        //TODO - Handle multiple datasource config
        $enabling_for = Event_Codes_Datasources::get_active_datasource();
        //TODO - Switch to handle multiple datasources, let all the messy logic be in this file and function
        $check = Event_Codes_Datasources::check_if_active_and_version_supported($enabling_for);

        //Do we support this version and plugin?
        if($check['is_support']) {

            //Bring out the datasource
            require_once plugin_dir_path(dirname(__FILE__)) . 'datasources/' . $check['data']['file'];
            $ds_class = $check['data']['class_name'];
            $ds = new $ds_class;

            //based on shortcode attributes consturct the WP_Query args
            $args = $ds->constructQueryArguments($atts);

            //Send Args to ds function which feteches data and returns our own Events object format
            $event_data = $ds->eventDataTransformation($args, $atts);

            //If the query did fetch events
            if ($event_data->count) {

                if($load_more_api == false) {

                    //We need a unique id if multiple shortcodes are placed on a page, used for load more ajax functionality
                    $shortcode_id = uniqid();
                    include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view.php';
                } else {

                    //In case of API we cannot just echo our content
                    //We need to save content to a variable along with other data and show it in the UI for load more
                    $load_more_api_data['markup'] = $this->returnLoadMoreEventsMarkupAndData($event_data,$atts);
                    $load_more_api_data['atts'] = $atts;
                    $load_more_api_data['results_count'] = $event_data->count;
                    return $load_more_api_data;
                }

            } else {
                include plugin_dir_path(dirname(__FILE__)) . '/events/views/not-available.php';
            }
        } else {
            include plugin_dir_path(dirname(__FILE__)) . '/events/views/not-available.php';
        }
    }

    public function returnLoadMoreEventsMarkupAndData($event_data,$atts) {
        ob_start();
        foreach ($event_data->events as $event) {
            include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view-item.php';
        }
        return ob_get_clean();
    }

}
