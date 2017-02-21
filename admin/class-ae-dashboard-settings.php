<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Ajency_Events_Dashboard_Settings extends Ajency_Events_Base {

    public function load_dashboard_config_menu(){
        add_submenu_page(
            'edit.php?post_type='.$this->custom_post_type_name,
            __( 'Event  Settings', $this->plugin_name ),
            __( 'Setings', $this->plugin_name ),
            'manage_options',
            $this->plugin_name.'-settings',
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
