jQuery(function($) {

    var
        $packages_list      = $('#bookly-packages-list'),
        $check_all_button   = $('#bookly-check-all'),
        $id_filter          = $('#bookly-filter-id'),
        $date_filter        = $('#bookly-filter-date'),
        $staff_filter       = $('#bookly-filter-staff'),
        $customer_filter    = $('#bookly-filter-customer'),
        $package_filter     = $('#bookly-filter-package'),
        $service_filter     = $('#bookly-filter-service'),
        $add_button         = $('#bookly-add'),
        $delete_button      = $('#bookly-delete'),
        isMobile            = false
    ;

    try {
        document.createEvent("TouchEvent");
        isMobile = true;
    } catch (e) {

    }
    $('.bookly-js-select').val(null);
    $.each(BooklyPackagesL10n.filter, function (field, value) {
        if (value != '') {
            $('#bookly-filter-' + field).val(value);
        }
        // check if select has correct values
        if ($('#bookly-filter-' + field).prop('type') == 'select-one') {
            if ($('#bookly-filter-' + field +' option[value="' + value + '"]').length == 0) {
                $('#bookly-filter-' + field).val(null);
            }
        }
    });

    /**
     * Init DataTables.
     */
    var columns = [
        { data: 'id', responsivePriority: 2 },
        { data: 'created', responsivePriority: 2 },
        { data: 'staff.name', responsivePriority: 2 },
        { data: 'customer.full_name', render: $.fn.dataTable.render.text(), responsivePriority: 2 },
        {
            data: 'customer.phone',
            responsivePriority: 3,
            render: function (data, type, row, meta) {
                if (isMobile) {
                    return '<a href="tel:' + data + '">' + $.fn.dataTable.render.text().display(data) + '</a>';
                } else {
                    return $.fn.dataTable.render.text().display(data);
                }
            }
        },
        { data: 'customer.email', render: $.fn.dataTable.render.text(), responsivePriority: 3 },
        {
            data: 'package.title',
            responsivePriority: 2
        },
        {
            data: 'service.title',
            responsivePriority: 2
        },
        { data: 'package.size', responsivePriority: 2 },
        {
            data: 'payment',
            responsivePriority: 5,
            render: function ( data, type, row, meta ) {
                return '';
            }
        }
    ];

    var dt = $packages_list.DataTable({
        order: [[ 1, 'desc' ]],
        info: false,
        paging: false,
        searching: false,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {
            url : ajaxurl,
            type: 'POST',
            data: function (d) {
                return $.extend({action: 'bookly_packages_get_packages', csrf_token : BooklyPackagesL10n.csrf_token}, {
                    filter: {
                        id       : $id_filter.val(),
                        date     : $date_filter.data('date'),
                        staff    : $staff_filter.val(),
                        customer : $customer_filter.val(),
                        package  : $package_filter.val(),
                        service  : $service_filter.val()
                    }
                }, d);
            }
        },
        columns: columns.concat([
            {
                responsivePriority: 1,
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return '<button type="button" class="btn btn-default bookly-js-edit-package-schedule" title="' + BooklyPackagesL10n.scheduleAppointments + '"><i class="glyphicon glyphicon-calendar"></i></a>';
                }
            },
            {
                responsivePriority: 1,
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return '<button type="button" class="btn btn-default bookly-js-edit-package" title="' + BooklyPackagesL10n.editPackage + '"><i class="glyphicon glyphicon-pencil"></i></a>';
                }
            },
            {
                responsivePriority: 1,
                orderable: false,
                render: function ( data, type, row, meta ) {
                    return '<input type="checkbox" value="' + row.id + '" />';
                }
            }
        ]),
        language: {
            zeroRecords: BooklyPackagesL10n.zeroRecords,
            processing:  BooklyPackagesL10n.processing
        }
    });

    /**
     * Add package.
     */
    $add_button.on('click', function () {
        showPackageDialog(
            null,
            function(event) {
                dt.ajax.reload();
            }
        )
    });

    $packages_list.on('click', 'button.bookly-js-edit-package', function() {
        showPackageDialog(
            dt.row($(this).closest('td')).data().id,
            function(event) {
                dt.ajax.reload();
            }
        )
    });

    $packages_list.on('click', 'button.bookly-js-edit-package-schedule', function () {
        $(document.body).trigger('bookly_packages.schedule_dialog', [dt.row($(this).closest('td')).data().id, function (event) {
            dt.ajax.reload();
        }]);
    });

    /**
     * Select all packages.
     */
    $check_all_button.on('change', function () {
        $packages_list.find('tbody input:checkbox').prop('checked', this.checked);
    });

    /**
     * On appointment select.
     */
    $packages_list.on('change', 'tbody input:checkbox', function () {
        $check_all_button.prop('checked', $packages_list.find('tbody input:not(:checked)').length == 0);
    });

    /**
     * Delete appointments.
     */
    $delete_button.on('click', function () {
        var ladda = Ladda.create(this);
        ladda.start();

        var data = [];
        var $checkboxes = $packages_list.find('tbody input[type="checkbox"]:checked');
        $checkboxes.each(function () {
            data.push(this.value);
        });

        $.ajax({
            url  : ajaxurl,
            type : 'POST',
            data : {
                action     : 'bookly_packages_delete_packages',
                csrf_token : BooklyPackagesL10n.csrf_token,
                data       : data,
                notify     : $('#bookly-delete-notify').prop('checked') ? 1 : 0,
                reason     : $('#bookly-delete-reason').val()
            },
            dataType : 'json',
            success  : function(response) {
                ladda.stop();
                $('#bookly-delete-dialog').modal('hide');
                if (response.success) {
                    dt.draw(false);
                } else {
                    alert(response.data.message);
                }
            }
        });
    });

    /**
     * Init date range picker.
     */
    moment.locale('en', {
        months       : BooklyPackagesL10n.calendar.longMonths,
        monthsShort  : BooklyPackagesL10n.calendar.shortMonths,
        weekdays     : BooklyPackagesL10n.calendar.longDays,
        weekdaysShort: BooklyPackagesL10n.calendar.shortDays,
        weekdaysMin  : BooklyPackagesL10n.calendar.shortDays
    });

    var picker_ranges = {};
    picker_ranges[BooklyPackagesL10n.yesterday]  = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
    picker_ranges[BooklyPackagesL10n.today]      = [moment(), moment()];
    picker_ranges[BooklyPackagesL10n.tomorrow]   = [moment().add(1, 'days'), moment().add(1, 'days')];
    picker_ranges[BooklyPackagesL10n.last_7]     = [moment().subtract(7, 'days'), moment()];
    picker_ranges[BooklyPackagesL10n.last_30]    = [moment().subtract(30, 'days'), moment()];
    picker_ranges[BooklyPackagesL10n.this_month] = [moment().startOf('month'), moment().endOf('month')];
    picker_ranges[BooklyPackagesL10n.next_month] = [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')];

    $date_filter.daterangepicker(
        {
            parentEl: $date_filter.parent(),
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            ranges: picker_ranges,
            locale: {
                applyLabel : BooklyPackagesL10n.apply,
                cancelLabel: BooklyPackagesL10n.cancel,
                fromLabel  : BooklyPackagesL10n.from,
                toLabel    : BooklyPackagesL10n.to,
                customRangeLabel: BooklyPackagesL10n.custom_range,
                daysOfWeek : BooklyPackagesL10n.calendar.shortDays,
                monthNames : BooklyPackagesL10n.calendar.longMonths,
                firstDay   : parseInt(BooklyPackagesL10n.startOfWeek),
                format     : BooklyPackagesL10n.mjsDateFormat
            }
        },
        function(start, end) {
            var format = 'YYYY-MM-DD';
            $date_filter
                .data('date', start.format(format) + ' - ' + end.format(format))
                .find('span')
                .html(start.format(BooklyPackagesL10n.mjsDateFormat) + ' - ' + end.format(BooklyPackagesL10n.mjsDateFormat));
        }
    );

    /**
     * On filters change.
     */
    $('.bookly-js-select')
        .on('select2:unselecting', function(e) {
            e.preventDefault();
            $(this).val(null).trigger('change');
        })
        .select2({
            width: '100%',
            theme: 'bootstrap',
            allowClear: true,
            language  : {
                noResults: function() { return BooklyPackagesL10n.no_result_found; }
            }
        });

    $id_filter.on('keyup', function () { dt.ajax.reload(); });
    $date_filter.on('apply.daterangepicker', function () { dt.ajax.reload(); });
    $staff_filter.on('change', function () { dt.ajax.reload(); });
    $customer_filter.on('change', function () { dt.ajax.reload(); });
    $package_filter.on('change', function () { dt.ajax.reload(); });
    $service_filter.on('change', function () { dt.ajax.reload(); });
});