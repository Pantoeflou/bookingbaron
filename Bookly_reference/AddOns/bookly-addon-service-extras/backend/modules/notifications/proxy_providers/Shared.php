<?php
namespace BooklyServiceExtras\Backend\Modules\Notifications\ProxyProviders;

use Bookly\Backend\Modules\Notifications\Proxy;

/**
 * Class Shared
 * @package BooklyServiceExtras\Backend\Modules\Notifications\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareNotificationCodes( array $codes, $type )
    {
        $codes['customer_appointment']['extras']             = __( 'extras titles', 'bookly' );
        $codes['customer_appointment']['extras_total_price'] = __( 'extras total price', 'bookly' );

        return $codes;
    }
}