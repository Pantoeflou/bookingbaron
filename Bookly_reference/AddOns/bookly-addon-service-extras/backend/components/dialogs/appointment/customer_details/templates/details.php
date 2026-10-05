<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/** @var BooklyServiceExtras\Lib\Entities\ServiceExtra[] $extras */
use Bookly\Lib\Utils\Price;
?>
<h3 class="bookly-block-head bookly-color-gray">
    <?php _e( 'Extras', 'bookly' ) ?>
</h3>
<div id="bookly-extras" class="bookly-flexbox">
    <?php foreach ( $extras as $extra ) : ?>
        <div class="bookly-flex-row service_<?php echo $extra->getServiceId() ?> bookly-margin-bottom-sm">
            <div class="bookly-flex-cell bookly-padding-bottom-sm" style="width:5em">
                <input class="extras-count form-control" data-id="<?php echo $extra->getId() ?>" type="number" min="0" name="extra[<?php echo $extra->getId() ?>]" value="0" />
            </div>
            <div class="bookly-flex-cell bookly-padding-bottom-sm bookly-vertical-middle">
                <span class="bookly-js-nop-wrap collapse">&nbsp;&times; <i class="fa fa-user"></i> <span class="bookly-js-nop"></span></span>&nbsp;&times; <b><?php echo $extra->getTitle() ?></b> (<?php echo Price::format( $extra->getPrice() ) ?>)
            </div>
        </div>
    <?php endforeach ?>
</div>