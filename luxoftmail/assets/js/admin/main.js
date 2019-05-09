jQuery(function($) {
    window.Notify = function (text, callback, close_callback, style) {
        var time = '3000';
        var $container = $('#ads-notify');
        var icon = '<i class="fa fa-info-circle"></i>';

        if (typeof style === 'undefined') {
            style = 'warning';
        }

        var html = $('<div class="alert alert-' + style + '  hide">' + icon + " " + text + '</div>');
        $('<a>', {
            text: '×',
            class: 'notify-close',
            href: '#',
            click: function (e) {
                e.preventDefault();
                close_callback && close_callback();
                remove_notice()
            }
        }).prependTo(html);
        $container.prepend(html);
        html.removeClass('hide').hide().fadeIn('slow');

        function remove_notice() {
            html.stop().fadeOut('slow').remove();
        }

        var timer = setInterval(remove_notice, time);
        $(html).hover(function () {
            clearInterval(timer);
        }, function () {
            timer = setInterval(remove_notice, time);
        });

        html.on('click', function () {
            clearInterval(timer);
            callback && callback();
            remove_notice();
        });
    };

    window.ADS = {
        tryJSON: function (data) {
            try {
                var response = $.parseJSON(data);
            } catch (e) {
                console.log(data);
                return false;
            }
            return response;
        },
        objTotmpl: function (tmpl, data) {
            if (typeof Handlebars === 'undefined') {
                console.log('Handlebars not registry');
                return false
            }
            var template = Handlebars.compile(tmpl);
            return template(data);
        },
        serialize: function ($el) {
            var serialized = $el.serialize();
            if (!serialized) {
                serialized = $el.find('input[name],select[name],textarea[name]').serialize();
            }

            return serialized;
        },
        notify: function (message, type) {
            window.Notify(message, null, null, type);
        },
        mainRequest: function ($el, page) {
            var $this = this;
            var th = $el,
                    tmpl = $(th.data('ads_template')).html(),
                    action = th.data('addon_action'),
                    target = $(th.data('ads_target')),
                    data = {},
                    fields = $el.find('.ads-field');

            if (fields.length > 0) {
                data = fields.serialize();
            } else {
                if (typeof page == 'undefined') {
                    page = 1;
                }
                data = 'page = ' + page;
            }

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'luxoftmail_ajax',
                    lux_action: action,
                    args: data
                },
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        if (response.hasOwnProperty('error')) {
                            $this.notify(response.error, 'danger');
                        } else {
                            target.html($this.objTotmpl(tmpl, response));
                            $('body').trigger({
                                type : "page:init",
                                obj  : target,
                                pagination : {
                                    totalPage : response.totalPage,
                                    page      : response.page,
                                    limit     : response.limit
                                }
                            });
                        }
                    }
                }
            });
        },
        mainHandlers: function () {
            var $this = this;

            $('[data-addon_action]').each(function () {
                $this.mainRequest($(this));
            });

            $(document).on('click', 'button', function (e) {
                var that = $(this);
                var th = $(this).parents('.panel').find('[data-addon_action]');
                var saveButton = th.find('button[name="save"]');
                if ($(this).hasClass('addon-button')
                    && !$(this).hasClass('ads-no')
                    && typeof th !== 'undefined'
                ) {
                    e.preventDefault();
                    var action = th.data('addon_action');
                    action = 'save_' + action;
                    that.addClass('animate-spinner').prop('disabled', true);
                    $.ajax({
                        url: ajaxurl,
                        data: {
                            action: 'luxoftmail_ajax', 
                            lux_action: action,
                            args: $this.serialize(th)
                        },
                        type: "POST",
                        dataType: 'json',
                        success: function (response) {
                            that.removeClass('animate-spinner').prop('disabled', false);
                            if (response.result == false) {
                                $this.notify(response.message, 'danger');
                            } else {
                                $this.notify(response.message, 'success');                                
                            }
                            if (response.hasOwnProperty('address')) {
                                $('#address').val(response.address);
                            }
                        }
                    });
                }
            });
        },
        init: function () {
            this.mainHandlers();
        }
    };

    ADS.init();
});