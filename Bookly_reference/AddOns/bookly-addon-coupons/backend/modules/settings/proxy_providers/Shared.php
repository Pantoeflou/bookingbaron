<?php
namespace BooklyCoupons\Backend\Modules\Settings\ProxyProviders;

use Bookly\Backend\Modules\Settings\Proxy;
use Bookly\Backend\Components\Settings\Menu;

/**
 * Class Shared
 * @package BooklyCoupons\Backend\Modules\Settings\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderMenuItem()
    {
        Menu::renderItem( esc_html__( 'Coupons', 'bookly' ), 'coupons' );
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
    public static function saveSettings( array $alert, $tab, array $params )
    {
        if ( $tab == 'coupons' ) {
            $options = array( 'bookly_coupons_default_code_mask' );
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