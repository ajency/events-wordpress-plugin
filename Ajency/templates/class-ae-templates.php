<?php

class Ajency_Events_Templates {


    public function events_single_template($single_template) {
        global $wp_query, $post;
        if ($post->post_type == 'eventcodes')
            $single_template = $this->load_template_location('events_single');
        return $single_template;
    }

    public function events_archive_template($archive_template) {
        global $wp_query, $post;
        if ( is_post_type_archive('eventcodes') )
            $archive_template = $this->load_template_location('events_archive');
        return $archive_template;
    }

    public function load_template_location($template) {
        $template = $template.'.php';
        if(file_exists(get_stylesheet_directory() . '/events/' . $template)) {
            $template = get_stylesheet_directory() . '/events/' . $template;
        }else{
            $template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/events/'.$template;
        }
        return $template;
    }
}
