<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col-sm-3 col-lg-2">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="bookly-show-step-repeat" class="bookly-js-show-step" data-target="bookly-step-4" <?php checked( get_option( 'bookly_recurring_appointments_enabled' ) ) ?>>
            <?php _e( 'Show Repeat step', 'bookly' ) ?>
        </label>
    </div>
</div>