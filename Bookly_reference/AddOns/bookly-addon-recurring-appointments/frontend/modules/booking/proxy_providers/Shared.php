<?php
namespace BooklyRecurringAppointments\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;
use BooklyRecurringAppointments\Lib;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Frontend\Modules\Booking\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function enqueueBookingScripts( array $depends )
    {
        $version    = Lib\Plugin::getVersion();
        $bookly_url = plugins_url( '', BooklyLib\Plugin::getMainFile() );
        wp_enqueue_script( 'bookly-recurring', $bookly_url . '/backend/resources/js/moment.min.js', array(), $version );

        return $depends;
    }
}