<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Ajency_Events_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {


       /* global $wpdb;

        $table_name = $wpdb->prefix . 'ae_location';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            event_id bigint(20) unsigned NOT NULL,
            address_line_1 VARCHAR(100) NOT NULL,
            address_line_2 VARCHAR(100) NOT NULL,
            city VARCHAR(100) NOT NULL,
            state VARCHAR(100) NOT NULL,
            country VARCHAR(100) NOT NULL,
            pincode VARCHAR(100) NOT NULL,
            lat DECIMAL NOT NULL,
            lng DECIMAL NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );*/

	}

}
