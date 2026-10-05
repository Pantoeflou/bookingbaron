<?php
namespace BooklyServiceExtras\Backend\Modules\Services;

use Bookly\Lib as BooklyLib;
use BooklyServiceExtras\Lib\Entities;

/**
 * Class Ajax
 * @package BooklyServiceExtras\Backend\Modules\Services
 */
class Ajax extends BooklyLib\Base\Ajax
{
    /**
     * Update extras position.
     */
    public static function updateExtraPosition()
    {
        $order = (array) self::parameter( 'position' );

        foreach (  $order as $position => $extra_id ) {
            $extra = new Entities\ServiceExtra();
            $extra->load( $extra_id );
            $extra->setPosition( $position );
            $extra->save();
        }

        wp_send_json_success();
    }

    /**
     * Delete extras.
     */
    public static function deleteServiceExtra()
    {
        $extra = new Entities\ServiceExtra();
        $extra->setId( $_POST['id'] );
        $extra->delete();
        wp_send_json_success();
    }
}