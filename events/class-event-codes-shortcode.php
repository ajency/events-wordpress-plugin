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

        //Debug mode set to false by default
        //Caught early before shortcode atts defaults setting
        $debug_atts = false;
        if(isset($atts['debug']) && ($atts['debug'] == 'true' OR $atts['debug'] == true)) {
            $debug_atts = $atts;
        }

        //Resetting String bool values to actual boolean === only works in modern PHP versions so cannot rely on it
        //TODO - make common function as required in API also
        if($atts) {
            foreach($atts as $k => $v){
                if($v == "false"){
                    $atts[$k] = false;
                } else if($v == "true"){
                    $atts[$k] = true;
                }
            }
        }

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
                'tag' => false,
                'cat' => false,
                'show-load-more' => true,
                'show-view-all' => true,
            ), $atts, 'event_codes'
        );

        //Validate allowed views
        $view_allowed_values = ['tabular'];
        if(!in_array($atts['view'],$view_allowed_values)) {
            $atts['view'] = 'tabular';
        }

        //Validate allowed styles
        $style_allowed_values = ['basic', 'shadow'];
        if(!in_array($atts['style'],$style_allowed_values)) {
            $atts['style'] = 'basic';
        }

        //Validate allowed row property
        $row_allowed_values = ['alternate-gray'];
        if(!in_array($atts['row'],$row_allowed_values)) {
            $atts['row'] = false;
        }

        //Validate atts that have to be boolean
        $bools = ['description','showtime','featured','past'];
        foreach($bools as $bool) {
            if(!is_bool($atts[$bool])){
                $atts[$bool] = false;
            }
        }

        //Check if bootstrap or normal view from settings
        $options =  get_option('event_codes_settings');
        if(empty($options)){
            $options = [];
            $options['template'] = 0;
        }
        $atts['template'] = $options['template'] == 1 ? 'bootstrap' : 'normal';

        //We do not use load more in older versions of WP, older than 4.4
        //admin-ajax code is still buggy - TODO
        $atts['show-load-more'] = Event_Codes_Common::check_if_wp_rest_api();

        //It all begins here
        $active_ds = Event_Codes_Datasources::get_active_datasource();
        $sc = new Event_Codes_Shortcode_Helper();
        $sc->setActiveDataSource($active_ds);
        if($debug_atts) {
            echo "DEBUG Shortcode Atts Passed : ".json_encode($debug_atts)."\n";
            echo "DEBUG Shortcode Atts Accepted : ".json_encode($atts);
        }
        $sc->renderShortcodeMarkupAndData($atts);
    }
}