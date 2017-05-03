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

		$this->create_symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
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
	function test_event_calender_active() {

		$this->create_symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
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


	function test_api_call_for_version() {

		$this->create_symlink(getenv('PLUGIN_TARGET'), getenv('PLUGIN_LINK'));
		$enabling_for = 'the-events-calendar/the-events-calendar.php';
		$this->plugin_activation($enabling_for);

		$event_codes = new Event_Codes();
		$event_codes_api = new Event_Codes_API($event_codes->get_plugin_name(),$event_codes->get_version());
		$event_codes_public = new Event_Codes_Public($event_codes->get_plugin_name(),$event_codes->get_version());
		$expected_result = $event_codes_api->dummy_data_object();

		$js_obj = $event_codes_public->construct_local_js_object();
		print_r($js_obj);
		if($js_obj['api_ver'] == 1) {
			$rest_url = $js_obj['root'];
		} else {
			$rest_url = $js_obj['root'].'events/v1/get-events';
		}
		$actual = $this->getReq($rest_url);
		$this->assertEqualSets($expected_result,$actual);

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

	function create_symlink($target,$link){
		if(!is_link($link)){
			symlink($target,$link);
		}
	}



	function getReq($url) {
		$ch = curl_init();
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
		);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$body = '{"action" : "dummy_data"}';
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$data = curl_exec($ch);
		echo $data;
		return json_decode($data,true);
	}

}
