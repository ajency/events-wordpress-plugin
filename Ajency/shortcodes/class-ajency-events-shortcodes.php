<?php

class Ajency_Events_Shortcodes {

    /**
     *
     */

    public function load_shortcodes()
    {
        add_shortcode( 'ajency-events', array( $this, 'shortcode_events' ) );
    }


    public function shortcode_events( $atts ){

        global $wpdb;

        $custom_post_type = 'post';

        $query = "
    SELECT *
    FROM $wpdb->posts p
    INNER JOIN wp_termmeta m ON p.id = m.post_id
    WHERE wtt.taxonomy = 'post_tag' AND wtt.count = 0";

        $wpdb->get_results($query);

        $allevents = $wpdb->get_var( $wpdb->prepare(
            "
		SELECT * from
		FROM $wpdb->posts 
		WHERE post_type = %s
	",
            $custom_post_type
        ) );


        echo 9999;
        print_r($allevents);

        $headers = ['Firstname', 'Lastname', 'Column 3'];

        $data = [
            ['asdasdvsd','asdqweqwe','sdfsdrqeq','qweqweqddwq'],
            ['2342','2243','wwer','234243'],
            ['sdfsdf','4534534','3453t43','ymymy'],
            ['asdasdsdfsvsd','dfgdfgdfg','sdfsdrqeq','hj,jhk,hj']
        ];
        $template = new Ajency_Events_Render_Template('shortcodes/templates/test.php', [ 'data' => $data, 'headers' => $headers]);
        return $template->render();
    }

}
