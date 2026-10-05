<?php
namespace BooklyRecurringAppointments\Backend\Modules\Settings\ProxyProviders;

use Bookly\Backend\Modules\Settings\Proxy;
use Bookly\Backend\Components\Settings\Menu;
use Bookly\Backend\Components\Settings\Inputs;

/**
 * Class Shared
 * @package BooklyRecurringAppointments\Backend\Modules\Settings\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderMenuItem()
    {
        Menu::renderItem( esc_html__( 'Recurring Appointments', 'bookly' ), 'recurring_appointments' );
    }

    /**
     * @inheritdoc
     */
    public static function renderTab()
    {
        self::renderTemplate( 'settings_tab' );
    }

    /**
     * @inheritdoc
     */
    public static function renderUrlSettings()
    {
        Inputs::renderText( 'bookly_recurring_appointments_approve_page_url', __( 'Approve recurring appointment URL (success)', 'bookly' ), __( 'Set the URL of a page that is shown to staff after they successfully approved recurring appointment.', 'bookly' ) );
        Inputs::renderText( 'bookly_recurring_appointments_approve_denied_page_url', __( 'Approve recurring appointment URL (denied)', 'bookly' ), __( 'Set the URL of a page that is shown to staff when the approval of recurring appointment cannot be done (changed status, etc.).', 'bookly' ) );
    }

    /**
     * @inheritdoc
     */
    public static function saveSettings( array $alert, $tab, array $params )
    {
        if ( $tab == 'recurring_appointments' ) {
            $options = array(
                'bookly_recurring_appointments_payment',
                'bookly_recurring_appointments_use_groups',
            );
            foreach ( $options as $option_name ) {
                if ( array_key_exists( $option_name, $params ) ) {
                    update_option( $option_name, $params[ $option_name ] );
                }
            }
            $alert['success'][] = __( 'Settings saved.', 'bookly' );
        } else if ( $tab == 'url' ) {
            update_option( 'bookly_recurring_appointments_approve_page_url', $params['bookly_recurring_appointments_approve_page_url'] );
            update_option( 'bookly_recurring_appointments_approve_denied_page_url', $params['bookly_recurring_appointments_approve_denied_page_url'] );
        }

        return $alert;
    }
}