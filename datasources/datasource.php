<?php

class Event_Codes_Datasource {

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
    public function renderShortcodeMarkupAndData($atts, $render = true) {

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
            if ($event_data['count']) {

                if($render) {

                    //We need a unique id if multiple shortcodes are placed on a page, used for load more ajax functionality
                    $shortcode_id = uniqid();
                    include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view.php';
                } else {
                    return $event_data;
                }

            } else {
                include plugin_dir_path(dirname(__FILE__)) . '/events/views/not-available.php';
            }
        } else {
            include plugin_dir_path(dirname(__FILE__)) . '/events/views/not-available.php';
        }
    }

    public function renderLoadMoreEventsMarkupAndData($event_data,$atts) {
        foreach ($event_data['events'] as $event) {
            include plugin_dir_path(dirname(__FILE__)) . '/events/views/' . $atts['template'] . '/' . $atts['view'] . '-view-item.php';
        }
    }

}
