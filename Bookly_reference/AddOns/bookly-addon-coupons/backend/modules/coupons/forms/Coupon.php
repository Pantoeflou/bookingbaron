<?php
namespace BooklyCoupons\Backend\Modules\Coupons\Forms;

use BooklyCoupons\Lib;
use Bookly\Lib as BooklyLib;

/**
 * Class Coupon
 * @package BooklyCoupons\Backend\Modules\Coupons\Forms
 */
class Coupon extends BooklyLib\Base\Form
{
    protected static $entity_class = 'Coupon';
    protected static $namespace    = '\BooklyCoupons\Lib\Entities';

    public function configure()
    {
        $this->setFields( array(
            'id',
            'code',
            'discount',
            'deduction',
            'usage_limit',
            'once_per_customer',
            'date_limit_start',
            'date_limit_end',
            'min_appointments',
            'max_appointments',
        ) );
    }

}