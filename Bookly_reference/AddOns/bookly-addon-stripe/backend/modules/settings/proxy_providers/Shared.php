<?php
namespace BooklyStripe\Backend\Modules\Settings\ProxyProviders;

use Bookly\Backend\Modules\Settings\Proxy;
use BooklyStripe\Lib;

/**
 * Class Shared
 * @package BooklyStripe\Backend\Modules\Settings\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function preparePaymentGatewaySettings( $payment_data )
    {
        $payment_data[ Lib\Plugin::getSlug() ] = self::renderTemplate( 'payment_settings', array(), false );

        return $payment_data;
    }

    /**
     * @inheritdoc
     */
    public static function saveSettings( array $alert, $tab, array $params )
    {
        if ( $tab == 'payments' ) {
            $options = array(
                'bookly_stripe_enabled',
                'bookly_stripe_publishable_key',
                'bookly_stripe_secret_key',
                'bookly_stripe_increase',
                'bookly_stripe_addition',
            );
            foreach ( $options as $option_name ) {
                if ( array_key_exists( $option_name, $params ) ) {
                    update_option( $option_name, trim( $params[ $option_name ] ) );
                }
            }
        }
    }
}