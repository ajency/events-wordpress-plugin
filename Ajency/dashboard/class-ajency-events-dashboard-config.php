<?php

class Ajency_Events_Config {

    public function load_dashboard_config_menu(){
        add_submenu_page(
            'edit.php?post_type=ajency-events',
            __( 'Ajency Events Settings', 'ajency-events' ),
            __( 'Setings', 'ajency-events' ),
            'manage_options',
            'ajency-events-settings',
            array( $this, 'add_settings_page' )
        );
    }


    public function add_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Event Settigns', 'ajency-events' ); ?></h1>
            <p><?php _e( 'Customize event settings', 'ajency-events' ); ?></p>
        </div>
        <?php
    }
}
