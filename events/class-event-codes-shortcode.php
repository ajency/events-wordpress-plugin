<?php

class Event_Codes_Shortcode {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function load_shortcodes()
    {
        add_shortcode( 'event_codes', array( $this, 'event_codes_shortcode' ) );
    }

    public function event_codes_shortcode( $atts ) {

        $atts = shortcode_atts(
            array(

                'view' => 'list',
                'style' => 'basic',
                'property' => 'altgrayshade', //needs tabular to be selected
                'showtime' => false,
                'description' => false,
                'count' => 5,
                'offset' => 0,
                'cat' => [],
                'tag' => [],
                'past' => false,
                'featured' => false,

            ), $atts, 'event_codes'
        );

        //include the datasource, base on config option
        //pass all filters to the data source
        //query builder etc should be in the ds folder, only returned data shoud be fecthed here in Event object $event
        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/events/class-event-codes-event.php';

        //Pass data to our events object
        $event = new Event_Codes_Event();
        $event->setEndDate(date('d-m-Y H:i:s'),time());
        $event->setStartDate(date('d-m-Y H:i:s'),time());
        $event->setTitle('Test Event');
        $event->setVenue('Test Venue');

        $template = 'bootstrap'; //boostrap, normal - fetched from option value, same value used in enqueue scripts
        $atts['view'] = 'tabular'; //rewrite the default for dev

        $event_data = [];
        $event_data[] = $event->getEvent();
        $event_data[] = $event->getEvent();
        $event_data[] = $event->getEvent();
        include(dirname( __FILE__ )  . '/views/'.$template.'/'.$atts['view'].'-view.php' );
        //Call requested view and based on more selections other UI options
    }
}