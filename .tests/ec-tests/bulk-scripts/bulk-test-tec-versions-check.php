<?php
/*
 * Run from .tests folder
 */
include 'bulk-test-tec-versions-check-config.php';

foreach(array_reverse($wp_versions) as $wp_version)
{
    foreach($tec_versions as $tec_ver) {
        run_unit_test($wp_version,'the-events-calendar',$tec_ver);
    }
}

//TODO : Support multiple plugins to be included
function run_unit_test($wp_ver,$plugin,$plugin_ver) {
    $cmd = 'WP_VER='.$wp_ver.' PLUGIN='.$plugin.' PLUGIN_VER='.$plugin_ver.' phpunit --filter test_event_calender_main_class';
    print "Running command : ".$cmd."\n";
    system($cmd);
    $cmd = 'WP_VER='.$wp_ver.' PLUGIN='.$plugin.' PLUGIN_VER='.$plugin_ver.' phpunit --filter test_event_calender_data_query';
    print "Running command : ".$cmd."\n";
    system($cmd);
}