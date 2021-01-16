$(document).ready(function () {
    $('#signing_date').datepicker();
    $('#expiry_date').datepicker();

    // Start to Verify Phone Number

    $("#owner_phone").on('keyup', function (event) {
        if (!event.ctrlKey) {
            validateInp(this);
        }
    });

    function validateInp(elem) {
        var validChars = /[0-9]/;
        var strIn = elem.value;
        var strOut = '';
        for (var i = 0; i < strIn.length; i++) {
            strOut += (validChars.test(strIn.charAt(i))) ? strIn.charAt(i) : '';
        }
        elem.value = strOut;
    }

    // End of Verify Phone Number

    $("#close_modal").click(function () {

        $('#NewPropertySave').trigger("reset");
    });


    $("#insertProperty").click(function () {

        $('#ModalProperty').modal('show');
        $('#clear_modal').remove();
        $('#save_property_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();

        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_property_data' onclick='NewPropertySave();' class='btn btn-default' value='Save'/>");


        $('#NewPropertySave').trigger("reset");


    });
    $('#propertyTable').DataTable();
});


// End of DOC

function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}


function NewPropertySave() {


    event.preventDefault();

    Property_name = $("#name").val();
    Owner_name = $("#owner_name").val();
    Owner_email = $("#owner_email").val();
    Owner_phone = $("#owner_phone").val();
    Property_address = $("#address").val();
    Property_size = $("#size").val();
    Property_floor = $("#floor").val();
    Property_bed = $("#bed").val();
    Property_price = $("#price").val();
    Property_status = $("#status_id").val();
    Property_signing_date = $("#signing_date").val();
    Property_expiry_date = $("#expiry_date").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var request = $.ajax({
        type: 'post',
        url: 'property/store',
        data: {
            'name': Property_name,
            'owner_name': Owner_name,
            'owner_email': Owner_email,
            'owner_phone': Owner_phone,
            'address': Property_address,
            'size': Property_size,
            'floor': Property_floor,
            'bed': Property_bed,
            'price': Property_price,
            'status_id': Property_status,
            'signing_date': Property_signing_date,
            'expiry_date': Property_expiry_date,
        },
        dataType: "json"
    });
    request.done(function (msg) {
        noty({
            "text": msg.message,
            "theme": "noty_theme_twitter",
            "layout": "top",
            "type": msg.result,
            "animateOpen": {"height": "toggle"},
            "animateClose": {"height": "toggle"},
            "speed": 500,
            "timeout": 2000,
            "closeButton": false,
            "closeOnSelfClick": true,
            "closeOnSelfOver": false
        });
        if (msg.result == 'success') {
            $('#ModalProperty').modal('hide');
            $("#refreshbody").load(location.href + " #refreshbody>*", "");
        }
        if (msg.result == 'error') {
        }
    });


    event.preventDefault();

}


function edit_property(id) {

    $('#property_edit_value').val('');
    $('#ModalProperty').modal('show');

    let val = $('#property_edit_value').val();
    if (!val) {

        if (id !== '') {

            $('#property_edit_value').val(1);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var request = $.ajax({
                type: 'post',
                url: 'property/edit',
                data: {
                    'id': id,
                },
                dataType: "json"
            });
            request.done(function (response) {
                noty({
                    "text": response.message,
                    "theme": "noty_theme_twitter",
                    "layout": "top",
                    "type": response.result,
                    "animateOpen": {"height": "toggle"},
                    "animateClose": {"height": "toggle"},
                    "speed": 500,
                    "timeout": 2000,
                    "closeButton": false,
                    "closeOnSelfClick": true,
                    "closeOnSelfOver": false
                });
                if (response.result == 'success') {

                    document.getElementById("name").value = response.dataProperty.name;
                    document.getElementById("owner_name").value = response.dataProperty.owner_name;
                    document.getElementById("owner_email").value = response.dataProperty.owner_email;
                    document.getElementById("owner_phone").value = response.dataProperty.owner_phone;
                    document.getElementById("address").value = response.dataProperty.address;
                    document.getElementById("size").value = response.dataProperty.size;
                    document.getElementById("floor").value = response.dataProperty.floor;
                    document.getElementById("bed").value = response.dataProperty.bed;
                    document.getElementById("price").value = response.dataProperty.price;

                    document.querySelector('#status_id [value="' + response.dataProperty.status_id + '"]').selected = true;

                    document.getElementById("signing_date").value = response.dataProperty.signing_date;
                    document.getElementById("expiry_date").value = response.dataProperty.expiry_date;
                    $('#property_edit_value').val('');


                    $('#clear_modal').remove();
                    $('#save_property_data').remove();
                    $('#cancel_update_button').remove();
                    $('#update_button').remove();
                    $('#close_modal').after("<input type='button' id='cancel_update_button' onclick='cancel_property_update(" + id + ")' class='btn btn-default' value='Cancel'/><input type='button' id='update_button' onclick='update_property(" + id + ")' class='btn btn-default' value='Update'/>");

                }
                if (response.result == 'error') {

                }
            });

        }


    } else {
        alert("You are already Editing one User");
        return;

    }

}


