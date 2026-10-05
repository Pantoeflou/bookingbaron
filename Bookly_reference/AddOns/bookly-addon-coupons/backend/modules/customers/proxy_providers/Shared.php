<?php
namespace BooklyCoupons\Backend\Modules\Customers\ProxyProviders;

use Bookly\Backend\Modules\Customers\Proxy;
use BooklyCoupons\Lib;

/**
 * Class Shared
 * @package BooklyCoupons\Backend\Modules\Customers\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function mergeCustomers( $target_id, array $ids )
    {
        Lib\Entities\CouponCustomer::query()
            ->update()
            ->set( 'customer_id', $target_id )
            ->whereIn( 'customer_id', $ids )
            ->execute();
    }
}