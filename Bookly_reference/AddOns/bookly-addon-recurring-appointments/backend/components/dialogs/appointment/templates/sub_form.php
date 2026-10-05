<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="checkbox bookly-margin-bottom-lg bookly-margin-top-remove" ng-hide="form.id">
    <label>
        <input type=checkbox id="bookly-repeat-enabled" ng-model=form.repeat.enabled ng-true-value="1" ng-false-value="0" /> <b><?php _e( 'Repeat this appointment', 'bookly' ) ?></b>
    </label>
</div>

<div class="form-group" ng-show="form.repeat.enabled">
    <div class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-2 control-label checkbox">
                <?php _e( 'Repeat', 'bookly' ) ?>
            </div>
            <div class="col-sm-4">
                <select id="bookly-repeat" class="form-control" ng-model=form.repeat.repeat ng-change="onRepeatChange()">
                    <option value="daily"><?php _e( 'Daily', 'bookly' ) ?></option>
                    <option value="weekly"><?php _e( 'Weekly', 'bookly' ) ?></option>
                    <option value="biweekly"><?php _e( 'Biweekly', 'bookly' ) ?></option>
                    <option value="monthly"><?php _e( 'Monthly', 'bookly' ) ?></option>
                </select>
            </div>
        </div>
        <div class="form-group" ng-show="form.repeat.repeat == 'daily'">
            <div class="col-sm-2 control-label"><?php _e( 'Every', 'bookly' ) ?></div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="number" id="bookly-repeat-every" step="1" min="1" class="form-control" ng-model=form.repeat.daily.every autocomplete="off" ng-change="onRepeatChange()" />
                    <span class="input-group-addon"><?php _e( 'day(s)', 'bookly' ) ?></span>
                </div>
            </div>
        </div>
        <div class="form-group" ng-show="form.repeat.repeat == 'weekly' || form.repeat.repeat == 'biweekly'">
            <div class="col-sm-2 control-label"><?php _e( 'On', 'bookly' ) ?></div>
            <div id="bookly-repeat-on" ng-class="{'col-sm-10': true, 'bg-danger': errors.repeat_weekdays_empty}">
                <?php foreach ( $weekdays as $i => $weekday ): ?>
                    <label class="checkbox-inline">
                        <input type="checkbox" value="<?php echo $weekday ?>"
                               ng-checked="form.repeat.weekly.on.indexOf('<?php echo $weekday ?>') > -1"
                               ng-click="schOnWeekdayClick('<?php echo $weekday ?>')"
                        /> <?php echo $weekday_abbrev[ $i ] ?>
                    </label>
                <?php endforeach ?>
            </div>
        </div>
        <div class="form-group" ng-show="form.repeat.repeat == 'monthly'">
            <div class="col-sm-2 control-label"><?php _e( 'On', 'bookly' ) ?></div>
            <div class="col-sm-4">
                <select class="form-control" ng-model=form.repeat.monthly.on ng-change="onRepeatChange()">
                    <option value="day"><?php _e( 'Specific day', 'bookly' ) ?></option>
                    <option value="first"><?php _e( 'First', 'bookly' ) ?></option>
                    <option value="second"><?php _e( 'Second', 'bookly' ) ?></option>
                    <option value="third"><?php _e( 'Third', 'bookly' ) ?></option>
                    <option value="fourth"><?php _e( 'Fourth', 'bookly' ) ?></option>
                    <option value="last"><?php _e( 'Last', 'bookly' ) ?></option>
                </select>
            </div>
            <div class="col-sm-2" ng-show="form.repeat.monthly.on == 'day'">
                <select id="bookly-repeat-specific-day" class="form-control" ng-model=form.repeat.monthly.day ng-change="onRepeatChange()">
                    <?php for ( $i = 1; $i <= 31; ++ $i ): ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php endfor ?>
                </select>
            </div>
            <div class="col-sm-2" ng-show="form.repeat.monthly.on != 'day'">
                <select class="form-control" ng-model=form.repeat.monthly.weekday ng-change="onRepeatChange()">
                    <?php foreach ( $weekdays as $i => $weekday ): ?>
                        <option value="<?php echo $weekday ?>"><?php echo $weekday_abbrev[ $i ] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-2 control-label"><?php _e( 'Until', 'bookly' ) ?></div>
            <div class="col-sm-4">
                <input type="text" id="bookly-js-repeat-until" class="form-control" autocomplete="off"
                       ng-model=form.repeat.until
                       ui-date="dateOptions" ui-date-format="yy-mm-dd"
                       ng-change="onRepeatChange()"/>
            </div>
            <div class="col-sm-1 control-label"><?php _e( 'or', 'bookly' ) ?></div>
            <div class="col-sm-2"><input type="number" step="1" min="1" id="bookly-js-repeat-times" class="form-control" autocomplete="off" ng-model=form.repeat.times ng-change="onRepeatChangeTimes()"/></div>
            <div class="col-sm-1 control-label"><?php _e( 'time(s)', 'bookly' ) ?></div>
        </div>
    </div>
</div>