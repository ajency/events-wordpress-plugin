<?php

class Event_Codes_Datasource_Groot extends Event_Codes_Datasource {

    public function event_data_transformation($args, $atts) {

        if( class_exists( 'Tribe__Events__Query' ) && method_exists('Tribe__Events__Query','getEvents'))
        {
            global $post;
            $query = Tribe__Events__Query::getEvents( $args , true);
            $events_array = [];
            foreach($query->posts  as $post) {
                setup_postdata( $post );
                $event = new Event_Codes_Event();
                $event->setTitle($post->post_title);
                $event->setDescription($post->post_content,$atts['description']);
                $event->setTitleLink(get_post_permalink());
                $event_start_date = strtotime($post->EventStartDate);
                $event_end_date = strtotime($post->EventEndDate);
                $event->setDates($event_start_date,$event_end_date,Event_Codes_Common::is_true( get_post_meta( $post->ID, '_EventAllDay', true ) ), $atts['showtime']);
                $event->setArtWork(get_the_post_thumbnail_url( $post));
                $event->setAddress([tribe_get_address(),tribe_get_city(),tribe_get_region(),tribe_get_country()]);
                //TODO set lat lng in a cleaner way
                $show_link = get_post_meta($post->ID,'_EventShowMapLink',true);
                $event->setAddressLink($show_link);
                $event->setNoAddressLabel();


                $event->setPrice(get_post_meta($post->ID,'_EventCost',true));
                $event->setCurrency(get_post_meta($post->ID,'_EventCurrencySymbol',true));
                $event->setCurrencyPosition(get_post_meta($post->ID,'_EventCurrencyPosition',true));

                $events_array[] = $event->getEvent();
            }
            wp_reset_query();
            $events = new Event_Codes_Events();
            $events->setEvents($events_array);
            $events->setCount($query->found_posts);

            if($atts['past']){
                $event_range_lbl = __('Past','event-codes');
            } else {
                $event_range_lbl = __('Upcoming','event-codes');
            }
            $featured_label = __('Featured','event-codes');
            if($atts['featured']) {
                $event_range_lbl = sprintf(esc_html($event_range_lbl.' '.$featured_label));
            }
            $events->setEventRangeLbl($event_range_lbl);
            return $events;
        } else {
            return false;
        }
    }

    public function construct_query_arguments($atts){

        $meta_query = [];
        if($atts['past']) {
            $meta_query['range_query'] = array(
                'key' => '_EventStartDate', // Check the start date field
                'value' => current_time( 'Y-m-d H:i:s' ), // Set today's date (note the similar format)
                'compare' => '<', // Return the ones lesser than today's date
                'type' => 'DATETIME' // Let WordPress know we're working with date
            );
            $order = 'DESC';
            $event_display = 'past';

        } else {
            $meta_query['range_query'] = array(
                'key' => '_EventEndDate', // Check the start date field
                'value' => current_time( 'Y-m-d H:i:s' ), // Set today's date (note the similar format)
                'compare' => '>=', // Return the ones greater than today's date
                'type' => 'DATETIME' // Let WordPress know we're working with date
            );
            $order = 'ASC';
            $event_display = 'custom';
        }

        if($atts['featured']) {
            $meta_query['featured_query'] = array(
                'key' => '_tribe_featured',
                'value' => 1,
                'compare' => '=',
            );
        }

        $tax_query = [];
        $tax_query['relation'] = 'AND';
        if ($atts['cat']) {
            $cat_query = [];

            if ( strpos( $atts['cat'], "," ) !== false ) {
                $atts['cats'] = explode( ",", $atts['cat'] );
                $atts['cats'] = array_map( 'trim', $atts['cats'] );
            } else {
                $atts['cats'] = $atts['cat'];
            }

            $cat_query['relation'] = 'OR';

            $cat_query[] = array(
                'taxonomy' => 'tribe_events_cat',
                'field' => 'name',
                'terms' => $atts['cats'],
            );

            $cat_query[] = array(
                'taxonomy' => 'tribe_events_cat',
                'field' => 'slug',
                'terms' => $atts['cats'],
            );
            $tax_query[] = $cat_query;
        }

        if ($atts['tag']) {

            $tag_query = [];
            if ( strpos( $atts['tag'], "," ) !== false ) {
                $atts['tags'] = explode( ",", $atts['tag'] );
                $atts['tags'] = array_map( 'trim', $atts['tags'] );
            } else {
                $atts['tags'] = $atts['tag'];
            }

            $tag_query['relation'] = 'OR';

            $tag_query[] = array(
                'taxonomy' => 'post_tag',
                'field' => 'name',
                'terms' => $atts['tags'],
            );
            $tag_query[] = array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => $atts['tags'],
            );
            $tax_query[] = $tag_query;
        }

        return array(
            'post_status' => 'publish',
            'posts_per_page' => $atts['count'],
            'offset' => $atts['offset'],
            'meta_key' => '_EventStartDate',
            'orderby' => 'meta_value',
            'order' => $order,
            'meta_query' => $meta_query,
            'tax_query' => $tax_query,
            'eventDisplay' => $event_display
        );

    }

}
