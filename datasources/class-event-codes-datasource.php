<?php

/*
 * Abstract class that has to be inherited by all data source files
 */
abstract class Event_Codes_Datasource {

    // Force Extending class to define this method
    abstract protected function event_data_transformation($args, $atts);
    abstract protected function construct_query_arguments($atts);
}
