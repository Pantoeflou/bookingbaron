<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Bookly Recurring Appointments (Add-on)
Plugin URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Description: Bookly Recurring Appointments add-on allows to create automatically repeated bookings at a custom repeat interval.
Version: 2.3
Author: Bookly
Author URI: https://www.booking-wp-plugin.com/?utm_source=bookly_admin&utm_medium=plugins_page&utm_campaign=plugins_page
Text Domain: bookly
Domain Path: /languages
License: Commercial
*/

if ( ! function_exists( 'bookly_recurring_appointments_loader' ) ) {
    include_once __DIR__ . '/autoload.php';

    BooklyRecurringAppointments\Lib\Boot::up();
}