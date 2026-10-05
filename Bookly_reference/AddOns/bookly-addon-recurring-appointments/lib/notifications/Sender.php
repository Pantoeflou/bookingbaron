<?php
namespace BooklyRecurringAppointments\Lib\Notifications;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\DataHolders\Booking as DataHolders;
use Bookly\Lib\Notifications\Codes;

/**
 * Class Sender
 * @package BooklyRecurringAppointments\Lib\Notifications
 */
abstract class Sender extends BooklyLib\Notifications\Sender
{
    /**
     * Send notifications for recurring appointment.
     *
     * @param DataHolders\Series $series
     * @param DataHolders\Order $order
     * @param array $codes_data
     * @param bool $to_staff
     * @param bool $to_customer
     */
    public static function sendRecurring(
        DataHolders\Series $series,
        DataHolders\Order $order,
        array $codes_data = array(),
        $to_staff = true,
        $to_customer = true
    )
    {
        $status = $series->getCA()->getStatus();
        $staff_email_notification  = $to_staff ? self::_getEmailNotification( 'staff', $status, true ) : false;
        $staff_sms_notification    = $to_staff ? self::_getSmsNotification( 'staff', $status, true ) : false;
        $client_email_notification = $to_customer ? self::_getEmailNotification( 'client', $status, true ) : false;
        $client_sms_notification   = $to_customer ? self::_getSmsNotification( 'client', $status, true ) : false;

        if ( $staff_email_notification || $staff_sms_notification || $client_email_notification || $client_sms_notification ) {
            $wp_locale      = self::_getWpLocale();
            // Set wp locale for staff,
            // reason - it was changed on front-end.
            self::_switchLocale( $wp_locale );

            // Prepare codes.
            $codes = Codes::createForOrder( $order, $series );
            if ( isset ( $codes_data['cancellation_reason'] ) ) {
                $codes->cancellation_reason = $codes_data['cancellation_reason'];
            }

            if ( $series->getStaff()->getVisibility() != 'archive' ) {
                // Notify staff by email.
                if ( $staff_email_notification ) {
                    self::_sendEmailToStaff( $staff_email_notification, $codes, $series->getStaff()->getEmail() );
                }
                // Notify staff by SMS.
                if ( $staff_sms_notification ) {
                    self::_sendSmsToStaff( $staff_sms_notification, $codes, $series->getStaff()->getPhone() );
                }
            }

            // Client Notification.
            if ( $client_email_notification || $client_sms_notification ) {
                $client_locale = $series->getCA()->getLocale() ?: $wp_locale;

                // Client locale.
                self::_switchLocale( $client_locale );
                $codes->refresh();

                // Client time zone offset.
                if ( $series->getCA()->getTimeZoneOffset() !== null ) {
                    $codes->appointment_start = $codes->appointment_start === null ? null : self::_applyTimeZone( $codes->appointment_start, $series->getCA() );
                    $codes->appointment_end   = $codes->appointment_start === null ? null : self::_applyTimeZone( $codes->appointment_end, $series->getCA() );
                    foreach ( $codes->schedule as &$row ) {
                        $row['start'] = self::_applyTimeZone( $row['start'], $series->getCA() );
                    }
                }

                // Notify client by email.
                if ( $client_email_notification ) {
                    self::_sendEmailToClient( $client_email_notification, $codes, $order->getCustomer()->getEmail() );
                }
                // Notify client by SMS.
                if ( $client_sms_notification ) {
                    self::_sendSmsToClient( $client_sms_notification, $codes, $order->getCustomer()->getPhone() );
                }

                // Restore locale.
                self::_switchLocale( $wp_locale );
            }
        }

        foreach ( $series->getItems() as $item ) {
            $ca = $item->getCA();
            if ( $ca->isJustCreated() ) {
                self::sendOnCACreated( $ca );
            } elseif ( $ca->isStatusChanged() ) {
                self::sendOnCAStatusChanged( $ca );
            }
        }
    }

    /**
     * Create ICS attachment.
     *
     * @param Codes $codes
     * @return bool|string
     */
    protected static function _createIcs( Codes $codes )
    {
        $ics = new ICS( $codes );

        return $ics->create();
    }
}