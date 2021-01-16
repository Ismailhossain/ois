$(document).ready(function () {

    $("#close_modal").click(function () {

        $('#NewUserSave').trigger("reset");
        $('#user_edit_value').val('');
        $("#refreshbody").load(location.href + " #refreshbody>*", "");

    });
    $("#insertUser").click(function () {

        $('#ModalUser').modal('show');
        $('#NewUserSave').trigger("reset");
        $('#clear_modal').remove();
        $('#save_user_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();
        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_user_data' onclick='NewUserSave();' class='btn btn-default' value='Save'/>");
    });


    // $('#agentTable').DataTable();
});

// End of doc




// Adding Bank Accounts

function NewUserSave() {
    let account_name = document.getElementById('account_name').value;
    let bank = document.getElementById('bank').value;
    let account_no = document.getElementById('account_no').value;
    var branch = $("#branch").val();
    let account_type = document.getElementById('account_type').value;
    let swift_code = document.getElementById('swift_code').value;
    let route_no = document.getElementById('route_no').value;

    let formData = new FormData();
    formData.append('account_name', account_name);
    formData.append('bank', bank);
    formData.append('account_no', account_no);
    formData.append('branch', branch);
    formData.append('account_type', account_type);
    formData.append('swift_code', swift_code);
    formData.append('route_no', route_no);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // 'Content-type': 'multipart/form-data'
        }
    });
    var request = $.ajax({
        type: 'post',
        url: 'bank_accounts/store',
        processData: false,
        contentType: false,
        headers: {

            // 'Content-Type':'multipart/form-data'
        },

        data: formData,
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
            $('#ModalUser').modal('hide');
            $('#user_edit_value').val('');
            $("#refreshbody").load(location.href + " #refreshbody>*", "");

        }
        if (response.result == 'error') {


        }
    });

    event.preventDefault();
}



