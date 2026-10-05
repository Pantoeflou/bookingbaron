jQuery(function($) {
    $(document.body).on('recurring_appointments.series_dialog', {},
        function (event, series_id, callback) {
            var $modal   = $('#bookly-series-details-dialog').off(),
                $body    = $modal.find('.modal-body'),
                spinner  = $body.html();

            $modal
                .on('show.bs.modal', function (e) {
                    $.ajax({
                        url:      ajaxurl,
                        data:     {action: 'bookly_recurring_appointments_get_series_appointments', series_id: series_id, csrf_token: BooklyL10n.csrf_token},
                        dataType: 'json',
                        success:  function (response) {
                            if (response.success) {
                                $body.html(response.data.html);
                                $('.bookly-js-edit-appointment', $body).on('click', function () {
                                    $modal.modal('hide');
                                    showAppointmentDialog(jQuery(this).data('appointment_id'), null, null, callback);
                                });
                            }
                        }
                    });
                })
                .on('hidden.bs.modal', function () {
                    $body.html(spinner);
                    if (($('#bookly-appointment-dialog').data('bs.modal') || {isShown: false}).isShown) {
                        $('body').addClass('modal-open');
                    }
                }).modal();
        }
    );
});