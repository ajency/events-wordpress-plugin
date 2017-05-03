<?php

class Event_Codes_The_Events_Calender_4_4 {

    public function eventDataTransformation($args, $atts ,$include_count = true) {

        global $post;
        $query = Tribe__Events__Query::getEvents( $args , true);

        $events = [];
        foreach($query->posts  as $post) {
            setup_postdata( $post );
            $event = new Event_Codes_Event();
            $event->setTitle($post->post_title);
            $event->setDescription($post->post_content,$atts['description']);
            $event->setTitleLink(get_post_permalink());
            $event_start_date = strtotime($post->EventStartDate);
            $event_end_date = strtotime($post->EventEndDate);
            $event->setDates($event_start_date,$event_end_date,Tribe__Date_Utils::is_all_day( get_post_meta( $post->ID, '_EventAllDay', true ) ), $atts['showtime']);

            //Will need to fetch the hard way
            $event->setAddress([tribe_get_address(),tribe_get_city(),tribe_get_region(),tribe_get_country()]);
            //TODO set lat lng clean way
            $show_link = get_post_meta($post->ID,'_EventShowMapLink',true);
            $event->setAddressLink(tribe_get_coordinates(),$show_link);


            $event->setPrice(get_post_meta($post->ID,'_EventCost',true));
            $event->setCurrency(get_post_meta($post->ID,'_EventCurrencySymbol',true));
            $event->setCurrencyPosition(get_post_meta($post->ID,'_EventCurrencyPosition',true));

            $events[] = $event->getEvent();
        }
        $response = [];
        $response['events'] = $events;
        if($include_count) {
            $response['count'] = $query->found_posts;
        }
        return $response;

    }


}
