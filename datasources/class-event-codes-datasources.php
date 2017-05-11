<?php

/*
 * Add new datasources from here
 * For each datasource add it as a case in check_if_active_and_version_supported
 */
class Event_Codes_Datasources {

    /**
     * Define Constant names for each datasource
     * Currently using characters from guardians of the galaxy
     */
    const THE_EVENTS_CALENDAR = 'groot';
    const EVENT_ESPRESSO = 'rocket';

    /**
     * @param $source
     * @return array|bool
     */
    static function check_if_active_and_version_supported($source)
    {

        $return = [];
        $return['is_support'] = false;
        $return['data'] = false;
        switch ($source) {
            case self::THE_EVENTS_CALENDAR:
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'datasources/the-events-calendar/class-event-codes-tec.php';
                $tec = new Event_Codes_The_Events_Calender();
                $check = $tec->is_active_and_version_supported();
                if(!$check) {
                    $return['data'] = $tec->is_not_active_message_params();
                } else {
                    $return['is_support'] = true;
                    $return['data'] = $check;
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
}
