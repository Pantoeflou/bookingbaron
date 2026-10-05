<?php
namespace BooklyPackages\Lib\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Lib\Entities\Notification;

/**
 * Class Shared
 * @package BooklyPackages\Lib\Shared
 */
class Shared extends BooklyLib\Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareNotificationTitles( array $titles )
    {
        $titles[ Notification::TYPE_NEW_PACKAGE ]     = __( 'Notification about new package creation', 'bookly' );
        $titles[ Notification::TYPE_PACKAGE_DELETED ] = __( 'Notification about package deletion', 'bookly' );

        return $titles;
    }

    /**
     * @inheritdoc
     */
    public static function prepareNotificationTypes( array $types, $gateway )
    {
        $types[] = Notification::TYPE_NEW_PACKAGE;
        $types[] = Notification::TYPE_PACKAGE_DELETED;

        return $types;
    }

}