<?php
namespace BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\Edit\Proxy\Shared as AppointmentEditProxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Components\Dialogs\Appointment
 */
class Shared extends AppointmentEditProxy
{
    /**
     * @inheritdoc
     */
    public static function renderAppointmentDialogFooter()
    {
        self::renderTemplate( 'footer_buttons' );
    }
}