<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col-md-3">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="bookly-show-coupons" class="bookly-js-show-coupons" <?php checked( get_option( 'bookly_coupons_enabled' ) ) ?>>
            <?php esc_html_e( 'Show coupons', 'bookly' ) ?>
        </label>
    </div>
</div>