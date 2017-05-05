<?php

class Event_Codes_Datasources {

    /**
     * @param $source
     * @return array|bool
     * Retuens false if it is active and array if not active - very reverse-psych
     */
    static function check_if_active_and_version_supported($source)
    {

        $return = [];
        $return['is_support'] = false;
        $return['data'] = false;
        switch ($source) {
            case 'the-events-calendar':
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
            case 'events-calipso':
                echo "i equals 1";
                break;
            default:
                echo "";
        }
        return false;
    }

    static function get_active_datasource(){
        return 'the-events-calendar';
    }
}
