<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
?>
<div id="bookly-package-schedule-dialog" class="modal fade" tabindex=-1 role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-title h2"><?php _e( 'Package schedule', 'bookly' ) ?></div>
                </div>
                <div class="modal-body">
                    <div class="bookly-loading"></div>
                    <div class="bookly-js-modal-body">
                        <div>
                            <label for="bookly-package-schedule-body" class="bookly-js-package-name"></label>
                            <ul class="list-group" id="bookly-package-schedule-body"></ul>
                        </div>
                        <div class="alert alert-success bookly-js-warning-alert bookly-js-expired-warning-alert collapse">
                            <?php _e( 'Selected appointment date exceeds the period when the customer can use a package of services.', 'bookly' ) ?>
                            <div class="checkbox">
                                <label><input type="checkbox" class="form-control bookly-js-ignore-expired"> <?php _e( 'Ignore', 'bookly' ) ?></label>
                            </div>
                        </div>
                        <div class="alert alert-danger bookly-js-error-alert collapse">
                            <div class="bookly-js-error bookly-js-expired-error-alert collapse"><?php _e( 'Selected appointment date exceeds the period when the customer can use a package of services.', 'bookly' ) ?></div>
                            <div class="bookly-js-error bookly-js-occupied-alert collapse"><?php _e( 'Selected period is occupied by another appointment', 'bookly' ) ?></div>
                            <div class="bookly-js-error bookly-js-time-prior-cancel-alert collapse"><?php _e( 'Unfortunately, you\'re not able to cancel the appointment because the required time limit prior to canceling has expired.', 'bookly' ) ?></div>
                            <div class="bookly-js-error bookly-js-time-prior-booking-alert collapse"><?php _e( 'Unfortunately, you\'re not able to book an appointment because the required time limit prior to booking has expired.', 'bookly' ) ?></div>
                            <div class="bookly-js-error bookly-js-outdated-alert collapse"><?php _e( 'You are trying to schedule an appointment in the past. Please select another time slot.', 'bookly' ) ?></div>
                        </div>
                        <ul class="pagination bookly-margin-top-remove">
                            <li class="disabled" data-page="1">
                                <a href="#"><span>«</span></a>
                            </li>
                            <li data-page="2">
                                <a href="#"><span>»</span></a>
                            </li>
                        </ul>
                        <?php if ( is_admin() ) : ?>
                        <div class=form-group>
                            <label for="bookly-packages-schedule-notification"><?php _e( 'Send notifications', 'bookly' ) ?></label>
                            <p class="help-block"><?php _e( 'If email or SMS notifications are enabled and you want customers or staff member to be notified about this appointments after saving, select appropriate option before clicking Save.', 'bookly' ) ?></p>
                            <select class="form-control" style="margin-top: 0" id="bookly-packages-schedule-notification">
                                <option value="no"><?php _e( 'Don\'t send', 'bookly' ) ?></option>
                                <option value="yes"<?php selected( get_user_meta( get_current_user_id(), 'bookly_packages_schedule_form_send_notifications', true ) == 'yes' ) ?>><?php _e( 'If appointments changed', 'bookly' ) ?></option>
                            </select>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <?php Buttons::renderSubmit() ?>
                        <?php Buttons::renderCustom( null, 'btn-lg btn-default', __( 'Cancel', 'bookly' ), array( 'data-dismiss' => 'modal' ) ) ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="schedule_entry_template" class="collapse">
    <li class="list-group-item">
        <div class="row bookly-js-schedule-entry" data-id="{{id}}">
            <div class="col-xs-1"><b>{{number}}</b></div>
            <div class="col-xs-9">
                <div class="row">
                    <div class="col-sm-5 bookly-js-schedule-view bookly-js-schedule-staff">{{staff}}</div>
                    <div class="col-sm-4 bookly-js-schedule-view bookly-js-schedule-date">{{date}}</div>
                    <div class="col-sm-3 bookly-js-schedule-view bookly-js-schedule-time">{{time}}</div>
                    <div class="col-sm-12 bookly-js-schedule-edit collapse">
                        <div class="form-group bookly-js-schedule-edit-staff">
                            <select class="form-control"></select>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 bookly-js-schedule-edit collapse bookly-js-schedule-edit-date form-group"><input type="text" class="form-control " autocomplete="off" value="{{date}}" placeholder="<?php esc_attr_e( 'Select appointment date', 'bookly' ) ?>"/></div>
                            <div class="col-sm-5 bookly-js-schedule-edit collapse bookly-js-schedule-edit-time form-group"><select class="form-control"></select></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 bookly-js-schedule-view text-right">
                <a href class="bookly-js-schedule-clear-btn dashicons dashicons-trash text-danger pull-right" title="<?php esc_attr_e( 'Delete package appointment', 'bookly' ) ?>"></a>
                <a href class="bookly-js-schedule-edit-btn pull-right" title="<?php esc_attr_e( 'Edit package appointment', 'bookly' ) ?>"><i class="dashicons dashicons-edit"></i></a>
            </div>
            <div class="col-xs-2 bookly-js-schedule-edit text-right collapse">
                <a href class="bookly-js-schedule-apply-btn"><i class="glyphicon glyphicon-ok"></i></a>
                <a href class="bookly-js-schedule-cancel-btn text-danger"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
    </li>
</div>
