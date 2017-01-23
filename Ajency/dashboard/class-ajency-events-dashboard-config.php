<?php

class Ajency_Events_Config {

    public function load_dashboard_config_menu(){

        add_submenu_page(
            'edit.php?post_type=ajency_event',
            __( 'Ajency Events Settings', 'ajency-events' ),
            __( 'Setings', 'ajency-events' ),
            'manage_options',
            'ajency-events-settings',
            array( $this, 'add_settings_page' )
        );
    }


    public function add_settings_page() {

        $template = new Ajency_Events_Render_Template('dashboard/templates/template-settings.php', []);

        
        print $template->render();

    }
}
