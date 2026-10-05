<?php
namespace BooklyStripe\Backend\Modules\Payments\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Payments\Proxy;

/**
 * Class Shared
 * @package BooklyStripe\Backend\Modules\Payments\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function paymentSpecificPriceExists( $gateway )
    {
        if ( $gateway === BooklyLib\Entities\Payment::TYPE_STRIPE && get_option( 'bookly_stripe_enabled' ) ) {
            return get_option( 'bookly_stripe_increase' ) != 0
                || get_option( 'bookly_stripe_addition' ) != 0;
        }

        return $gateway;
    }
}