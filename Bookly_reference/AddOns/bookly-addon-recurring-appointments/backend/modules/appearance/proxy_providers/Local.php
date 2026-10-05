<?php
namespace BooklyRecurringAppointments\Backend\Modules\Appearance\ProxyProviders;

use Bookly\Backend\Modules\Appearance\Proxy;
use BooklyRecurringAppointments\Lib;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Backend\Modules\Appearance\ProxyProviders
 */
class Local extends Proxy\RecurringAppointments
{
    /**
     * @inheritdoc
     */
    public static function renderInfoMessage()
    {
        self::renderTemplate( 'info_message' );
    }

    /**
     * @inheritdoc
     */
    public static function renderShowStep()
    {
        self::renderTemplate( 'show_repeat_step');
    }

    /**
     * @inheritdoc
     */
    public static function renderStep( $progress_tracker )
    {
        self::renderTemplate( 'repeat_step', compact( 'progress_tracker' ) );
    }
}