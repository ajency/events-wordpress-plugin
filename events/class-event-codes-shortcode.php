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
                'count' => 2,
                'offset' => 0,
                'showtime' => false,
                'description' => false,

                //TODO
                /*
                 'past' => false,
                 'featured' => false,
                 'property' => 'altgrayshade', //needs tabular to be selected
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
        $template = $options['template'] == 1 ? 'bootstrap' : 'normal';
        $atts['template'] = $template;


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