<?php
namespace BooklyStripe\Lib;

/**
 * Class Updates
 * @package BooklyStripe\Lib
 */
class Updater extends \Bookly\Lib\Base\Updater
{
    public function update_1_1()
    {
        add_option( 'bookly_stripe_increase', '0' );
        add_option( 'bookly_stripe_addition', '0' );
    }
}