<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Bookly\Backend\Components\Appearance\Codes;
use Bookly\Backend\Components\Appearance\Editable;
/**
 * @var WP_Locale $wp_locale
 */
global $wp_locale;
?>
<div class="bookly-form">

    <!-- Progress Tracker-->
    <?php echo $progress_tracker ?>

    <div class="bookly-box">
        <?php Editable::renderText( 'bookly_l10n_info_repeat_step', Codes::getHtml( 4 ) ) ?>
    </div>
    <div class="bookly-repeat-step">
        <div class="bookly-row">
            <div class="bookly-checkbox-group">
                <input type="checkbox" class="bookly-js-repeat-appointment-enabled" checked>
                <label class="bookly-square bookly-checkbox" style="width:28px; float:left;">
                    <i class="bookly-icon-sm"></i>
                </label>
                <?php Editable::renderLabel( array( 'bookly_l10n_repeat_this_appointment', ) ) ?>
            </div>
        </div>
        <div class="bookly-js-repeat-variants-container">
            <div class="bookly-row">
                <div class="bookly-col-2 bookly-col-label">
                    <?php Editable::renderString( array(
                        'bookly_l10n_repeat',
                        'bookly_l10n_repeat_daily',
                        'bookly_l10n_repeat_weekly',
                        'bookly_l10n_repeat_biweekly',
                        'bookly_l10n_repeat_monthly',
                    ) ) ?>
                </div>
                <div class="bookly-col-4">
                    <select class="bookly-js-repeat-variant bookly-control">
                        <option value="daily" class="bookly-js-option bookly_l10n_repeat_daily"><?php echo get_option( 'bookly_l10n_repeat_daily' ) ?></option>
                        <option value="weekly" class="bookly-js-option bookly_l10n_repeat_weekly"><?php echo get_option( 'bookly_l10n_repeat_weekly' ) ?></option>
                        <option value="biweekly" class="bookly-js-option bookly_l10n_repeat_biweekly"><?php echo get_option( 'bookly_l10n_repeat_biweekly' ) ?></option>
                        <option value="monthly" class="bookly-js-option bookly_l10n_repeat_monthly"><?php echo get_option( 'bookly_l10n_repeat_monthly' ) ?></option>
                    </select>
                </div>
                <div class="bookly-js-variant-daily bookly-col-1 bookly-text-center bookly-margin-top">
                    <?php Editable::renderString( array( 'bookly_l10n_repeat_every', ) ) ?>
                </div>
                <div class="bookly-js-variant-daily bookly-col-2">
                    <input type="number" class="bookly-js-repeat-daily-every bookly-control" value="1" min="1" />
                </div>
                <div class="bookly-js-variant-daily bookly-col-1 bookly-visible-md bookly-text">
                    <?php Editable::renderString( array( 'bookly_l10n_repeat_days', ) ) ?>
                </div>
            </div>
            <div class="bookly-js-variant-weekly bookly-js-variant-biweekly">
                <div class="bookly-row">
                    <div class="bookly-col-2 bookly-visible-md" style="text-align: right;">
                        <?php Editable::renderString( array( 'bookly_l10n_repeat_on_week', ) ) ?>
                    </div>
                    <div class="bookly-col-10">
                        <div class="bookly-week-days bookly-js-week-days bookly-table">
                            <?php foreach ( $wp_locale->weekday_abbrev as $day ) : ?>
                                <div>
                                    <span><?php echo $day ?></span>
                                    <label>
                                        <input class="bookly-js-week-day" type="checkbox"/>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="bookly-js-days-error bookly-label-error">
                            <?php Editable::renderString( array( 'bookly_l10n_repeat_required_week_days', ) ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bookly-js-variant-monthly">
                <div class="bookly-row">
                    <div for="bookly-repeat-on" class="bookly-col-2 bookly-col-label">
                        <?php Editable::renderString( array(
                            'bookly_l10n_repeat_on',
                            'bookly_l10n_repeat_specific',
                            'bookly_l10n_repeat_first',
                            'bookly_l10n_repeat_second',
                            'bookly_l10n_repeat_third',
                            'bookly_l10n_repeat_fourth',
                            'bookly_l10n_repeat_last',
                        ) ) ?>
                    </div>
                    <div class="bookly-col-4">
                        <select class="bookly-js-repeat-variant-monthly bookly-control">
                            <option value="specific" class="bookly-js-option bookly_l10n_repeat_specific"><?php echo get_option( 'bookly_l10n_repeat_specific' ) ?></option>
                            <option value="first" class="bookly-js-option bookly_l10n_repeat_first"><?php echo get_option( 'bookly_l10n_repeat_first' ) ?></option>
                            <option value="second" class="bookly-js-option bookly_l10n_repeat_second"><?php echo get_option( 'bookly_l10n_repeat_second' ) ?></option>
                            <option value="third" class="bookly-js-option bookly_l10n_repeat_third"><?php echo get_option( 'bookly_l10n_repeat_third' ) ?></option>
                            <option value="fourth" class="bookly-js-option bookly_l10n_repeat_fourth"><?php echo get_option( 'bookly_l10n_repeat_fourth' ) ?></option>
                            <option value="last" class="bookly-js-option bookly_l10n_repeat_last"><?php echo get_option( 'bookly_l10n_repeat_last' ) ?></option>
                        </select>
                    </div>
                    <div class="bookly-col-2 bookly-visible-sm bookly-margin-top">
                        <?php Editable::renderString( array( 'bookly_l10n_repeat_day', ) ) ?>
                    </div>
                    <div class="bookly-col-2">
                        <select class="bookly-js-monthly-week-day bookly-control">
                            <?php foreach ( $wp_locale->weekday as $week_day ) : ?>
                                <option><?php echo $week_day ?></option>
                            <?php endforeach ?>
                        </select>
                        <select class="bookly-js-monthly-specific-day bookly-control">
                            <?php for ( $i = 1; $i <= 31; $i ++ ) : ?>
                                <option><?php echo $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="bookly-row">
                <div class="bookly-col-2 bookly-col-label">
                    <?php Editable::renderString( array( 'bookly_l10n_repeat_until', ) ) ?>
                </div>
                <div class="bookly-col-4">
                    <input class="bookly-js-repeat-until bookly-control" type="text" data-value="<?php echo date( 'Y-m-d', time() + 30 * DAY_IN_SECONDS ) ?>"/>
                </div>
                <div class="bookly-col-1 bookly-text-center bookly-margin-top">
                    <?php Editable::renderString( array( 'bookly_l10n_repeat_or', ) ) ?>
                </div>
                <div class="bookly-col-2">
                    <input type="number" class="bookly-js-repeat-times" value="20" min="1" />
                </div>
                <div class="bookly-col-1 bookly-visible-md bookly-text">
                    <?php Editable::renderString( array( 'bookly_l10n_repeat_times', ) ) ?>
                </div>
            </div>
            <div class="bookly-row">
                <div class="bookly-col-2 bookly-visible-md">&nbsp;</div>
                <div class="bookly-col-10">
                    <div class="bookly-btn bookly-get-schedule bookly-js-get-schedule">
                        <?php Editable::renderString( array( 'bookly_l10n_repeat_schedule', ) ) ?>
                    </div>
                </div>
            </div>
            <div class="bookly-js-schedule-container">
                <div class="bookly-js-schedule-container" style="display: block;">
                    <div class="bookly-row bookly-well bookly-js-schedule-help">
                        <div class="bookly-round"><i class="bookly-icon-sm bookly-icon-i"></i></div>
                        <div>
                            <?php Editable::renderText( 'bookly_l10n_repeat_schedule_info', '', 'auto' ) ?>
                        </div>
                    </div>
                    <div class="bookly-row">
                        <div class="bookly-schedule-slots bookly-js-schedule-slots">
                            <div class="bookly-schedule-row">
                                <div>1</div>
                                <div class="bookly-schedule-appointment">
                                    <div class="bookly-schedule-date"><?php echo date_i18n( 'D, M d', strtotime( '+17 days' ) ) ?></div>
                                    <div class="bookly-schedule-time"><?php echo \Bookly\Lib\Utils\DateTime::formatTime( 50400 ) ?></div>
                                    <div class="bookly-rounds-group">
                                        <button class="bookly-round" data-action="edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-edit"></i></button>
                                        <button class="bookly-round" data-action="drop" title="<?php esc_attr_e( 'Remove', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-drop"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="bookly-schedule-row">
                                <div>2</div>
                                <div class="bookly-schedule-appointment">
                                    <div class="bookly-schedule-date"><?php echo date_i18n( 'D, M d', strtotime( '+18 days' ) ) ?></div>
                                    <div class="bookly-schedule-time"><?php echo \Bookly\Lib\Utils\DateTime::formatTime( 50400 ) ?></div>
                                    <div class="bookly-rounds-group">
                                        <button class="bookly-round" data-action="edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-edit"></i></button>
                                        <button class="bookly-round" data-action="drop" title="<?php esc_attr_e( 'Remove', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-drop"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="bookly-schedule-row">
                                <div>3</div>
                                <div class="bookly-schedule-appointment">
                                    <div class="bookly-schedule-date"><?php echo date_i18n( 'D, M d', strtotime( '+19 days' ) ) ?></div>
                                    <div class="bookly-schedule-time"></div>
                                    <div class="bookly-rounds-group">
                                        <button class="bookly-round" data-action="edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-edit"></i></button>
                                        <button class="bookly-round" data-action="drop" title="<?php esc_attr_e( 'Remove', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-drop"></i></button>
                                    </div>
                                    <div class="bookly-label-error">
                                        <?php Editable::renderString( array( 'bookly_l10n_repeat_no_available_slots' ) ) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bookly-schedule-row">
                                <div>4</div>
                                <div class="bookly-schedule-appointment">
                                    <div class="bookly-schedule-date"><?php echo date_i18n( 'D, M d', strtotime( '+20 days' ) ) ?></div>
                                    <div class="bookly-schedule-time"><?php echo \Bookly\Lib\Utils\DateTime::formatTime( 54000 ) ?></div>
                                    <div class="bookly-schedule-intersect" style="display: block;">
                                        <div class="bookly-round" style="margin-right: 6px;float: left;"><i class="bookly-icon-sm bookly-icon-exclamation"></i></div>
                                        <?php Editable::renderString( array( 'bookly_l10n_repeat_another_time', ) ) ?>
                                    </div>
                                    <div class="bookly-rounds-group">
                                        <button class="bookly-round" data-action="edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-edit"></i></button>
                                        <button class="bookly-round" data-action="drop" title="<?php esc_attr_e( 'Remove', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-drop"></i></button>
                                    </div>
                                </div>
                            </div><div class="bookly-schedule-row">
                                <div>5</div>
                                <div class="bookly-schedule-appointment bookly-appointment-hidden">
                                    <div class="bookly-hidden-info">
                                        <?php Editable::renderString( array( 'bookly_l10n_repeat_deleted', ) ) ?>
                                        <div class="bookly-rounds-group">
                                            <button class="bookly-round" data-action="restore" title="<?php esc_attr_e( 'Restore', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-restore"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bookly-row">
                        <ul class="bookly-pagination" style="display: inline-block;"><li>«</li><li class="active">1</li><li>2</li><li>»</li></ul>
                    </div>
                    <div class="bookly-row bookly-well">
                        <div class="bookly-triangle"><i class="bookly-icon-sm bookly-icon-exclamation"></i></div>
                        <div class="bookly-js-intersection-info">
                            <?php Editable::renderText( 'bookly_l10n_repeat_schedule_help', $self::renderTemplate( '_code', array(), false  ), 'auto' ) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bookly-box bookly-nav-steps">
        <div class="bookly-back-step bookly-js-back-step bookly-btn">
            <?php Editable::renderString( array( 'bookly_l10n_button_back' ) ) ?>
        </div>
        <button class="bookly-go-to-cart bookly-js-go-to-cart bookly-round bookly-round-md ladda-button"><img src="<?php echo plugins_url( 'bookly-responsive-appointment-booking-tool/frontend/resources/images/cart.png' ) ?>" /></button>
        <div class="<?php echo get_option( 'bookly_app_align_buttons_left' ) ? 'bookly-left' : 'bookly-right' ?>">
            <div class="bookly-next-step bookly-js-next-step bookly-btn">
                <?php Editable::renderString( array( 'bookly_l10n_step_repeat_button_next' ) ) ?>
            </div>
        </div>
    </div>
</div>