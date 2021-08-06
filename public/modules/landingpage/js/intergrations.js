(function($) {
    "use strict"; // Start of use strict

    function actionAjaxLoading(response) {
        $(`#spinner-loading`).addClass('d-none');
        var alertLabel = 'alert-danger';
        if (response.status) {
            alertLabel = 'alert-success';
        }
        $('#alert-intergration')[0].className = `alert ${alertLabel}`;
        $(`#alert-intergration`).text(response.message);
    }

    function loadingMergeFieldsMailchimp(list_id, api_key, async = false) {
        $.ajax({
            type: "POST",
            async: async,
            url: url_load_merge_fields + `/mailchimp`,
            data: {
                api_key: api_key,
                list_id: list_id,
                "_token": _token
            },
            beforeSend: function() {
                $(`#spinner-loading`).removeClass('d-none');
            },
            success: function(response) {
                if (response.status == true) {
                    $('#merge_fields_span').text(response.data);
                    $('#mailchimp_merge_fields').val(response.data);
                } else {
                    $('#merge_fields_span').text('');
                    $('#mailchimp_merge_fields').val('');
                }

                $(`#spinner-loading`).addClass('d-none');
            }
        });
    }

    function loadingListMailchimp(input, api_key) {
        $.ajax({
            type: "POST",
            url: url_load_list + `/mailchimp`,
            data: {
                api_key: api_key,
                "_token": _token
            },
            beforeSend: function() {
                $(`#spinner-loading`).removeClass('d-none');
                input.prop('disabled', true);

            },
            success: function(response) {
                if (response.status == false) {
                    input.val('');
                    input.prop('disabled', false);
                    actionAjaxLoading(response);

                } else {

                    input.prop('disabled', false);
                    //select option mailing_list
                    var html_option = ``;
                    response.data.forEach(function(item) {
                        var selected = '';
                        if (item.id == item_intergration.settings['mailing_list']) {
                            selected = ' selected '
                        }
                        html_option += `<option value="${item.id}" ${selected}>${item.name}</option>`;

                    });
                    $('#mailchimp_mailing_list').html(html_option);

                    var list_id = $('#mailchimp_mailing_list :selected').val();

                    if (!list_id) {
                        list_id = $('#mailchimp_mailing_list option:nth-child(1)').val();
                    }

                    if (list_id) loadingMergeFieldsMailchimp(list_id, api_key);

                    actionAjaxLoading(response);
                }
                
                $("#loadingMessage").addClass('d-none');

                return false;

            }
        });
    }
    function cardIntergration(type)
    {
        var temp = '';
        $(".intergration_row").find(".card.active").each(function(e) {
            $(this).removeClass("active");
        });
        $(`#card_${type}`).addClass("active");

        $("#input_intergration_type").val(type);

        $('.form-intergration').addClass('d-none');
        $(`#form_${type}`).removeClass('d-none');
        $('#alert-intergration')[0].className = 'd-none';

    }
    function initIntergration(item_intergration) {

        cardIntergration(item_intergration.type);

        if (item_intergration.type == "mailchimp") {

            var input = $('#mailchimp_api_key');
            var api_key = input.val();
            
            if (api_key) {
                loadingListMailchimp(input, api_key);
            }
        }
    }
    
    $('#intergrations-tab').on('click', function(e) {
        initIntergration(item_intergration);
    });

    

    // app card click                                
    $(".intergration_row > .col-md-4 > .card").on('click', function(e) {
        var type = $(this).attr('data-type');
        cardIntergration(type);
    });


    $('#mailchimp_api_key').on('change', function(e) {
        var input = $(this);
        var api_key = $(this).val();
        //
        loadingListMailchimp(input, api_key, 'mailchimp');

    });

    $('#mailchimp_mailing_list').on('change', function(e) {

        var list_id = $(this).val();
        var api_key = $('#mailchimp_api_key').val();
        loadingMergeFieldsMailchimp(list_id, api_key, true);

    });

})(jQuery); // End of use strict