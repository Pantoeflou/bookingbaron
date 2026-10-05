<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Controls\Buttons;
use Bookly\Backend\Components\Dialogs;
use Bookly\Lib\Config;
?>
<div ng-app="packageDialog" ng-controller="packageDialogCtrl">
    <div id="bookly-package-dialog" class="modal fade" tabindex=-1 role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form ng-submit=processForm()>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="modal-title h2"><?php _e( 'New package', 'bookly' ) ?></div>
                    </div>
                    <div ng-show=loading class="modal-body">
                        <div class="bookly-loading"></div>
                    </div>
                    <div ng-hide="loading || form.screen != 'main'" class="modal-body">
                        <div class=form-group>
                            <label for="bookly-provider"><?php _e( 'Provider', 'bookly' ) ?></label>
                            <p class="help-block"><?php _e( 'Select service provider to see the packages provided. Or select unassigned package to see packages with no particular provider.', 'bookly' ); ?></p>
                            <select id="bookly-provider" class="form-control" ng-model="form.staff" ng-options="s.full_name for s in dataSource.data.staff" ng-change="onStaffChange()"></select>
                        </div>

                        <div class=form-group>
                            <label for="bookly-service"><?php _e( 'Package', 'bookly' ) ?></label>
                            <select id="bookly-service" class="form-control" ng-model="form.service"
                                    ng-options="s.title for s in form.staff.services" ng-change="onServiceChange()">
                                <option value=""><?php _e( '-- Select a package --', 'bookly' ) ?></option>
                            </select>
                            <p class="text-danger" my-slide-up="errors.service_required">
                                <?php _e( 'Please select a package', 'bookly' ) ?>
                            </p>
                        </div>

                        <?php if ( Config::locationsActive() ): ?>
                            <div class="form-group">
                                <label for="bookly-package-location"><?php _e( 'Location', 'bookly' ) ?></label>
                                <select id="bookly-package-location" class="form-control" ng-model="form.location"
                                        ng-options="l.name for l in form.staff.locations" ng-change="onLocationChange()">
                                    <option value=""></option>
                                </select>
                            </div>
                            <p class="text-success" my-slide-up="errors.location_service_combination">
                                <?php _e( 'Incorrect location and package combination', 'bookly' ) ?>
                            </p>
                        <?php endif ?>

                        <div class=form-group>
                            <label for="bookly-select2"><?php _e( 'Customers', 'bookly' ) ?></label>
                            <div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select id="bookly-select2" data-placeholder="<?php esc_attr_e( '-- Search customers --', 'bookly' ) ?>"
                                                class="form-control"
                                                ng-model="form.customer" ng-options="c.name for c in dataSource.data.customers"
                                                >
                                        </select>
                                        <span class="input-group-btn">
                                            <a class="btn btn-success" ng-click="openNewCustomerDialog()">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <?php _e( 'New customer', 'bookly' ) ?>
                                            </a>
                                        </span>
                                    </div>
                                    <p class="text-danger" my-slide-up="errors.customers_required">
                                        <?php _e( 'Please select a customer', 'bookly' ) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class=form-group>
                            <label for="bookly-packages-notification"><?php _e( 'Send notifications', 'bookly' ) ?></label>
                            <p class="help-block"><?php _e( 'If email or SMS notifications are enabled and you want customers and staff member to be notified about this package after saving, select appropriate option before clicking Save.', 'bookly' ) ?></p>
                            <select class="form-control" style="margin-top: 0" id="bookly-packages-notification"  ng-model=form.notification ng-init="form.notification = '<?php echo get_user_meta( get_current_user_id(), 'bookly_packages_form_send_notifications', true ) ?>' || 'no'" >
                                <option value="all"><?php _e( 'Send', 'bookly' ) ?></option>
                                <option value="no"><?php _e( 'Don\'t send', 'bookly' ) ?></option>
                            </select>
                        </div>

                        <div class=form-group>
                            <label for="bookly-internal-note"><?php _e( 'Internal note', 'bookly' ) ?></label>
                            <textarea class="form-control" ng-model=form.internal_note id="bookly-internal-note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div ng-hide=loading>
                            <?php Buttons::renderCustom( 'bookly-save-schedule', 'btn-lg btn-success', __( 'Save & schedule', 'bookly' ), array( 'ng-click' => 'saveAndSchedule()' ) ) ?>
                            <?php Buttons::renderSubmit() ?>
                            <?php Buttons::renderCustom( null, 'btn-lg btn-default', __( 'Cancel', 'bookly' ), array( 'ng-click' => 'closeDialog()', 'data-dismiss' => 'modal' ) ) ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div customer-dialog=createCustomer(customer)></div>
    <div payment-details-dialog="completePayment(payment_id, payment_title)"></div>

    <?php Dialogs\Customer\Edit\Dialog::render() ?>
</div>