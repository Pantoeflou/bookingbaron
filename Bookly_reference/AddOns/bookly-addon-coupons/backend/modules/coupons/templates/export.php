<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
use Bookly\Backend\Components\Controls\Inputs;
?>
<div id="bookly-export-coupon-dialog" class="modal fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <form action="<?php echo admin_url( 'admin-ajax.php?action=bookly_coupons_export' ) ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <div class="modal-title h2"><?php esc_html_e( 'Export to CSV', 'bookly' ) ?></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="export_customers_delimiter"><?php esc_html_e( 'Delimiter', 'bookly' ) ?></label>
                        <select name="export_customers_delimiter" id="export_customers_delimiter" class="form-control">
                            <option value=","><?php esc_html_e( 'Comma (,)', 'bookly' ) ?></option>
                            <option value=";"><?php esc_html_e( 'Semicolon (;)', 'bookly' ) ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="checkbox"><label><input checked name="exp[code]" type="checkbox" /> <?php esc_html_e( 'Code', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[discount]" type="checkbox" /> <?php esc_html_e( 'Discount (%)', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[deduction]" type="checkbox" /> <?php esc_html_e( 'Deduction', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[services]" type="checkbox" /> <?php esc_html_e( 'Services', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[staff]" type="checkbox" /> <?php esc_html_e( 'Staff', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[customers]" type="checkbox" /> <?php esc_html_e( 'Customers limit', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[usage_limit]" type="checkbox" /><?php esc_html_e( 'Usage limit', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[used]" type="checkbox" /><?php esc_html_e( 'Number of times used', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[date_limit_start]" type="checkbox" /><?php esc_html_e( 'Active from', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[date_limit_end]" type="checkbox" /><?php esc_html_e( 'Active until', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[min_appointments]" type="checkbox" /><?php esc_html_e( 'Min. appointments', 'bookly' ) ?></label></div>
                        <div class="checkbox"><label><input checked name="exp[max_appointments]" type="checkbox" /><?php esc_html_e( 'Max appointments', 'bookly' ) ?></label></div>
                        <br>
                        <div class="checkbox"><label><input checked name="only_active" type="checkbox" value=1 /><?php esc_html_e( 'Export only active coupons', 'bookly' ) ?></label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php Inputs::renderCsrf() ?>
                    <?php Buttons::renderSubmit( null, null, __( 'Export to CSV', 'bookly' ) ) ?>
                </div>
            </div>
        </form>
    </div>
</div>