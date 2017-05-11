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

        $debug_atts = false;
        if(isset($atts['debug']) && ($atts['debug'] == 'true' OR $atts['debug'] == true)) {
            $debug_atts = $atts;
        }
        //Resetting String bool values to actual boolean === only works in modern PHP versions so cannot rely
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
            ), $atts, 'event_codes'
        );

        //Provide additional atts that are required
        $options =  get_option('event_codes_settings');
        if(empty($options)){
            $options = [];
            $options['template'] = 0;
        }

        $view_allowed_values = ['list', 'tabular'];
        if(!in_array($atts['view'],$view_allowed_values)) {
            $atts['style'] = 'list';
        }

        $style_allowed_values = ['basic', 'shadow'];
        if(!in_array($atts['style'],$style_allowed_values)) {
            $atts['style'] = 'basic';
        }

        $row_allowed_values = ['alternate-gray'];
        if(!in_array($atts['row'],$row_allowed_values)) {
            $atts['style'] = 'basic';
        }

        if(!is_bool($atts['description'])){
            $atts['description'] = false;
        }

        if(!is_bool($atts['showtime'])){
            $atts['showtime'] = false;
        }

        if(!is_bool($atts['featured'])){
            $atts['featured'] = false;
        }

        if(!is_bool($atts['past'])){
            $atts['past'] = false;
        }

        $atts['template'] = $options['template'] == 1 ? 'bootstrap' : 'normal';

        //We do not use load more in older versions of WP, older than 4.4
        //admin-ajax code is still buggy - TODO
        $atts['load-more'] = Event_Codes_Common::check_if_wp_rest_api();

        //It all begins here
        $ds = new Event_Codes_Datasource();
        $active_ds = Event_Codes_Datasources::get_active_datasource();
        $ds->setActiveDataSource($active_ds);
        if($debug_atts) {
            echo "DEBUG Shortcode Atts Passed : ".json_encode($debug_atts);
        }
        $ds->renderShortcodeMarkupAndData($atts);

        //Call requested view and based on more selections other UI options
    }
}