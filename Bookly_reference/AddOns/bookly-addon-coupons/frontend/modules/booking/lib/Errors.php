<?php
namespace BooklyCoupons\Frontend\Modules\Booking\Lib;

/**
 * Class Errors
 *
 * @package BooklyCoupons\Frontend\Modules\Booking\Lib
 */
abstract class Errors extends \Bookly\Frontend\Modules\Booking\Lib\Errors {

    const INVALID = 'invalid_coupon';
    const EXPIRED = 'expired_coupon';
}