<?php
namespace BooklyRecurringAppointments\Lib;

use Bookly\Lib\Entities\Notification;

/**
 * Class Updates
 * @package BooklyRecurringAppointments\Lib
 */
class Updater extends \Bookly\Lib\Base\Updater
{
    function update_2_2()
    {
        add_option( 'bookly_recurring_appointments_use_groups', '0' );
    }

    function update_1_9()
    {
        $this->addL10nOptions( array(
            'bookly_l10n_repeat_or'    => __( 'or',         'bookly' ),
            'bookly_l10n_repeat_times' => __( 'time(s)',    'bookly' ),
        ) );
    }

    function update_1_8()
    {
        $notifications = array(
            array(
                'gateway' => 'email',
                'type'    => 'client_waitlisted_recurring_appointment',
                'subject' =>  __( 'You have been added to waiting list for appointment', 'bookly' ),
                'message' => wpautop( __( "Dear {client_name}.\n\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\n\nPlease find the service schedule below.\n\n{appointment_schedule}\n\nThank you for choosing our company.\n\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ) ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'email',
                'type'    => 'staff_waitlisted_recurring_appointment',
                'subject' => __( 'New waiting list information', 'bookly' ),
                'message' => wpautop( __( "Hello.\n\nYou have new customer in the waiting list.\n\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ) ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'sms',
                'type'    => 'client_waitlisted_recurring_appointment',
                'subject' => '',
                'message' => __( "Dear {client_name}.\nThis is a confirmation that you have been added to the waiting list for {service_name} (x {recurring_count}).\nPlease find the service schedule below.\n{appointment_schedule}\nThank you for choosing our company.\n{company_name}\n{company_phone}\n{company_website}", 'bookly' ),
                'active'  => 1,
            ),
            array(
                'gateway' => 'sms',
                'type'    => 'staff_waitlisted_recurring_appointment',
                'subject' => '',
                'message' => __( "Hello.\nYou have new customer in the waiting list.\nService: {service_name} (x {recurring_count})\nSchedule:\n{appointment_schedule}\nClient name: {client_name}\nClient phone: {client_phone}\nClient email: {client_email}", 'bookly' ),
                'active'  => 1,
            ),
        );

        foreach ( $notifications as $data ) {
            $notification = new Notification( $data );
            $notification->save();
        }

        add_option( 'bookly_recurring_appointments_approve_page_url', home_url() );
        add_option( 'bookly_recurring_appointments_approve_denied_page_url', home_url() );
    }

    function update_1_2()
    {
        $this->addL10nOptions( array(
            'bookly_l10n_repeat_no_available_slots' => __( 'There are no available time slots for this day', 'bookly' ),
            'bookly_l10n_step_repeat_button_next'   => __( 'Next', 'bookly' ),
        ) );
    }

}