<?php

class Event_Codes_The_Events_Calender {

    public function supported_versions_config()
    {
        //TODO in later version we might need these depending on wordpress versions
        return [
            '4.4.5' => [
                    'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                    'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
        /*    '4.4.4' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],*/
            '4.4.3' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
           /* '4.4.2' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
            '4.4.1' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
            '4.4.0' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
            '4.4' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],*/
        ];

    }

    /**
     * @return bool|string
     * Returns false if plugin is not active or the version is not supported
     * Returns the config for the version if is supported
     */
    public function is_active_and_version_supported(){
        if (class_exists('Tribe__Events__Main') OR
            defined('Tribe__Events__Main::VERSION')
        ) {
            $version = Tribe__Events__Main::VERSION;
            $supported_versions = $this->supported_versions_config();
            if(in_array($version,array_keys($supported_versions)))
            {
                return $supported_versions[$version];
            }
        }
        return false;
    }

    public function is_not_active_message_params()
    {
        return [
            'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true&fields[versions]=true',
            'plugin_name' => 'The Events Calendar',
            'version' => max(array_keys($this->supported_versions_config())),
        ];
    }

}