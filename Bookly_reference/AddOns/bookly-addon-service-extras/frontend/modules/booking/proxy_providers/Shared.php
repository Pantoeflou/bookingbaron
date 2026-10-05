<?php
namespace BooklyServiceExtras\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;
use BooklyServiceExtras\Lib;

/**
 * Class Shared
 * @package BooklyServiceExtras\Frontend\Modules\Booking\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function enqueueBookingStyles( array $depends )
    {
        $version    = Lib\Plugin::getVersion();
        $bookly_url = plugins_url( '', Lib\Plugin::getMainFile() );
        wp_enqueue_style( 'bookly-extras', $bookly_url . '/frontend/modules/booking/resources/css/bookly-extras.css', array( 'bookly-main' ), $version );

        return $depends;
    }

    /**
     * @inheritdoc
     */
    public static function prepareChainItemInfoText( $data, BooklyLib\ChainItem $chain_item )
    {
        $titles = array();
        $extras = $chain_item->getExtras();
        if ( ! empty( $extras ) ) {
            foreach ( Lib\ProxyProviders\Local::findByIds( array_keys( $extras ) ) as $extra ) {
                $titles[] = Lib\Utils\Common::formatTitle( $extra->getTranslatedTitle(), $extras[ $extra->getId() ] );
            }
        }
        $data['extras'][] = implode( ', ', $titles );

        return $data;
    }

    /**
     * @inheritdoc
     */
    public static function prepareInfoTextCodes( array $info_text_codes, array $data )
    {
        if ( get_option( 'bookly_service_extras_enabled' ) ) {
            $titles = array();
            foreach ( $data['extras'] as $index => $extra ) {
                if ( get_option( 'bookly_service_extras_multiply_nop', 1 ) && isset ( $data['numbers_of_persons'][ $index ] ) && $data['numbers_of_persons'][ $index ] > 1 ) {
                    // Convert string Extras1, Extras2 to array ['5 × Extras1', '5 × Extras2']
                    $multiplier = $data['numbers_of_persons'][ $index ];
                    $titles[] = implode( ', ', array_map( function ( $extras_title ) use ( $multiplier ) { return $multiplier . ' × ' . $extras_title; }, array_map( 'trim', explode( ',', $extra ) ) ) );
                } else {
                    $titles[] = $extra;
                }
            }
            $info_text_codes['{extras}'] = '<b>' . implode( ', ', $titles ) . '</b>';
        }

        return $info_text_codes;
    }

    /**
     * @inheritdoc
     */
    public static function prepareCartItemInfoText( $data, BooklyLib\CartItem $cart_item )
    {
        if ( get_option( 'bookly_service_extras_enabled' ) ) {
            $titles = array();
            $extras = $cart_item->getExtras();
            if ( ! empty( $extras ) ) {
                foreach ( Lib\ProxyProviders\Local::findByIds( array_keys( $extras ) ) as $extra ) {
                    $titles[] = ( get_option( 'bookly_service_extras_multiply_nop', 1 ) && $cart_item->getNumberOfPersons() > 1 ? $cart_item->getNumberOfPersons() . ' × ' : '' ) . Lib\Utils\Common::formatTitle( $extra->getTranslatedTitle(), $extras[ $extra->getId() ] );
                }
            }
            $data['extras'][] = implode( ', ', $titles );
        }
        return $data;
    }

    /**
     * @inheritdoc
     */
    public static function renderCartItemInfo( BooklyLib\UserBookingData $userData, $cart_key, $positions, $desktop )
    {
        if ( get_option( 'bookly_service_extras_show_in_cart' ) ) {
            $cart_items = $userData->cart->getItems();
            $cart_item  = $cart_items[ $cart_key ];
            $template   = $desktop ? 'cart_extras' : 'cart_extras_mobile';
            $data       = array();
            $nop        = $cart_item->getNumberOfPersons();
            $extras_qty = $cart_item->getExtras();

            foreach ( BooklyLib\Proxy\ServiceExtras::findByIds( array_keys( $extras_qty ) ) as $extras ) {
                $quantity = $extras_qty[ $extras->getId() ];
                $data[]   = array(
                    'title'    => $extras->getTranslatedTitle(),
                    'quantity' => $quantity,
                    'price'    => BooklyLib\Utils\Price::format( $extras->getPrice() ),
                    'total'    => BooklyLib\Utils\Price::format( get_option( 'bookly_service_extras_multiply_nop' ) ? $nop * $quantity * $extras->getPrice() : $quantity * $extras->getPrice() ),
                );
            }

            self::renderTemplate( $template, compact( 'data', 'nop', 'positions', 'cart_key' ) );
        }
    }

    /**
     * @inheritdoc
     */
    public static function booklyFormOptions( array $bookly_options )
    {
        $bookly_options['skip_steps']['extras'] = ! get_option( 'bookly_service_extras_enabled' );
        $bookly_options['step_extras'] = get_option( 'bookly_service_extras_after_step_time' )
            ? 'after_step_time'
            : 'before_step_time';

        if ( $bookly_options['form_attributes']['hide_services'] ) {
            // Case when service is hidden on bookly form
            // if all sub services in Compound or Collaborate services without extras
            // we need to skip step extras.
            $defaults = BooklyLib\Session::getFormVar( $bookly_options['form_id'], 'defaults' );
            if ( $defaults['service_id'] ) {
                $service = BooklyLib\Entities\Service::find( $defaults['service_id'] );
                switch ( $service->getType() ) {
                    case BooklyLib\Entities\Service::TYPE_COMPOUND:
                    case BooklyLib\Entities\Service::TYPE_COLLABORATIVE:
                        foreach ( $service->getSubServices() as $item ) {
                            if ( count( $item->getExtras() ) == 0 ) {
                                $bookly_options['skip_steps']['extras'] = 1;
                                break;
                            }
                        }
                        break;
                    case BooklyLib\Entities\Service::TYPE_SIMPLE:
                        $bookly_options['skip_steps']['extras'] = count( $service->getExtras() ) == 0;
                        break;
                    case BooklyLib\Entities\Service::TYPE_PACKAGE:
                    default:
                }
            }
        }
        $bookly_options['skip_steps']['extras'] = (int) $bookly_options['skip_steps']['extras'];

        return $bookly_options;
    }
}