$( document ).ready(function() {

    /***************  Get report type selected in filter **************/
    $("#report-type").change(function(){
        $selectedReportType = $('option:selected', $(this)).val();
        $('#report_type_value').val($selectedReportType);
        $('#report_type_selected').text($('option:selected', $(this)).text());

    });

    $("#download_file").click(function(){
        var reportType = $('#report_type_value').val();
        if(reportType == ''){
            $('#report_type_error').text('Please select report type.');
            $('#report_type_error').show();
            return false;
        } else {
            $('#report_type_error').hide();
            $('form#frm-download-excel').submit();
        }
    });

});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

/*
* Clear search result and reload packages list.
* */
$("#clear-filter").on('click', function () {
    $("#param").val('');
    $("#from-date").val('');
    $("#to-date").val('');
    $("#mobile_no").val('');
    $("#whatsapp_no").val('');
    $("#city").val('');
    window.location.href("/customer/customers-list");
})

/*
* Delete call.
* @var id
* @var ajax_url
* */
$(".deleteVoucher").on('click', function () {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var ajax_url = config.routes.deleteVoucher;
    $.confirm({
        title: 'Delete Voucher!',
        content: 'Sure to delete Voucher?',
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
                            if (data.status == 'success') {
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Delete Voucher',
                                    subtitle: '',
                                    body: data.message

                                })
                                $("."+type + id).remove();
                                // $(".purchase" + id).remove();
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

/*
* Delete bank call.
* @var id
* @var ajax_url
* */
$(".deleteBank").on('click', function () {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var ajax_url = config.routes.deleteBank;
    $.confirm({
        title: 'Delete Bank!',
        content: 'Sure to delete Bank?',
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
                            if (data.status == 'success') {
                                $(document).Toasts('create', {
                                    class: 'bg-success',
                                    title: 'Delete Bank',
                                    subtitle: '',
                                    body: data.message

                                })
                                $("#bank_" + id).remove();
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



