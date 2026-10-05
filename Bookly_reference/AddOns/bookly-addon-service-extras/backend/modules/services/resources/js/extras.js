jQuery(function ($) {
    /*<Extras>*/
    $('.extras-container').sortable({
        axis   : 'y',
        handle : '.bookly-js-handle',
        update : function( event, ui ) {
            var data = [];
            $(this).find('.extra').each(function() {
                data.push($(this).data('extra-id'));
            });
            $.ajax({
                type : 'POST',
                url  : ajaxurl,
                data : { action: 'bookly_service_extras_update_extra_position', position: data, csrf_token : BooklyL10n.csrf_token }
            });
        }
    });

    $(document).on('click', '.bookly-js-collapse .extra-new', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var children = $('.extras-container li.new');

        var id = 1;
        children.each(function (i, el) {
            var elId = parseInt($(el).data('extra-id'));
            id = (elId >= id) ? elId + 1 : id;
        });
        var template = $('.bookly-js-templates.extras').html();
        var $container = $(this).parents('.bookly-js-collapse').find('.extras-container');
        id += '-new';
        $container.append(
            template.replace(/%id%/g, id)
        );

        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str.title_with_service)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        $('#title_extras_' + id).typeahead({
                hint: false,
                highlight: true,
                minLength: 0
            },
            {
                name: 'extras',
                display: 'title',
                source: substringMatcher(ExtrasL10n.list),
                templates: {
                    suggestion: function (data) {
                        return '<div>' + data.title_with_service + '</div>';
                    }
                }
            })
            .bind('typeahead:select', function(ev, suggestion) {
                $extras = $(this).closest('.extra');
                id = $extras.attr('data-extra-id');
                $extras.find('#title_extras_' + id, $extras).val(suggestion.title);
                $extras.find('#price_extras_' + id, $extras).val(suggestion.price);
                $extras.find('#max_quantity_extras_' + id, $extras).val(suggestion.max_quantity);
                $extras.find('#duration_extras_' + id, $extras).val(suggestion.duration);
                if (suggestion.image != false) {
                    $extras.find("[name='extras[" + id + "][attachment_id]']").val(suggestion.attachment_id);
                    $extras.find('.extra-attachment-image').css({'background-image': 'url(' + suggestion.image[0] + ')', 'background-size': 'cover'});
                    $extras.find('.bookly-js-remove-attachment').show();
                }
            });
        $('#title_extras_' + id).focus();
    });

    $(document).on('click', '.bookly-js-collapse .extra-attachment', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var extra = $(this).parents('.extra');
        var frame = wp.media({
            library: {type: 'image'},
            multiple: false
        });
        frame.on('select', function () {
            var selection = frame.state().get('selection').toJSON(),
                img_src
            ;
            if (selection.length) {
                if (selection[0].sizes['thumbnail'] !== undefined) {
                    img_src = selection[0].sizes['thumbnail'].url;
                } else {
                    img_src = selection[0].url;
                }
                extra.find("[name='extras[" + extra.data('extra-id') + "][attachment_id]']").val(selection[0].id);
                extra.find('.extra-attachment-image').css({'background-image': 'url(' + img_src + ')', 'background-size': 'cover'});
                extra.find('.bookly-js-remove-attachment').show();
                $(this).hide();
            }
        });

        frame.open();
    });

    $(document).on('click', '.bookly-js-collapse .bookly-js-remove-attachment', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).hide();
        var extra = $(this).parents('.extra');
        extra.find("[name='extras[" + extra.data('extra-id') + "][attachment_id]']").attr('value', '');
        extra.find('.extra-attachment-image').attr('style', '');
        extra.find('.extra-attachment').show();
    }).on('change', '.popover-range-start, .popover-range-end', function () {
        var $popover_content = $(this).closest('.popover-content');
        rangeTools.hideInaccessibleBreaks($popover_content.find('.popover-range-start'), $popover_content.find('.popover-range-end'));
    });

    $(document).on('click', '.bookly-js-collapse .extra-delete', function (e) {
        e.preventDefault();
        e.stopPropagation();
        if (confirm(BooklyL10n.are_you_sure)) {
            var extra = $(this).parents('.extra');
            if (!extra.hasClass('new')) {
                $.post(ajaxurl, {action: 'bookly_service_extras_delete_service_extra', id: extra.data('extra-id'), csrf_token : BooklyL10n.csrf_token}, function () {
                });
            }
            extra.remove();
        }
    });
    /*</Extras>*/
});