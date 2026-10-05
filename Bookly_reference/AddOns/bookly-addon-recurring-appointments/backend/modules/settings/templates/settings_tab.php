<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Lib as BooklyLib;
use Bookly\Backend\Components\Controls\Buttons;
use Bookly\Backend\Components\Controls\Inputs;
use Bookly\Backend\Components\Settings\Selects;
?>
<div class="tab-pane" id="bookly_settings_recurring_appointments">
    <form method="post" action="<?php echo esc_url( add_query_arg( 'tab', 'recurring_appointments' ) ) ?>">
        <?php Selects::renderSingle( 'bookly_recurring_appointments_payment', __( 'Online Payments', 'bookly' ), null, array( array( 'first', __( 'Customers must pay only for the 1st appointment', 'bookly' ) ), array( 'all', __( 'Customers must pay for all appointments in series', 'bookly' ) ) ) ) ?>
        <?php if ( BooklyLib\Config::groupBookingActive() ) : ?>
            <?php Selects::renderSingle( 'bookly_recurring_appointments_use_groups', __( 'Group appointments', 'bookly' ), null, array( array( '0', __( 'Create new appointment for every recurring booking', 'bookly' ) ), array( '1', __( 'Add customer to available group bookings', 'bookly' ) ) ) ) ?>
        <?php endif ?>
        <div class="panel-footer">
            <?php Inputs::renderCsrf() ?>
            <?php Buttons::renderSubmit() ?>
            <?php Buttons::renderReset() ?>
        </div>
    </form>
</div>