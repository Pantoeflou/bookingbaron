<?php
namespace BooklyCoupons\Backend\Modules\Appearance\ProxyProviders;

use Bookly\Backend\Modules\Appearance\Proxy;

/**
 * Class Local
 * @package BooklyCoupons\Backend\Modules\Appearance\ProxyProviders
 */
class Local extends Proxy\Coupons
{
    /**
     * @inheritdoc
     */
    public static function renderCouponBlock()
    {
        self::renderTemplate( 'coupon_block' );
    }
    /**
     * @inheritdoc
     */
    public static function renderShowCoupons()
    {
        self::renderTemplate( 'show_coupons' );
    }
}