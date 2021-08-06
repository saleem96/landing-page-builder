(function($) {
    "use strict"; // Start of use strict
    // load content page
    const functionFormSubmit = function() {
        var url = window._formLink.trim();
        var values = $(this).serialize();
        var form = $(this);
        $.ajax({
            url: url,
            type: 'POST',
            data: values + `&_token=${window._token}`,
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    if (data.type_form_submit == 'url') {
                        window.location.href = data.redirect_url;
                    } else {
                        window.location.href = window._thankYouURL;
                    }

                    form.css("display", "none");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: data.error,
                    });

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr);
            }
        });

        return false;
    };

    const paymentButtonFunction = function() {
        
        var btn = $(this);
        var classBtn = btn.attr("class");
        var type = '';

        switch(classBtn) {

          case 'builder-stripe-button':
            type = 'stripe';
            break;

          case 'builder-paypal-button':
            type = 'paypal';
            break;

          default:
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: "Button don't support",
            });
            return false;
        }

        var btnID = window[btn.attr('id')];
        
        if (btnID != undefined && btnID.productid) {
            var values = `_token=${window._token}&_productid=${btnID.productid}&_type=${type}`;
            var notfi_err = '';
            if (btn.closest('form').length > 0) {
                var form = btn.closest('form');
                // validation form          
                var elements = form.find("select, textarea, input");

                $.each(elements, function(index, item) {
                    var attr_required = $(item).attr('required');
                    if (attr_required && !item.value) {
                        notfi_err += `<span>${item.name} is required</span><br>`;
                    }
                });

                if (!notfi_err) {
                    values += '&' + form.serialize();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: notfi_err,
                    });
                }
            }

            if (!notfi_err) {

                var url = window._orderLink.trim();
                
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: values,
                    beforeSend: function() { 
                      btn.attr("disabled", true);
                      btn.after('<smal id="loading-ajax-small">Loading...</small>');
                    },
                    success: function(data) {

                        if ($.isEmptyObject(data.error)) {
                            
                            if (type == 'stripe') {
                                var stripe = Stripe(`${data.stripe_key}`);
                                stripe.redirectToCheckout({
                                    sessionId: `${data.stripe_session_id}`
                                }).then(function (result) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        html: result.error.message,
                                    });
                                    document.location = `${data.page_url}`;
                                });
                            }
                            else if(type == 'paypal'){
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                }
                            }
                            
                        } else {
                            
                            btn.removeAttr("disabled");
                            $('#loading-ajax-small').remove();

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: data.error,
                            });

                        }
                        

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        btn.removeAttr("disabled");
                        $('#loading-ajax-small').remove();
                        
                        console.log(xhr);
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: 'You need set product for button',
            });
        }
        

    };


    $.ajax({
        url: window._loadPageLink,
        type: 'POST',
        data: `_token=${window._token}`,
        success: function(data) {
            if ($.isEmptyObject(data.error)) {
                $('head').append(data.custom_header);
                $('body').prepend(`<script type="text/javascript">
                                    ${data.main_page_script}
                                 </script>`);
                $('body').prepend(data.html);
                $('body').prepend(`<style>${data.css}</style>`);
                $('body').prepend(`<style>${data.blockscss}</style>`);

                $('body').append(data.custom_footer);
                $('#loadingMessage').css('display', 'none');

                $('form').on('submit', functionFormSubmit);
                $("button.builder-paypal-button").on('click', paymentButtonFunction);
                $("button.builder-stripe-button").on('click', paymentButtonFunction);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: data.error,
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr);
        }
    });



})(jQuery); // End of use strict