<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
?>
<div id="bookly-delete-recurring-appointment-dialog" class="modal fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="modal-title h2"><?php _e( 'Delete Appointment', 'bookly' ) ?></div>
            </div>
            <div class="modal-body">
                <div class="radio">
                    <label>
                        <input type="radio" name="delete-series" value="" checked />
                        <?php _e( 'Delete only this appointment', 'bookly' ) ?>
                    </label>
                    <br>
                    <label class="bookly-margin-top-sm">
                        <input type="radio" name="delete-series" value="current-and-next" class="bookly-js-delete-series" />
                        <?php _e( 'Delete this and the following appointments', 'bookly' ) ?>
                    </label>
                    <br>
                    <label class="bookly-margin-top-sm">
                        <input type="radio" name="delete-series" value="series" class="bookly-js-delete-series" />
                        <?php _e( 'Delete all appointments in series', 'bookly' ) ?>
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input class="bookly-js-recurring-notify" type="checkbox" />
                        <?php _e( 'Send notifications', 'bookly' ) ?>
                    </label>
                </div>
                <div class="form-group" style="display: none;">
                    <input class="form-control bookly-js-delete-reason" type="text" placeholder="<?php _e( 'Cancellation reason (optional)', 'bookly' ) ?>" />
                </div>
            </div>
            <div class="modal-footer">
                <?php Buttons::renderCustom( null, 'bookly-js-series-delete btn-lg btn-success', __( 'Delete', 'bookly' ) ) ?>
                <?php Buttons::renderCustom( null, 'btn-lg btn-default', __( 'Cancel', 'bookly' ), array( 'data-dismiss' => 'modal' ) ) ?>
            </div>
        </div>
    </div>
</div>