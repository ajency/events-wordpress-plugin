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


        $args = array(
            'post_status' => 'publish',
            'hide_upcoming' => false,
            /*            'posts_per_page' => $atts['limit'],
                        'tax_query'=> $atts['event_tax'],
                        'meta_key' => $atts['key'],
                        'orderby' => 'meta_value',
                        'author' => $atts['author'],
                        'order' => $atts['order'],*/
        );

        if(function_exists('tribe_get_events')) {
            $posts = tribe_get_events($args);
        } else {
            echo "No Shortcode";
        }

/*
        print "<pre>";
        print_r($posts);*/

        //TEST Data
        foreach($posts as $post) {

            $event = new Event_Codes_Event();
            $event_start_date = strtotime($post->EventStartDate);
            $event_end_date = strtotime($post->EventEndDate);
            $event->setStartDateDay(date('d',$event_start_date));
            $event->setStartDateMon(date('M',$event_start_date));
            $event->setEndDateDay(date('d',$event_end_date));
            $event->setEndDateMon(date('M',$event_end_date));
            $event->setStartTime(date('h:i A',$event_start_date));
            $event->setEndTime(date('h:i A',$event_end_date));
            $event->setTitle($post->post_title);
            $event->setAddress('Test Line 1, test Addreess, test cpuntry');
            $event->setPrice(100);
            $event_data[] = $event->getEvent();
        }
        include(dirname( __FILE__ )  . '/views/'.$template.'/'.$view.'-view.php' );
        //Call requested view and based on more selections other UI options
    }
}