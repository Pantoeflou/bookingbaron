<?php
namespace BooklyRecurringAppointments\Frontend\Modules\Booking;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Scheduler;
use Bookly\Lib\DataHolders\Booking as DataHolders;
use BooklyRecurringAppointments\Lib\Notifications;

/**
 * Class Ajax
 * @package BooklyRecurringAppointments\Frontend\Modules\Booking
 */
class Ajax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritdoc
     */
    protected static function permissions()
    {
        return array( '_default' => 'anonymous' );
    }

    /**
     * Get Schedule for step Repeat on frontend.
     */
    public static function getCustomerSchedule()
    {
        $userData = new BooklyLib\UserBookingData( self::parameter( 'form_id' ) );
        if ( $userData->load() ) {
            $until    = self::parameter( 'until' );
            $repeat   = self::parameter( 'repeat' );
            $params   = self::parameter( 'params', array() );
            $slots    = $userData->getSlots();
            $datetime = $slots[0][2];

            $userData->setRepeatData( compact( 'repeat','until','params' ) );

            self::_getCustomerScheduleResponse( $userData, $datetime, $until, $repeat, $params );
        } else {
            wp_send_json_error();
        }
    }

    /**
     * Get Daily Schedule for editing.
     */
    public static function getDailyCustomerSchedule()
    {
        $userData = new BooklyLib\UserBookingData( self::parameter( 'form_id' ) );
        if ( $userData->load() ) {
            $date  = self::parameter( 'date' );
            self::_getCustomerScheduleResponse( clone $userData, $date . ' 00:00:00', $date, 'daily', array( 'every' => 1 ), self::parameter( 'exclude', array() ), true );
        } else {
            wp_send_json_error();
        }
    }

    /**
     * Approve the whole series schedule.
     */
    public static function approveSchedule()
    {
        $url   = get_option( 'bookly_recurring_appointments_approve_denied_page_url' );
        $token = BooklyLib\Utils\Common::xorDecrypt( self::parameter( 'token' ), 'approve' );

        // Find series.
        $series_entity = new BooklyLib\Entities\Series();
        $series_entity->loadBy( array( 'token' => $token ) );

        if ( $series_entity->isLoaded() ) {
            // Make sure there are no cancelled/rejected appointments in the series.
            $count = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
                ->leftJoin( 'Series', 's', 's.id = ca.series_id' )
                ->where( 's.token', $token )
                ->whereIn( 'ca.status', array(
                    BooklyLib\Entities\CustomerAppointment::STATUS_CANCELLED,
                    BooklyLib\Entities\CustomerAppointment::STATUS_REJECTED,
                ) )
                ->count();

            if ( $count == 0 ) {
                // Update status.
                $affected = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
                    ->update()
                    ->set( 'ca.status', BooklyLib\Entities\CustomerAppointment::STATUS_APPROVED )
                    ->leftJoin( 'Series', 's', 's.id = ca.series_id' )
                    ->where( 's.token', $token )
                    ->where( 'ca.status', BooklyLib\Entities\CustomerAppointment::STATUS_PENDING )
                    ->execute();

                if ( $affected > 0 ) {
                    // Find customers.
                    $ca_list = BooklyLib\Entities\CustomerAppointment::query( 'ca' )
                        ->leftJoin( 'Appointment', 'a', 'a.id = ca.appointment_id' )
                        ->leftJoin( 'Series', 's', 's.id = ca.series_id' )
                        ->where( 's.token', $token )
                        ->where( 'ca.status', BooklyLib\Entities\CustomerAppointment::STATUS_APPROVED )
                        ->sortBy( 'a.start_date' )
                        ->find();

                    /** @var DataHolders\Order[] $orders */
                    $orders = array();

                    /** @var BooklyLib\Entities\CustomerAppointment $ca */
                    foreach ( $ca_list as $i => $ca ) {
                        if ( ! isset ( $orders[ $ca->getCustomerId() ] ) ) {
                            $series = DataHolders\Series::create( $series_entity )->addItem( $i, DataHolders\Simple::create( $ca ) );
                            $orders[ $ca->getCustomerId() ] = DataHolders\Order::createFromItem( $series );
                        } else {
                            $orders[ $ca->getCustomerId() ]->getItem( 0 )->addItem( $i, DataHolders\Simple::create( $ca ) );
                        }
                    }

                    foreach ( $orders as $order ) {
                        Notifications\Sender::sendRecurring( $order->getItem( 0 ), $order );
                    }
                }

                $url = get_option( 'bookly_recurring_appointments_approve_page_url' );
            }
        }

        wp_redirect( $url );
        self::renderTemplate( 'redirection', compact( 'url' ) );
        exit ( 0 );
    }

    /**
     * @param BooklyLib\UserBookingData $userData
     * @param string $datetime Y-m-d H:i:s
     * @param string $until Y-m-d
     * @param string $repeat
     * @param array $params
     * @param array $exclude
     * @param bool $with_options
     */
    private static function _getCustomerScheduleResponse(
        BooklyLib\UserBookingData $userData,
        $datetime,
        $until,
        $repeat,
        array $params,
        array $exclude = array(),
        $with_options = false
    )
    {
        if ( get_option( 'bookly_recurring_appointments_use_groups' ) || ! BooklyLib\Config::groupBookingActive() ) {
            $chain = $userData->chain;
        } else {
            $chain          = new BooklyLib\Chain();
            $staff_capacity = array();
            foreach ( $userData->chain->getItems() as $item ) {
                $chain_item = clone $item;
                $staff_id   = current( $chain_item->getStaffIds() );
                if ( isset( $staff_capacity[ $staff_id ] )
                     && array_key_exists( $chain_item->getServiceId(), $staff_capacity[ $staff_id ] )
                ) {
                    // Exist capacity value
                } else {
                    $service = BooklyLib\Entities\Service::find( $chain_item->getServiceId() );

                    if ( $service->getType() == BooklyLib\Entities\Service::TYPE_SIMPLE ) {
                        $staff_service = BooklyLib\Entities\StaffService::query()
                            ->select( 'capacity_max' )
                            ->where( 'staff_id', $staff_id )
                            ->where( 'service_id', $chain_item->getServiceId() )
                            ->fetchRow();
                        $capacity      = $staff_service['capacity_max'];
                    } else {
                        $capacity = $service->getCapacityMax();
                    }
                    $staff_capacity[ $staff_id ][ $chain_item->getServiceId() ] = $capacity;
                }
                $chain_item->setNumberOfPersons( $staff_capacity[ $staff_id ][ $chain_item->getServiceId() ] );
                $chain->add( $chain_item );
            }
        }

        $scheduler = new Scheduler( $chain, $datetime, $until, $repeat, $params, $exclude, false );

        wp_send_json_success( $scheduler->scheduleForFrontend( $with_options ) );
    }

    /**
     * Override parent method to exclude actions from CSRF token verification.
     *
     * @param string $action
     * @return bool
     */
    protected static function csrfTokenValid( $action = null )
    {
        $excluded_actions = array(
            'approveSchedule',
        );

        return in_array( $action, $excluded_actions ) || parent::csrfTokenValid( $action );
    }
}