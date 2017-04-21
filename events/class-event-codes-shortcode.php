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

                'range' => 'upcoming', // month, day, year, upcoming, past
                'range-setting' => 30, // no of days in case of upcoming, past. Default to 30,

                'featured' => false,
                'event-status' => false,

                'tags' => false,

                'limit' => 5,
                'offset' => 0,

                'order' => 'ASC',
                'order-by' => 'startdate',

                'fields' => 'name,venue,startdate', // name,city,startdate|Event Name,City,Start at
                'link-field' => 'name',
                'map-field' => 'venue',

                'date-format' => 'd-M-Y',

                'event-status' => 'publish',

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


        $event_data = [];
        $event_data[] = $event->getEvent();
        $event_data[] = $event->getEvent();
        $event_data[] = $event->getEvent();
        include(dirname( __FILE__ )  . '/views/table-view-bootstrap.php' );
        //Call requested view and based on more selections other UI options
    }
}





/* for($i = 2; $i < 2000; $i++)
 {

     Print "Egenerate Events";

     $post_id = wp_insert_post(array (
         'post_type' => 'eventcode',
         'post_title' => 'Generated Event '.$i,
         'post_content' => 'This is an auto generated Event',
         'post_status' => 'publish',
         'comment_status' => 'closed',   // if you prefer
         'ping_status' => 'closed',      // if you prefer
     ));


     print $post_id;


     $int= rand(1262304000,1577836800);

     $end_date_diff_min = 30000;
     $end_date_diff_max = 86400;

     $date_from = date("Y-m-d H:i:s",$int);
     $date_to = date("Y-m-d H:i:s",$int + rand($end_date_diff_min,$end_date_diff_max));

     if ($post_id) {
         add_post_meta($post_id, '_event_startdate', $date_from);
         add_post_meta($post_id, '_event_enddate', $date_to);

         if ($i % 5 != 0){
             add_post_meta($post_id, '_event_featured', 1);
         }

         $cities = [
             'Banglore', 'Panjim', 'Margao', 'Mumbai', 'Pune', 'Delhi'
         ];
         $city = $cities[array_rand($cities)];

         $venues = [
             'The Loft', 'DTR', 'HYatt', 'Megamall', 'Palace Grounds', 'Hauz Classic'
         ];
         $venue = $venues[array_rand($venues)];

         add_post_meta($post_id, '_event_venue', $venue);
         add_post_meta($post_id, '_event_city', $city);
     }

 }*/