<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/** @var Bookly\Lib\CartInfo $cart_info */
use Bookly\Lib\Utils;
?>
<div class="bookly-box bookly-list">
    <label>
        <input type="radio" class="bookly-payment" name="payment-method-<?php echo $form_id ?>" value="card" data-form="stripe" />
        <span><?php echo Utils\Common::getTranslatedOption( 'bookly_l10n_label_pay_ccard' ) ?>
            <?php if ( $show_price ) : ?>
                <span class="bookly-js-pay"><?php echo Utils\Price::format( $cart_info->getPayNow() ) ?></span>
            <?php endif ?>
        </span>
        <img src="<?php echo $url_cards_image ?>" alt="cards" />
    </label>
    <?php if ( get_option( 'bookly_stripe_publishable_key' ) != '' ) : ?>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <?php endif ?>
    <form class="bookly-stripe" style="display: none; margin-top: 15px;">
        <input type="hidden" id="publishable_key" value="<?php echo get_option( 'bookly_stripe_publishable_key' ) ?>">
        <?php Bookly\Frontend\Components\Booking\CardPayment::render() ?>
    </form>
</div>