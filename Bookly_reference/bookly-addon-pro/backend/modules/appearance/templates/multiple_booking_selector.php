<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
    <div class="col-md-12">
        <div class="alert alert-info bookly-margin-top-lg bookly-margin-bottom-remove bookly-flexbox">
            <div class="bookly-flex-row">
                <div class="bookly-flex-cell" style="width:39px"><i class="alert-icon"></i></div>
                <div class="bookly-flex-cell">
                    <div>
                        <?php _e( 'The booking form on this step may have different set or states of its elements. It depends on various conditions such as installed/activated add-ons, settings configuration or choices made on previous steps. Select option and click on the underlined text to edit.', 'bookly' ) ?>
                    </div>
                    <div class="bookly-margin-top-lg">
                        <select id="bookly-payment-step-view" class="form-control">
                            <option value="single-app"><?php _e( 'Form view in case of single booking', 'bookly' ) ?></option>
                            <option value="several-apps"><?php _e( 'Form view in case of multiple booking', 'bookly' ) ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>