function cancel_property_update(id) {
    $('#NewPropertySave').trigger("reset");
    $('#ModalProperty').modal('hide');
    $("#refreshbody").load(location.href + " #refreshbody>*", "");
}


function update_property(id) {


    if (id !== '') {
        Property_name = $("#name").val();
        Owner_name = $("#owner_name").val();
        Owner_email = $("#owner_email").val();
        Owner_phone = $("#owner_phone").val();
        Property_address = $("#address").val();
        Property_size = $("#size").val();
        Property_floor = $("#floor").val();
        Property_bed = $("#bed").val();
        Property_price = $("#price").val();
        Property_status = $("#status_id").val();
        Property_signing_date = $("#signing_date").val();
        Property_expiry_date = $("#expiry_date").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        var request = $.ajax({
            type: 'post',
            url: 'property/update',
            data: {
                'id': id,
                'name': Property_name,
                'owner_name': Owner_name,
                'owner_email': Owner_email,
                'owner_phone': Owner_phone,
                'address': Property_address,
                'size': Property_size,
                'floor': Property_floor,
                'bed': Property_bed,
                'price': Property_price,
                'status_id': Property_status,
                'signing_date': Property_signing_date,
                'expiry_date': Property_expiry_date,
            },
            dataType: "json"
        });
        request.done(function (response) {
            noty({
                "text": response.message,
                "theme": "noty_theme_twitter",
                "layout": "top",
                "type": response.result,
                "animateOpen": {"height": "toggle"},
                "animateClose": {"height": "toggle"},
                "speed": 500,
                "timeout": 2000,
                "closeButton": false,
                "closeOnSelfClick": true,
                "closeOnSelfOver": false
            });
            if (response.result == 'success') {
                $('#ModalProperty').modal('hide');
                $('#property_edit_value').val('');
                $("#refreshbody").load(location.href + " #refreshbody>*", "");
                $('#NewPropertySave').trigger("reset");
            }
            if (response.result == 'error') {
                $('#property_edit_value').val('');

            }
        });

    }

}


function delete_property(id) {


    if (confirm('Are you sure you want to Delete this property?')) {

        if (id !== '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var request = $.ajax({
                type: 'post',
                url: 'property/destroy',
                data: {
                    'id': id,
                },
                dataType: "json"
            });
            request.done(function (response) {
                noty({
                    "text": response.message,
                    "theme": "noty_theme_twitter",
                    "layout": "top",
                    "type": response.result,
                    "animateOpen": {"height": "toggle"},
                    "animateClose": {"height": "toggle"},
                    "speed": 500,
                    "timeout": 2000,
                    "closeButton": false,
                    "closeOnSelfClick": true,
                    "closeOnSelfOver": false
                });
                if (response.result == 'success') {

                    $('#property_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                }
                if (response.result == 'error') {
                    $('#property_edit_value').val('');

                }
            });

        }


    } else {
        $('#property_edit_value').val('');
    }

}








