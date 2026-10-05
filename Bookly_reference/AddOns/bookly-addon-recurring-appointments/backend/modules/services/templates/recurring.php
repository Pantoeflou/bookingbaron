<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="bookly-js-service bookly-js-service-simple bookly-js-service-collaborative bookly-js-service-compound bookly-margin-bottom-xs">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="bookly-recurring-appointments-<?php echo $service['id'] ?>"><?php _e( 'Repeat', 'bookly' ) ?></label>
                <p class="help-block"><?php _e( 'Allow this service to have recurring appointments.', 'bookly' ) ?></p>
                <select id="bookly-recurring-appointments-<?php echo $service['id'] ?>" class="form-control" name="recurrence_enabled">
                    <option value="0"><?php _e( 'Disabled', 'bookly' ) ?></option>
                    <option value="1" <?php selected( $service['recurrence_enabled'] ) ?>><?php _e( 'Enabled', 'bookly' ) ?></option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label><?php _e( 'Frequencies', 'bookly' ) ?></label><br/>
                <ul class="bookly-js-simple-dropdown bookly-js-frequencies"
                    data-icon-class="dashicons dashicons-calendar"
                    data-txt-select-all="<?php esc_attr_e( 'All', 'bookly' ) ?>"
                    data-txt-all-selected="<?php esc_attr_e( 'All', 'bookly' ) ?>"
                    data-txt-nothing-selected="<?php esc_attr_e( 'Nothing selected', 'bookly' ) ?>"
                >
                    <?php foreach ( $frequencies as $type ): ?>
                        <li data-input-name="recurrence_frequencies[]" data-value="<?php echo $type ?>" data-selected="<?php echo (int) in_array( $type, $recurrence_frequencies ) ?>">
                            <?php esc_html_e( ucfirst( $type ), 'bookly' ) ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>