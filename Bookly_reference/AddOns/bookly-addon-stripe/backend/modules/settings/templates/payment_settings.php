<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Settings\Inputs;
use Bookly\Backend\Components\Settings\Payments;
use Bookly\Backend\Components\Settings\Selects;
?>

<div class="panel panel-default bookly-collapse" data-slug="bookly-addon-stripe">
    <div class="panel-heading">
        <i class="bookly-js-handle bookly-margin-right-sm bookly-icon bookly-icon-draghandle bookly-cursor-move ui-sortable-handle" title="<?php esc_attr_e( 'Reorder', 'bookly' ) ?>"></i>
        <a href="#bookly_pmt_stripe" class="panel-title" role="button" data-toggle="collapse">
            Stripe
        </a>
        <img class="pull-right" src="<?php echo plugins_url( 'frontend/resources/images/stripe.png', \BooklyStripe\Lib\Plugin::getMainFile() ) ?>">
    </div>
    <div id="bookly_pmt_stripe" class="panel-collapse collapse in">
        <div class="panel-body">
            <?php Selects::renderSingle( 'bookly_stripe_enabled' ) ?>
            <div class="bookly-stripe">
                <div class="form-group">
                    <h4><?php _e( 'Instructions', 'bookly' ) ?></h4>
                    <p>
                        <?php _e( 'If <b>Publishable Key</b> is provided then Bookly will use <a href="https://stripe.com/docs/stripe.js" target="_blank">Stripe.js</a><br/>for collecting credit card details.', 'bookly' ) ?>
                    </p>
                </div>
                <?php Inputs::renderText( 'bookly_stripe_secret_key', __( 'Secret Key', 'bookly' ) ) ?>
                <?php Inputs::renderText( 'bookly_stripe_publishable_key', __( 'Publishable Key', 'bookly' ) ) ?>
                <?php Payments::renderPriceCorrection( 'stripe' ) ?>
            </div>
        </div>
    </div>
</div>