/*
* Delete Sale call.
* @var id
* @var ajax_url
* */
$(".delete").on('click', function () {
    var id = $(this).attr('data-id');
    var ajax_url = config.routes.deleteSale;
    $.confirm({
        title: 'Delete Sale!',
        content: 'Sure to delete Sale?',
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
                                    title: 'Delete Sale',
                                    subtitle: '',
                                    body: data.message

                                })
                                $(".sale" + id).remove();
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

$('body').on("focusout", ".quantity", function () {
    var row_id = $(this).closest("tr").find(".row_id").val();
    let quantity = $(this).closest("tr").find(".quantity_" + row_id).val();
    let price = $(this).closest("tr").find(".price_" + row_id).val();
    console.log(row_id + ", " + quantity + ", " + price);
    if (parseInt(quantity) > 0) {
        $(this).closest("tr").find(".amount_" + row_id).val(quantity * price);
    } else {
        $(this).closest("tr").find(".amount_" + row_id).val('');
    }
});

/*
* Get all sales for selected brand.
* */
$('body').on('change', '#brand_id', function () {
    var brandCode = $("#brand_id option:selected").val();
    var categoryCode = $("#category_id option:selected").val();
    if (brandCode != '') {
        $.ajax({
            url: config.routes.getBrandProducts,
            type: 'GET',
            dataType: "json",
            data: {'brandCode': brandCode, 'categoryCode': categoryCode},
            beforeSend: function () {
                $(".overlay").show();
                $(".product_id").prop('disabled', true);
            },
            success: function (response) {
                var $row = jQuery(this).closest("tr");
                if (response.status == 'success') {
                    $(".product_id").empty();
                    $(".price").val('');
                    $(".product_id").append($("<option />").val("").text("Select"));
                    $.each(response.data, function (key, value) {
                        $(".product_id").append($("<option />").val(value.id).text(value.name));
                    });
                } else {
                    $(".product_id").empty();
                    $(".overlay").hide();
                }
            },
            complete: function () {
                $(".overlay").hide();
                $(".product_id").prop('disabled', false);
            },
            error: function (error) {
                toastr.error(error);
            }
        });
    } else {
        $(".product_id").empty();
        $(".price").val('');
    }
});

/*
* Get all sales for selected brand.
* */
$('body').on('change', '.product_id', function () {
    // var productCode = $(".product_id option:selected").val();
    var productCode = $(this).val();
    var row_id = $(this).closest("tr").find(".row_id").val();
    // console.log(row_id);
    if (productCode != '') {
        $.ajax({
            url: config.routes.getProductDetail,
            type: 'GET',
            dataType: "json",
            data: {'productCode': productCode},
            beforeSend: function () {
                $(".overlay").show();
                $(".product_id_" + row_id).prop('disabled', true);
                $(".price_" + row_id).prop('disabled', true);
            },
            success: function (response) {
                var $row = jQuery(this).closest("tr");
                if (response.status == 'success') {
                    console.log(row_id);
                    console.log(response.data.price);
                    $(".price_" + row_id).empty();
                    $(".price_" + row_id).val(response.data.sale_price);
                    // $(".item_class_" + row_id).val(response.item_class);
                } else {
                    $(".price").empty();
                }
            },
            error: function (error) {
                toastr.error(error);
            },
            complete: function () {
                $(".product_id_" + row_id).prop('disabled', false);
                $(".price_" + row_id).prop('disabled', false);
                $(".overlay").hide();
            },
        });
    } else {
        $(".price_" + row_id).empty();
    }

});

/*
* Duplicate row of Grid.
* */
$('body').on('click', '.btn-duplicate', function (e) {
    e.preventDefault();
    var $tr = $(this).closest('.tr_clone');
    var $clone = $tr.clone();
    $clone.find(':text').val('');
    $clone.find("input").val("").end();
    $tr.append().after($clone);

    var numItems = $('.tr_clone').length;
    var nextId = parseInt(numItems) - parseInt(1);
    console.log(nextId);
    $clone.removeClass("validator_0");
    $clone.addClass("validator_" + nextId);
    $(this).attr('data-item-number', "");
    $clone.find(".row_id").val(nextId);
    $clone.find(".purchase_id").removeClass("purchase_id_0");
    $clone.find(".purchase_id").addClass("purchase_id_" + nextId);
    $clone.find(".quantity").removeClass("quantity_0");
    $clone.find(".quantity").addClass("quantity_" + nextId);
    $clone.find(".price").removeClass("price_0");
    $clone.find(".price").addClass("price_" + nextId);
    $clone.find(".amount").removeClass("amount_0");
    $clone.find(".amount").addClass("amount_" + nextId);

    //remove old select2 span and trigger new event for select2
    $('.tr_clone').find("select.product_id").next(".select2-container").remove();
    $('.tr_clone').find("select.product_id").next(".select2-container").remove();
    $('.tr_clone').find(".product_id").select2();

    if (parseInt(nextId) > 0) {
        $clone.find(".delete-row").removeClass("delete_row_0");
        $clone.find(".delete-row").addClass("delete_row_" + nextId);
        $(".delete_row_" + nextId).show();
    }
    $(".purchase_id_" + nextId).val("");
    doQuantityTotal();
    doAmountTotal();
});

/*
* Remove duplicated row.
* */
$('body').on('click', '.delete-row', function (e) {
    e.preventDefault();
    $(this).closest("tr").remove();
    doQuantityTotal();
    doAmountTotal();
});

/*
* Validate on click of save button
* */
$("#save").on('click', function () {
    console.log($("#sale-date").val());
    if ($("#sale-date").val() == '') {
        toastr.error('Please select the date');
        return false;
    } else if ($("#customer_id").val() == '') {
        toastr.error('Please select the customer');
        return false;
    } else if ($("#brand_id").val() == '') {
            toastr.error('Please select the brand');
            return false;
    } else if ($("#tracking_number").val() == '') {
        toastr.error('Please enter the tracking number');
        return false;
    } else if ($(".product_id").val() == '') {
        toastr.error('Please select the product');
        return false;
    } else if ($(".rate").val() == '') {
        toastr.error('Please enter the rate');
        return false;
    } else if ($(".quantity").val() == '') {
        toastr.error('Please enter the quantity');
        return false;
    } else {
        $("#frmSale").submit();
    }
});

$('body').on('keyup', '.quantity', function (e) {
    doQuantityTotal();
});

$('body').on('focusout', '.quantity', function (e) {
    $(".amount").each(function () {
        var amount = $(".amount").val();
        console.log(amount);
    });
    doAmountTotal();
});

function doQuantityTotal() {
    //Initialize total to 0
    var totalQty = 0;
    $(".quantity").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            totalQty += parseFloat(this.value);
        }
    });
    $('#totalQty').val(totalQty.toFixed(2));
}

function doAmountTotal() {
    var totalAmount = 0;
    $(".amount").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            totalAmount += parseFloat(this.value);
        }
    });
    $('#totalAmount').val(totalAmount.toFixed(2));
}
