/*
* Generic Function to search values in the tables.
* */
function searchRecord(searchString, table) {
    $("#" + searchString).on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#" + table + " tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
}

/*
* Get approvers on selection of bu id.
* */
$('#bu_id').change(function () {
    var buId = $(this).val();
    $.ajax({
        url: config.routes.getApprovers + '/' + buId,
        type: 'GET',
        data: {},
        success: function (response) {
            var jsonResponse = $.parseJSON(response);
            if (jsonResponse.status == 'SUCCESS') {
                $("#approver_id").empty();
                $.each(jsonResponse.object, function (key, value) {
                    $("#approver_id").append($("<option />").val(value['id']).text(value['name']));
                });
            } else {
                alert('Problem in fetching data')
            }
        },
        error: function () {

        }
    });
});

/*
* Button to clear search text box.
* */
function tog(v){return v?'addClass':'removeClass';}
$(document).on('input', '.clearable', function(){
    $(this)[tog(this.value)]('x');
}).on('mousemove', '.x', function( e ){
    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');
}).on('touchstart click', '.onX', function( ev ){
    ev.preventDefault();
    $(this).removeClass('x onX').val('').change();
});

/*
* Clear search result and reload packages list.
* */
$("#clear-filter").on('click', function () {
    $("#param").val('');
    window.location.href("/contracts/list");
})


$( function() {
    $( "#sortable1, #sortable2" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
} );

function hideOrShowDropRow(){
    $(".sortable").each(function() {
        var dropRow = $(this).find(".drop-row"),
            hasRows = $(this).find("tbody tr").length;

        hasRows ? dropRow.hide() : dropRow.show();

        $('input:checkbox', this).prop('disabled', function (i, value) {
            return value;
        });
    });
}


$(".sortable").sortable({
    items: 'tbody > tr',
    connectWith: ".sortable",
    receive: function(event, ui) {
        $(this).find("tbody").append(ui.item);
        hideOrShowDropRow();
    }
});

hideOrShowDropRow();

$('#btn_save').click(function(e){
    /*$("#selected_content_group_ids").val('');
    $("#selected_bu_ids").val('');*/
    /* Create ids array for bu */
    let buIds = new Array();
    $('#tbl_assigned_bu input[type="checkbox"]').each(function () {
        buIds.push($(this).val())
    });
    $("#selected_bu_ids").val(buIds);

    /* Create ids array for content groups*/
    let contentGroupIds = new Array();
    $('#tbl_assigned_group input[type="checkbox"]').each(function () {
        contentGroupIds.push($(this).val())
    });
    $("#selected_content_group_ids").val(contentGroupIds);
});

