<?php
include 'wordpress-versions.php';
$current_dir = dirname(__FILE__);
foreach($wordpress_versions as $k => $v) {
    exec('svn co http://develop.svn.wordpress.org/branches/'.$k.'/tests/ '.$current_dir.'/downloads/tests/'.$k.'/tests');
/*    exec('wget https://wordpress.org/wordpress-'.$k.'.tar.gz -P '.$current_dir.'/downloads/wordpress/wordpress-'.$k);
    foreach($v as $ver){
        exec('wget https://wordpress.org/wordpress-'.$ver.'.tar.gz -P '.$current_dir.'/downloads/wordpress/wordpress-'.$ver);
    }*/
}
