<?php
namespace BooklyRecurringAppointments\Lib;

use BooklyRecurringAppointments\Backend;
use BooklyRecurringAppointments\Frontend;

/**
 * Class Plugin
 * @package BooklyRecurringAppointments\Lib
 */
abstract class Plugin extends \Bookly\Lib\Base\Plugin
{
    protected static $prefix;
    protected static $title;
    protected static $version;
    protected static $slug;
    protected static $directory;
    protected static $main_file;
    protected static $basename;
    protected static $text_domain;
    protected static $root_namespace;
    protected static $embedded;

    /**
     * @inheritdoc
     */
    protected static function init()
    {
        // Init ajax.
        Backend\Components\Dialogs\Appointment\Ajax::init();
        Backend\Components\Dialogs\Recurring\DeleteSeriesAjax::init();
        Backend\Components\Dialogs\Recurring\ShowSeriesAjax::init();
        if ( get_option( 'bookly_recurring_appointments_enabled' ) ) {
            Frontend\Modules\Booking\Ajax::init();
        }

        // Init proxy.
        Backend\Components\Dialogs\Appointment\ProxyProviders\Local::init();
        Backend\Components\Dialogs\Appointment\ProxyProviders\Shared::init();
        Backend\Modules\Appearance\ProxyProviders\Local::init();
        Backend\Modules\Appearance\ProxyProviders\Shared::init();
        Backend\Modules\Appointments\ProxyProviders\Shared::init();
        Backend\Modules\Calendar\ProxyProviders\Shared::init();
        Backend\Modules\Notifications\ProxyProviders\Shared::init();
        Backend\Modules\Services\ProxyProviders\Shared::init();
        Backend\Modules\Settings\ProxyProviders\Shared::init();
        Backend\Modules\Sms\ProxyProviders\Shared::init();
        if ( get_option( 'bookly_recurring_appointments_enabled' ) ) {
            Frontend\Modules\Booking\ProxyProviders\Local::init();
            Frontend\Modules\Booking\ProxyProviders\Shared::init();
        }
        ProxyProviders\Local::init();
        ProxyProviders\Shared::init();
    }
}