<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment;

use Bookly\Lib as BooklyLib;

/**
 * Class Ajax
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment
 */
class Ajax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritdoc
     */
    protected static function permissions()
    {
        return array( '_default' => 'user' );
    }

    /**
     * Get schedule.
     */
    public static function getSchedule()
    {
        $datetime = self::parameter( 'datetime' );
        $until    = self::parameter( 'until' );
        $repeat   = self::parameter( 'repeat' );
        $params   = self::parameter( 'params', array() );
        $exclude  = self::parameter( 'exclude', array() );
        $extras   = (array) self::parameter( 'extras' );
        $duration = (int) self::parameter( 'duration' );
        $nop      = (int) self::parameter( 'nop' );

        $service_id  = (int) self::parameter( 'service_id' ) ?: null;
        $staff_id    = (int) self::parameter( 'staff_id' );
        $location_id = (int) self::parameter( 'location_id' ) ?: null;

        if ( ! BooklyLib\Utils\Common::isCurrentUserAdmin() ) {
            $staff = BooklyLib\Entities\Staff::query()
                ->where( 'wp_user_id', get_current_user_id() )
                ->fetchRow();
            $staff_id = $staff['id'];
        }

        if ( $service_id ) {
            if ( ! get_option( 'bookly_recurring_appointments_use_groups' ) && BooklyLib\Config::groupBookingActive() ) {
                $staff_service = BooklyLib\Entities\StaffService::query()
                    ->select( 'capacity_max' )
                    ->where( 'staff_id', $staff_id )
                    ->where( 'service_id', $service_id )
                    ->fetchRow();

                $nop = $staff_service['capacity_max'];
            }
        } else {
            // Custom service.
            $service = new BooklyLib\Entities\Service();
            $service->setDuration( $duration );
            BooklyLib\Entities\Service::putInCache( null, $service );
        }

        $chain_item = new BooklyLib\ChainItem();
        $chain_item
            ->setStaffIds( array( $staff_id ) )
            ->setServiceId( $service_id )
            ->setNumberOfPersons( $nop )
            ->setQuantity( 1 )
            ->setLocationId( $location_id );

        $max_extras_duration = 0;
        $max_extras = array();
        foreach ( $extras as $customer_extras ) {
            $duration = BooklyLib\Proxy\ServiceExtras::getTotalDuration( $customer_extras );
            if ( $max_extras_duration < $duration ) {
                $max_extras_duration = $duration;
                $max_extras = $customer_extras;
            }
        }
        $chain_item->setExtras( $max_extras );

        $chain = new BooklyLib\Chain();
        $chain->add( $chain_item );
        $scheduler = new BooklyLib\Scheduler( $chain, $datetime, $until, $repeat, $params, $exclude, false );

        wp_send_json_success( $scheduler->scheduleForBackend( self::parameter( 'with_options', 0 ) ) );
    }
}