<?php
namespace BooklyRecurringAppointments\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;
use Bookly\Lib\Scheduler;

/**
 * Class Local
 * @package BooklyRecurringAppointments\Frontend\Modules\Booking
 */
class Local extends Proxy\RecurringAppointments
{
    /**
     * @inheritdoc
     */
    public static function getStepHtml( BooklyLib\UserBookingData $userData, $show_cart_btn, $info_text, $progress_tracker )
    {
        /** @global $wp_locale */
        global $wp_locale;

        // Available days and times.
        $services   = array();
        $days_times = BooklyLib\Config::getDaysAndTimes();

        $freq_collection = array();
        foreach ( $userData->chain->getItems() as $chain_item ) {
            $service_id = $chain_item->getService()->getId();
            $services[ $service_id ] = 1;

            if ( $chain_item->getService()->getRecurrenceEnabled() ) {
                $frequencies = explode( ',', $chain_item->getService()->getRecurrenceFrequencies() );
                foreach ( $frequencies as $type ) {
                    $freq_collection[ $type ][ $service_id ] = 1;
                }
            } else {
                $freq_collection = array();
                break;
            }
        }

        // Create a frequency list that satisfies the requirements of the recurring services
        // (frequency - daily, weekly, biweekly, monthly)
        // Example:
        //  Service 1 -> only daily
        //  Service 2 -> only weekly
        // => $recurrence_frequencies = array( 'weekly' );
        $frequencies     = array();
        if ( $freq_collection ) {
            $services_count = count( $services );
            $exists_less = false;
            $current = null;
            foreach ( array( 'daily', 'weekly', 'biweekly', 'monthly' ) as $type ) {
                if ( isset( $freq_collection[ $type ] ) ) {
                    $current = $type;
                    if ( count( $freq_collection[ $current ] ) == $services_count ) {
                        $frequencies[ $current ] = true;
                        $exists_less = true;
                    } elseif ( $exists_less ) {
                        $frequencies[ $current ] = true;
                    }
                }
            }
            if ( empty( $frequencies ) ) {
                $frequencies = array( $current => true );
            }
        }
        $slots     = $userData->getSlots();
        $until     = date_create( $slots[0][2] )->modify( '+1 month' )->format( 'Y-m-d' );
        $day       = (int) date( 'N', strtotime( $slots[0][2] ) );
        $day_index = ( $day === 7 ) ? 1 : $day + 1;
        $weekdays  = array( 1 => 'sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', );
        $week      = array();
        foreach ( $days_times['days'] as $index => $abbrev ) {
            $week['full'][ $weekdays[ $index ] ]    = $wp_locale->weekday[ $index < 8 ? $index - 1 : 0 ];
            $week['abbrev'][ $weekdays[ $index ] ]  = $wp_locale->weekday_abbrev[ $week['full'][ $weekdays[ $index ] ] ];
            $week['checked'][ $weekdays[ $index ] ] = $index === $day_index;
        }

        return self::renderTemplate( 'step_repeat', compact( 'frequencies', 'show_cart_btn', 'info_text', 'progress_tracker', 'week', 'until' ), false );
    }

    /**
     * @inheritdoc
     */
    public static function buildSchedule( BooklyLib\UserBookingData $userData, $start_time, $end_time, $repeat, array $params, array $slots )
    {
        $scheduler = new Scheduler( $userData->chain, $start_time, $end_time, $repeat, $params, array() );

        return $scheduler->build( $slots );
    }

    /**
     * @inheritdoc
     */
    public static function renderInfoMessage( BooklyLib\UserBookingData $userData )
    {
        if ( get_option( 'bookly_recurring_appointments_payment' ) === 'first' ) {
            foreach ( $userData->cart->getItems() as $cart_key => $cart_item ) {
                if ( $cart_item->getSeriesUniqueId() && ( !$cart_item->getFirstInSeries() ) ) {
                    $info_msg = BooklyLib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_first_in_cart_info' );
                    if ( $info_msg != '' ) {
                        self::renderTemplate( '_info_message', compact( 'info_msg' ) );
                    }
                    break;
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function canBeRepeated( $default, BooklyLib\UserBookingData $userData )
    {
        $edit_cart_keys = $userData->getEditCartKeys();
        if ( count( $edit_cart_keys ) === 1 ) {
            $items = $userData->cart->getItems();
            $series_id = $items[ $edit_cart_keys[ 0 ] ]->getSeriesUniqueId();
            if ( $series_id ) {
                $count_in_series = 0;
                foreach ( $items as $item ) {
                    if ( $item->getSeriesUniqueId() === $series_id ) {
                        $count_in_series++;
                    }
                }
                if ( $count_in_series > 1 ) {
                    $default = false;
                }
            }
        }

        return $default;
    }
}