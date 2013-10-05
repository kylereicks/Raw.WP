<?php
/*
Plugin Name: Raw.WP
Plugin URI: Include GitHub repository
Description: Add the Raw app by Density Design to the WordPress Media Center.
Author: Kyle Reicks
Version: 0.0.0
Author URI: http://github.com/kylereicks/
*/

define('RAW_WP_PATH', plugin_dir_path(__FILE__));
define('RAW_WP_URL', plugins_url('/', __FILE__));
define('RAW_WP_VERSION', '0.0.0');

require_once(RAW_WP_PATH . 'inc/class-raw-wp.php');

register_deactivation_hook(__FILE__, array('Raw_WP', 'deactivate'));

Raw_WP::get_instance();
