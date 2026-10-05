<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components;
?>
<div id="bookly-tbs" class="wrap">
    <div class="bookly-tbs-body">
        <div class="page-header text-right clearfix">
            <div class="bookly-page-title">
                <?php esc_html_e( 'Coupons', 'bookly' ) ?>
            </div>
            <?php Components\Support\Buttons::render( $self::pageSlug() ) ?>
        </div>
        <div class="panel panel-default bookly-main">
            <div class="panel-body">
                <div class="form-inline bookly-margin-bottom-lg text-right">
                    <div class="form-group">
                        <button type="button" class="btn btn-default bookly-btn-block-xs" data-action="bookly-js-export"><i class="glyphicon glyphicon-export"></i> <?php esc_html_e( 'Export to CSV', 'bookly' ) ?></button>
                    </div>
                    <div class="form-group">
                        <button type="button"
                                id="bookly-add-series"
                                class="btn btn-success"
                                data-toggle="modal"
                                data-target="#bookly-coupon-modal">
                            <i class="glyphicon glyphicon-plus"></i> <?php esc_html_e( 'Add Coupon Series', 'bookly' ) ?>
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="button"
                                id="bookly-add"
                                class="btn btn-success"
                                data-toggle="modal"
                                data-target="#bookly-coupon-modal">
                            <i class="glyphicon glyphicon-plus"></i> <?php esc_html_e( 'Add Coupon', 'bookly' ) ?>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <input class="form-control" type="text" id="bookly-filter-code" placeholder="<?php esc_attr_e( 'Coupon code', 'bookly' ) ?>" />
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-service" data-placeholder="<?php esc_attr_e( 'Service', 'bookly' ) ?>">
                                <?php foreach ( $services as $service ): ?>
                                    <option value="<?php echo $service['id'] ?>"><?php echo esc_html( $service['title'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-staff" data-placeholder="<?php esc_attr_e( 'Staff', 'bookly' ) ?>">
                                <?php foreach ( $staff_members as $staff ): ?>
                                    <option value="<?php echo $staff['id'] ?>"><?php echo esc_html( $staff['title'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix visible-md-block"></div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <select class="form-control bookly-js-select" id="bookly-filter-customer" data-placeholder="<?php esc_attr_e( 'Customer', 'bookly' ) ?>">
                                <?php foreach ( $customers as $customer ): ?>
                                    <option value="<?php echo $customer['id'] ?>"><?php echo esc_html( $customer['name'] ) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="bookly-filter-active" />
                                    <?php esc_html_e( 'Show only active', 'bookly' ) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped" id="bookly-coupons-list" width="100%">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'Code', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Discount (%)', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Deduction', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Services', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Staff', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Customers limit', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Usage limit', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Number of times used', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Active until', 'bookly' ) ?></th>
                            <th><?php esc_html_e( 'Min. appointments', 'bookly' ) ?></th>
                            <th width="200"></th>
                            <th width="16"><input type="checkbox" id="bookly-check-all" /></th>
                        </tr>
                    </thead>
                </table>

                <div class="text-right bookly-margin-top-lg">
                    <?php Components\Controls\Buttons::renderDelete() ?>
                </div>
            </div>
        </div>
        <?php $self::renderTemplate( 'coupon', compact( 'services', 'dropdown_data', 'customers' ) ) ?>
        <?php $self::renderTemplate( 'export' ) ?>
    </div>
</div>