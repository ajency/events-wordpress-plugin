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
                'count' => 5,
                'offset' => 0,
                'showtime' => false,
                'description' => false,
                'row' => false,
                'past' => false,
                'featured' => false,

                //TODO
                /*
                 'cat' => [],
                 'tag' => [],*/

            ), $atts, 'event_codes'
        );

        //Provide additional atts that are required
        $options =  get_option('event_codes_settings');
        if(empty($options)){
            $options = [];
            $options['template'] = 0;
        }
        $atts['template'] = $options['template'] == 1 ? 'bootstrap' : 'normal';
        $atts['load-more'] = Event_Codes_Common::check_if_wp_rest_api();


        $ds = new Event_Codes_Datasource();
        $ds->renderShortcodeMarkupAndData($atts);

        //Call requested view and based on more selections other UI options
    }


    //TODO
    //1 - Excerpt limit
    //showtime and desription
    //diff tests for all those combos
    //removing load more and view more
}