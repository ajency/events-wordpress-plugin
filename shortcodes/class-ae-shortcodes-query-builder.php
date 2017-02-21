<?php



class Ajency_Events_Shortcodes_Query_Builder extends Ajency_Events_Base  {


    public function initialize_query($post_status = FILTER_POST_STATUS_DEFAULT, $limit = 10, $offset = 0 , $tags = false) {

        $query = [
            'post_type' => $this->custom_post_type_name,
            'post_status' => $post_status, // only get posts with this status\
            'posts_per_page' => $limit,
            'offset' => $offset,
        ];

        if($tags){
            $query['tax_query'] = array(
                'taxonomy' => 'event-types',
                'field' => 'slug',
                'terms' => $tags
            );
        }

        return $query;
    }



    public function filter_range($range = 'all', $range_setting = false) {

        //ensuring final else conditions in case of all or invalid values for $range
        $to = false;
        $from = false;

        if($range == 'upcoming' || $range == 'past')
        {
            $no_of_days = is_numeric($range_setting) ? $range_setting : 30;
            $date = new DateTime();

        }
        else if($range == 'month' || $range == 'day' || $range == 'year' || $range == 'week')
        {
            try {
                $date = new DateTime($range_setting);
            } catch (Exception $e){

                //If some invalid asdf string is given catch it and set default $date to current Datetime
                $date = new DateTime();

            }
        }


        if($range == 'upcoming') {

            $from = $date->setTime(0, 0, 0)->format('Y-m-d H:i:s');
            $to = $date->modify( '+'.$no_of_days." days")->setTime(23, 59, 59)
                ->format("Y-m-d H:i:s");

        }
        else if ($range == 'past') {

            $to = $date->setTime(23, 59, 59)->format('Y-m-d H:i:s');
            $from = $date->modify( "-".$no_of_days." days")->setTime(0, 0, 0)
                ->format("Y-m-d H:i:s");
        }
        else if ($range == 'month') {

            $from = $date->modify('first day of this month')->setTime(0, 0, 0)
                ->format("Y-m-d H:i:s");
            $to = $date->modify('last day of this month')->setTime(23, 59, 59)
                ->format("Y-m-d H:i:s");
        }
        else if ($range == 'year') {

            $from = $date->modify('first day of January')->setTime(0, 0, 0)
                ->format("Y-m-d H:i:s");
            $to = $date->modify('last day of December')->setTime(23, 59, 59)
                ->format("Y-m-d H:i:s");
        }
        else if ($range == 'week') {

            //TODO config for timezones, start and ending of weeks
            $from = $date->modify('previous sunday')->setTime(0, 0, 0)
                ->format("Y-m-d H:i:s");
            $to = $date->modify('next saturday')->setTime(23, 59, 59)
                ->format("Y-m-d H:i:s");
        }
        else if ($range == 'day') {

            $from = $date->setTime(0, 0, 0)->format("Y-m-d H:i:s");
            $to = $date->setTime(23, 59, 59)->format("Y-m-d H:i:s");

        }

        if($to && $from){

            $filter[] =  [
                'key' => '_event_startdate',
                'value' => $from,
                'compare' => '>'
            ];

            $filter[] =  [
                'key' => '_event_startdate',
                'value' => $to,
                'compare' => '<'
            ];

            return $filter;
        }

        return;
    }


    /**
     * Function
     */
    public function filter_featured($featured = false) {

        //ensuring valid values are passed
        if(is_numeric($featured) && ($featured == 1 || $featured == 0)) {
            return [
                'key' => '_event_featured',
                'value' => $featured,
                'compare' => '='
            ];
        }
        return;
    }


    public function sort($sort_by = 'startdate', $sort_order = 'DESC') {

        if($sort_by == 'startdate'){

            $query['orderby'] = 'meta_value';
            $query['meta_key'] = '_event_startdate';
        }
        else if($sort_by == 'enddate')
        {
            $query['orderby'] = 'meta_value';
            $query['meta_key'] = '_event_enddate';
        }


        $query['order'] = $sort_order;
        return $query;
    }

    public function get_post_custom_multiple($events_ids,$meta_keys) {

        global $wpdb;

        $query = "SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta} p where (post_id = %d".str_repeat(" OR post_id = %d",count($events_ids) - 1).") AND";
        $query .= " (meta_key = '%s'".str_repeat(" OR meta_key = '%s'",count($meta_keys) - 1).")";

        $preparedQuery = $wpdb->prepare(
            $query,
            array_merge($events_ids,$meta_keys)
        );

        foreach($wpdb->get_results($preparedQuery, ARRAY_N) as $val) {
            if($val[1] == Ajency_Events_Constants::FIELD_LOCATION_OBJECT) {
                $value = unserialize($val[2]);

            } else {
                $value = $val[2];
            }
            $event_meta[$val[0]][$val[1]] = $value;
        };
        return $event_meta;
    }

}
