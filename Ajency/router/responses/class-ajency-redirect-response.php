<?php

class Ajency_Redirect_Response extends Ajency_Response {

	/**
	 * Builds redirect response.
	 *
	 * @param string
	 * @param integer
	 * @param array
	 */
    public function __construct( $url, $status = 302, $headers = array() )
    {
    	$headers[] = 'Location: ' . $url;

    	return parent::__construct( null, $status, $headers );
    }
}
