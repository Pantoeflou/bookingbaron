<?php
namespace BooklyCoupons\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use BooklyCoupons\Lib;
use BooklyCoupons\Backend\Modules\Coupons\Page;

/**
 * Class Local
 * @package BooklyCoupons\Lib\ProxyProviders
 */
class Local extends BooklyLib\Proxy\Coupons
{
    /**
     * @inheritdoc
     */
    public static function addBooklyMenuItem()
    {
        add_submenu_page(
            'bookly-menu',
            __( 'Coupons', 'bookly' ),
            __( 'Coupons', 'bookly' ),
            'manage_options',
            Page::pageSlug(),
            function () { Page::render(); }
        );
    }

    /**
     * @inheritdoc
     */
    public static function findOneByCode( $code )
    {
        return Lib\Entities\Coupon::query()->where( 'code', $code )->findOne();
    }
}