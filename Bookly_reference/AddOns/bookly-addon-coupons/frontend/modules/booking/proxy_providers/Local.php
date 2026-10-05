<?php
namespace BooklyCoupons\Frontend\Modules\Booking\ProxyProviders;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Modules\Booking\Proxy;
use Bookly\Frontend\Components\Booking\InfoText;

/**
 * Class Local
 * @package BooklyCoupons\Frontend\Modules\Booking\ProxyProviders
 */
class Local extends Proxy\Coupons
{
    /**
     * @inheritdoc
     */
    public static function renderPaymentStep( BooklyLib\UserBookingData $userData )
    {
        $info_text_coupon_tpl = BooklyLib\Utils\Common::getTranslatedOption(
            count( $userData->cart->getItems() ) > 1
                ? 'bookly_l10n_info_coupon_several_apps'
                : 'bookly_l10n_info_coupon_single_app'
        );

        $info_text_coupon = InfoText::prepare( 7, $info_text_coupon_tpl, $userData );
        $coupon_code = $userData->getCouponCode();

        self::renderTemplate( 'coupon_block', compact( 'info_text_coupon', 'coupon_code' ) );
    }
}