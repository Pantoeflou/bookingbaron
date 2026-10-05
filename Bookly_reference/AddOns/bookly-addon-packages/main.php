<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Bookly Packages (Add-on)
Plugin URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Description: Bookly Service Package add-on allows you to sell services in package.
Version: 2.2
Author: Bookly
Author URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Text Domain: bookly
Domain Path: /languages
License: Commercial
*/

if ( ! function_exists( 'bookly_packages_loader' ) ) {
    include_once __DIR__ . '/autoload.php';

    BooklyPackages\Lib\Boot::up();
}