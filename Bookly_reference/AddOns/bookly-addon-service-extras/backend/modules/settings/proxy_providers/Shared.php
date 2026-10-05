<?php
namespace BooklyServiceExtras\Backend\Modules\Settings\ProxyProviders;

use Bookly\Backend\Modules\Settings\Proxy;
use Bookly\Backend\Components\Settings\Menu;
use Bookly\Backend\Components\Settings\Selects;

/**
 * Class Shared
 * @package BooklyServiceExtras\Backend\Modules\Settings\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderMenuItem()
    {
        Menu::renderItem( esc_html__( 'Service Extras', 'bookly' ), 'service_extras' );
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
    public static function prepareCalendarAppointmentCodes( array $codes, $participants )
    {
        if ( $participants == 'one' ) {
            $codes[] = array( 'code' => 'extras', 'description' => __( 'extras titles', 'bookly' ), );
            $codes[] = array( 'code' => 'extras_total_price', 'description' => __( 'extras total price', 'bookly' ), );
        }

        return $codes;
    }

    /**
     * @inheritdoc
     */
    public static function prepareWooCommerceCodes( array $codes )
    {
        $codes[] = array( 'code' => 'extras', 'description' => __( 'extras titles', 'bookly' ) );

        return $codes;
    }

    /**
     * @inheritdoc
     */
    public static function saveSettings( array $alert, $tab, array $params )
    {
        if ( $tab == 'service_extras' ) {
            if ( ! array_key_exists( 'bookly_service_extras_show', $params ) ) {
                $params['bookly_service_extras_show'] = array();
            }
            $options = array( 'bookly_service_extras_multiply_nop', 'bookly_service_extras_show', 'bookly_service_extras_after_step_time' );
            foreach ( $options as $option_name ) {
                if ( array_key_exists( $option_name, $params ) ) {
                    update_option( $option_name, $params[ $option_name ] );
                }
            }
            $alert['success'][] = __( 'Settings saved.', 'bookly' );
        }

        return $alert;
    }
}