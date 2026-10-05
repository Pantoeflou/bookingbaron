<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Bookly Coupons (Add-on)
Plugin URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Description: Bookly Coupons add-on allows you to provide discounts to your customers via coupon codes.
Version: 1.7
Author: Bookly
Author URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Text Domain: bookly
Domain Path: /languages
License: Commercial
*/

if ( ! function_exists( 'bookly_coupons_loader' ) ) {
    include_once __DIR__ . '/autoload.php';

    BooklyCoupons\Lib\Boot::up();
}