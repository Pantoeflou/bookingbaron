<?php
namespace BooklyCoupons\Frontend\Modules\Booking;

use Bookly\Lib as BooklyLib;
use Bookly\Frontend\Components\Booking\InfoText as BookingComponents;
use Bookly\Frontend\Modules\Booking\Lib\Steps;
use BooklyCoupons\Frontend\Modules\Booking\Lib\Errors;
use BooklyCoupons\Lib;

/**
 * Class Ajax
 * @package BooklyCoupons\Frontend\Modules\Booking
 */
class Ajax extends BooklyLib\Base\Ajax
{
    /**
     * @inheritdoc
     */
    protected static function permissions()
    {
        return array( '_default' => 'anonymous' );
    }

    /**
     * Apply coupon
     */
    public static function applyCoupon()
    {
        $response = null;
        $userData = new BooklyLib\UserBookingData( self::parameter( 'form_id' ) );

        if ( get_option( 'bookly_coupons_enabled' ) && $userData->load() ) {
            $coupon_code = self::parameter( 'coupon_code' );

            $coupon = new Lib\Entities\Coupon();
            $coupon->loadBy( array(
                'code' => $coupon_code,
            ) );

            $info_text_coupon_tpl = BooklyLib\Utils\Common::getTranslatedOption(
                BooklyLib\Config::showStepCart() && count( $userData->cart->getItems() ) > 1
                    ? 'bookly_l10n_info_coupon_several_apps'
                    : 'bookly_l10n_info_coupon_single_app'
            );

            do {
                $error = Errors::INVALID;
                // Check usage.
                if ( $coupon->isLoaded() && ! $coupon->fullyUsed() ) {
                    // Check start date.
                    if ( $coupon->started() ) {
                        // Check end date.
                        if ( ! $coupon->expired() ) {
                            // Check customer.
                            $customer = $userData->getCustomer();
                            if ( ( ! $customer->isLoaded() && ! $coupon->hasLimitForCustomer() ) || $coupon->validForCustomer( $customer ) ) {
                                // Check cart.
                                if ( $coupon->validForCart( $userData->cart ) ) {
                                    // Coupon is valid.
                                    $userData->setCouponCode( $coupon_code );
                                    $response = array( 'success' => true );
                                    break;
                                }
                            }
                        } else {
                            $error = Errors::EXPIRED;
                        }
                    }
                }
                // Coupon is invalid.
                $userData->setCouponCode( null );
                $response = array(
                    'success' => false,
                    'error'   => $error,
                    'text'    => BookingComponents::prepare( Steps::PAYMENT, $info_text_coupon_tpl, $userData ),
                );
            } while ( false );
        } else {
            $response = array( 'success' => false, 'error' => Errors::SESSION_ERROR );
        }

        // Output JSON response.
        wp_send_json( $response );
    }
}