jQuery(function($) {
    var luxoft = (function() {
        var $this;

        return {
            init: function(el) {
                if ($this) {
                    return ;
                }

                $this = this;
                $this.initSaveAddress();
            },
            initSaveAddress: function() {
                $('#address_form').on('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $.ajax({
                        url: ajax_object.ajax_url,
                        data: {
                            action: 'luxoftmail_ajax',
                            lux_action: 'front_address',
                            args: 'address=' + $('#luxoft_address').val()
                        },
                        type: "POST",
                        dataType: 'json',
                        success: function(response) {
                            if (typeof response == 'undefined') {
                                return false;
                            }
                            if (response.result) {
                                $('#luxoft_address').val(response.address);
                            }
                            //alert('address has been saved');
                        }
                    });
                });
            }
        }
    })();

    luxoft.init();
});