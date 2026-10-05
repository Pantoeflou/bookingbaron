<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col-md-3">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="bookly-show-cart-extras" <?php checked( get_option( 'bookly_service_extras_show_in_cart' ) ) ?>>
            <?php _e( 'Show extras', 'bookly' ) ?>
        </label>
    </div>
</div>