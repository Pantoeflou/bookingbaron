<?php
namespace BooklyPackages\Backend\Modules\Packages;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Entities;
use Bookly\Lib\Utils;
use Bookly\Lib\DataHolders;

/**
 * Class Controller
 *
 * @package BooklyPackages\Backend\Modules\Packages
 */
class Page extends BooklyLib\Base\Component
{
    /**
     * Render page.
     */
    public static function render()
    {
        /** @var \WP_Locale $wp_locale */
        global $wp_locale;

        self::enqueueStyles( array(
            'bookly' => array(
                'backend/resources/css/select2.min.css',
                'backend/resources/bootstrap/css/bootstrap-theme.min.css',
                'backend/resources/css/daterangepicker.css',
                'frontend/resources/css/ladda.min.css',
            ),
        ) );

        self::enqueueScripts( array(
            'bookly' => array(
                'backend/resources/bootstrap/js/bootstrap.min.js' => array( 'jquery' ),
                'backend/resources/js/datatables.min.js'          => array( 'jquery' ),
                'backend/resources/js/moment.min.js'              => array( 'jquery' ),
                'backend/resources/js/daterangepicker.js'         => array( 'jquery' ),
                'backend/resources/js/select2.full.min.js'        => array( 'jquery' ),
                'backend/resources/js/help.js'                    => array( 'jquery' ),
                'frontend/resources/js/spin.min.js'               => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js'              => array( 'jquery' ),
            ),
            'module' => array( 'js/packages.js' => array( 'jquery' ), ),
        ) );

        wp_localize_script( 'bookly-packages.js', 'BooklyPackagesL10n', array(
            'csrf_token'           => Utils\Common::getCsrfToken(),
            'new_package'          => __( 'New package', 'bookly' ),
            'edit_package'         => __( 'Edit package', 'bookly' ),
            'tomorrow'             => __( 'Tomorrow', 'bookly' ),
            'today'                => __( 'Today', 'bookly' ),
            'yesterday'            => __( 'Yesterday', 'bookly' ),
            'last_7'               => __( 'Last 7 days', 'bookly' ),
            'last_30'              => __( 'Last 30 days', 'bookly' ),
            'this_month'           => __( 'This month', 'bookly' ),
            'next_month'           => __( 'Next month', 'bookly' ),
            'custom_range'         => __( 'Custom range', 'bookly' ),
            'apply'                => __( 'Apply', 'bookly' ),
            'cancel'               => __( 'Cancel', 'bookly' ),
            'to'                   => __( 'To', 'bookly' ),
            'from'                 => __( 'From', 'bookly' ),
            'calendar'             => array(
                'longMonths'  => array_values( $wp_locale->month ),
                'shortMonths' => array_values( $wp_locale->month_abbrev ),
                'longDays'    => array_values( $wp_locale->weekday ),
                'shortDays'   => array_values( $wp_locale->weekday_abbrev ),
            ),
            'mjsDateFormat'        => Utils\DateTime::convertFormat( 'date', Utils\DateTime::FORMAT_MOMENT_JS ),
            'startOfWeek'          => (int) get_option( 'start_of_week' ),
            'are_you_sure'         => __( 'Are you sure?', 'bookly' ),
            'zeroRecords'          => __( 'No packages for selected period and criteria.', 'bookly' ),
            'scheduleAppointments' => __( 'Package schedule', 'bookly' ),
            'editPackage'          => __( 'Edit package', 'bookly' ),
            'processing'           => __( 'Processing...', 'bookly' ),
            'edit'                 => __( 'Edit', 'bookly' ),
            'filter'               => (array) get_user_meta( get_current_user_id(), 'bookly_packages_filter_packages_list', true ),
            'no_result_found'      => __( 'No result found', 'bookly' ),
        ) );

        // Filters data
        $staff_members = Entities\Staff::query( 's' )->select( 's.id, s.full_name' )->fetchArray();
        $customers     = Entities\Customer::query( 'c' )->select( 'c.id, c.full_name, c.first_name, c.last_name' )->fetchArray();
        $packages      = Entities\Service::query( 's' )->select( 's.id, s.title' )->where( 'type', Entities\Service::TYPE_PACKAGE )->fetchArray();
        $services      = Entities\Service::query( 's' )->select( 's.id, s.title' )->where( 'type', Entities\Service::TYPE_SIMPLE )->fetchArray();

        self::renderTemplate( 'index', compact( 'staff_members', 'customers', 'packages', 'services' ) );
    }
}