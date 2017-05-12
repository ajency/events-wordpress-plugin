<?php

/*
 * Add new datasources from here
 * For each datasource add it as a case in check_if_active_and_version_supported
 */
class Event_Codes_Datasources {

    /**
     * Define Constant names for each datasource
     */
    const THE_EVENTS_CALENDAR = 'the-events-calendar';
    const EVENT_ESPRESSO = 'event-espresso';

    /**
     * @param $source
     * @return array|bool
     * Switch case makes sure only the required file is called
     */
    static function check_if_active_and_version_supported($source)
    {

        $return = [];
        $return['is_support'] = false;
        $return['data'] = false;
        switch ($source) {
            case self::THE_EVENTS_CALENDAR:
                self::_load_dependencies('class-event-codes-the-events-calendar.php');
                $tec = new Event_Codes_The_Events_Calender();
                $check = $tec->is_active_and_version_supported();
                if(!$check) {
                    //return params to show message to install/activate/correct version
                    $return['data'] = $tec->is_not_active_message_params();
                } else {
                    $return['is_support'] = true;
                    $return['code_name'] = $check;
                }
                return $return;
                break;
            case self::EVENT_ESPRESSO :
                //TODO
                break;
            default:
                echo "";
                //TODO - define a default datasouce a user can install
        }
    }

    /*
     * Assuming one data source can be used at a time
     * For now its The Events Calendar
     */
    static function get_active_datasource(){
        return self::THE_EVENTS_CALENDAR;
    }

    static function _load_dependencies($ds_file_path) {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/class-event-codes-datasource-config.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/configs/'.$ds_file_path;
    }
}
