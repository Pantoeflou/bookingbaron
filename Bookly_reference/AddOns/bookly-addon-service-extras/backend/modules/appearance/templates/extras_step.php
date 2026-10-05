<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib\Utils\Price;
use Bookly\Backend\Components\Appearance\Codes;
use Bookly\Backend\Components\Appearance\Editable;
use Bookly\Backend\Modules\Appearance\Proxy;
?>
<div class="bookly-form">

    <!-- Progress Tracker-->
    <?php echo $progress_tracker ?>

    <div class="bookly-box">
        <?php Editable::renderText( 'bookly_l10n_info_extras_step', Codes::getHtml( 2 ) ) ?>
    </div>
    <div class="bookly-extra-step">
        <div class="bookly-box">
            <div class="bookly-extras-item">
                <div class="bookly-extras-thumb bookly-extras-selected">
                    <div><img style="margin-bottom: 8px" src="<?php echo plugins_url( 'bookly-addon-service-extras/backend/modules/appearance/resources/images/medical.png' ) ?>" /></div>
                    <span>Dental Care Pack</span>
                    <strong><?php echo Price::format( 90 ) ?></strong>
                </div>
            </div>
            <div class="bookly-extras-item">
                <div class="bookly-extras-thumb">
                    <div><img style="margin-bottom: 8px" src="<?php echo plugins_url( 'bookly-addon-service-extras/backend/modules/appearance/resources/images/teeth.png' ) ?>" /></div>
                    <span>Special Toothbrush</span>
                    <strong><?php echo Price::format( 15 ) ?></strong>
                </div>
            </div>
            <div class="bookly-extras-item">
                <div class="bookly-extras-thumb">
                    <div><img style="margin-bottom: 8px" src="<?php echo plugins_url( 'bookly-addon-service-extras/backend/modules/appearance/resources/images/tool.png' ) ?>" /></div>
                    <span>Natural Toothpaste</span>
                    <strong><?php echo Price::format( 10 ) ?></strong>
                </div>
            </div>
        </div>

        <div class="bookly-extras-summary bookly-js-extras-summary bookly-box"><?php _e( 'Summary', 'bookly' ) ?>: <?php echo Price::format( 350 ) ?> + <?php echo Price::format( 90 ) ?><span></span></div>
    </div>
    <div class="bookly-box bookly-nav-steps">
        <div class="bookly-back-step bookly-js-back-step bookly-btn">
            <?php Editable::renderString( array( 'bookly_l10n_button_back' ) ) ?>
        </div>
        <?php Proxy\Cart::renderButton() ?>
        <div class="<?php echo get_option( 'bookly_app_align_buttons_left' ) ? 'bookly-left' : 'bookly-right' ?>">
            <div class="bookly-next-step bookly-js-next-step bookly-btn">
                <?php Editable::renderString( array( 'bookly_l10n_step_extras_button_next' ) ) ?>
            </div>
        </div>
    </div>
</div>