<?php
namespace BooklyRecurringAppointments\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\DataHolders\Booking as DataHolders;
use BooklyRecurringAppointments\Lib;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Lib
 */
class Local extends BooklyLib\Proxy\RecurringAppointments
{
    /**
     * @inheritdoc
     */
    public static function hideChildAppointments( $default, BooklyLib\CartItem $cart_item )
    {
        if (
            $cart_item->getSeriesUniqueId()
            && get_option( 'bookly_recurring_appointments_payment' ) === 'first'
            && ( ! $cart_item->getFirstInSeries() )
        ) {
            return true;
        }

        return $default;
    }

    /**
     * @inheritdoc
     */
    public static function cancelPayment( $payment_id )
    {
        $ca_list = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
            ->where( 'ca.payment_id', $payment_id )
            ->whereNot( 'ca.series_id', null )
            ->groupBy( 'ca.series_id' )
            ->find();

        foreach ( $ca_list as $ca ) {
            $ca->deleteCascade();
        }
    }

    /**
     * @inheritdoc
     */
    public static function sendRecurring(
        DataHolders\Series $series,
        DataHolders\Order $order,
        $codes_data = array(),
        $to_staff = true,
        $to_customer = true
    )
    {
        Lib\Notifications\Sender::sendRecurring( $series, $order, $codes_data, $to_staff, $to_customer );
    }
}