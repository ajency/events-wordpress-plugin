(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function() {

		$('.aj--loadmore').click(function(e) {

			console.log(event_codes);

			e.preventDefault();
			$('#'+e.target.id).hide();

			var sc_params = window['event_codes_sc_atts_'+e.target.id]
			sc_params._jilarx = true;
			sc_params._api_nonce = event_codes.api_nonce;

			if(event_codes.api_ver == 1) {
				var url = event_codes.api_url;
				sc_params.action = 'get_api_data';
			} else {
				var url = event_codes.api_url + 'events/v1/get-more-events';
			}

			//Send the AJAX call to the server
			$.ajax({
				//The URL to process the request
				'url' : url,
				//The type of request, also known as the "method" in HTML forms
				//Can be 'GET' or 'POST'
				'type' : 'GET',
				//Any post-data/get-data parameters
				//This is optional
				beforeSend : function ( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', event_codes.api_nonce );
				},
				'data' : sc_params,
				//The response from the server
				'success' : function(data) {

					console.log(data);

					$('#'+e.target.id).show();

					var markup1 = $(data.markup);
					$('#data-' + e.target.id).append(markup1);
					window['event_codes_sc_atts_'+e.target.id] = data.atts;

/*					console.log(+data.atts.count + +data.atts.offset);
					console.log(data.results_count);*/
					if(data.results_count <= (+data.atts.count + +data.atts.offset)) {
						$('#'+e.target.id).remove();
					}
				}
			});
		});
	});


})( jQuery );
