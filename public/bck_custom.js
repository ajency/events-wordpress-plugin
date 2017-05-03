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
			e.preventDefault();

			var sc_params = {};
			$('#form-' + e.target.id).serializeArray().map(function(x){sc_params[x.name] = x.value;});
			console.log(sc_params);
			if(event_codes.api_ver == 1) {
				var url = event_codes.root;
				sc_params.action = 'get_api_data';
			} else {
				var url = event_codes.root + 'events/v1/get-events';
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
				'data' : sc_params,
				//The response from the server
				'success' : function(data) {

					console.log(data);

					$.ajax({
						//The URL to process the request
						'url' : event_codes.root + 'events/v1/get-template',
						//The type of request, also known as the "method" in HTML forms
						//Can be 'GET' or 'POST'
						'type' : 'GET',
						//Any post-data/get-data parameters
						//This is optional
						'data' : sc_params,
						//The response from the server
						'success' : function(markup) {
							for(var i = 0; i < data.event_data.length; i ++) {
								var markup1 = $(markup);
								var a_title = markup1.find('.aj__data-title').find('a');
								var event = data.event_data[i];

								console.log(event);

								$(a_title[0]).text(event.title);

								var a_address = markup1.find('.aj__address').find('a');
								$(a_address[0]).text(event.address);

								if(event.price !==- false) {
									markup1.find('.aj__data-price').text(event.price);
									markup1.find('.aj__data-currency').text(event.currency);
								} else {

								}

								markup1.find('.aj__data-daystart').text(event.start_date_day);
								markup1.find('.aj__data-dayend').text(event.end_date_day);
								markup1.find('.aj__data-daystart-month').text(event.start_date_mon);
								markup1.find('.aj__data-dayend-month').text(event.end_date_mon);
								markup1.find('.aj__data-timestart').text(event.start_time);
								markup1.find('.aj__data-timeend').text(event.end_time);
								markup1.find('.aj__data-desc').text(event.description);

								$('#data-' + e.target.id).append(markup1);
							}

							var atts_form = $('#form-' + e.target.id);
							console.log(data.atts);
							$.each( data.atts, function( key, value ) {
								atts_form.find('input[name="'+key+'"]').val(value);
							});
						}
					});
				}
			});
		});
	});


})( jQuery );
