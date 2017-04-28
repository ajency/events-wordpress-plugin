<?php
/**
 * Class SampleTest
 *
 * @package Eventcodes
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_event_calender_not_installed() {

		$event_codes = new Event_Codes();
		$event_codes_admin = new Event_Codes_Admin($event_codes->get_plugin_name(),$event_codes->get_version());
		$event_codes_ds = $event_codes_admin->allowed_datasources();
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$event_codes_ds_the_events_calender = $event_codes_ds[$enabling_for];
		$expected_output = false;
		$test_on = $event_codes_admin->check_datasources($enabling_for);
		$this->assertEquals($test_on['success'],$expected_output);

	}

	/**
	 * A single example test.
	 */
	function test_event_calender_not_active() {

		symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
		$event_codes = new Event_Codes();
		$event_codes_admin = new Event_Codes_Admin($event_codes->get_plugin_name(),$event_codes->get_version());
		$event_codes_ds = $event_codes_admin->allowed_datasources();
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$event_codes_ds_the_events_calender = $event_codes_ds[$enabling_for];
		$expected_output = false;
		$test_on = $event_codes_admin->check_datasources($enabling_for);
		$this->assertEquals($test_on['success'],$expected_output);
		unlink(getenv('PLUGIN_LINK'));
	}

	/**
	 * A single example test.
	 */
	function test_event_calender_data_object() {

		$event_codes_event = new Event_Codes_Event();

/*		symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$this->plugin_activation($enabling_for);
		$event_codes = new Event_Codes();
		$event_codes_admin = new Event_Codes_Admin($event_codes->get_plugin_name(),$event_codes->get_version());
		$event_codes_ds = $event_codes_admin->allowed_datasources();
		$event_codes_ds_the_events_calender = $event_codes_ds[$enabling_for];
		if(in_array(getenv('PLUGIN_VER'),$event_codes_ds_the_events_calender['versions'])) {
			$expected_output = true;
		} else {
			$expected_output = false;
		}
		$test_on = $event_codes_admin->check_datasources($enabling_for);
		$this->assertEquals($test_on['success'],$expected_output);
		//TODO deactivate plugin here
		unlink(getenv('PLUGIN_LINK'));*/
	}

	/**
	 * A single example test.
	 */
	function test_event_calender_active() {

		symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$this->plugin_activation($enabling_for);
		$event_codes = new Event_Codes();
		$event_codes_admin = new Event_Codes_Admin($event_codes->get_plugin_name(),$event_codes->get_version());
		$event_codes_ds = $event_codes_admin->allowed_datasources();
		$event_codes_ds_the_events_calender = $event_codes_ds[$enabling_for];
		if(in_array(getenv('PLUGIN_VER'),$event_codes_ds_the_events_calender['versions'])) {
			$expected_output = true;
		} else {
			$expected_output = false;
		}
		$test_on = $event_codes_admin->check_datasources($enabling_for);
		$this->assertEquals($test_on['success'],$expected_output);
		//TODO deactivate plugin here
		unlink(getenv('PLUGIN_LINK'));
	}

	function plugin_activation( $plugin ) {
		if( ! function_exists('activate_plugin') ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if( ! is_plugin_active( $plugin ) ) {
			activate_plugin( $plugin );
		}
	}

}
