<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * @var string $type
 */
?>
<div class="form-group">
    <div class="radio">
        <label class="bookly-margin-right-md">
            <input type="radio" name="type" value="package" data-panel-class="panel-info" <?php echo checked( $type == \Bookly\Lib\Entities\Service::TYPE_PACKAGE ) ?>><?php _e( 'Package', 'bookly' ) ?>
        </label>
    </div>
</div>