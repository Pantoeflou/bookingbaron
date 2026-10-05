<?php
namespace BooklyPackages\Backend\Components\Dialogs\Package;

use Bookly\Lib as BooklyLib;

/**
 * Class Dialog
 * @package BooklyPackages\Backend\Components\Dialogs\Package
 */
class Dialog extends BooklyLib\Base\Component
{
    public static function render()
    {
        self::enqueueStyles( array(
            'bookly' => array(
                'backend/resources/css/select2.min.css',
                'backend/resources/css/jquery-ui-theme/jquery-ui.min.css',
                'frontend/resources/css/ladda.min.css',
            ),
        ) );

        self::enqueueScripts( array(
            'bookly' => array(
                'backend/resources/js/angular.min.js'           => array( 'jquery' ),
                'backend/resources/js/angular-ui-date-0.0.8.js' => array( 'bookly-angular.min.js' ),
                'backend/resources/js/moment.min.js'            => array( 'jquery' ),
                'backend/resources/js/select2.full.min.js'      => array( 'jquery' ),
                'backend/resources/js/help.js'                  => array( 'jquery' ),
                'frontend/resources/js/spin.min.js'             => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js'            => array( 'jquery' ),
            ),
            'module' => array(
                'js/package_dialog.js' => array( 'bookly-angular-ui-date-0.0.8.js', 'jquery-ui-datepicker' ),
            ),
        ) );

        self::renderTemplate( 'modal' );
    }
}