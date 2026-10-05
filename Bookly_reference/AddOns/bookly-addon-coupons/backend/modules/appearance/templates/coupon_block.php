<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Appearance\Codes;
use Bookly\Backend\Components\Appearance\Editable;
use Bookly\Lib as BooklyLib;
?>
<div class="bookly-js-payment-coupons"<?php if ( ! get_option( 'bookly_coupons_enabled' ) ) : ?> style="display: none;"<?php endif ?>>
    <div class="bookly-box bookly-js-payment-single-app">
        <?php Editable::renderText( 'bookly_l10n_info_coupon_single_app', Codes::getHtml( 7 ) ) ?>
    </div>
    <div class="bookly-box bookly-js-payment-several-apps" style="display:none">
        <?php Editable::renderText( 'bookly_l10n_info_coupon_several_apps', Codes::getHtml( 7, true ) ) ?>
    </div>

    <div class="bookly-box bookly-list">
        <?php Editable::renderString( array( 'bookly_l10n_label_coupon', ) ) ?>
        <div class="bookly-inline-block">
            <input class="bookly-user-coupon" type="text"/>
            <div class="bookly-btn bookly-inline-block">
                <?php Editable::renderString( array( 'bookly_l10n_button_apply', ) ) ?>
            </div>
        </div>
    </div>
</div>