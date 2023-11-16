/*
* Delete category call.
* @var id
* @var ajax_url
* */
$(".delete").on('click', function () {
    var id = $(this).attr('data-id');
    var ajax_url = config.routes.deleteCategory;
    $.confirm({
        title: 'Delete Category!',
        content: 'Sure to delete category?',
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
                                    title: 'Delete Category',
                                    subtitle: '',
                                    body: data.message

                                })
                                $(".category" + id).remove();
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
