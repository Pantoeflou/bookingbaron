jQuery(function ($) {

    function Archivarius(options) {
        var obj = this;
        $.extend(obj, options);
    }

    Archivarius.prototype = {
        getArchived: function () {
            return $('.bookly-js-archived', this.containers.categories);
        },
        refreshCounters: function () {
            var count = this.getArchived().length;
            this.containers.counterArch.html(count > 0 ? count : '');
            this.containers.counterStaff.html(this.containers.categories.find('ul.bookly-js-staff-members li.bookly-nav-item:not(.bookly-js-archived)').length);
            this.toggle.toggle(count != 0);
        },
        archiving: function (staff_id, archiving) {
            var $archiveButton = $('.bookly-js-staff-archive', this.containers.staff),
                ladda = Ladda.create($archiveButton[0]),
                self  = this
            ;
            if (archiving != 'verify') {
                ladda.start();
            }
            $.ajax({
                url  : ajaxurl,
                type : 'POST',
                data: {
                    action: 'bookly_pro_archiving_staff',
                    csrf_token: self.csrfToken,
                    staff_id: staff_id,
                    archiving: archiving
                },
                dataType : 'json',
                success  : function(response) {
                    if (response.success) {
                        // Click on button 'Archive' and staff without affecting appointments
                        if (archiving === 'verify-and-confirm') {
                            if (confirm(self.l10n.areYouSure)) {
                                self.archiving(staff_id, 'force');
                            }
                        } else if (archiving != 'verify') {
                            $('#bookly-visibility', self.containers.staff).val('archive');
                            $archiveButton.hide();
                            self.muteStaff(staff_id, true);
                        }
                        self.confirmation.modal('hide');
                    } else {
                        self.confirmation.modal({backdrop: 'static', keyboard: false});
                        self.confirmation.find('.bookly-js-staff-archive').toggle(archiving !== 'verify');
                        self.confirmation.find('.btn-success').toggle(archiving === 'verify');
                        self.confirmation.find('.bookly-js-edit').off().on('click', function () {
                            ladda = Ladda.create(this);
                            ladda.start();
                            window.location.href = response.data.filter_url;
                        }).show();
                    }
                    ladda.stop();
                    Ladda.create($('.bookly-js-staff-archive', self.confirmation)[0]).stop();
                }
            });
        },
        muteStaff: function (staff_id, state) {
            var archived = this.getArchived().length;
            $('.bookly-nav-item[data-staff-id=' + staff_id + ']', this.containers.categories).toggleClass('bookly-staff-archived bookly-js-archived', state);
            this.refreshCounters();
            this.containers.staff.find('.bookly-js-staff-archive').toggle(!state);
            if (archived == 0 && state === true) {
                // Archive first staff, show 'Hide archived staff' button
                $('span', this.toggle).html(this.l10n.hideStaff);
                this.toggle.attr('aria-pressed', 'true').addClass('active');
            } else if (!state) {
                // When status not equal to Archive, show staff if hidden
                $('.bookly-nav-item[data-staff-id=' + staff_id + ']', this.containers.categories).show();
            }
        },
        getStaffId: function () {
            return $('[name=id]', this.containers.staff).val();
        },
        init: function () {
            var self = this;
            this.getArchived().hide();
            $('span',this.toggle).html(self.l10n.showStaff);
            this.refreshCounters();
            this.containers.staff
                .on('click', '.bookly-js-staff-archive', function (e) {
                    self.archiving(self.getStaffId(), 'verify-and-confirm');
                })
                .on('click', '#bookly-details-save', function (e) {
                    e.preventDefault();
                    var archived = $('#bookly-visibility', self.containers.staff).val() == 'archive';
                    self.muteStaff(self.getStaffId(), archived);
                    self.refreshCounters();
                })
                .on('change', '#bookly-visibility', function () {
                    if (this.value == 'archive') {
                        self.archiving(self.getStaffId(), 'verify');
                    }
                });
            this.toggle
                .on('click', function () {
                    var pressed = $(this).attr('aria-pressed') == 'true';
                    self.getArchived().toggle(!pressed);
                    if (pressed) {
                        $('span',self.toggle).html(self.l10n.showStaff);
                    } else {
                        $('span',self.toggle).html(self.l10n.hideStaff);
                    }
                });
            this.confirmation
                .on('click', '.bookly-js-staff-archive', function(){
                    Ladda.create(this).start();
                    self.archiving(self.getStaffId(), 'force');
                })
                .on('click', '.bookly-js-close', function () {
                    // Check if clicked button Cancel when changed staff value visibility to 'archive'
                    if (self.confirmation.find('.btn-success').css('display') != 'none') {
                        // Reset visibility value to previous.
                        var $visibility = $('#bookly-visibility', self.containers.staff);
                        $visibility.val($visibility.data('default'));
                    }
                });
        }
    };

    var archTool = new Archivarius({
        containers: {
            staff        : $('#bookly-container-edit-staff'),
            categories   : $('#bookly-staff-categories'),
            counterArch  : $('#bookly-staff-archived-count'),
            counterStaff : $('#bookly-staff-count'),
        },
        csrfToken : BooklyL10nStaffArchive.csrfToken,
        toggle    : $('[data-action=toggle-archive]'),
        confirmation: $('#bookly-archiving-confirmation'),
        l10n: {
            areYouSure: BooklyL10nStaffArchive.areYouSure,
            showStaff:  BooklyL10nStaffArchive.showArchivedStaff,
            hideStaff:  BooklyL10nStaffArchive.hideArchivedStaff
        }
    });

    archTool.init();
});