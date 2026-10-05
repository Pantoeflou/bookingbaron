<?php
namespace BooklyServiceExtras\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Components\Dialogs\Appointment\Edit;

/**
 * Class Shared
 * @package BooklyFiles\Backend\Components\Dialogs\Appointment\Edit\ProxyProviders
 */
class Shared extends Edit\Proxy\Shared
{
    /**
     * Enqueue assets for AppointmentForm
     */
    public static function enqueueAssets()
    {
        self::enqueueScripts( array(
            'module' => array(
                'js/service-extras-customer-details.js' => array()
            ),
        ) );
    }
}