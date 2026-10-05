<?php
namespace BooklyRecurringAppointments\Backend\Modules\Services\ProxyProviders;

use Bookly\Backend\Modules\Services\Proxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Services\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderServiceForm( array $service )
    {
        $frequencies = array( 'daily', 'weekly', 'biweekly', 'monthly' );
        $recurrence_frequencies = explode( ',', $service['recurrence_frequencies'] );

        self::renderTemplate( 'recurring', compact( 'service', 'recurrence_frequencies', 'frequencies' ) );
    }
}