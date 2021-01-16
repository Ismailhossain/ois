$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $( "#agentName" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                type: 'post',
                url:'agent/name/autocomplete',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        select: function (event, ui) {
            $('#agentName').val(ui.item.label);
            var request = $.ajax({
                type: "post",
                url: 'agent/report',
                data: {'id': ui.item.user_id},
                dataType: "json",
                success: function (response) {
                    // location.reload();
                }
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
                    $('div.per_agent_report').html('');
                    $("div.per_agent_report").append(response.dataProperty);

                }
                if (response.result == 'error') {

                }
            });

            return false;
        }
    });






});


