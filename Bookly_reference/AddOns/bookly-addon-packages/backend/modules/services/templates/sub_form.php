<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @var array  $service_collection
 * @var array  $service
 */
?>
<div class="form-group bookly-js-service bookly-js-service-package">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="package_service_<?php echo $service['id'] ?>"><?php _e( 'Service', 'bookly' ) ?></label>
                <select class="form-control bookly-js-package-sub-service bookly-js-question" id="package_service_<?php echo $service['id'] ?>" name="package_service">
                    <option value="0"><?php _e( 'Select service', 'bookly' ) ?></option>
                    <?php foreach ( $service_collection as $_service ) : ?>
                        <?php if ( $_service['id'] != $service['id'] && $_service['type'] == \Bookly\Lib\Entities\Service::TYPE_SIMPLE && $_service['units_max'] == 1 ) : ?>
                            <option value="<?php echo $_service['id'] ?>"<?php if ( isset( $service['sub_services'][0] ) ) {selected( $_service['id'], $service['sub_services'][0]['sub_service_id'] );} ?>><?php echo esc_html( $_service['title'] ) ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
                <input type="hidden" id="bookly-js-package-service-changed" name="package_service_changed" value="0"/>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="form-group">
                <label for="package_unassigned_<?php echo $service['id'] ?>"><?php _e( 'Unassigned', 'bookly' ) ?></label>
                <p class="help-block"><?php _e( 'Enable this setting so that the package can be displayed and available for booking when clients have not specified a particular provider.', 'bookly' ); ?></p>
                <select class="form-control bookly-js-package-unassigned" id="package_unassigned_<?php echo $service['id'] ?>" name="package_unassigned">
                    <option value="0"><?php _e( 'Disabled', 'bookly' ) ?></option>
                    <option value="1"<?php selected( $service['package_unassigned'] ) ?>><?php _e( 'Enabled', 'bookly' ) ?></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="package_size_<?php echo $service['id'] ?>"><?php _e( 'Quantity', 'bookly' ) ?></label>
                    <input id="package_size_<?php echo $service['id'] ?>" class="form-control" type="number" min="1" step="1" name="package_size" value="<?php echo esc_attr( $service['package_size'] ? : 10 ) ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="package_life_time_<?php echo $service['id'] ?>"><?php _e( 'Life Time', 'bookly' ) ?></label>
                    <p class="help-block"><?php _e( 'The period in days when the customer can use a package of services.', 'bookly' ) ?></p>
                    <input id="package_life_time_<?php echo $service['id'] ?>" class="form-control" type="number" min="0" step="1" name="package_life_time" value="<?php echo esc_attr( $service['package_life_time'] ? : 30 ) ?>">
                </div>
            </div>
        </div>
    </div>
</div>
