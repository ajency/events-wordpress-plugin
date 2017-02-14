<?php

class Ajency_Events_Dashboard_Settings {

    public function load_dashboard_config_menu(){

        include '/var/www/wp/wp-content/plugins/eventcodes/Ajency/dashboard/template-settings.php';
        $ae = Ajency_Events::getInstance();
        add_submenu_page(
            'edit.php?post_type='.$ae->get_custom_post_type_name(),
            __( 'Event  Settings', $ae->get_plugin_name() ),
            __( 'Setings', $ae->get_plugin_name() ),
            'manage_options',
            $ae->get_plugin_name().'-settings',
            array( $this, 'add_settings_page' )
        );
    }


    public function add_settings_page() {
        ?>
        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">

            <div id="icon-themes" class="icon32"></div>
            <h2>Sandbox Theme Options</h2>
            <?php settings_errors(); ?>

            <h2 class="nav-tab-wrapper">
                <a href="#" class="nav-tab">Display Options</a>
                <a href="#" class="nav-tab">Social Options</a>
            </h2>

            <form method="post" action="options.php">

                <?php settings_fields( 'sandbox_theme_display_options' ); ?>
                <?php do_settings_sections( 'sandbox_theme_display_options' ); ?>

                <?php settings_fields( 'sandbox_theme_social_options' ); ?>
                <?php do_settings_sections( 'sandbox_theme_social_options' ); ?>

                <?php submit_button(); ?>

            </form>

        </div><!-- /.wrap -->

        <?php
    }
}
