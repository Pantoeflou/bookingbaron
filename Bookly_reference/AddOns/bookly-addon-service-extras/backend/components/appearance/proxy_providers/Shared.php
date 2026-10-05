<?php
namespace BooklyServiceExtras\Backend\Components\Appearance\ProxyProviders;

use Bookly\Backend\Components\Appearance\Proxy;

/**
 * Class Shared
 * @package BooklyServiceExtras\Backend\Modules\Appearance\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function prepareCodes( array $codes )
    {
        return array_merge( $codes, array(
            array( 'code' => 'extras', 'description' => __( 'extras titles', 'bookly' ), 'flags' => array( 'step' => '>2' ) ),
        ) );
    }

}