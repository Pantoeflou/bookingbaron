<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Appearance\Editable;
?>
<div class="bookly-box bookly-well bookly-js-repeat-enabled" style="display:none">
    <div class="bookly-round"><i class="bookly-icon-sm bookly-icon-i"></i></div>
    <div>
        <?php Editable::renderText( 'bookly_l10n_repeat_first_in_cart_info', '', 'auto' ) ?>
    </div>
</div>