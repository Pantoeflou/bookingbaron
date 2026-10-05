<?php
namespace BooklyCoupons\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;

/**
 * Class Shared
 * @package BooklyCoupons\Lib\ProxyProviders
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function preparePaymentDetails( $details, BooklyLib\DataHolders\Booking\Order $order, BooklyLib\CartInfo $cart_info )
    {
        $coupon = $cart_info->getCoupon();
        if ( $coupon ) {
            $details['coupon'] = array(
                'code'      => $coupon->getCode(),
                'discount'  => $coupon->getDiscount(),
                'deduction' => $coupon->getDeduction(),
            );
        }

        return $details;
    }
}