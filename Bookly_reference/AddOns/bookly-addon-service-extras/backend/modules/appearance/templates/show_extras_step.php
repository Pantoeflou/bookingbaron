<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col-sm-3 col-lg-2">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="bookly-show-step-extras" class="bookly-js-show-step" data-target="bookly-step-2" <?php checked( get_option( 'bookly_service_extras_enabled' ) ) ?>>
            <?php _e( 'Show Extras step', 'bookly' ) ?>
        </label>
    </div>
</div>