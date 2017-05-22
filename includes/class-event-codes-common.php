<?php

class Event_Codes_Common {

	/**
	 * @return array
	 * Function to get API version and API url incase we need to make API calls from JS
	 */
	static function get_wp_api_version() {

		if(function_exists('rest_url')) {
			$api_url = esc_url_raw( rest_url());
			$api_ver = 2;
		} else {
			$api_url = admin_url( 'admin-ajax.php' );
			$api_ver = 1;
		}
		return array(
			'api_ver' => $api_ver,
			'api_url' => $api_url,
		);
	}

	/**
	 *
	 */
	static function check_if_wp_rest_api() {
		if(function_exists('rest_url')) {
			return true;
		}
		return false;
	}

	static function is_true($meta_value) {

		$meta_value = trim( $meta_value );

		return (
			'true' === strtolower( $meta_value )
			|| 'yes' === strtolower( $meta_value )
			|| true === $meta_value
			|| 1 == $meta_value
		);
	}
}