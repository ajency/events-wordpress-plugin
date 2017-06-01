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

    //Does not matter as API needs to be public
    function event_codes_api_auth( $result )
    {

        // $result should be null. Any other value indicates something
        // happened before we got here.
        if (!is_null($result) || is_wp_error($result)) {
            return $result;
        }

        // Make sure we need to authenticate at all.
        if (empty($_REQUEST['_jilarx']) || empty($_REQUEST['_api_nonce'])) {
            return $result;
        }

        // Verifiy the nonce.
        $nonce = $_REQUEST['_api_nonce'];
        if (wp_verify_nonce($nonce, 'api_nonce')) {
            return true;
        }

        // If we're still here, just return the original result.
        return $result;
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
        $ds = new Event_Codes_Shortcode_Helper();
        $atts['offset'] = $atts['offset'] + $atts['count'];
        return $ds->render_shortcode_markup_and_data($atts,true);
    }


    function dummy_data_object() {

        $event = new Event_Codes_Event();
        $events = [];
        $event->setDescription('Seamlessly actualize parallel technologies and multidisciplinary technologies...');
        $event->setEndDate('15 Mar');
        $event->setStartDate('23 Feb');
        $event->setAddress('Kala Academy, Panjim, Goa');
        $event->setTitle('sdfsdfsdfsdf sdfsdfsdfsfd');
        $event->setPrice(100);
        $event->setStartDateDay(16);
        $event->setStartDateMon('May');
        $event->setEndDateDay(18);
        $event->setEndDateMon('May');
        $event->setStartTime('10:00 AM');
        $event->setEndTime('02:00 PM');
        $events[] = $event->getEvent();
        return $events;
    }
}