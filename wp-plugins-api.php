<?php
/*
Plugin Name: Wp-plugins-api
Version: 0.1-alpha
Description: PLUGIN DESCRIPTION HERE
Author: YOUR NAME HERE
Author URI: YOUR SITE HERE
Plugin URI: PLUGIN SITE HERE
Text Domain: wp-plugins-api
Domain Path: /languages
*/

require dirname(__FILE__).'/vendor/autoload.php';

$wp_plugins_api = new WP_Plugins_API();
$wp_plugins_api->register();

class WP_Plugins_API {

	public function __construct()
	{

	}

	public function register()
	{
		add_shortcode( 'plugins_api', array( $this, 'plugins_api' ) );
	}

	public function plugins_api()
	{

	}
}
