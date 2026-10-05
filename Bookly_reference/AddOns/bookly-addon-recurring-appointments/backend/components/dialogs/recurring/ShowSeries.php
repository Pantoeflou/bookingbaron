<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;

/**
 * Class ShowList
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class ShowSeries extends BooklyLib\Base\Component
{
    /**
     * Render show series dialog.
     */
    public static function render()
    {
        self::enqueueStyles( array(
            'bookly' => array( 'frontend/resources/css/ladda.min.css', )
        ) );

        self::enqueueScripts( array(
            'module' => array(
                'js/show_series.js' => array( 'jquery' ),
            ),
            'bookly' => array(
                'frontend/resources/js/spin.min.js'  => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js' => array( 'jquery' ),
            )
        ) );

        self::renderTemplate( 'show_series' );
    }
}