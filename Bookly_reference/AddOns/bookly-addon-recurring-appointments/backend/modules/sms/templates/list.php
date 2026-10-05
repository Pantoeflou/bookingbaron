<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib\Entities\Notification;
/** @var Bookly\Backend\Modules\Notifications\Forms\Notifications $form */
?>
<?php if ( $form->types['recurring'] ) : ?>
    <h4 class="bookly-block-head bookly-color-gray"><?php _e( 'Recurring', 'bookly' ) ?></h4>
    <div class="panel-group bookly-margin-vertical-xlg" id="bookly-js-recurring-notifications">
        <?php foreach ( $form->getNotifications( 'recurring' ) as $notification ) :
            $id = $notification['id'];
            ?>
            <div class="panel panel-default bookly-js-collapse">
                <div class="panel-heading" role="tab">
                    <div class="checkbox bookly-margin-remove">
                        <label>
                            <input name="notification[<?php echo $id ?>][active]" value="0" type="checkbox" checked="checked" class="hidden">
                            <input id="<?php echo $id ?>_active" name="notification[<?php echo $id ?>][active]" value="1" type="checkbox" <?php checked( $notification['active'] ) ?>>
                            <a href="#collapse_<?php echo $id ?>" class="collapsed panel-title" role="button" data-toggle="collapse" data-parent="#bookly-js-recurring-notifications">
                                <?php echo Notification::getName( $notification['type'] ) ?>
                            </a>
                        </label>
                    </div>
                </div>
                <div id="collapse_<?php echo $id ?>" class="panel-collapse collapse">
                    <div class="panel-body">

                        <?php $form->renderEditor( $id ) ?>
                        <?php $form->renderCopy( $notification ) ?>

                        <div class="form-group">
                            <label><?php _e( 'Codes', 'bookly' ) ?></label>
                            <?php $form->renderCodes( $notification['type'] ) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>