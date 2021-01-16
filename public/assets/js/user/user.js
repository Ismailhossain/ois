$(document).ready(function () {

    $("#close_modal").click(function () {

        $('#NewUserSave').trigger("reset");
        $('#user_edit_value').val('');
        $("#refreshbody").load(location.href + " #refreshbody>*", "");

    });
    $("#insertUser").click(function () {

        $('#ModalUser').modal('show');
        $("#hide_password").show();
        $("#hide_password_confirmation").show();
        $('#NewUserSave').trigger("reset");
        $('#clear_modal').remove();
        $('#save_user_data').remove();
        $('#cancel_update_button').remove();
        $('#update_button').remove();
        $('#close_modal').after("<input type='reset' id='clear_modal' onclick='' class='btn btn-default' value='Clear'/><input type='button' id='save_user_data' onclick='NewUserSave();' class='btn btn-default' value='Save'/>");
        $('#no_image_added1').remove();
        $('#my_user_image_url').remove();
    });


    $("#user_image").change(function () {
        $('#no_image_added1').remove();
        $('#my_user_image_url').remove();
        filePreview_user_image(this);
    });

    // $('#agentTable').DataTable();
});

// End of doc

function filePreview_user_image(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#user_image + img').remove();
            document.getElementById("user_image_url").innerHTML = "<img style='width:60px;height:60px' src=" + e.target.result + " id='my_user_image_url' />";
        }
        reader.readAsDataURL(input.files[0]);
    }
}


// Adding User

function NewUserSave() {
    let name = document.getElementById('name').value;
    let agent_id = document.getElementById('agent_id').value;
    let email = document.getElementById('email').value;
    var property_name = $("#property_name").val();
    let password = document.getElementById('password').value;
    let password_confirmation = document.getElementById('password_confirmation').value;
    let file = document.getElementById('user_image');
    let files = file.files;

    let formData = new FormData();
    formData.append('name', name);
    formData.append('agent_id', agent_id);
    formData.append('email', email);
    formData.append('property_name', property_name);
    formData.append('password', password);
    formData.append('password_confirmation', password_confirmation);
    formData.append('user_image', files[0]);
    // console.log(files[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // 'Content-type': 'multipart/form-data'
        }
    });
    var request = $.ajax({
        type: 'post',
        url: 'user/store',
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


// Edit User

function edit_user(id) {

    $("#hide_password").hide();
    $("#hide_password_confirmation").hide();
    $('#my_user_image_url').remove();
    $('#ModalUser').modal('show');
    let val = $('#user_edit_value').val();
    if (!val) {
        if (id !== '') {

            $('#user_edit_value').val(1);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var request = $.ajax({
                type: 'post',
                url: 'user/edit',
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
                    let all_image_url = $('#all_image_url').val();
                    if (response.dataUser.image !== "") {
                        user_image_url = all_image_url + '/images/' + response.dataUser.image;
                        document.getElementById("user_image_url").innerHTML = "<img style='width:60px;height: 60px' src=" + user_image_url + " id='my_user_image_url' />";

                    } else {
                        $("#no_image_added1").html("No image added previously");
                    }
                    document.getElementById("hidden_user_id").value = response.dataUser.id;
                    document.getElementById("name").value = response.dataUser.name;
                    document.getElementById("agent_id").value = response.dataUser.agent_id;
                    document.getElementById("email").value = response.dataUser.email;
                    document.getElementById("hidden_user_image").value = response.dataUser.image;
                    for (var i = 0; i < response.dataUserProperties.length; i++) {
                        document.querySelector('#property_name [value="' + response.dataUserProperties[i].property_id + '"]').selected = true;
                    }

                    $('#clear_modal').remove();
                    $('#save_user_data').remove();
                    $('#cancel_update_button').remove();
                    $('#update_button').remove();
                    $('#close_modal').after("<input type='button' id='cancel_update_button' onclick='cancel_user_update(" + id + ")' class='btn btn-default' value='Cancel'/><input type='button' id='update_button' onclick='update_user(" + id + ")' class='btn btn-default' value='Update'/>");

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


function update_user(id) {

    if (id !== '') {

        let name = document.getElementById('name').value;
        let agent_id = document.getElementById('agent_id').value;
        let email = document.getElementById('email').value;
        var property_name = $("#property_name").val();
        let hidden_user_image = document.getElementById('hidden_user_image').value;
        let file = document.getElementById('user_image');
        let files = file.files;

        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', name);
        formData.append('agent_id', agent_id);
        formData.append('email', email);
        formData.append('property_name', property_name);
        formData.append('hidden_user_image', hidden_user_image);
        formData.append('user_image', files[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        var request = $.ajax({
            type: 'post',
            url: 'user/update',
            processData: false,
            contentType: false,
            headers: {},

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
                $("#refreshbody").load(location.href + " #refreshbody>*", "");
                // $('#UserGrid').data('kendoGrid').dataSource.read();
                $('#user_edit_value').val('');
                $('#NewUserSave').trigger("reset");

            }
            if (response.result == 'error') {
                $('#user_edit_value').val('');

            }
        });


    }

}

function cancel_user_update(id) {

    $('#ModalUser').modal('hide');
    $('#user_edit_value').val('');
    $("#refreshbody").load(location.href + " #refreshbody>*", "");
    $('#NewUserSave').trigger("reset");
}


function delete_user(id) {


    if (confirm('Are you sure you want to Delete this user?')) {

        if (id !== '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            var request = $.ajax({
                type: 'post',
                url: 'user/destroy',
                data: {
                    // '_token': _token,
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

                    $('#user_edit_value').val('');
                    $("#refreshbody").load(location.href + " #refreshbody>*", "");
                }
                if (response.result == 'error') {
                    $('#user_edit_value').val('');

                }
            });

            // event.preventDefault();

        }


    } else {
        $('#user_edit_value').val('');
    }

}

