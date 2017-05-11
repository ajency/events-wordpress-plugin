<?php


class Event_Codes_API
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }


    function event_codes_api()
    {
        register_rest_route(
            'events/v1',
            '/get-more-events',
            array(
                'methods' => 'GET',
                'callback' => array($this,'get_more_events'),
                'permission_callback' => function () {
                    return true;
                }

            )
        );
    }

    function get_more_events($request_data) {

        $atts = $request_data->get_params();
        foreach($atts as $k => $v){
            if($v == "false"){
                $atts[$k] = false;
            } else if($v == "true"){
                $atts[$k] = true;
            }
        }
        $ds = new Event_Codes_Datasource();
        $atts['offset'] = $atts['offset'] + $atts['count'];
        $event_data = $ds->renderShortcodeMarkupAndData($atts,false);
        ob_start();
        $ds->renderLoadMoreEventsMarkupAndData($event_data,$atts);
        $data['markup'] = ob_get_clean();
        $data['atts'] = $atts;
        $data['results_count'] = $event_data['count'];
        return $data;
    }
}