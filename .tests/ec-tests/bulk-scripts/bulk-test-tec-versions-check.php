<?php
/*
 * Run from .tests folder
 */

include 'bulk-test-tec-versions-check-config.php';
header("Content-type: text/plain");
disable_ob();

foreach(array_reverse($wp_versions) as $wp_version)
{
    foreach($tec_versions as $tec_ver) {
        run_unit_test($wp_version,'the-events-calendar',$tec_ver);
    }
}

//TODO : Support multiple plugins to be included
function run_unit_test($wp_ver,$plugin,$plugin_ver) {
    $cmd = 'WP_VER='.$wp_ver.' PLUGIN='.$plugin.' PLUGIN_VER='.$plugin_ver.' phpunit --filter test_event_calender_main_class'."\n";
    print "Running command : ".$cmd;
    system($cmd);
}


function disable_ob() {
    // Turn off output buffering
    ini_set('output_buffering', 'off');
    // Turn off PHP output compression
    ini_set('zlib.output_compression', false);
    // Implicitly flush the buffer(s)
    ini_set('implicit_flush', true);
    ob_implicit_flush(true);
    // Clear, and turn off output buffering
    while (ob_get_level() > 0) {
        // Get the curent level
        $level = ob_get_level();
        // End the buffering
        ob_end_clean();
        // If the current level has not changed, abort
        if (ob_get_level() == $level) break;
    }
    // Disable apache output buffering/compression
    if (function_exists('apache_setenv')) {
        apache_setenv('no-gzip', '1');
        apache_setenv('dont-vary', '1');
    }
}