<?php

class Ajency_Events_Dashboard_Settings {

    public function load_dashboard_config_menu(){

        add_submenu_page(
            'edit.php?post_type=eventcode',
            __( 'Ajency Events Settings', 'eventcodes' ),
            __( 'Setings', 'eventcodes' ),
            'manage_options',
            'eventcodes-settings',
            array( $this, 'add_settings_page' )
        );
    }


    public function add_settings_page() {

        $template = new Ajency_Events_Render_Template('dashboard/template-settings.php', []);


        print $template->render();

    }
}
