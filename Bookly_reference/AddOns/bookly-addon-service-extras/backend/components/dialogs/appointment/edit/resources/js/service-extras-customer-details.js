jQuery(function ($) {
    $('body')
        .on('bookly.edit.customer_details', {},
            // Bin handler for customer details in Appointment Form.
            function (event, $container, customer) {
                $('#bookly-number-of-persons', $container).on('change', function () {
                    if (customer.extras_multiply_nop == 1 && this.value > 1) {
                        $('.bookly-js-nop').text(this.value);
                        $('.bookly-js-nop-wrap').show();
                    } else {
                        $('.bookly-js-nop-wrap').hide();
                    }
                }).trigger('change');
            }
        );
});