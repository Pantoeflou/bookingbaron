<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
?>
<div class="modal fade" id="bookly-series-details-dialog" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'bookly' ) ?>"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title"><?php _e( 'Recurring appointments', 'bookly' ) ?></h2>
            </div>
            <div class="modal-body">
                <div class="bookly-loading"></div>
            </div>
            <div class="modal-footer">
                <?php Buttons::renderCustom( null, 'btn-default btn-lg', __( 'Close', 'bookly' ), array( 'data-dismiss' => 'modal' ) ) ?>
            </div>
        </div>
    </div>
</div>