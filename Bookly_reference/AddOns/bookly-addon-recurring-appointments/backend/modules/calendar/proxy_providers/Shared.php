<?php
namespace BooklyRecurringAppointments\Backend\Modules\Calendar\ProxyProviders;

use Bookly\Backend\Modules\Calendar\Proxy;
use BooklyRecurringAppointments\Lib;
use BooklyRecurringAppointments\Backend\Components;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Calendar\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderAddOnsComponents()
    {
        Components\Dialogs\Recurring\DeleteSeries::render();
        Components\Dialogs\Recurring\ShowSeries::render();
    }
}