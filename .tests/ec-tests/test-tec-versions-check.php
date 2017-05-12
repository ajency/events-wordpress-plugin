<?php


class TEC_Versions_Check extends Event_Code_Tests
{

    /**
     * A single example test.
     */
    function test_event_calender_main_class()
    {

        //testing to see if your logic works assuming Tribe_Main class and VERSION const
        $res = Event_Codes_Datasources::check_if_active_and_version_supported(Event_Codes_Datasources::THE_EVENTS_CALENDAR);
        $this->assertTrue($res['is_support']);
    }

    function test_event_calender_data()
    {
        $data = new Event_Codes_Datasource_Groot();
        $scc = new Event_Codes_Shortcode();
        $atts = $scc->default_atts();
        $args = $data->construct_query_arguments($atts);
        $events = $data->event_data_transformation($args,$atts);
        print_r($events);
    }

    public function setUp()
    {
        print "Set Up..."."\n";
        $this->create_symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
        $enabling_for = 'the-events-calendar/the-events-calendar.php';
        $this->plugin_activation($enabling_for);
        print "Set Up End..."."\n";
    }

    public function tearDown()
    {
        print "Tear Down..."."\n";
        unlink(getenv('PLUGIN_LINK'));
        print "Tear Down End..."."\n";
    }


}