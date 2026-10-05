<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="bookly-js-service bookly-js-service-simple bookly-js-service-collaborative bookly-js-service-compound">
    <div class="row">
        <div class="col-sm-8">
            <label for="appointments_limit_<?php echo $service['id'] ?>">
                <?php esc_html_e( 'Limit appointments per customer', 'bookly' ) ?>
            </label>
            <p class="help-block"><?php esc_html_e( 'This setting allows you to limit the number of appointments that can be booked by a customer in any given period. Restriction may end after a fixed period or with the beginning of the next calendar period – new day, week, month, etc.', 'bookly' ) ?></p>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <select id="limit_period_<?php echo $service['id'] ?>" class="form-control" name="limit_period">
                            <option value="off"><?php esc_html_e( 'OFF', 'bookly' ) ?></option>
                            <option value="upcoming"<?php selected( 'upcoming', $service['limit_period'] ) ?>><?php esc_html_e( 'upcoming', 'bookly' ) ?></option>
                            <option value="day"<?php selected( 'day', $service['limit_period'] ) ?>><?php esc_html_e( 'per 24 hours', 'bookly' ) ?></option>
                            <option value="calendar_day"<?php selected( 'calendar_day', $service['limit_period'] ) ?>><?php esc_html_e( 'per day', 'bookly' ) ?></option>
                            <option value="week"<?php selected( 'week', $service['limit_period'] ) ?>><?php esc_html_e( 'per 7 days', 'bookly' ) ?></option>
                            <option value="calendar_week"<?php selected( 'calendar_week', $service['limit_period'] ) ?>><?php esc_html_e( 'per week', 'bookly' ) ?></option>
                            <option value="month"<?php selected( 'month', $service['limit_period'] ) ?>><?php esc_html_e( 'per 30 days', 'bookly' ) ?></option>
                            <option value="calendar_month"<?php selected( 'calendar_month', $service['limit_period'] ) ?>><?php esc_html_e( 'per month', 'bookly' ) ?></option>
                            <option value="year"<?php selected( 'year', $service['limit_period'] ) ?>><?php esc_html_e( 'per 365 days', 'bookly' ) ?></option>
                            <option value="calendar_year"<?php selected( 'calendar_year', $service['limit_period'] ) ?>><?php esc_html_e( 'per year', 'bookly' ) ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input id="appointments_limit_<?php echo $service['id'] ?>" class="form-control" type="number" min="0" step="1" name="appointments_limit" value="<?php echo esc_attr( $service['appointments_limit'] ) ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>