<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Bookly Service Extras (Add-on)
Plugin URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Description: Bookly Service Extras add-on introduces new booking step in Bookly. At this step your clients can choose extra items to be added to selected service.
Version: 2.5
Author: Bookly
Author URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Text Domain: bookly
Domain Path: /languages
License: Commercial
*/

if ( ! function_exists( 'bookly_service_extras_loader' ) ) {
    include_once __DIR__ . '/autoload.php';

    BooklyServiceExtras\Lib\Boot::up();
}