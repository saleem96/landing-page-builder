(function($) {
    "use strict"; // Start of use strict


    function makeIdRandom(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $(document).on('click', "button.btn-lead-delete", function() {
        var id_temp = $(this).attr('id');
        $(`#row-${id_temp}`).remove();
    });

    $('#btn-add-field-lead').on('click', function() {

        var id_temp = makeIdRandom(8);
        var field_add = `<div class="row" id="row-${id_temp}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" name="new_field[${id_temp}]" value=""  required class="form-control" placeholder="Field name">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="new_field_value[${id_temp}]" value="" required class="form-control" placeholder="Field value">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-lead-delete" id="${id_temp}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>`;
        $('#row-button-add-field').before(field_add);
    });



})(jQuery); // End of use strict