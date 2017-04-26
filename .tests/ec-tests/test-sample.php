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
	function test_is_admin_context() {
		$this->assertFalse( is_admin() );
	}

	/**
	 * A single example test.
	 */
	/*function test_the_event_calender_444_active() {

		$plugin = new Event_Codes();
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$admin = new Event_Codes_Admin($plugin->get_plugin_name(),$plugin->get_version());
		$data = $admin->check_datasources($enabling_for);
		$expected_data = ['success' => true, 'data' => [
			'versions' => ['4.4.4' , '4.4.3'],
			'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true',
			'plugin_name' => 'The Events Calendar',
			]
		];
		// Replace this with some actual testing code.
		$this->assertEqualSets( $data, $expected_data );
	}*/

	/**
	 * A single example test.
	 */
	function test_the_event_calender_444_deactivated() {

		$plugin = new Event_Codes();
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$admin = new Event_Codes_Admin($plugin->get_plugin_name(),$plugin->get_version());
		$data = $admin->check_datasources($enabling_for);

		$expected_data = ['success' => false, 'data' => [
			'versions' => ['4.4.4' , '4.4.3'],
			'install_url' =>  'plugin-install.php?tab=plugin-information&plugin=the-events-calendar&TB_iframe=true',
			'plugin_name' => 'The Events Calendar',
		]
		];
		// Replace this with some actual testing code.
		$this->assertEqualSets( $data, $expected_data );
	}
}
