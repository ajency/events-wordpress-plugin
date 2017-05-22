<?php

/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 12/5/17
 * Time: 3:37 PM
 */
class Event_Code_Tests extends WP_UnitTestCase
{
    function create_symlink($target,$link){
        if(!is_link($link)){
            symlink($target,$link);
        } else {
            unlink($link);
            symlink($target,$link);
        }
    }

    function plugin_activation( $plugin ) {
        if( ! function_exists('activate_plugin') ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        if( ! is_plugin_active( $plugin ) ) {
            activate_plugin( $plugin );
        }
    }

/*    function create_symlink($target,$link){
        if(!is_link($link)){
            symlink($target,$link);
        }
    }
*/


    function getReq($url) {
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $body = '{"action" : "dummy_data"}';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $data = curl_exec($ch);
        echo $data;
        return json_decode($data,true);
    }

    function write_to_csv($bool,$file) {
        $line = [];
        $line['WHEN'] = date('d-M-Y H:i:s',time());
        $line['WP_VER'] = getenv('WP_VER');
        $line['PLUGIN'] = getenv('PLUGIN');
        $line['PLUGIN_VER'] = getenv('PLUGIN_VER');
        if($bool == false) {
            $line['result'] = 'No';
        } else {
            $line['result'] = 'Yes';
        }
        $handle = fopen('ec-tests/logs/'.$file.".csv", "a");
        fputcsv($handle, $line);
        fclose($handle);
    }
}