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

    public function default_atts() {
        return array(
            'view' => 'list',
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
        );
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

        $atts = $this->_validate_atts($atts);

        $atts = shortcode_atts(
            $this->default_atts(), $atts, 'event_codes'
        );

        //Check if bootstrap or normal view from settings
        $options =  get_option('event_codes_settings');
        if(empty($options)){
            $options = [];
            $options['template'] = 0;
        }
        $atts['template'] = $options['template'] == 1 ? 'bootstrap' : 'normal';

        //We do not use load more in older versions of WP, older than 4.4
        //admin-ajax code is still buggy - TODO
        //If true recehck if wp rest 2 version
        if($atts['show-load-more']) {
            $atts['show-load-more'] = Event_Codes_Common::check_if_wp_rest_api();
        }

        //It all begins here
        $sc = new Event_Codes_Shortcode_Helper();
        if($debug_atts) {
            echo "DEBUG Shortcode Atts Passed : ".json_encode($debug_atts)."\n";
            echo "DEBUG Shortcode Atts Accepted : ".json_encode($atts);
        }
        $data = $sc->render_shortcode_markup_and_data($atts);
        echo $data['markup'];
    }

    function _validate_atts($atts) {

        //Make sure gebberish values are not sent to count and offset - has to be the first check
        $numerics = ['count','offset'];
        foreach($numerics as $numeric) {
            if(isset($atts[$numeric]) && !is_numeric($atts[$numeric])){
                unset($atts[$numeric]); //defaults will take over
            }
        }

        //Validate atts that have to be boolean
        $bools = ['description','showtime','featured','past'];
        foreach($bools as $bool) {
            if(isset($atts[$bool]) && !is_bool($atts[$bool])){
                unset($atts[$bool]);
            }
        }

        //Validate allowed views
        $view_allowed_values = ['tabular','list'];
        if(isset($atts['view']) && !in_array($atts['view'],$view_allowed_values)) {
            unset($atts['view']);
        }

        //based on views validate styles and other style related options
        if(isset($atts['view']) && $atts['view'] == 'list') {
            $list_style_allowed_values = ['basic', 'big-date', 'card-overlay', 'complete-overlay'];
            if(isset($atts['style']) && !in_array($atts['style'],$list_style_allowed_values)) {
                unset($atts['style']);
            }

        } else if(isset($atts['view']) && $atts['view'] == 'tabular') {
            //Validate allowed styles
            $table_style_allowed_values = ['basic', 'shadow'];
            if(isset($atts['style']) && !in_array($atts['style'],$table_style_allowed_values)) {
                unset($atts['style']);
            }

            //Validate allowed row property
            $table_row_allowed_values = ['alternate-gray'];
            if(isset($atts['row']) && !in_array($atts['row'],$table_row_allowed_values)) {
                unset($atts['row']);
            }

            //Unset everything if view is not valid
        } else {
            if(isset($atts['style'])) {
                unset($atts['style']);
            }
            if(isset($atts['style'])) {
                unset($atts['row']);
            }
        }
        return $atts;
    }


}