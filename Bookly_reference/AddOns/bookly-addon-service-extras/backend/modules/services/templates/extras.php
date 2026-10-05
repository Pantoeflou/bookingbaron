<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib\Utils\DateTime;
use Bookly\Backend\Components\Controls\Buttons;
/** @var BooklyServiceExtras\Lib\Entities\ServiceExtra[] $extras */
?>
<div class="bookly-js-service bookly-js-service-simple bookly-margin-bottom-xs">
    <a class="h4" href="#bookly_service_extras_container_<?php echo $service_id ?>" data-toggle="collapse" role="button">
        <?php echo get_option( 'bookly_l10n_step_extras' ) ?>
    </a>
    <div id="bookly_service_extras_container_<?php echo $service_id ?>" class="bookly-margin-top-lg collapse in">
        <ul class="list-group extras-container" data-service="<?php echo $service_id ?>">
            <div class="form-group text-right">
                <button type="button" class="btn btn-success extra-new" data-spinner-size="40" data-style="zoom-in">
                    <span class="ladda-label"><i class="glyphicon glyphicon-plus"></i> <?php _e( 'New Item', 'bookly' ) ?></span>
                </button>
            </div>
            <?php foreach ( $extras as $extra ) : ?>
                <li class="list-group-item extra" data-extra-id="<?php echo $extra->getId() ?>">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="bookly-flexbox">
                                <div class="bookly-flex-cell bookly-vertical-top">
                                    <i class="bookly-js-handle bookly-icon bookly-icon-draghandle bookly-margin-right-sm bookly-cursor-move" title="<?php esc_attr_e( 'Reorder', 'bookly' ) ?>"></i>
                                </div>
                                <div class="bookly-flex-cell" style="width: 100%">
                                    <div class="form-group">
                                        <input name="extras[<?php echo $extra->getId() ?>][id]"
                                               value="<?php echo $extra->getId() ?>" type="hidden">
                                        <input name="extras[<?php echo $extra->getId() ?>][attachment_id]"
                                               value="<?php echo $extra->getAttachmentId() ?>" type="hidden">

                                        <?php $img = wp_get_attachment_image_src( $extra->getAttachmentId(), 'thumbnail' ) ?>

                                        <div class="extra-attachment-image bookly-thumb bookly-thumb-lg bookly-margin-right-lg"
                                            <?php echo $img ? 'style="background-image: url(' . $img[0] . '); background-size: cover;"' : ''  ?>
                                        >
                                            <a class="bookly-js-remove-attachment dashicons dashicons-trash text-danger bookly-thumb-delete" href="javascript:void(0)" title="<?php _e( 'Delete', 'bookly' ) ?>"
                                               <?php if ( !$img ) : ?>style="display: none;"<?php endif ?>>
                                            </a>
                                            <div class="bookly-thumb-edit extra-attachment" <?php if ( $img ) : ?>style="display: none;"<?php endif ?> >
                                                <div class="bookly-pretty">
                                                    <label class="bookly-pretty-indicator bookly-thumb-edit-btn"><?php _e( 'Image', 'bookly' ) ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="title_extras_<?php echo $extra->getId() ?>">
                                    <?php _e( 'Title', 'bookly' ) ?>
                                </label>
                                <input name="extras[<?php echo $extra->getId() ?>][title]" class="form-control" type="text" id="title_extras_<?php echo $extra->getId() ?>" value="<?php echo $extra->getTitle() ?>">
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="price_extras_<?php echo $extra->getId() ?>">
                                            <?php _e( 'Price', 'bookly' ) ?>
                                        </label>
                                        <input name="extras[<?php echo $extra->getId() ?>][price]" class="form-control" type="number" step="1" id="price_extras_<?php echo $extra->getId() ?>" min="0.00" value="<?php echo $extra->getPrice() ?>">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="duration_extras_<?php echo $extra->getId() ?>">
                                            <?php _e( 'Duration', 'bookly' ) ?>
                                        </label>
                                        <select name="extras[<?php echo $extra->getId() ?>][duration]" id="duration_extras_<?php echo $extra->getId() ?>" class="form-control">
                                            <option value="0"><?php _e( 'OFF', 'bookly' ) ?></option>
                                            <?php for ( $j = $time_interval; $j <= 720; $j += $time_interval ) : ?><?php if ( $extra->getDuration() > 0 && $extra->getDuration() / 60 > $j - $time_interval && $extra->getDuration() / 60 < $j ) : ?><option value="<?php echo esc_attr( $extra->getDuration() ) ?>" selected><?php echo DateTime::secondsToInterval( $extra->getDuration() ) ?></option><?php endif ?><option value="<?php echo $j * 60 ?>" <?php selected( $extra->getDuration(), $j * 60 ) ?>><?php echo DateTime::secondsToInterval( $j * 60 ) ?></option><?php endfor ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="max_quantity_extras_<?php echo $extra->getId() ?>">
                                            <?php _e( 'Max quantity', 'bookly' ) ?>
                                        </label>
                                        <input name="extras[<?php echo $extra->getId() ?>][max_quantity]" class="form-control" type="number" step="1" id="max_quantity_extras_<?php echo $extra->getId() ?>" min="1" value="<?php echo $extra->getMaxQuantity() ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <?php Buttons::renderDelete( null, 'extra-delete' ) ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>