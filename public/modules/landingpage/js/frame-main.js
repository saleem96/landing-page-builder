(function($) {
    "use strict"; // Start of use strict
    // load content page
    $.ajax({
        url: window._loadTemplateLink,
        type: 'POST',
        data: `_token=${window._token}`,
        success: function(data) {
            if ($.isEmptyObject(data.error)) {
                $('body').prepend(data.content);
                $('body').prepend(`<style>${data.style}</style>`);
                $('body').prepend(`<style>${data.blockscss}</style>`);
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