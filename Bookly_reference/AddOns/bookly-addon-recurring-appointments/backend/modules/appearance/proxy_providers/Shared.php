<?php
namespace BooklyRecurringAppointments\Backend\Modules\Appearance\ProxyProviders;

use Bookly\Backend\Modules\Appearance\Proxy;
use BooklyRecurringAppointments\Lib;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Appearance\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareOptions( array $options_to_save, array $options )
    {
        $options_to_save = array_merge( $options_to_save, array_intersect_key( $options, array_flip( array (
            'bookly_recurring_appointments_enabled',
            'bookly_l10n_info_repeat_step',
            'bookly_l10n_label_repeat',
            'bookly_l10n_repeat',
            'bookly_l10n_repeat_another_time',
            'bookly_l10n_repeat_biweekly',
            'bookly_l10n_repeat_daily',
            'bookly_l10n_repeat_day',
            'bookly_l10n_repeat_days',
            'bookly_l10n_repeat_deleted',
            'bookly_l10n_repeat_every',
            'bookly_l10n_repeat_first',
            'bookly_l10n_repeat_first_in_cart_info',
            'bookly_l10n_repeat_fourth',
            'bookly_l10n_repeat_last',
            'bookly_l10n_repeat_monthly',
            'bookly_l10n_repeat_no_available_slots',
            'bookly_l10n_repeat_on',
            'bookly_l10n_repeat_on_week',
            'bookly_l10n_repeat_required_week_days',
            'bookly_l10n_repeat_schedule',
            'bookly_l10n_repeat_schedule_help',
            'bookly_l10n_repeat_schedule_info',
            'bookly_l10n_repeat_second',
            'bookly_l10n_repeat_specific',
            'bookly_l10n_repeat_third',
            'bookly_l10n_repeat_this_appointment',
            'bookly_l10n_repeat_until',
            'bookly_l10n_repeat_weekly',
            'bookly_l10n_step_repeat',
            'bookly_l10n_step_repeat_button_next',
            'bookly_l10n_repeat_or',
            'bookly_l10n_repeat_times',
        ) ) ) );

        return $options_to_save;
    }
}