<?php

$plugin_link = dirname(__FILE__).'/downloads/wordpress/wordpress-'.getenv('WP_VER').'/wordpress/wp-content/plugins/'.getenv('PLUGIN');
$plugin_target = dirname(__FILE__).'/downloads/plugins/'.getenv('PLUGIN').'-'.getenv('PLUGIN_VER');
$wp_path = dirname(__FILE__).'/downloads/wordpress/wordpress-'.getenv('WP_VER').'/wordpress/';
$proceed = true;

if (!file_exists($wp_path)) {
	print 'Wordpress '.getenv('WP_VER').' does not exist in test suite'."\n";
	$proceed = false;
}

if (!file_exists($plugin_target)) {
	print getenv('PLUGIN').' '.getenv('PLUGIN_VER').' does not exist in test suite'."\n";
	$proceed = false;
}

$major_wp_version_explode = explode('.',getenv('WP_VER'));
$major_wp_version = $major_wp_version_explode[0].'.'.$major_wp_version_explode[1];

$_tests_dir = './tests/'.$major_wp_version.'/tests/phpunit';

if (!file_exists($_tests_dir)) {
	print 'Tests folder for '.$major_wp_version.' needs to be downloaded'."\n";
	$proceed = false;
}

if($proceed) {

// Give access to tests_add_filter() function.
	require_once $_tests_dir . '/includes/functions.php';

	/**
	 * Manually load the plugin being tested.
	 */
	function _manually_load_plugin() {
		require '../event-codes.php';
	}
	tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

	symlink($plugin_target, $plugin_link);
	putenv('PLUGIN_LINK='.$plugin_link);
	putenv('WP_PATH='.$wp_path);

	print 'Running tests for Wordpress '.getenv('WP_VER').' and '.getenv('PLUGIN').' '.getenv('PLUGIN_VER')."\n";

//Call original bs file
	require $_tests_dir . '/includes/bootstrap.php';

	function endScript(){
		unlink(getenv('PLUGIN_LINK'));
		echo "Done!!"."\n";
	}

	register_shutdown_function('endScript');
} else {
	die;
}

