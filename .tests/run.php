<?php
echo "-------------------------START-------------------------------\n";
$major_wp_version_explode = explode('.',getenv('WP_VER'));
$major_wp_version = $major_wp_version_explode[0].'.'.$major_wp_version_explode[1];
putenv('WP_MAJOR_VER='.$major_wp_version);

$_tests_dir = dirname(__FILE__).'/downloads/tests/'.$major_wp_version.'/tests/phpunit';

$proceed = true;
if (!file_exists($_tests_dir)) {
	print 'Tests folder for '.$major_wp_version.' needs to be downloaded for WP_UnitTestCase to be included'."\n";
	$proceed = false;
}

//If proceed already fails no need todo this, script will exit
//Order of checking is
//1. Does the tests files exist for requested WP version
//2. Does the wp ver exists
//3. Does the requested plugin version exists
//TODO currently supporting only one plugin, can refactor this to multiple
if($proceed) {

	//No validation on config file, will break if missing
	$tests_config_file = dirname(__FILE__).'/wp-tests-config.php';
	$tests_config_file_link = dirname(__FILE__).'/downloads/tests/'.$major_wp_version.'/wp-tests-config.php';
	symlink($tests_config_file, $tests_config_file_link);
	putenv('CONFIG_LINK='.$tests_config_file_link);

	$plugin_link = dirname(__FILE__).'/downloads/wordpress/wordpress-'.getenv('WP_VER').'/wordpress/wp-content/plugins/'.getenv('PLUGIN');
	$plugin_target = dirname(__FILE__).'/downloads/plugins/'.getenv('PLUGIN').'.'.getenv('PLUGIN_VER').'/'.getenv('PLUGIN');
	$wp_path = dirname(__FILE__).'/downloads/wordpress/wordpress-'.getenv('WP_VER').'/wordpress/';


	//Check if wordpress ver exists
	if (!file_exists($wp_path)) {
		print 'Wordpress '.getenv('WP_VER').' does not exist in test suite'."\n";
		$proceed = false;
	}

	//check if plugin exists
	if (!file_exists($plugin_target)) {
		print getenv('PLUGIN').' '.getenv('PLUGIN_VER').' does not exist in test suite'."\n";
		$proceed = false;
	}
}


if($proceed) {


	print "Testing"."\n";
	//Continue with the testing, pre bootstrap

	// Give access to tests_add_filter() function.
	require_once $_tests_dir . '/includes/functions.php';

	/**
	 * Manually load the plugin being tested.
	 */
	function _manually_load_plugin() {
		require '../event-codes.php';
	}
	tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

	//create the symbolic link since plugin exists - We need this linking to be dynamic in tests
#	symlink($plugin_target, $plugin_link);
	putenv('PLUGIN_LINK='.$plugin_link);
	putenv('PLUGIN_TARGET='.$plugin_target);
	putenv('WP_PATH='.$wp_path);

	print 'Running tests for Wordpress '.getenv('WP_VER').' and '.getenv('PLUGIN').' '.getenv('PLUGIN_VER')."\n";

	//Call original bs file
	require $_tests_dir . '/includes/bootstrap.php';

	//include additional commin fucntions in our suite
	include 'ec-tests/Event_Code_Tests.php';

	//unlink config file and plugin file, like a teardown after ending testing
	function endScript(){
/*		unlink(getenv('PLUGIN_LINK'));*/
		unlink(getenv('CONFIG_LINK'));
		echo "-------------------------END - TEST RAN-------------------------------\n";
	}
	register_shutdown_function('endScript');
} else {
#	unlink(getenv('CONFIG_LINK'));
	echo "-------------------------END - TEST DID NOT RUN-------------------------------\n";
}

