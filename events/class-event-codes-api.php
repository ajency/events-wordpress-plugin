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
            '/get-events',
            array(
                'methods' => 'GET',
                'callback' => array($this,'dummy_data'),
                'permission_callback' => function () {
                    return true;
                }

            )
        );

        register_rest_route(
            'events/v1',
            '/get-template',
            array(
                'methods' => 'GET',
                'callback' => array($this,'get_template'),
                'permission_callback' => function () {
                    return true;
                }

            )
        );
    }

    function get_template($request_data) {

        $parameters = $request_data->get_params();
        return file_get_contents(dirname( __FILE__ )  .'/views/'.$parameters['template'].'/'.$parameters['view'].'-view-item.php' );
    }

    function dummy_data() {

        include 'class-event-codes-event.php';
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