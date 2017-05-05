<?php

class Event_Codes_The_Events_Calender {

    public function supported_versions_config()
    {
        return [
            '4.4.5' =>
                [
                    'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                    'class_name' => 'Event_Codes_The_Events_Calender_444',
                ],
            '4.4.4' => [
                'file' => 'the-events-calendar/class-event-codes-tec-444.php',
                'class_name' => 'Event_Codes_The_Events_Calender_444',
            ],
            '4.4.3' => 'the-events-calender-444',
            '4.4.2' => 'the-events-calender-444',
            '4.4.1' => 'the-events-calender-444',
            '4.4.0' => 'the-events-calender-444',
            '4.4' => 'the-events-calender-444',
            '4.3.9' => 'the-events-calender-439',
            '4.3.8' => 'the-events-calender-439',
            '4.3.7' => 'the-events-calender-439',
            '4.3.6' => 'the-events-calender-439',
            '4.3.5' => 'the-events-calender-439',
            '4.3.4' => 'the-events-calender-439',
            '4.3.3' => 'the-events-calender-439',
            '4.3.2' => 'the-events-calender-439',
            '4.3.1' => 'the-events-calender-439',
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
            'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true',
            'plugin_name' => 'The Events Calendar',
        ];
    }

}