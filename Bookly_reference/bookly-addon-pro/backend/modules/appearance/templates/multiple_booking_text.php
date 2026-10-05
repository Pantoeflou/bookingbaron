<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Appearance\Codes;
use Bookly\Backend\Components\Appearance\Editable;
?>
<div class="bookly-box bookly-js-payment-several-apps" style="display:none">
    <?php Editable::renderText( 'bookly_l10n_info_payment_step_several_apps', Codes::getHtml( 7, true ), 'right' ) ?>
</div>
