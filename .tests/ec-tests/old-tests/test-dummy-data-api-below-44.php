<?php
/**
 * Class SampleTest
 *
 * @package Eventcodes
 */

/**
 * Sample test case.
 */
class DummyAPITestBelow44 extends Event_Code_Tests {

    function test_ajax_initiate_upload() {

        if(!function_exists('rest_url')) {

            print "REST DOES NOT EXIST"."\n";

            try {
                $this->_handleAjax( 'dummy_data' );
            } catch ( Exception $e ) {
/*                print_r($e);*/
            }

            $response = json_decode( $this->_last_response );
            print_r($response);

            $event_codes = new Event_Codes();
            $event_codes_api = new Event_Codes_API($event_codes->get_plugin_name(),$event_codes->get_version());
            $event_codes_public = new Event_Codes_Public($event_codes->get_plugin_name(),$event_codes->get_version());
            $expected_result = $event_codes_api->dummy_data_object();


            /*    $this->assertInternalType( 'object', $response );
                $this->assertObjectHasAttribute( 'success', $response );
                $this->assertTrue( $response->success );
                $this->assertObjectHasAttribute( data, $response );*/
            $this->assertEqualSets( $response, $expected_result );
        } else {
            print "REST Exists on this WP version, skipping test"."\n";
        }
    }
}
