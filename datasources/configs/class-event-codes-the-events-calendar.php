<?php

class Event_Codes_The_Events_Calender extends Event_Codes_Datasource_Config {

    //Each codebase is given a codename so that we can mention which versions of The Event Calender pro we support with a single codebase
    //Guardians of the galaxy
    const GROOT = 'groot';
    const ROCKET = 'rocket';
    const MIN_VERSION_SUPPORT = 3.10;
    const DEFAULT_VERSION_SUPPORT = 3.10;

    public function supported_versions_config()
    {
        //TODO in later version we might need these depending on wordpress versions
        return
#            GROOT => ['4.4.5','4.4.4','4.4.3','4.4.2','4.4.1','4.4']
            //We changed this array as its easier to array search by key -- less expensive
            //The earlier would lead to MD array and array search below 5.5 is bad
            [
                '4.5.2.1' => self::GROOT,

                '4.5.0.2' => self::GROOT,
                '4.5.0.1' => self::GROOT,
                '4.5' => self::GROOT,
                '4.4.5' => self::GROOT,
                '4.4.4' => self::GROOT,
                '4.4.3' => self::GROOT,
                '4.4.2' => self::GROOT,
                '4.4.1.1' => self::GROOT,
                '4.4.1' => self::GROOT,
                '4.4.0.1' => self::GROOT,
                '4.4' => self::GROOT,
                '4.3.5' => self::GROOT,
                '4.3.4.2' => self::GROOT,
                '4.3.4.1' => self::GROOT,
                '4.3.4' => self::GROOT,
                '4.3.3' => self::GROOT,
                '4.3.2' => self::GROOT,
                '4.3.1.1' => self::GROOT,
                '4.3.1' => self::GROOT,
                '4.3.0.1' => self::GROOT,
                '4.3' => self::GROOT,
                '4.2.7' => self::GROOT,
                '4.2.6' => self::GROOT,
                '4.2.5' => self::GROOT,
                '4.2.4' => self::GROOT,
                '4.2.3' => self::GROOT,
                '4.2.2' => self::GROOT,
                '4.2.1.1' => self::GROOT,
                '4.2.1' => self::GROOT,
                '4.2' => self::GROOT,
                '4.1.4' => self::GROOT,
                '4.1.3' => self::GROOT,
                '4.1.2' => self::GROOT,
                '4.1.1.1' => self::GROOT,
                '4.1.1' => self::GROOT,
                '4.1.0.1' => self::GROOT,
                '4.1' => self::GROOT,
                '4.0.7' => self::GROOT,
                '4.0.6' => self::GROOT,
                '4.0.5' => self::GROOT,
                '4.0.4' => self::GROOT,
                '4.0.3' => self::GROOT,
                '4.0.2' => self::GROOT,
                '4.0.1' => self::GROOT,
                '4.0' => self::GROOT,
                '3.12.6' => self::GROOT,
                '3.12.5' => self::GROOT,
                '3.12.4' => self::GROOT,
                '3.12.3' => self::GROOT,
                '3.12.2' => self::GROOT,
                '3.12.1' => self::GROOT,
                '3.12' => self::GROOT,
                '3.11.2' => self::GROOT,
                '3.11.1' => self::GROOT,
                '3.11' => self::GROOT,
                '3.10.1' => self::GROOT,
                '3.10' => self::GROOT,
                /*'3.9.3' => self::GROOT,
                '3.9.2' => self::GROOT,
                '3.9.1' => self::GROOT,
                '3.9' => self::GROOT,
                '3.8.1' => self::GROOT,
                '3.8' => self::GROOT,
                '3.7' => self::GROOT,
                '3.6.1' => self::GROOT,
                '3.6' => self::GROOT,
                '3.5.1' => self::GROOT,
                '3.5' => self::GROOT,
                '3.4.1' => self::GROOT,
                '3.4' => self::GROOT,
                '3.3.1' => self::GROOT,
                '3.3' => self::GROOT,
                '3.2' => self::GROOT,
                '3.1' => self::GROOT,
                '3.0.3' => self::GROOT,
                '3.0.2' => self::GROOT,
                '3.0.1' => self::GROOT,
                '3.0' => self::GROOT,
                '2.0.11' => self::GROOT,
                '2.0.10' => self::GROOT,
                '2.0.9' => self::GROOT,
                '2.0.8' => self::GROOT,
                '2.0.7' => self::GROOT,
                '2.0.6' => self::GROOT,
                '2.0.5' => self::GROOT,
                '2.0.4' => self::GROOT,
                '2.0.3' => self::GROOT,
                '2.0.2' => self::GROOT,
                '2.0.1' => self::GROOT,
                '2.0' => self::GROOT,
                '1.6.5' => self::GROOT,
                '1.6.4' => self::GROOT,
                '1.6.3' => self::GROOT,
                '1.6.2' => self::GROOT,
                '1.6.1' => self::GROOT,
                '1.6' => self::GROOT,
                '1.5.6' => self::GROOT,
                '1.5.5' => self::GROOT,
                '1.5.4' => self::GROOT,
                '1.5.3' => self::GROOT,
                '1.5.2' => self::GROOT,
                '1.5.1' => self::GROOT,
                '1.5' => self::GROOT,*/
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
#            $supported_versions = $this->supported_versions_config();
/*            if(in_array($version,array_keys($supported_versions)))
            {
                //return the codename
                return $supported_versions[$version];
            }*/
            $min_version = self::MIN_VERSION_SUPPORT;
            if($version > $min_version) {
                return self::GROOT;
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