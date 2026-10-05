jQuery(function($) {

    var $codeFilter       = $('#bookly-filter-code'),
        $serviceFilter    = $('#bookly-filter-service'),
        $staffFilter      = $('#bookly-filter-staff'),
        $customerFilter   = $('#bookly-filter-customer'),
        $onlyActiveFilter = $('#bookly-filter-active'),
        $couponsList      = $('#bookly-coupons-list'),
        $checkAllButton   = $('#bookly-check-all'),
        $couponModal      = $('#bookly-coupon-modal'),
        $seriesNewTitle   = $('#bookly-new-coupon-series-title'),
        $couponNewTitle   = $('#bookly-new-coupon-title'),
        $couponEditTitle  = $('#bookly-edit-coupon-title'),
        $couponCode       = $('#bookly-coupon-code'),
        $generateCode     = $('#bookly-generate-code'),
        $seriesMask       = $('#bookly-coupon-series-mask'),
        $seriesAmount     = $('#bookly-coupon-series-amount'),
        $couponDiscount   = $('#bookly-coupon-discount'),
        $couponDeduction  = $('#bookly-coupon-deduction'),
        $couponUsageLimit = $('#bookly-coupon-usage-limit'),
        $couponOncePerCst = $('#once_per_customer'),
        $couponDateStart  = $('#bookly-coupon-date-limit-start'),
        $clearDateStart   = $('#bookly-clear-date-limit-start'),
        $couponDateEnd    = $('#bookly-coupon-date-limit-end'),
        $clearDateEnd     = $('#bookly-clear-date-limit-end'),
        $couponMinApps    = $('#bookly-coupon-min-appointments'),
        $couponMaxApps    = $('#bookly-coupon-max-appointments'),
        $couponCustomers  = $('#bookly-coupon-customers'),
        $customersList    = $('#bookly-customers-list'),
        $couponServices   = $('#bookly-js-coupon-services'),
        $couponProviders  = $('#bookly-js-coupon-providers'),
        $saveButton       = $('#bookly-coupon-save'),
        $addButton        = $('#bookly-add'),
        $addSeriesButton  = $('#bookly-add-series'),
        $deleteButton     = $('#bookly-delete'),
        $createAnother    = $('#bookly-create-another-coupon'),
        row,
        series,
        duplicate
    ;

    /**
     * Init filters.
     */
    $('.bookly-js-select')
        .val(null)
        .on('select2:unselecting', function(e) {
            e.preventDefault();
            $(this).val(null).trigger('change');
        })
        .on('change', function () { dt.ajax.reload(); })
        .select2({
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            language  : {
                noResults: function() { return BooklyCouponL10n.noResultFound; }
            }
        });
    $onlyActiveFilter.on('change', function () { dt.ajax.reload(); });
    $codeFilter.on('keyup', function () { dt.ajax.reload(); });
    /**
     * Init DataTables.
     */
    var dt = $couponsList.DataTable({
        order       : [[ 0, "asc" ]],
        info        : false,
        searching   : false,
        lengthChange: false,
        pageLength  : 25,
        pagingType  : 'numbers',
        processing  : true,
        responsive  : true,
        serverSide  : true,
        ajax        : {
            url : ajaxurl,
            type: 'POST',
            data: function (d) {
                return $.extend({action: 'bookly_coupons_get_coupons', csrf_token : BooklyCouponL10n.csrfToken}, {
                    filter: {
                        code       : $codeFilter.val(),
                        service    : $serviceFilter.val(),
                        staff      : $staffFilter.val(),
                        customer   : $customerFilter.val(),
                        only_active: $onlyActiveFilter.prop('checked') ? 1 : 0
                    }
                }, d);
            }
        },
        columns: [
            { data: "code" },
            { data: "discount" },
            { data: "deduction" },
            {
                data: 'services_count',
                render: function (data, type, row, meta) {
                    if (data == 0) {
                        return BooklyCouponL10n.services.nothingSelected;
                    } else if (data == 1) {
                        return BooklyCouponL10n.services.collection[row.service_ids[0]].title;
                    } else {
                        if (data == Object.keys(BooklyCouponL10n.services.collection).length) {
                            return BooklyCouponL10n.services.allSelected;
                        } else {
                            return data + '/' + Object.keys(BooklyCouponL10n.services.collection).length;
                        }
                    }
                }
            },
            {
                data: 'staff_count',
                render: function (data, type, row, meta) {
                    if (data == 0) {
                        return BooklyCouponL10n.staff.nothingSelected;
                    } else if (data == 1) {
                        if (typeof BooklyCouponL10n.staff.collection[row.staff_ids[0]] === 'undefined') {
                            return BooklyCouponL10n.staff.nothingSelected;
                        } else {
                            return BooklyCouponL10n.staff.collection[row.staff_ids[0]].title;
                        }
                    } else {
                        if (data == Object.keys(BooklyCouponL10n.staff.collection).length) {
                            return BooklyCouponL10n.staff.allSelected;
                        } else {
                            return data + '/' + Object.keys(BooklyCouponL10n.staff.collection).length;
                        }
                    }
                }
            },
            {
                data: 'customers_count',
                render: function (data, type, row, meta) {
                    if (data == 0) {
                        return BooklyCouponL10n.customers.nothingSelected;
                    } else if (data == 1) {
                        return $.fn.dataTable.render.text().display(BooklyCouponL10n.customers.collection[row.customer_ids[0]].name);
                    } else {
                        if (data == Object.keys(BooklyCouponL10n.customers.collection).length) {
                            return BooklyCouponL10n.customers.allSelected;
                        } else {
                            return data + '/' + Object.keys(BooklyCouponL10n.customers.collection).length;
                        }
                    }
                }
            },
            { data: "usage_limit" },
            { data: "used" },
            {
                data: "date_limit_end",
                render: function (data, type, row, meta) {
                    return row.date_limit_end_formatted;
                }
            },
            { data: "min_appointments" },
            {
                responsivePriority: 1,
                orderable: false,
                searchable: false,
                render: function ( data, type, row, meta ) {
                    return '<div style="white-space: nowrap"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#bookly-coupon-modal" data-action="new"><i class="glyphicon glyphicon-edit"></i> ' + BooklyCouponL10n.edit + '</button> <button type="button" class="btn btn-default" data-toggle="modal" data-target="#bookly-coupon-modal" data-action="duplicate"><i class="dashicons dashicons-admin-page"></i> ' + BooklyCouponL10n.duplicate + '</button></div>';
                }
            },
            {
                responsivePriority: 1,
                orderable: false,
                searchable: false,
                render: function ( data, type, row, meta ) {
                    return '<input type="checkbox" value="' + row.id + '">';
                }
            }
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row pull-left'<'col-sm-12 bookly-margin-top-lg'p>>",
        language: {
            zeroRecords: BooklyCouponL10n.zeroRecords,
            processing:  BooklyCouponL10n.processing
        }
    });

    /**
     * Select all coupons.
     */
    $checkAllButton.on('change', function () {
        $couponsList.find('tbody input:checkbox').prop('checked', this.checked);
    });

    /**
     * On coupon select.
     */
    $couponsList.on('change', 'tbody input:checkbox', function () {
        $checkAllButton.prop('checked', $couponsList.find('tbody input:not(:checked)').length == 0);
    });

    /**
     * Edit coupon.
     */
    $couponsList.on('click', 'button', function () {
        row       = dt.row($(this).closest('td'));
        series    = false;
        duplicate = $(this).data('action') === 'duplicate';
    });

    /**
     * New coupon.
     */
    $addButton.on('click', function () {
        row       = null;
        series    = false;
        duplicate = false;
    });

    /**
     * New coupon series.
     */
    $addSeriesButton.on('click', function () {
        row       = null;
        series    = true;
        duplicate = false;
    });

    /**
     * On show modal.
     */
    $couponModal.on('show.bs.modal', function () {
        var data = {};
        if (row) {
            data = row.data();
            $couponCode.val(data.code);
            $couponDiscount.val(data.discount);
            $couponDeduction.val(data.deduction);
            $couponUsageLimit.val(data.usage_limit);
            $couponOncePerCst.val(data.once_per_customer);
            $couponDateStart.datepicker('setDate', data.date_limit_start ? new Date(data.date_limit_start) : null);
            $couponDateEnd.datepicker('setDate', data.date_limit_end ? new Date(data.date_limit_end) : null);
            $couponMinApps.val(data.min_appointments);
            $couponMaxApps.val(data.max_appointments);
            $couponCustomers.val(data.customer_ids).trigger('change');
            $seriesNewTitle.hide();
            if (duplicate) {
                $couponEditTitle.hide();
                $couponNewTitle.show();
            } else {
                $couponEditTitle.show();
                $couponNewTitle.hide();
            }
            $couponServices.booklyDropdown('setSelected', data.service_ids);
            $couponProviders.booklyDropdown('setSelected', data.staff_ids);
        } else {
            $couponCode.val('');
            $seriesMask.val(BooklyCouponL10n.defaultCodeMask);
            $seriesAmount.val(1);
            $couponDiscount.val('0');
            $couponDeduction.val('0');
            $couponUsageLimit.val('1');
            $couponOncePerCst.val('0');
            $couponDateStart.datepicker('setDate', null);
            $couponDateEnd.datepicker('setDate', null);
            $couponMinApps.val('1');
            $couponMaxApps.val('');
            $couponCustomers.val(null).trigger('change');
            $couponEditTitle.hide();
            if (series) {
                $couponNewTitle.hide();
                $seriesNewTitle.show();
            } else {
                $couponNewTitle.show();
                $seriesNewTitle.hide();
            }
            $couponServices.booklyDropdown('selectAll');
            $couponProviders.booklyDropdown('selectAll');
        }
        $('.bookly-js-series-field').toggle(series);
        $('.bookly-js-coupon-field').toggle(!series);
        $couponCode.trigger('change');
        $createAnother.prop('checked', false);
    });

    /**
     * Code.
     */
    $couponCode.on('keyup change', function () {
        $generateCode.prop('disabled', $couponCode.val().length && $couponCode.val().indexOf('*') === -1);
    });

    /**
     * Generate code.
     */
    $generateCode.on('click', function () {
        var ladda = Ladda.create(this);
        ladda.start();
        $.ajax({
            url  : ajaxurl,
            type : 'POST',
            data : {
                action : 'bookly_coupons_generate_code',
                csrf_token : BooklyCouponL10n.csrfToken,
                mask : $couponCode.val()
            },
            dataType : 'json',
            success  : function(response) {
                ladda.stop();
                if (response.success) {
                    $couponCode.val(response.data.code);
                    $generateCode.prop('disabled', true);
                } else {
                    alert(response.data.message);
                }
            }
        });
    });

    /**
     * Date limit start.
     */
    $couponDateStart.datepicker($.extend({}, BooklyCouponL10n.dateOptions,
        {
            altField: $couponDateStart.next('input:hidden'),
            altFormat: 'yy-mm-dd'
        }
    ));
    $clearDateStart.on('click', function () {
        $couponDateStart.datepicker('setDate', null);
    });

    /**
     * Date limit end.
     */
    $couponDateEnd.datepicker($.extend({}, BooklyCouponL10n.dateOptions,
        {
            altField: $couponDateEnd.next('input:hidden'),
            altFormat: 'yy-mm-dd'
        }
    ));
    $clearDateEnd.on('click', function () {
        $couponDateEnd.datepicker('setDate', null);
    });

    /**
     * Customers list.
     */
    $couponCustomers.select2({
        width: '100%',
        theme: 'bootstrap',
        allowClear: false,
        language  : {
            noResults: function() { return BooklyCouponL10n.noResultFound; }
        }
    });
    $couponCustomers.on('change', function () {
        $customersList.empty();
        $couponCustomers.find('option:selected').each(function () {
            var $option = $(this),
                $li     = $('<li/>'),
                $span   = $('<span/>'),
                $a      = $('<a class="dashicons dashicons-trash text-danger pull-right" href="#"/>')
            ;
            $span.text($option.text());
            $a.on('click', function (e) {
                e.preventDefault();
                var newValues = [];
                $.each($couponCustomers.val(), function (i, id) {
                    if (id !== $option.val()) {
                        newValues.push(id);
                    }
                });
                $couponCustomers.val(newValues);
                $couponCustomers.trigger('change');
            });
            $a.attr('title', BooklyCouponL10n.removeCustomer);
            $li.append($span).append($a);
            $customersList.append($li);
        });
    });

    /**
     * Services.
     */
    $couponServices.booklyDropdown();

    /**
     * Providers (staff).
     */
    $couponProviders.booklyDropdown();

    /**
     * Save coupon.
     */
    $saveButton.on('click', function (e) {
        e.preventDefault();
        var $form = $(this).parents('form');
        var data = $form.serializeArray();
        data.push({name: 'action', value: 'bookly_coupons_save_coupon'});
        if (row && !duplicate) {
            data.push({name: 'id', value: row.data().id});
        }
        if (series) {
            data.push({name: 'create_series', value: '1'});
        }
        var ladda = Ladda.create(this);
        ladda.start();
        $.ajax({
            url  : ajaxurl,
            type : 'POST',
            data : data,
            dataType : 'json',
            success  : function(response) {
                if (response.success) {
                    dt.ajax.reload();
                    if (!series && $createAnother.prop('checked')) {
                        row = null;
                        $couponNewTitle.show();
                        $couponEditTitle.hide();
                        $couponCode.val('');
                        $createAnother.prop('checked', false);
                    } else {
                        $couponModal.modal('hide');
                    }
                } else {
                    alert(response.data.message);
                }
                ladda.stop();
            }
        });
    });

    /**
     * Delete coupons.
     */
    $deleteButton.on('click', function () {
        if (confirm(BooklyCouponL10n.areYouSure)) {
            var ladda = Ladda.create(this);
            ladda.start();

            var data = [];
            var $checkboxes = $couponsList.find('tbody input:checked');
            $checkboxes.each(function () {
                data.push(this.value);
            });

            $.ajax({
                url  : ajaxurl,
                type : 'POST',
                data : {
                    action : 'bookly_coupons_delete_coupons',
                    csrf_token : BooklyCouponL10n.csrfToken,
                    data : data
                },
                dataType : 'json',
                success  : function(response) {
                    if (response.success) {
                        dt.ajax.reload();
                    } else {
                        alert(response.data.message);
                    }
                    ladda.stop();
                }
            });
        }
    });

    $('[data-action=bookly-js-export]').on('click',function(){
        $('#bookly-export-coupon-dialog').modal('show');
    });
});