<?php
namespace BooklyRecurringAppointments\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Utils;
use Bookly\Lib\Notifications\Codes;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Lib\ProxyProviders
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareNotificationCodesForOrder( Codes $codes )
    {
        /** @var BooklyLib\DataHolders\Booking\Series $item */
        $item = $codes->getItem();
        if ( $item->isSeries() ) {
            $schedule = array();
            foreach ( $item->getItems() as $sub_item ) {
                $schedule[] = array(
                    'start'      => $sub_item->getAppointment()->getStartDate(),
                    'end'        => $sub_item->getAppointment()->getEndDate(),
                    'token'      => $sub_item->getCA()->getToken(),
                    'duration'   => $sub_item->getService()->getDuration(),
                    'start_info' => $sub_item->getService()->getStartTimeInfo(),
                );
            }
            $codes->schedule     = $schedule;
            $codes->series_token = $item->getSeries()->getToken();
        }
    }

    /**
     * @inheritdoc
     */
    public static function prepareReplaceCodes( array $codes, Codes $notification_codes, $format )
    {
        if ( is_array( $notification_codes->schedule ) ) {
            $schedule = $schedule_c = '';
            $position = 1;
            foreach ( $notification_codes->schedule as $appointment ) {
                $date       = Utils\DateTime::formatDate( $appointment['start'] );
                $time       = $appointment['duration'] < DAY_IN_SECONDS ? Utils\DateTime::formatTime( $appointment['start'] ) : $appointment['start_info'];
                $cancel_url = admin_url( 'admin-ajax.php?action=bookly_cancel_appointment&token=' . $appointment['token'] );
                if ( $format == 'html' ) {
                    $schedule_c .= sprintf( '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $position, $date, $time, $cancel_url );
                    $schedule   .= sprintf( '<tr><td>%s</td><td>%s</td><td>%s</td></tr>', $position, $date, $time );
                } else {
                    $schedule_c .= sprintf( '%s. %s %s %s %s', $position, $date, __( 'at', 'bookly' ), $time, $cancel_url ) . PHP_EOL;
                    $schedule   .= sprintf( '%s. %s %s %s', $position, $date, __( 'at', 'bookly' ), $time ) . PHP_EOL;
                }
                $position ++;
            }
            if ( $format == 'html' ) {
                $codes['{appointment_schedule}']   = '<table>' . $schedule . '</table>';
                $codes['{appointment_schedule_c}'] = '<table>' . $schedule_c . '</table>';
            } else {
                $codes['{appointment_schedule}']   = $schedule;
                $codes['{appointment_schedule_c}'] = $schedule_c ;
            }
            $codes['{recurring_count}'] = count( $notification_codes->schedule );
            $codes['{approve_appointment_schedule_url}'] = admin_url(
                'admin-ajax.php?action=bookly_recurring_appointments_approve_schedule&token=' .
                urlencode( Utils\Common::xorEncrypt( $notification_codes->series_token, 'approve' ) )
            );
        } else {
            $codes['{appointment_schedule}']             = '';
            $codes['{appointment_schedule_c}']           = '';
            $codes['{recurring_count}']                  = '';
            $codes['{approve_appointment_schedule_url}'] = '';
        }

        return $codes;
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationNames( array $names )
    {
        $names['client_pending_recurring_appointment']    = __( 'Notification to customer about pending recurring appointment', 'bookly' );
        $names['staff_pending_recurring_appointment']     = __( 'Notification to staff member about pending recurring appointment', 'bookly' );
        $names['client_approved_recurring_appointment']   = __( 'Notification to customer about approved recurring appointment', 'bookly' );
        $names['staff_approved_recurring_appointment']    = __( 'Notification to staff member about approved recurring appointment', 'bookly' );
        $names['client_cancelled_recurring_appointment']  = __( 'Notification to customer about cancelled recurring appointment', 'bookly' );
        $names['staff_cancelled_recurring_appointment']   = __( 'Notification to staff member about cancelled recurring appointment ', 'bookly' );
        $names['client_rejected_recurring_appointment']   = __( 'Notification to customer about rejected recurring appointment', 'bookly' );
        $names['staff_rejected_recurring_appointment']    = __( 'Notification to staff member about rejected recurring appointment ', 'bookly' );
        $names['client_waitlisted_recurring_appointment'] = __( 'Notification to customer about placing on waiting list for recurring appointment', 'bookly' );
        $names['staff_waitlisted_recurring_appointment']  = __( 'Notification to staff member about placing on waiting list for recurring appointment ', 'bookly' );

        return $names;
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationTypeIds( array $type_ids )
    {
        $type_ids['client_pending_recurring_appointment']    = 31;
        $type_ids['staff_pending_recurring_appointment']     = 32;
        $type_ids['client_approved_recurring_appointment']   = 33;
        $type_ids['staff_approved_recurring_appointment']    = 34;
        $type_ids['client_cancelled_recurring_appointment']  = 35;
        $type_ids['staff_cancelled_recurring_appointment']   = 36;
        $type_ids['client_rejected_recurring_appointment']   = 37;
        $type_ids['staff_rejected_recurring_appointment']    = 38;
        $type_ids['client_waitlisted_recurring_appointment'] = 39;
        $type_ids['staff_waitlisted_recurring_appointment']  = 40;

        return $type_ids;
    }

    /**
     * @inheritdoc
     */
    public static function prepareTestNotificationCodes( Codes $codes )
    {
        $start_date = date_create()->modify( '-1 month' );
        $schedule   = array(
            array(
                'start' => $start_date->format( 'Y-m-d 12:00:00' ),
                'token' => null,
            ),
            array(
                'start' => $start_date->modify( '1 day' )->format( 'Y-m-d 14:00:00' ),
                'token' => null,
            ),
            array(
                'start' => $start_date->modify( '1 day' )->format( 'Y-m-d 12:00:00' ),
                'token' => null,
            ),
        );
        $codes->schedule = $schedule;

        return $codes;
    }
}