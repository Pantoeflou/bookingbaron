<?php
namespace BooklyRecurringAppointments\Backend\Modules\Appointments\ProxyProviders;

use Bookly\Backend\Modules\Appointments\Proxy;
use BooklyRecurringAppointments\Lib;
use BooklyRecurringAppointments\Backend\Components;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Appointments\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderAddOnsComponents()
    {
        Components\Dialogs\Recurring\ShowSeries::render();
    }
}