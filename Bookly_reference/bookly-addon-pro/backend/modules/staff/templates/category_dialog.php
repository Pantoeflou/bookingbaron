<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components;
?>
<div class="form-group">
    <button id="bookly-new-staff-category" type="button" class="btn btn-xlg btn-block btn-success-outline">
        <i class="dashicons dashicons-plus-alt"></i>
        <?php esc_html_e( 'New Category', 'bookly' ) ?>
    </button>
</div>
<form method="post" id="bookly-new-category-form" style="display: none">
    <div class="form-group bookly-margin-bottom-md">
        <div class="form-field form-required">
            <label for="bookly-category-name"><?php esc_html_e( 'Name', 'bookly' ) ?></label>
            <input class="form-control" id="bookly-category-name" type="text" name="name" />
            <input type="hidden" name="action" value="bookly_pro_add_staff_category" />
            <?php Components\Controls\Inputs::renderCsrf() ?>
        </div>
    </div>
    <hr />
    <div class="text-right">
        <?php Components\Controls\Buttons::renderSubmit() ?>
        <?php Components\Controls\Buttons::renderCustom( null, 'bookly-popover-close btn-lg btn-default', __( 'Close', 'bookly' ) ) ?>
    </div>
</form>
<div id="bookly-new-category-template" class="collapse">
    <div class="panel panel-default bookly-collapse" data-category="{{id}}">
        <div class="panel-heading">
            <div class="bookly-flexbox">
                <div class="bookly-flex-cell bookly-vertical-middle" style="width: 1%;">
                    <i class="bookly-js-categories-handle bookly-margin-right-sm bookly-icon bookly-icon-draghandle bookly-cursor-move ui-sortable-handle" title="<?php esc_attr_e( 'Reorder', 'bookly' ) ?>"></i>
                </div>
                <div class="bookly-flex-cell bookly-vertical-middle bookly-js-category-name">
                    <a href="#category{{id}}" class="panel-title" role="button" data-toggle="collapse">
                        {{name}}
                    </a>
                    <input class="form-control input-lg collapse" type="text" value="{{name}}"/>
                </div>
                <div class="bookly-flex-cell bookly-vertical-middle bookly-js-new-staff-member" style="width: 1%; padding-left: 10px;">
                    <a href="#" style="font-size: 15px;" title="<?php esc_attr_e( 'Add new item to the category', 'bookly' ) ?>"><i class="fa fa-user-plus"></i> </a>
                </div>
                <div class="bookly-flex-cell bookly-vertical-middle bookly-js-edit-category" style="width: 1%; padding-left: 10px;">
                    <a href="#" style="font-size: 15px;" title="<?php esc_attr_e( 'Edit category name', 'bookly' ) ?>"><i class="fa fa-edit"></i> </a>
                </div>
                <div class="bookly-flex-cell bookly-vertical-middle bookly-js-delete-category" style="width: 1%; padding-left: 10px;">
                    <a href="#" style="font-size: 15px;" title="<?php esc_attr_e( 'Delete category', 'bookly' ) ?>"><i class="fa fa-trash-alt"></i> </a>
                </div>
            </div>
        </div>
        <div id="category{{id}}" class="panel-collapse collapse in">
            <div class="panel-body">
                <ul class="bookly-js-staff-members" style="min-height: 10px;"></ul>
            </div>
        </div>
    </div>
</div>