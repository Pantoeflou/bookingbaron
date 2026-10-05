<?php
namespace BooklyStripe\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;
use BooklyStripe\Lib;

/**
 * Class Shared
 * @package BooklyStripe\Frontend\Modules\Booking\ProxyProviders
 */
class Shared extends Proxy\Shared
{
    /**
     * @inheritdoc
     */
    public static function preparePaymentOptions( $options, $form_id, $show_price, BooklyLib\CartInfo $cart_info, $payment_status )
    {
        $cart_info->setGateway( BooklyLib\Entities\Payment::TYPE_STRIPE );
        $url_cards_image = plugins_url( 'frontend/resources/images/cards.png', BooklyLib\Plugin::getMainFile() );
        $options[ Lib\Plugin::getSlug() ] = self::renderTemplate(
            'payment_option',
            compact( 'form_id', 'url_cards_image', 'show_price', 'cart_info' ),
            false
        );

        return $options;
    }
}