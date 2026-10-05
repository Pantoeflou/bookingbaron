<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $random_id = mt_rand( 1000, 9999 );
    echo $progress_tracker;
?>
<div class="bookly-box"><?php echo $info_text ?></div>
<div class="bookly-repeat-step">
    <div class="bookly-row">
        <div class="bookly-checkbox-group">
            <input type="checkbox" class="bookly-js-repeat-appointment-enabled" id="bookly-repeat-<?php echo $random_id ?>" <?php disabled( empty( $frequencies ) ) ?>>
            <label class="bookly-square bookly-checkbox" style="width:28px; float:left;" for="bookly-repeat-<?php echo $random_id ?>">
                <i class="bookly-icon-sm"></i>
            </label>
            <label for="bookly-repeat-<?php echo $random_id ?>">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_this_appointment' ) ?>
            </label>
        </div>
    </div>
    <div class="bookly-js-repeat-variants-container">
        <div class="bookly-row">
            <div class="bookly-col-2 bookly-col-label">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat' ) ?>
            </div>
            <div class="bookly-col-4">
                <select class="bookly-js-repeat-variant bookly-control">
                    <?php foreach ( array( 'daily', 'weekly', 'biweekly', 'monthly' ) as $type ) :
                        if ( isset( $frequencies[ $type ] ) ) : ?>
                            <option value="<?php echo $type ?>"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_' . $type ) ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="bookly-js-variant-daily bookly-col-1 bookly-text-center bookly-margin-top">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_every' ) ?>
            </div>
            <div class="bookly-js-variant-daily bookly-col-2">
                <input type="number" class="bookly-js-repeat-daily-every bookly-control" value="1" min="1">
            </div>
            <div class="bookly-js-variant-daily bookly-col-1 bookly-visible-md bookly-text">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_days' ) ?>
            </div>
        </div>
        <div class="bookly-js-variant-weekly bookly-js-variant-biweekly">
            <div class="bookly-row">
                <div class="bookly-col-2 bookly-visible-md" style="text-align: right;">
                    <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_on_week' ) ?>
                </div>
                <div class="bookly-col-10">
                    <?php if ( ! empty ( $week ) ) : ?>
                        <div class="bookly-week-days bookly-js-week-days bookly-table">
                            <?php foreach ( $week['abbrev'] as $day_slug => $day ) : ?>
                                <div>
                                    <span><?php echo $day ?></span>
                                    <label<?php if ( $week['checked'][ $day_slug ] ) : ?> class="active"<?php endif ?>>
                                        <input class="bookly-js-week-day" value="<?php echo $day_slug ?>"<?php checked( $week['checked'][ $day_slug ] ) ?> type="checkbox"/>
                                    </label>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <div class="bookly-js-days-error bookly-label-error" style="display: none;">
                            <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_required_week_days' ) ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="bookly-js-variant-monthly">
            <div class="bookly-row">
                <div for="bookly-repeat-on" class="bookly-col-2 bookly-col-label">
                    <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_on' ) ?>
                </div>
                <div class="bookly-col-4">
                    <select class="bookly-js-repeat-variant-monthly bookly-control">
                        <option value="specific"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_specific' ) ?></option>
                        <option value="first"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_first' ) ?></option>
                        <option value="second"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_second' ) ?></option>
                        <option value="third"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_third' ) ?></option>
                        <option value="fourth"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_fourth' ) ?></option>
                        <option value="last"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_last' ) ?></option>
                    </select>
                </div>
                <div class="bookly-col-2 bookly-visible-sm bookly-margin-top">
                    <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_day' ) ?>
                </div>
                <div class="bookly-col-2">
                    <select class="bookly-js-monthly-week-day bookly-control">
                        <?php foreach ( $week['full'] as $day_slug => $week_day ) : ?>
                            <option value="<?php echo $day_slug ?>"<?php selected( $week['checked'][ $day_slug ] ) ?>><?php echo $week_day ?></option>
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
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_until' ) ?>
            </div>
            <div class="bookly-col-4">
                <input class="bookly-js-repeat-until bookly-control" type="text" value="" data-value="<?php echo esc_attr( $until ) ?>"/>
            </div>
            <div class="bookly-col-1 bookly-text-center bookly-margin-top">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_or' ) ?>
            </div>
            <div class="bookly-col-2">
                <input type="number" step="1" min="1" class="bookly-js-repeat-times" value="" data-value=""/>
            </div>
            <div class="bookly-col-1 bookly-text">
                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_times' ) ?>
            </div>
        </div>
        <div class="bookly-row">
            <div class="bookly-col-2 bookly-visible-md">&nbsp;</div>
            <div class="bookly-col-10">
                <button class="bookly-btn bookly-get-schedule bookly-js-get-schedule" data-style="zoom-in" data-spinner-size="40">
                    <span class="ladda-label"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_schedule' ) ?></span>
                </button>
            </div>
        </div>
        <div class="bookly-js-schedule-container" style="display: none">
            <div class="bookly-schedule-row-template" style="display: none">
                <div class="bookly-schedule-row">
                    <div></div>
                    <div class="bookly-schedule-appointment">
                        <div class="bookly-schedule-date"></div>
                        <div class="bookly-schedule-time bookly-js-schedule-time"></div>
                        <div class="bookly-schedule-time bookly-js-schedule-all-day-time" style="display: none;"></div>
                        <div class="bookly-rounds-group">
                            <button class="bookly-round" data-action="save" title="<?php esc_attr_e( 'Save', 'bookly' ) ?>" style="display: none"><i class="bookly-icon-sm bookly-icon-check"></i></button>
                            <button class="bookly-round" data-action="edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-edit"></i></button>
                            <button class="bookly-round" data-action="drop" title="<?php esc_attr_e( 'Remove', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-drop"></i></button>
                        </div>
                        <div class="bookly-hidden-info">
                            <span>
                                <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_deleted' ) ?>
                            </span>
                            <div class="bookly-rounds-group">
                                <button class="bookly-round" data-action="restore" title="<?php esc_attr_e( 'Restore', 'bookly' ) ?>"><i class="bookly-icon-sm bookly-icon-restore"></i></button>
                            </div>
                        </div>
                        <div class="bookly-schedule-intersect" style="display: none;">
                            <div class="bookly-round" style="margin-right: 6px;float: left;"><i class="bookly-icon-sm bookly-icon-exclamation"></i></div>
                            <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_another_time' ) ?>
                        </div>
                        <div class="bookly-label-error" style="display: none">
                            <?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_no_available_slots' ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bookly-row bookly-well bookly-js-schedule-help">
                <div class="bookly-round bookly-margin-sm"><i class="bookly-icon-sm bookly-icon-i"></i></div>
                <div>
                    <?php echo nl2br( \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_repeat_schedule_info' ) ) ?>
                </div>
            </div>
            <div class="bookly-row">
                <div class="bookly-schedule-slots bookly-js-schedule-slots"></div>
            </div>
            <div class="bookly-row">
                <ul class="bookly-pagination"></ul>
            </div>
            <div class="bookly-row bookly-well">
                <div class="bookly-triangle"><i class="bookly-icon-sm bookly-icon-exclamation"></i></div>
                <div class="bookly-js-intersection-info"></div>
            </div>
        </div>
    </div>
</div>
<div class="bookly-box bookly-nav-steps">
    <button class="bookly-back-step bookly-js-back-step bookly-btn ladda-button" data-style="zoom-in" data-spinner-size="40">
        <span class="ladda-label"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_button_back' ) ?></span>
    </button>
    <?php if ( $show_cart_btn ) : ?>
        <button class="bookly-go-to-cart bookly-js-go-to-cart bookly-round bookly-round-md ladda-button" data-style="zoom-in" data-spinner-size="30"><span class="ladda-label"><img src="<?php echo plugins_url( 'bookly-responsive-appointment-booking-tool/frontend/resources/images/cart.png' ) ?>"/></span></button>
    <?php endif ?>
    <div class="<?php echo get_option( 'bookly_app_align_buttons_left' ) ? 'bookly-left' : 'bookly-right' ?>">
        <button class="bookly-next-step bookly-js-next-step bookly-btn ladda-button" data-style="zoom-in" data-spinner-size="40">
            <span class="ladda-label"><?php echo \Bookly\Lib\Utils\Common::getTranslatedOption( 'bookly_l10n_step_repeat_button_next' ) ?></span>
        </button>
    </div>
</div>