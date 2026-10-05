<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;

/**
 * Class DeleteSeries
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class DeleteSeries extends BooklyLib\Base\Component
{
    /**
     * Render delete series dialog.
     */
    public static function render()
    {
        self::enqueueStyles( array(
            'bookly' => array( 'frontend/resources/css/ladda.min.css', )
        ) );

        self::enqueueScripts( array(
            'module' => array(
                'js/delete_series.js' => array( 'jquery' ),
            ),
            'bookly' => array(
                'frontend/resources/js/spin.min.js'  => array( 'jquery' ),
                'frontend/resources/js/ladda.min.js' => array( 'jquery' ),
            )
        ) );

        self::renderTemplate( 'delete_series' );
    }
}