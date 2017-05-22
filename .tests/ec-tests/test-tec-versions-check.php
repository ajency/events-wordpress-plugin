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
        $this->write_to_csv($res['is_support'],$this->getName());
        $this->assertTrue($res['is_support']);
    }

    function test_event_calender_data_query()
    {

        $ev = new Event_Codes();
        $scc = new Event_Codes_Shortcode($ev->get_plugin_name(),$ev->get_version());
        $sch = new Event_Codes_Shortcode_Helper();
        $atts = $scc->default_atts();
        $markup = $sch->render_shortcode_markup_and_data($atts);
        if(is_bool($markup) && $markup == false) {
            $r = $markup;
        } else if(is_array($markup)) {
            $r = true;
        }
        $this->write_to_csv($r,$this->getName());
        $this->assertTrue($r);
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

    function shutdown()
    {
        // This is our shutdown function, in
        // here we can do any last operations
        // before the script is complete.

        echo 'Script executed with success', PHP_EOL;
    }
}