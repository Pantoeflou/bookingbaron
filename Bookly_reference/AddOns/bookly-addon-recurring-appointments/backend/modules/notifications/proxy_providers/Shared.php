<?php
namespace BooklyRecurringAppointments\Backend\Modules\Notifications\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Notifications\Proxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Notifications\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderEmailNotifications( $form )
    {
        self::renderTemplate( 'list', compact ( 'form' ) );
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationCodes( array $codes, $type )
    {
        $codes['series']['appointment_schedule']   = __( 'recurring appointments schedule', 'bookly' );
        $codes['series']['appointment_schedule_c'] = __( 'recurring appointments schedule with cancel', 'bookly' );
        $codes['series']['approve_appointment_schedule_url'] = __( 'URL for approving the whole schedule', 'bookly' );
        $codes['series']['recurring_count']        = __( 'recurring appointments', 'bookly' );

        return $codes;
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationTypes( array $types )
    {
        $types['recurring'] = array(
            'client_pending_recurring_appointment',
            'staff_pending_recurring_appointment',
            'client_approved_recurring_appointment',
            'staff_approved_recurring_appointment',
            'client_cancelled_recurring_appointment',
            'staff_cancelled_recurring_appointment',
            'client_rejected_recurring_appointment',
            'staff_rejected_recurring_appointment',
        );

        if ( BooklyLib\Config::waitingListActive() ) {
            $types['recurring'][] = 'client_waitlisted_recurring_appointment';
            $types['recurring'][] = 'staff_waitlisted_recurring_appointment';
        }

        return $types;
    }

    /**
     * @inheritdoc
     */
    public static function buildNotificationCodesList( array $codes, $notification_type, array $codes_data )
    {
        switch ( $notification_type ) {
            case 'client_pending_recurring_appointment':
            case 'staff_pending_recurring_appointment':
            case 'client_approved_recurring_appointment':
            case 'staff_approved_recurring_appointment':
            case 'client_cancelled_recurring_appointment':
            case 'staff_cancelled_recurring_appointment':
            case 'client_rejected_recurring_appointment':
            case 'staff_rejected_recurring_appointment':
            case 'client_waitlisted_recurring_appointment':
            case 'staff_waitlisted_recurring_appointment':
                $codes = array_merge(
                    $codes_data['series'],
                    $codes_data['appointment'],
                    $codes_data['category'],
                    $codes_data['service'],
                    $codes_data['customer'],
                    $codes_data['customer_timezone'],
                    $codes_data['staff'],
                    $codes_data['payment'],
                    $codes_data['company']
                );
                break;
        }

        return $codes;
    }
}