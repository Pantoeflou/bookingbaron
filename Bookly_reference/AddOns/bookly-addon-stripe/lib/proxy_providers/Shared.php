<?php
namespace BooklyStripe\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use BooklyStripe\Lib\Plugin;

/**
 * Class Shared
 * @package BooklyStripe\Lib\ProxyProviders
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function showPaymentSpecificPrices( $show )
    {
        if ( ! $show && get_option( 'bookly_stripe_enabled' ) ) {
            return (float) get_option( 'bookly_stripe_increase' ) != 0 || (float) get_option( 'bookly_stripe_addition' ) != 0;
        }

        return $show;
    }

    /**
     * @inheritdoc
     */
    public static function applyGateway( BooklyLib\CartInfo $cart_info, $gateway )
    {
        if ( $gateway === BooklyLib\Entities\Payment::TYPE_STRIPE && get_option( 'bookly_stripe_enabled' ) ) {
            $cart_info->setGateway( $gateway );
        }

        return $cart_info;
    }
}