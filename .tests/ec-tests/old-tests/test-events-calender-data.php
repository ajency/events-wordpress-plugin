<?php


class ECTest extends Event_Code_Tests
{

    /**
     * A single example test.
     */
    function test_event_calender_data()
    {
        $this->create_symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));

/*        print ABSPATH."\n";
        exec('cd '.ABSPATH);*/
        exec('wp plugin install the-events-calendar --activate');
        exec('wp plugin install wordpress-importer --activate');
        $import_cmd = 'wp import '.dirname(__FILE__).'/test-data/thewp.wordpress.2017-05-02.xml --authors=create';
        print $import_cmd;
        exec($import_cmd,$op);
        $enabling_for = 'the-events-calendar/the-events-calendar.php';
        print_r(get_plugin_data($enabling_for));
        die;

        $ec = new Event_Codes_The_Events_Calender_4_4();
        $args = [];
        $args['limit'] = 5;
        $data = $ec->getEventData($args);



        if (class_exists( 'Tribe__Events__Main' ) or defined( 'Tribe__Events__Main::VERSION' )) {
            print "Tribe Exists";
        }

        print "List of events";
 /*       print_r($data);*/

        unlink(getenv('PLUGIN_LINK'));

    }

}