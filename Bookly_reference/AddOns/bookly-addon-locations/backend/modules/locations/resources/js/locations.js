jQuery(function($) {

    var
        $locations_list      = $('#bookly-locations'),
        $check_all_button    = $('#bookly-locations-check-all'),
        $location_modal      = $('#bookly-location-modal'),
        $location_name       = $('#bookly-location-name'),
        $location_info       = $('#bookly-location-info'),
        $staff               = $('#bookly-js-staff'),
        $location_new_title  = $('#bookly-new-locations-title'),
        $location_edit_title = $('#bookly-edit-locations-title'),
        $save_button         = $('#bookly-location-save'),
        $delete_button       = $('#bookly-delete'),
        $add_button          = $('#bookly-location-add'),
        row
    ;

    /**
     * Init DataTables.
     */
    var dt = $locations_list.DataTable({
        paging: false,
        info: false,
        searching: false,
        processing: true,
        responsive: true,
        ajax: {
            url: ajaxurl,
            data: { action: 'bookly_locations_get_locations', csrf_token : BooklyL10n.csrfToken }
        },
        rowReorder: {
            dataSrc: 'position',
            snapX: true,
            selector: '.bookly-icon-draghandle'
        },
        order: [0, 'asc'],
        columnDefs: [
            { visible: false, targets: 0 },
            { orderable: false, targets: '_all' }
        ],
        columns: [
            {
                data: 'position'
            },
            {
                render: function (data, type, row, meta) {
                    return '<i class="bookly-icon bookly-icon-draghandle bookly-cursor-move" title="' + BooklyL10n.reorder + '"></i>';
                }
            },
            { data: 'name' },
            {
                data: 'staff_ids',
                render: function (data, type, row, meta) {
                    if (data.length == 0) {
                        return BooklyL10n.staff.nothingSelected;
                    } else if (data.length == 1) {
                        return BooklyL10n.staff.collection[data[0]].full_name;
                    } else {
                        if (data.length == Object.keys(BooklyL10n.staff.collection).length) {
                            return BooklyL10n.staff.allSelected;
                        } else {
                            return data.length + '/' + Object.keys(BooklyL10n.staff.collection).length;
                        }
                    }
                }
            },
            {
                responsivePriority: 1,
                render: function (data, type, row, meta) {
                    return '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#bookly-location-modal"><i class="glyphicon glyphicon-edit"></i> ' + BooklyL10n.edit + '</button>';
                }
            },
            {
                responsivePriority: 1,
                render: function (data, type, row, meta) {
                    return '<input type="checkbox" class="bookly-js-delete" value="' + row.id + '" />';
                }
            }
        ],
        language: {
            zeroRecords: BooklyL10n.zeroRecords,
            processing:  BooklyL10n.processing
        }
    }).on( 'row-reordered', function ( e, diff, edit ) {
        var position = {},
            pos;
        dt.data().each(function(location) {
            pos = location.position - 1;
            position[pos] = location.id;
        });
        $.ajax({
            url : ajaxurl,
            type: 'POST',
            data: {
                action: 'bookly_locations_update_locations_position',
                csrf_token : BooklyL10n.csrfToken,
                position: position
            },
            dataType: 'json',
            success: function (response) {

            }
        });
    });

    /**
     * Select all locations.
     */
    $check_all_button.on('change', function () {
        $locations_list.find('tbody input:checkbox').prop('checked', this.checked);
    });

    /**
     * On location select.
     */
    $locations_list.on('change', 'tbody input:checkbox', function () {
        $check_all_button.prop('checked', $locations_list.find('tbody input:not(:checked)').length == 0);
    });

    /**
     * Edit location.
     */
    $locations_list.on('click', 'button', function () {
        row = dt.row($(this).closest('td'));
    });

    /**
     * Add new location.
     */
    $add_button.on('click', function () {
        row = null;
    });

    /**
     * On show modal.
     */
    $location_modal.on('show.bs.modal', function (e) {
        var data;
        if (row) {
            data = row.data();
            $location_new_title.hide();
            $location_edit_title.show();
        } else {
            data = {title: '', staff_ids: []};
            $location_new_title.show();
            $location_edit_title.hide();
        }
        $location_name.val(data.name);
        $location_info.val(data.info);
        $staff.booklyDropdown('setSelected', data.staff_ids);
    });

    /**
     * Staff drop-down.
     */
    $staff.booklyDropdown();

    /**
     * Save location.
     */
    $save_button.on('click', function (e) {
        e.preventDefault();
        var $form = $(this).closest('form');
        var data = $form.serializeArray();
        data.push({name: 'action', value: 'bookly_locations_save_location'});
        if (row){
            data.push({name: 'id', value: row.data().id});
        }
        var ladda = Ladda.create(this, {timeout: 2000});
        ladda.start();
        $.ajax({
            url  : ajaxurl,
            type : 'POST',
            data : data,
            dataType : 'json',
            success  : function(response) {
                if (response.success) {
                    if (row) {
                        row.data(response.data).draw();
                    } else {
                        dt.row.add(response.data).draw();
                    }
                    $location_modal.modal('hide');
                } else {
                    alert(response.data.message);
                }
                ladda.stop();
            }
        });

    });

    /**
     * Delete locations.
     */
    $delete_button.on('click', function () {
        if (confirm(BooklyL10n.areYouSure)) {
            var ladda = Ladda.create(this);
            ladda.start();

            var data = [];
            var $checkboxes = $locations_list.find('input.bookly-js-delete:checked');
            $checkboxes.each(function () {
                data.push(this.value);
            });

            $.ajax({
                url  : ajaxurl,
                type : 'POST',
                data : {
                    action     : 'bookly_locations_delete_locations',
                    csrf_token : BooklyL10n.csrfToken,
                    locations  : data
                },
                dataType : 'json',
                success  : function(response) {
                    ladda.stop();
                    if (response.success) {
                        dt.rows($checkboxes.closest('td')).remove().draw();
                    } else {
                        alert(response.data.message);
                    }
                }
            });
        }
    });
});