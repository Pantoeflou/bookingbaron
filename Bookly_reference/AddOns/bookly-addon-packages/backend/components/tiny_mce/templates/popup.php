<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script type="text/javascript">
    jQuery(function ($) {
        $('#add-customer-packages-list').on('click', function (e) {
            e.preventDefault();
            window.send_to_editor('[bookly-packages-list]');
            return false;
        });
    });
</script>