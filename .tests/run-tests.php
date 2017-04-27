<?php
include 'run-tests-config.php';

foreach($config as $cnf)
{
    print_r($cnf);
    run_unit_test($cnf[0],$cnf[1],$cnf[2]);
}

//TODO : Support multiple plugins to be included
function run_unit_test($wp_ver,$plugin,$plugin_ver) {
    $cmd = 'WP_VER='.$wp_ver.' PLUGIN='.$plugin.' PLUGIN_VER='.$plugin_ver.' phpunit'."\n";
    print "Running command : ".$cmd;
    exec($cmd,$op);
    print_r($op);
}