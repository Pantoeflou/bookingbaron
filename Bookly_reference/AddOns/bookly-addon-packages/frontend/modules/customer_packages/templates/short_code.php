<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use BooklyPackages\Backend\Components\Dialogs;
?>
<?php if ( is_user_logged_in() ) : ?>
    <div id="bookly-tbs" class="wrap bookly-js-customer-packages-<?php echo $form_id ?> ">
        <div class="bookly-tbs-body">
            <table id="bookly-packages-list" class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th><?php _e( 'Package', 'bookly' ) ?></th>
                    <th><?php _e( 'Creation Date', 'bookly' ) ?></th>
                    <th><?php _e( 'Expires', 'bookly' ) ?></th>
                    <th><?php echo get_option( 'bookly_l10n_label_employee' ) ?></th>
                    <th><?php echo get_option( 'bookly_l10n_label_service' ) ?></th>
                    <th><?php _e( 'Quantity', 'bookly' ) ?></th>
                    <th><?php _e( 'Schedule', 'bookly' ) ?></th>
                </tr>
                </thead>
            </table>
            <?php Dialogs\Package\Dialog::render() ?>
            <?php Dialogs\Schedule\Dialog::render() ?>
        </div>
    </div>

    <script type="text/javascript">
        (function (win, fn) {
            var done = false, top = true,
                doc = win.document,
                root = doc.documentElement,
                modern = doc.addEventListener,
                add = modern ? 'addEventListener' : 'attachEvent',
                rem = modern ? 'removeEventListener' : 'detachEvent',
                pre = modern ? '' : 'on',
                init = function(e) {
                    if (e.type == 'readystatechange') if (doc.readyState != 'complete') return;
                    (e.type == 'load' ? win : doc)[rem](pre + e.type, init, false);
                    if (!done) { done = true; fn.call(win, e.type || e); }
                },
                poll = function() {
                    try { root.doScroll('left'); } catch(e) { setTimeout(poll, 50); return; }
                    init('poll');
                };
            if (doc.readyState == 'complete') fn.call(win, 'lazy');
            else {
                if (!modern) if (root.doScroll) {
                    try { top = !win.frameElement; } catch(e) { }
                    if (top) poll();
                }
                doc[add](pre + 'DOMContentLoaded', init, false);
                doc[add](pre + 'readystatechange', init, false);
                win[add](pre + 'load', init, false);
            }
        })(window, function() {
            window.booklyCustomerPackages({
                ajaxurl : <?php echo json_encode( $ajax_url ) ?>,
                form_id : <?php echo json_encode( $form_id ) ?>
            });
        });
    </script>
<?php else : ?>
    <?php wp_login_form() ?>
<?php endif ?>