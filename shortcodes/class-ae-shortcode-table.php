<?php

class Ajency_Events_Shortcode_Table {

    /**
     *
     */

    public function load_shortcodes()
    {
        add_shortcode( 'ajency-events-table', array( $this, 'shortcode_events' ) );
    }

    /**
     * @shortcode Table
     * key : range
     * values : upcoming, past, all, month, year, day
     * default : all
     *
     * key : range-setting (Used in conjunction with range key)
     * values : Int indicating no of days in case of upcoming and past
     * default : false
     * default (when upcoming, past) : 30
     * default (when month, day, year) : current month, day or year respectfully
     *
     * key : featured
     * values : 1,0
     * default : false
     *
     * key : limit
     * values : int
     * default : 10
     *
     * key : offset
     * values : int
     * default : 0
     *
     * key : order
     * values : ASC, DESC
     * default : ASC
     *
     * key : order-by
     * values : startdate, enddate, created, updated
     * default : startdate
     *
     * key : tags
     * values : tag strings defined in wordpress tags
     * default : false
     *
     * key : event-status
     * values : draft, published
     * default : false
     *
     * key : fields
     * values : comma seperated list of fields | comma sperated list of field-labels
     * default : name,venue,startdate,enddate,city,link
     *
     * key : link-field
     * values : name,link
     * default : link
     *
     * key : show-header
     * values : 0,1
     * default : false
     */

    public function shortcode_events( $atts ) {

        $atts = shortcode_atts(
            array(

                'range' => 'upcoming', // month, day, year, upcoming, past
                'range-setting' => 30, // no of days in case of upcoming, past. Default to 30,

                'featured' => false,
                'event-status' => false,

                'tags' => false,

                'limit' => 5,
                'offset' => 0,

                'order' => 'ASC',
                'order-by' => 'startdate',

                'fields' => 'name,venue,startdate', // name,city,startdate|Event Name,City,Start at
                'link-field' => 'name',
                'map-field' => 'venue',

                'date-format' => 'd-M-Y',

                'event-status' => 'publish',

            ), $atts, 'ajency_events'
        );

        require_once plugin_dir_path( dirname( __FILE__ ) ) . '/shortcodes/class-ae-shortcodes-query-builder.php';

        $qb = new Ajency_Events_Shortcodes_Query_Builder();

        if($atts['tags']){
            $tags = explode(',',$atts['tags']);
        }

        $query = $qb->initialize_query($atts['event-status'],$atts['limit'],$atts['offset'],$tags);

        $meta_query = [];
        $meta_query[] = $qb->filter_featured($atts['featured']);
        $meta_query_event_startdate = $qb->filter_range($atts['range'],$atts['range-setting']);
        $query['meta_query'] = array_merge($meta_query,$meta_query_event_startdate);
        $query_sort = $qb->sort($atts['order-by'],$atts['order']);
        $query = array_merge($query,$query_sort);

        $field_settings = explode('|',$atts['fields']);
        $fields = explode(',',$field_settings[0]);
        $field_labels = explode(',',$field_settings[1]);

        $html = '<table class="aj-t__table" cellpadding="0" cellspacing="0" border="0">';

        if(!empty($field_labels[0])) {

            $html .= '<thead><tr>';

            foreach ($field_labels as $field_label)
            {
                $html .= '<th>'.$field_label.'</th>';
            }

            $html .= '</tr></thead><tbody>';

        }

        $html .= '<tbody>';


        $ids = [];
        $posts = query_posts($query);
        foreach ($posts as $post){
            $ids[] = $post->ID;
        }

        //A helper function to get all the meta in all the posts

        if($ids) {
            $post_meta = $qb->get_post_custom_multiple($ids,[
                    Ajency_Events_Constants::FIELD_FEATURED,
                    Ajency_Events_Constants::FIELD_STARTDATE,
                    Ajency_Events_Constants::FIELD_ENDDATE,
                    Ajency_Events_Constants::FIELD_LOCATION_OBJECT,
                    Ajency_Events_Constants::FIELD_LAT_EDITED,
                    Ajency_Events_Constants::FIELD_LNG_EDITED,
                    Ajency_Events_Constants::FIELD_LOCATION_EDITED
                ]
            );
        }

        $width = 100/count($fields);

        while ( have_posts() ) { the_post();
            $html .= '<tr>';
            foreach ($fields as $i => $field){

                switch ($field) {
                    case "name":
                        $content =  __(get_the_title());
                        break;
                    case "venue":
                        $content = __($post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_LOCATION_OBJECT][Ajency_Events_Location_Object_Fields::NAME]);
                        break;
                    case "startdate":
                        $content = __(date($atts['date-format'],strtotime($post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_STARTDATE])));
                        break;
                    case "enddate":
                        $content = __($post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_ENDDATE]);
                        break;
                    case "city":
                        $content = __(

                            $post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_LOCATION_OBJECT][Ajency_Events_Location_Object_Fields::LOCALITY]

                        );
                        break;
                    case "link":
                        $content = __('View');
                        break;
                    default:
                        //Do Nothing - In case a missspelt field will lead to field being omited
                }

/*                print "<pre>";
                print $post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_LAT_EDITED];*/

                if($content == '') {
                    $content = 'NA';
                }

                if($atts['map-field'] == $field && $content != 'NA') {

                    $lat = $post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_LAT_EDITED];
                    $lng = $post_meta[get_the_ID()][Ajency_Events_Constants::FIELD_LNG_EDITED];
                    $content = $content.'(<a target="_blank" href="http://maps.google.com/?q='.$lat.','.$lng.'"">View Map</a>)';
                } else  if($atts['link-field'] == $field && $content != 'NA') {
                    $content =     '<a href='.get_permalink().'>'.__($content).'</a>';
                }


                $html .=     '<td style="width: '.$width.'%" class="aj-t__col">'.__($content).'</td>';

            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        wp_reset_query();
        return $html;
    }
}



/* for($i = 2; $i < 2000; $i++)
 {

     Print "Egenerate Events";

     $post_id = wp_insert_post(array (
         'post_type' => 'eventcode',
         'post_title' => 'Generated Event '.$i,
         'post_content' => 'This is an auto generated Event',
         'post_status' => 'publish',
         'comment_status' => 'closed',   // if you prefer
         'ping_status' => 'closed',      // if you prefer
     ));


     print $post_id;


     $int= rand(1262304000,1577836800);

     $end_date_diff_min = 30000;
     $end_date_diff_max = 86400;

     $date_from = date("Y-m-d H:i:s",$int);
     $date_to = date("Y-m-d H:i:s",$int + rand($end_date_diff_min,$end_date_diff_max));

     if ($post_id) {
         add_post_meta($post_id, '_event_startdate', $date_from);
         add_post_meta($post_id, '_event_enddate', $date_to);

         if ($i % 5 != 0){
             add_post_meta($post_id, '_event_featured', 1);
         }

         $cities = [
             'Banglore', 'Panjim', 'Margao', 'Mumbai', 'Pune', 'Delhi'
         ];
         $city = $cities[array_rand($cities)];

         $venues = [
             'The Loft', 'DTR', 'HYatt', 'Megamall', 'Palace Grounds', 'Hauz Classic'
         ];
         $venue = $venues[array_rand($venues)];

         add_post_meta($post_id, '_event_venue', $venue);
         add_post_meta($post_id, '_event_city', $city);
     }

 }*/