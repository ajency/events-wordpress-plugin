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

                'view' => 'tabular',
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


        $options =  get_option('event_codes_settings');
        $template = $options['template'] == 1 ? 'bootstrap' : 'normal';
        $view = $atts['view'];
        $shortcode_id = uniqid();

        //TEST Data
        for($i = 0 ; $i < $atts['count']; $i++) {

            $event = new Event_Codes_Event();
            $event->setStartDateDay('13');
            $event->setStartDateMon('Jan');
            $event->setEndDateDay('15');
            $event->setEndDateMon('Dec');
            $event->setStartTime('2:30 PM');
            $event->setEndTime('9:30 PM');
            $event->setTitle('Test Event '. $i);
            $event->setAddress('Test Line 1, test Addreess, test cpuntry');
            $event->setPrice($i * 5);
            $event_data[] = $event->getEvent();
        }
        include(dirname( __FILE__ )  . '/views/'.$template.'/'.$view.'-view.php' );
        //Call requested view and based on more selections other UI options
    }
}