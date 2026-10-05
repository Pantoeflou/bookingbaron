<?php
namespace BooklyServiceExtras\Backend\Components\Dialogs\Appointment\CustomerDetails\ProxyProviders;

use Bookly\Backend\Components\Dialogs\Appointment\CustomerDetails\Proxy;
use BooklyServiceExtras\Lib;

/**
 * Class Shared
 * @package BooklyServiceExtras\Backend\Components\Dialogs\Appointment\CustomerDetails\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderDetails()
    {
        $extras = Lib\ProxyProviders\Local::findAll();

        if ( ! empty ( $extras ) ) {
            self::renderTemplate( 'details', compact( 'extras' ) );
        }
    }
}