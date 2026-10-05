<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components;
use BooklyPackages\Backend\Components\Dialogs;
?>
<div id="bookly-tbs" class="wrap">
    <div class="bookly-tbs-body">
        <div class="page-header text-right clearfix">
            <div class="bookly-page-title">
                <?php _e( 'Packages', 'bookly' ) ?>
            </div>
            <?php Components\Support\Buttons::render( $self::pageSlug() ) ?>
        </div>
        <div class="panel panel-default bookly-main">
            <div class="panel-body">
                <div class="row">
                    <div class="form-inline bookly-margin-bottom-lg text-right">
                        <div class="form-group">
                            <button type="button" class="btn btn-success bookly-btn-block-xs" id="bookly-add"><i class="glyphicon glyphicon-plus"></i> <?php _e( 'New package', 'bookly' ) ?></button>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-1">
                        <div class="form-group">
                            <input class="form-control" type="text" id="bookly-filter-id" placeholder="<?php esc_attr_e( 'No.', 'bookly' ) ?>" />
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="bookly-margin-bottom-lg bookly-relative">
                            <button type="button" class="btn btn-block btn-default" id="bookly-filter-date" data-date="<?php echo date( 'Y-m-d', strtotime( 'first day of' ) ) ?> - <?php echo date( 'Y-m-d', strtotime( 'last day of' ) ) ?>">
                                <i class="dashicons dashicons-calendar-alt"></i>
                                <span>
                                    <?php echo \Bookly\Lib\Utils\DateTime::formatDate( 'first day of this month' ) ?> - <?php echo \Bookly\Lib\Utils\DateTime::formatDate( 'last day of this month' ) ?>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-staff" data-placeholder="<?php echo esc_attr( get_option( 'bookly_l10n_label_employee' ) ) ?>">
                                <option value="0"><?php esc_attr_e( 'Unassigned', 'bookly' ) ?></option>
                                <?php foreach ( $staff_members as $staff ) : ?>
                                    <option value="<?php echo $staff['id'] ?>"><?php esc_html_e( $staff['full_name'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix visible-md-block"></div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-customer" data-placeholder="<?php esc_attr_e( 'Customer', 'bookly' ) ?>">
                                <?php foreach ( $customers as $customer ) : ?>
                                    <option value="<?php echo $customer['id'] ?>"><?php esc_html_e( $customer['full_name'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-package" data-placeholder="<?php esc_attr_e( 'Package', 'bookly' ) ?>">
                                <?php foreach ( $packages as $package ) : ?>
                                    <option value="<?php echo $package['id'] ?>"><?php esc_html_e( $package['title'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-service" data-placeholder="<?php echo esc_attr( get_option( 'bookly_l10n_label_service' ) ) ?>">
                                <?php foreach ( $services as $service ) : ?>
                                    <option value="<?php echo $service['id'] ?>"><?php esc_html_e( $service['title'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <table id="bookly-packages-list" class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th><?php _e( 'No.', 'bookly' ) ?></th>
                        <th><?php _e( 'Creation Date', 'bookly' ) ?></th>
                        <th><?php echo get_option( 'bookly_l10n_label_employee' ) ?></th>
                        <th><?php _e( 'Customer Name', 'bookly' ) ?></th>
                        <th><?php _e( 'Customer Phone', 'bookly' ) ?></th>
                        <th><?php _e( 'Customer Email', 'bookly' ) ?></th>
                        <th><?php _e( 'Package', 'bookly' ) ?></th>
                        <th><?php echo get_option( 'bookly_l10n_label_service' ) ?></th>
                        <th><?php _e( 'Quantity', 'bookly' ) ?></th>
                        <th><?php _e( 'Payment', 'bookly' ) ?></th>
                        <th></th>
                        <th></th>
                        <th width="16"><input type="checkbox" id="bookly-check-all" /></th>
                    </tr>
                    </thead>
                </table>

                <div class="text-right bookly-margin-top-lg">
                    <?php Components\Controls\Buttons::renderDelete( null, null, null, array( 'data-toggle' => 'modal', 'data-target'=> '#bookly-delete-dialog' ) ) ?>
                </div>
            </div>
        </div>
        <?php Components\Dialogs\Appointment\Delete\Dialog::render() ?>
        <?php Dialogs\Schedule\Dialog::render() ?>
        <?php Dialogs\Package\Dialog::render() ?>
    </div>
</div>
