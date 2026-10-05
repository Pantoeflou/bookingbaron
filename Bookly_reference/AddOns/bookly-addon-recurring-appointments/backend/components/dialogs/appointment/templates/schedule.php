<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div ng-hide="loading || form.screen != 'schedule'" class="modal-body">
    <div ng-show="form.schedule.items.length">
        <div class="alert alert-danger bookly-margin-top-remove" ng-show="form.schedule.another_time.length">
            <span class="dashicons dashicons-warning"></span>
            <?php _e( 'Some of the desired time slots are busy. System offers the nearest time slot instead. Click the Edit button to select another time if needed.', 'bookly' ) ?>
        </div>
        <ul id="bookly-schedule-items" class="list-group bookly-margin-bottom-remove">
            <li class="list-group-item" ng-repeat="item in form.schedule.items | startFrom: schStartingItem() | limitTo: 10">
                <div class="row">
                    <div class="col-sm-1"><b>{{item.index}}</b></div>
                    <div class="col-sm-10 text-muted" ng-show="item.deleted">
                        <?php _e( 'Deleted', 'bookly' ) ?>
                    </div>
                    <div class="col-sm-1 text-right" ng-show="item.deleted">
                        <a href class="text-muted" title="<?php esc_attr_e( 'Restore', 'bookly' ) ?>"
                           ng-click="item.deleted = false">
                            <span class="glyphicon glyphicon-share-alt"></span>
                        </a>
                    </div>
                    <div class="col-sm-3" ng-hide="item.deleted || form.schedule.edit == item.index">{{schFormatDate(item.date)}}</div>
                    <div class="col-sm-4" ng-if="form.schedule.edit == item.index">
                        <input type="text" class="form-control" autocomplete="off" ui-date="schDateOptions" ui-date-format="yy-mm-dd"
                               ng-model="item.date"
                               ng-change="schOnDateChange(item)" />
                    </div>
                    <div class="col-sm-2" ng-hide="item.all_day_service_time || item.deleted || form.schedule.edit == item.index">{{schFormatTime(item.slots, item.options)}}</div>
                    <div class="col-sm-2" ng-show="item.all_day_service_time">{{item.all_day_service_time}}</div>
                    <div class="col-sm-3" ng-if="form.schedule.edit == item.index" ng-hide="item.all_day_service_time">
                        <select class="form-control" ng-model="item.slots"
                                ng-options="t.value as t.title disable when t.disabled for t in item.options"></select>
                    </div>
                    <div class="col-sm-4" ng-hide="item.deleted || form.schedule.edit == item.index">
                            <span ng-show="item.another_time">
                                <span class="dashicons dashicons-warning"></span>
                                <?php _e( 'Another time', 'bookly' ) ?>
                            </span>
                    </div>
                    <div class="col-sm-2 text-right" ng-hide="item.deleted || form.schedule.edit == item.index">
                        <a href class="dashicons dashicons-edit" title="<?php esc_attr_e( 'Edit', 'bookly' ) ?>"
                           ng-click="form.schedule.edit = item.index; schOnDateChange(item);"></a>
                        <a href class="dashicons dashicons-trash text-danger" title="<?php esc_attr_e( 'Delete', 'bookly' ) ?>"
                           ng-click="item.deleted = true"></a>
                    </div>
                    <div class="col-sm-4 text-right" ng-show="form.schedule.edit == item.index">
                        <a href class="glyphicon glyphicon-ok" title="<?php esc_attr_e( 'Apply', 'bookly' ) ?>"
                           ng-show="form.schedule.edit == item.index"
                           ng-click="form.schedule.edit = 0"></a>
                    </div>
                </div>
            </li>
        </ul>
        <nav ng-show="schNumberOfPages() > 1">
            <ul class="pagination">
                <li ng-class="{'disabled': schFirstPage()}">
                    <a href ng-click="schPageBack()"><span>&laquo;</span></a>
                </li>
                <li ng-repeat="p in [] | range: schNumberOfPages()"
                    ng-class="{'active': form.schedule.page+1 == p}">
                    <a href ng-click="form.schedule.page = p - 1">{{p}}</a>
                </li>
                <li ng-class="{'disabled': schLastPage()}">
                    <a href ng-click="schPageForward()"><span>&raquo;</span></a>
                </li>
            </ul>
        </nav>
        <div class="alert alert-danger bookly-margin-top-remove" ng-show="form.schedule.another_time.length && schNumberOfPages() > 1">
            <span class="dashicons dashicons-warning"></span>
            <?php _e( 'Another time was offered on pages', 'bookly' )?>
            {{form.schedule.another_time.join(', ')}}.
        </div>
    </div>
</div>