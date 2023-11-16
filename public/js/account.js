/*
* Delete acccount call.
* @var id
* @var ajax_url
* */
$(".deleteAccount").on('click', function () {
    var id = $(this).attr('data-id');
    var ajax_url = config.routes.deleteAccount;
    $.confirm({
        title: 'Delete Account!',
        content: 'Sure to delete account?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: 'Yes Delete',
                btnClass: 'btn-red',
                action: function () {
                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: {"id": id},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#loading').css('display', 'block');
                        },
                        success: function (data) {
                            console.log(data);
                            if (data.status == 'success') {
                                // toastr.success(data.message);
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Delete Account',
                                    subtitle: '',
                                    body: data.message

                                })
                                $(".account" + id).remove();
                                $("#toastsContainerTopRight").delay(3000).slideUp(300);
                                location.reload();
                            } else {
                                toastr.error(data.message)
                            }
                        },
                        complete: function () {
                            $('#loading').css('display', 'none');
                        },
                        error: function (errorThrown) {
                            var errors = errorThrown.responseJSON.errors;
                            toastr.error(errors);
                        }
                    });
                }

            },
            close: function () {
                $.alert('Deletion Canceled!');
            },
        }
    });
});


$(document).ready(function () {
    $('#advance-search-btn').on('click', function (event) {
        $("#from-date, #to-date, #mobile_no, #whatsapp_no, #city").val('');
        $("#advance-search").toggle('slow');
    });

    if ($("#from-date").val() != '' || $("#to-date").val() != '' || $("#mobile_no").val() != '' || $("#whatsapp_no").val() != '' || $("#city").val() != '') {
        $("#advance-search").show();
    }

    $("#account_type").on('change', function () {
        let type = $(this).val();
        console.log(type);
        if (type == 'E') {
            $("#email-div").css('display', 'none');
            $("#phone-div").css('display', 'none');
            $("#mobile-div").css('display', 'none');
            $("#whatsapp-div").css('display', 'none');
            $("#city-div").css('display', 'none');
            $("#mailingAddress-div").css('display', 'none');
            $("#shippingAddress-div").css('display', 'none');
        } else {
            $("#email-div").css('display', 'block');
            $("#phone-div").css('display', 'block');
            $("#mobile-div").css('display', 'block');
            $("#whatsapp-div").css('display', 'block');
            $("#city-div").css('display', 'block');
            $("#mailingAddress-div").css('display', 'block');
            $("#shippingAddress-div").css('display', 'block');
        }
    });
});


