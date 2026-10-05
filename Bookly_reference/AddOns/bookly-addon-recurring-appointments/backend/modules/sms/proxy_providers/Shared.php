<?php
namespace BooklyRecurringAppointments\Backend\Modules\Sms\ProxyProviders;

use Bookly\Backend\Modules\Sms\Proxy\Shared as SmsProxy;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Sms
 */
class Shared extends SmsProxy
{
    /**
     * @inheritdoc
     */
    public static function renderSmsNotifications( $form )
    {
        self::renderTemplate( 'list', compact ( 'form' ) );
    }
}