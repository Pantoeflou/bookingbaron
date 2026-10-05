<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring;

use Bookly\Lib as BooklyLib;
use BooklyRecurringAppointments\Lib\Notifications;

/**
 * Class DeleteSeriesAjax
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Recurring
 */
class DeleteSeriesAjax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritdoc
     */
    protected static function permissions()
    {
        return array( '_default' => 'user' );
    }

    /**
     * Delete recurring appointment.
     */
    public static function deleteAppointment()
    {
        $query = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
            ->where( 'ca.series_id', self::parameter( 'series_id' ) );
        if ( self::parameter( 'what' ) === 'current-and-next' ) {
            $current = BooklyLib\Entities\Appointment::query( 'a' )
                ->select( 'a.start_date' )
                ->where( 'a.id', self::parameter( 'appointment_id' ) )
                ->fetchRow();
            if ( $current ) {
                $query->leftJoin( 'Appointment', 'a', 'a.id = ca.appointment_id' )->whereGte( 'a.start_date', $current['start_date'] );
            }
        }

        if ( ! BooklyLib\Utils\Common::isCurrentUserAdmin() ) {
            $query->leftJoin( 'Staff', 'st', 'st.id = a.staff_id' )->where( 'st.wp_user_id', get_current_user_id() );
        }

        /** @var BooklyLib\Entities\CustomerAppointment[] $customer_appointments */
        $customer_appointments = $query->find();

        if ( self::parameter( 'notify' ) ) {
            /** @var BooklyLib\DataHolders\Booking\Order[] $orders */
            $orders = array();
            foreach ( $customer_appointments as $i => $ca ) {
                switch ( $ca->getStatus() ) {
                    case BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED:
                    case BooklyLib\Entities\CustomerAppointment::STATUS_PENDING:
                        $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED );
                        break;
                    default:
                        $ca->setStatus( BooklyLib\Entities\CustomerAppointment::STATUS_CANCELLED );
                }

                $item = BooklyLib\DataHolders\Booking\Simple::create( $ca )
                    ->setAppointment( BooklyLib\Entities\Appointment::find( $ca->getAppointmentId() ) );
                if ( ! isset ( $orders[ $ca->getCustomerId() ] ) ) {
                    $series   = BooklyLib\DataHolders\Booking\Series::create( BooklyLib\Entities\Series::find( $ca->getSeriesId() ) );
                    $customer = BooklyLib\Entities\Customer::find( $ca->getCustomerId() );
                    $order    = BooklyLib\DataHolders\Booking\Order::create( $customer )->addItem( 0, $series );

                    $orders[ $ca->getCustomerId() ] = $order;
                }
                $orders[ $ca->getCustomerId() ]->getItem( 0 )->addItem( $i, $item );
            }

            foreach ( $orders as $order ) {
                Notifications\Sender::sendRecurring(
                    $order->getItem( 0 ),
                    $order,
                    array( 'cancellation_reason' => self::parameter( 'reason' ) )
                );
            }
        }

        foreach ( $customer_appointments as $ca ) {
            $ca->delete();
            $appointment = BooklyLib\Entities\Appointment::find( $ca->getAppointmentId() );
            if ( count( $appointment->getCustomerAppointments() ) == 0 ) {
                $appointment->delete();
            }
        }

        wp_send_json_success();
    }
}