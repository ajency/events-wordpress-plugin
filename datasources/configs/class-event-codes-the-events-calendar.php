<?php

class Event_Codes_The_Events_Calender extends Event_Codes_Datasource_Config {

    //Each codebase is given a codename so that we can mention which versions of The Event Calender pro we support with a single codebase
    //Guardians of the galaxy
    const GROOT = 'groot';
    const ROCKET = 'rocket';
    const MIN_VERSION_SUPPORT = 3.10;

    public function supported_versions_config()
    {
        //TODO in later version we might need these depending on wordpress versions
        return
            [
                'default' => self::GROOT,
                '3.9' => self::ROCKET //If we did have a different codebase for < 3.10
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

            if($version > self::MIN_VERSION_SUPPORT) {
                if(in_array($version,$supported_versions)){
                    return $supported_versions[$version];
                }
                return $supported_versions['default'];
            }
        }
        return false;
    }

    public function is_not_active_message_params()
    {
        return [
            'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true&fields[versions]=true',
            'plugin_name' => __('The Events Calendar','event-codes'),
            'version' => max(array_keys($this->supported_versions_config())),
        ];
    }

}