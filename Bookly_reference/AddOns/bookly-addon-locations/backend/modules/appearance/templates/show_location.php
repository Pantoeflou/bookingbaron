<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="col-md-3">
    <div class="checkbox">
        <label<?php if ( get_option( 'bookly_locations_allow_services_per_location' ) ) : ?> class="bookly-js-simple-popover" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="auto" data-content="<?php echo esc_attr( 'Custom settings for location enabled', 'bookly' ) ?>"<?php endif ?>>
            <input type="checkbox" id="bookly-show-location" <?php checked( get_option( 'bookly_locations_allow_services_per_location' ) || get_option( 'bookly_locations_enabled' ) ); disabled( get_option( 'bookly_locations_allow_services_per_location' ) ) ?>>
            <?php esc_html_e( 'Show location', 'bookly' ) ?>
        </label>
    </div>
</div>
