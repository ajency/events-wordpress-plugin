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

		$('#load-more').click(function(e) {
			e.preventDefault();
//Send the AJAX call to the server
			$.ajax({
				//The URL to process the request



				'url' : event_codes.root + 'events/v1/get-events',
				//The type of request, also known as the "method" in HTML forms
				//Can be 'GET' or 'POST'
				'type' : 'GET',
				//Any post-data/get-data parameters
				//This is optional
				'data' : {
					'paramater1' : 'value',
					'parameter2' : 'another value'
				},
				//The response from the server
				'success' : function(data) {

					console.log($('#style').val());

					$.ajax({
						//The URL to process the request
						'url' : 'http://wp.dev/wp-content/plugins/event_codes/events/views/bootstrap/tabular-view-item.php',
						//The type of request, also known as the "method" in HTML forms
						//Can be 'GET' or 'POST'
						'type' : 'GET',
						//Any post-data/get-data parameters
						//This is optional
						'data' : {
							'style' : $('#style').val()
						},
						//The response from the server
						'success' : function(markup) {
							for(var i = 0; i < data.length; i ++) {
								var markup1 = $(markup);
								var a = markup1.find('.aj__data-title').find('a');
								var event = data[i];
								$(a[0]).text(event.title);
								$('.aj-table').append(markup1);
							}
						}
					});
				}
			});
		});
	});


})( jQuery );
