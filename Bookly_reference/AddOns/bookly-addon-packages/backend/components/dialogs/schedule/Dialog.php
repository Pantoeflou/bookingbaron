<?php
namespace BooklyPackages\Backend\Components\Dialogs\Schedule;

use Bookly\Lib as BooklyLib;

/**
 * Class Dialog
 * @package BooklyPackages\Backend\Components\Dialogs\Schedule
 */
class Dialog extends BooklyLib\Base\Component
{
    public static function render()
    {
        self::enqueueStyles( array(
            'bookly' => array(
                'backend/resources/css/jquery-ui-theme/jquery-ui.min.css',
                'frontend/resources/css/ladda.min.css',
            ),
        ) );

        self::enqueueScripts( array(
            'bookly' => array(
                'backend/resources/js/angular.min.js'           => array( 'jquery' ),
                'backend/resources/js/angular-ui-date-0.0.8.js' => array( 'bookly-angular.min.js' ),
                'backend/resources/js/moment.min.js'            => array( 'jquery' ),
                'backend/resources/js/help.js'                  => array( 'jquery' ),
                'frontend/resources/js/spin.min.js'             => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js'            => array( 'jquery' ),
            ),
            'module' => array(
                'js/package_schedule_dialog.js' => array( 'bookly-angular-ui-date-0.0.8.js', 'jquery-ui-datepicker' ),
            ),
        ) );

        wp_localize_script( 'bookly-package_schedule_dialog.js', 'BooklyL10nPackageScheduleDialog', array(
            'csrf_token' => BooklyLib\Utils\Common::getCsrfToken(),
            'minDate'    => BooklyLib\Utils\Common::isCurrentUserAdmin() ? null : 0,
            'maxDate'    => BooklyLib\Utils\Common::isCurrentUserAdmin() ? null : BooklyLib\Config::getMaximumAvailableDaysForBooking(),
            'ajaxurl'    => admin_url( 'admin-ajax.php' ),
        ) );

        self::renderTemplate( 'modal' );
    }
}