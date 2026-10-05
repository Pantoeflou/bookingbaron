<?php
namespace BooklyPro\Backend\Modules\Analytics;

use Bookly\Lib as BooklyLib;
use BooklyPro\Lib;

/**
 * Class Page
 * @package BooklyPro\Backend\Modules\Analytics
 */
class Page extends BooklyLib\Base\Component
{
    /**
     * Display page.
     */
    public static function render()
    {
        /** @var \WP_Locale $wp_locale */
        global $wp_locale;

        self::enqueueStyles( array(
            'bookly' => array(
                'backend/resources/bootstrap/css/bootstrap-theme.min.css',
                'backend/resources/css/jquery-ui-theme/jquery-ui.min.css',
                'backend/resources/css/select2.min.css',
                'backend/resources/css/daterangepicker.css',
                'frontend/resources/css/ladda.min.css',
            ),
        ) );

        self::enqueueScripts( array(
            'bookly' => array(
                'backend/resources/bootstrap/js/bootstrap.min.js' => array( 'jquery' ),
                'backend/resources/js/datatables.min.js' => array( 'jquery' ),
                'backend/resources/js/dropdown.js' => array( 'jquery' ),
                'backend/resources/js/help.js' => array( 'jquery' ),
                'backend/resources/js/moment.min.js' => array( 'jquery' ),
                'backend/resources/js/daterangepicker.js'  => array( 'jquery' ),
                'backend/resources/js/select2.full.min.js' => array( 'jquery' ),
                'frontend/resources/js/spin.min.js'  => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js' => array( 'jquery' ),
            ),
            'module' => array( 'js/analytics.js' => array( 'bookly-datatables.min.js', 'bookly-dropdown.js' ) )
        ) );

        wp_localize_script( 'bookly-analytics.js', 'BooklyL10n', array(
            'csrfToken'    => BooklyLib\Utils\Common::getCsrfToken(),
            'tomorrow'     => __( 'Tomorrow', 'bookly' ),
            'today'        => __( 'Today', 'bookly' ),
            'yesterday'    => __( 'Yesterday', 'bookly' ),
            'last7'        => __( 'Last 7 days', 'bookly' ),
            'last30'       => __( 'Last 30 days', 'bookly' ),
            'thisMonth'    => __( 'This month', 'bookly' ),
            'nextMonth'    => __( 'Next month', 'bookly' ),
            'customRange'  => __( 'Custom range', 'bookly' ),
            'apply'        => __( 'Apply', 'bookly' ),
            'cancel'       => __( 'Cancel', 'bookly' ),
            'to'           => __( 'To', 'bookly' ),
            'from'         => __( 'From', 'bookly' ),
            'calendar'     => array(
                'longMonths'  => array_values( $wp_locale->month ),
                'shortMonths' => array_values( $wp_locale->month_abbrev ),
                'longDays'    => array_values( $wp_locale->weekday ),
                'shortDays'   => array_values( $wp_locale->weekday_abbrev ),
            ),
            'mjsDateFormat' => BooklyLib\Utils\DateTime::convertFormat( 'date', BooklyLib\Utils\DateTime::FORMAT_MOMENT_JS ),
            'startOfWeek'   => (int) get_option( 'start_of_week' ),
            'zeroRecords'   => __( 'No appointments for selected period.', 'bookly' ),
            'processing'    => __( 'Processing...', 'bookly' ),
        ) );

        $dropdown_data = array(
            'service' => BooklyLib\Utils\Common::getServiceDataForDropDown( 's.type = "simple"' ),
            'staff'   => Lib\ProxyProviders\Local::getStaffDataForDropDown()
        );

        self::renderTemplate( 'index', compact( 'dropdown_data' ) );
    }
}