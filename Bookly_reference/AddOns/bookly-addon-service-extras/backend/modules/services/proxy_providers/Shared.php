<?php
namespace BooklyServiceExtras\Backend\Modules\Services\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Backend\Modules\Services\Proxy;
use BooklyServiceExtras\Backend\Modules\Services\Forms;
use BooklyServiceExtras\Lib;
use BooklyServiceExtras\Lib\Entities\ServiceExtra;

/**
 * Class Shared
 * @package BooklyServiceExtras\Backend\Modules\Services\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function renderServiceForm( array $service )
    {
        $service_id = $service['id'];
        $extras = BooklyLib\Proxy\ServiceExtras::findByServiceId( $service_id );
        $time_interval = get_option( 'bookly_gen_time_slot_length' );

        self::renderTemplate( 'extras', compact( 'service_id', 'extras', 'time_interval' ) );
    }

    /**
     * @inheritdoc
     */
    public static function renderAfterServiceList()
    {
        $list = self::getExtrasList();

        self::enqueueStyles( array(
            'bookly' => array(
                'backend/resources/bootstrap/css/bootstrap-theme.min.css',
                'backend/resources/css/typeahead.css',
            ),
        ) );

        self::enqueueScripts( array(
            'module' => array( 'js/extras.js' => array( 'jquery' ), ),
            'bookly' => array(
                'backend/resources/js/typeahead.bundle.min.js' => array( 'jquery' ),
            ),
        ) );

        wp_localize_script( 'bookly-extras.js', 'ExtrasL10n', array(
            'list' => $list,
        ) );

        self::renderTemplate( 'extras_blank' );
    }

    /**
     * @inheritdoc
     */
    public static function prepareUpdateServiceResponse( array $response, BooklyLib\Entities\Service $service, array $_post )
    {
        $service_extras = (array) Lib\ProxyProviders\Local::findByServiceId( $service->getId() );

        /** @var ServiceExtra[] $db_extras */
        $db_extras = array();
        foreach ( $service_extras as $extra ) {
            $db_extras[ $extra->getId() ] = $extra;
        }
        $new_extras = array();
        // Find id for new extras.
        if ( isset( $_post['extras'] ) ) {
            foreach ( $_post['extras'] as $_post_id => $_post_extra ) {
                if ( isset( $db_extras[ $_post_id ] ) ) {
                    unset( $db_extras[ $_post_id ] );
                } else {
                    foreach ( $db_extras as $id => $extra ) {
                        if ( $extra->getTitle() == $_post_extra['title']
                             && $extra->getPrice() == $_post_extra['price']
                             && $extra->getDuration() == $_post_extra['duration']
                        ) {
                            $new_extras[ $_post_id ] = $id;
                            unset( $db_extras[ $id ] );
                            break;
                        }
                    }
                }
            }
        }

        $response['new_extras_ids']  = $new_extras;
        $response['new_extras_list'] = self::getExtrasList();

        return $response;
    }

    /**
     * @inheritdoc
     */
    public static function updateService( array $alert, BooklyLib\Entities\Service $service, array $_post )
    {
        if ( isset( $_post['extras'] ) ) {
            foreach ( $_post['extras'] as $data ) {
                $form               = new Forms\ServiceExtra();
                $data['service_id'] = $service->getId();
                $form->bind( $data );
                $form->save();
            }
        }

        return $alert;
    }

    /**
     * @return array
     */
    protected static function getExtrasList()
    {
        $extras = ServiceExtra::query( 'e' )
            ->select( 'e.*, s.title as service_title' )
            ->leftJoin( 'Service', 's', 's.id = e.service_id', 'Bookly\Lib\Entities' )
            ->sortBy( 'title' )
            ->fetchArray();
        $list = array();

        foreach ( $extras as $extra ) {
            $list[ $extra['id'] ] = array(
                'attachment_id'      => $extra['attachment_id'],
                'image'              => wp_get_attachment_image_src( $extra['attachment_id'], 'thumbnail' ),
                'title'              => $extra['title'],
                'title_with_service' => sprintf( '%s (%s)', $extra['title'], $extra['service_title'] ),
                'duration'           => $extra['duration'],
                'price'              => $extra['price'],
                'max_quantity'       => $extra['max_quantity'],
            );
        }

        return $list;
    }

}