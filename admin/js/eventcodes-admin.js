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


    jQuery(document).ready(function(){
        jQuery('#_event_enddate').datetimepicker({
            format:'d-M-Y H:i:s',
		});

        jQuery('#_event_startdate').datetimepicker({
            format:'d-M-Y H:i:s',
        });



        //Autocomplete variables
        var input = document.getElementById('_event_loc');


        google.maps.event.addDomListener(input, 'keydown', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });


        var place;
        var autocomplete = new google.maps.places.Autocomplete(input);

        //Google Map variables
        var map;
        var marker;

        //Add listener to detect autocomplete selection
        google.maps.event.addListener(autocomplete, 'place_changed', function () {

            place = autocomplete.getPlace();

            console.log(place);

            var componentForm = {

                street_number: 'short_name',
                route: 'long_name',
                locality: 'long_name',
                administrative_area_level_1: 'short_name',
                administrative_area_level_2: 'short_name',
                sublocality_level_1: 'short_name',
                sublocality_level_2: 'short_name',
                country: 'long_name',
                postal_code: 'short_name'

            };

            var componentFields = {

                street_number: '_street_no',
                route: '_route',
                locality: '_locality',
                administrative_area_level_1: '_admin_1',
                administrative_area_level_2: '_admin_2',
                sublocality_level_1: '_subloc_1',
                sublocality_level_2: '_subloc_2',
                country: '_country',
                postal_code: '_postal_code'

            };


            //TODO fix this
            for (var key in componentForm) {
            	console.log(componentFields[key]);

/*                document.getElementById('event_loc[' + componentFields[key] + ']').value = '';*/
            }

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById('_event_loc_obj[' + componentFields[addressType] + ']').value = val;
				}
            }

            document.getElementById('_event_loc_obj[_name]').value = place.name;

            var event_location = place.name + ' ' + place.formatted_address;

            document.getElementById('_event_loc').value = event_location;
            document.getElementById('_event_loc_edited').value = event_location;

            var newlatlong = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());

            document.getElementById("_event_loc_lat").value = place.geometry.location.lat();
            document.getElementById("_event_loc_lng").value = place.geometry.location.lng();
            document.getElementById("_event_loc_lat_edited").value = place.geometry.location.lat();
            document.getElementById("_event_loc_lng_edited").value = place.geometry.location.lng();

            map.setCenter(newlatlong);
            marker.setPosition(newlatlong);
            map.setZoom(12);
        });


/*
        //Add listener to search
        searchform.addEventListener("submit", function() {
            var newlatlong = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());
            map.setCenter(newlatlong);
            marker.setPosition(newlatlong);
            map.setZoom(12);
        });

        //Reset the inpout box on click
        input.addEventListener('click', function(){
            input.value = "";
        });
*/



        function initialize() {

            var defaultLat = document.getElementById('_event_loc_lat_edited').value;
            var defaultLng = document.getElementById('_event_loc_lng_edited').value;

            console.log(defaultLat);
            console.log(defaultLng);

            var myLatlng = new google.maps.LatLng(defaultLat,defaultLng);

            var mapOptions = {
                zoom: 19,
                center: myLatlng
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable:true,
                title: 'Main map'
            });

            google.maps.event.addListener(marker, 'dragend', function(marker){

            	console.log(marker);

				var latLng = marker.latLng;

                var myInput = document.getElementById("_event_loc");
                if (myInput && myInput.value) {
                    document.getElementById("_event_loc_lat_edited").value = latLng.lat();
                    document.getElementById("_event_loc_lng_edited").value = latLng.lng();
                } else {
                    alert('Please search for a location before placing the map marker');
                }
            });
        }


        google.maps.event.addDomListener(window, 'load', initialize);



/*
        jQuery('#startdate').datetimepicker({
            format:'d-M-Y H:i:s',
        });*/

/*
        jQuery('#date').datepicker({
            dateFormat: 'dd-mm-yy'
        });*/
    });




})( jQuery );
