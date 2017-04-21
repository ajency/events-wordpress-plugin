<?php

class Event_Codes_The_Events_Calender_4_4 {

    public function getEventData() {

        global $wpdb;

        $query = "select p.title,";
        $query .= "pm1.meta_value as start_date,";
        $query .= "pm2.meta_value as end_date,";
        $query .= "pm3.meta_value as venue,";
        $query .= " from wp_posts p";
        $query .= " inner join wp_postmeta pm1 on p.id = pm1.post_id and pm1.meta_key = '_EventStartDate'";
        $query .= " inner join wp_postmeta pm2 on p.id = pm2.post_id and pm2.meta_key = '_EventEndDate'";
        $query .= " inner join wp_postmeta pm3 on p.id = pm3.post_id and pm3.meta_key = '_EventVenueID'";
        $query .= " where p.id = 1451";

        return $wpdb->get_results($query, OBJECT);
    }


}
