<?php

/*
 * Abstract class that has to be inherited by all data source config files
 */
abstract class Event_Codes_Datasource_Config {

    // Force Extending class to define this method
    abstract protected function supported_versions_config();
    abstract protected function is_active_and_version_supported();
    abstract protected function is_not_active_message_params();

}
