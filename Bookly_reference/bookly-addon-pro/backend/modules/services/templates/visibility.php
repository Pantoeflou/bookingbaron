<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib\Config;
use Bookly\Lib\Entities\Service;
use Bookly\Backend\Modules\Services\Proxy;
?>
<div class="col-sm-4 bookly-js-service bookly-js-service-simple bookly-js-service-collaborative bookly-js-service-compound bookly-js-service-package">
    <div class="form-group">
        <label for="visibility_<?php echo $service['id'] ?>"><?php _e( 'Visibility', 'bookly' ) ?></label>
        <p class="help-block"><?php _e( 'To make service invisible to your customers set the visibility to "Private".', 'bookly' ) ?></p>
        <select name="visibility" class="form-control bookly-js-visibility" id="visibility_<?php echo $service['id'] ?>">
            <option value="public" <?php selected( $service['visibility'], Service::VISIBILITY_PUBLIC ) ?>><?php _e( 'Public', 'bookly' ) ?></option>
            <option value="private" <?php selected( $service['visibility'] == Service::VISIBILITY_PRIVATE || ( $service['visibility'] == Service::VISIBILITY_GROUP_BASED && ! Config::customerGroupsActive() ) ) ?>><?php _e( 'Private', 'bookly' ) ?></option>
            <?php Proxy\CustomerGroups::renderVisibilityOption( $service ) ?>
        </select>
    </div>
</div>