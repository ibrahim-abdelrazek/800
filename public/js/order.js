$(document).ready(function () {

    var changeOrdersId = [];
    var serviceOrderDetail = [];

    $(document).on('click', 'a[id^=btn_service_order_detail_table_row_]', function () {
        //alert($(this).text() + " hasan");
        var DocketNumber = this.id.replace("btn_service_order_detail_table_row_", "");
        for (var i = 0; i < serviceOrderDetail.length; i++) {
            var obj = $.parseJSON(serviceOrderDetail[i]);
            if (DocketNumber == obj.DocketNumber) {
                $(this).parent().parent().remove();
                serviceOrderDetail.splice(i, 1);
                blIsInArray = true;
                break;
            }
        }
    });

    function serviceOrderDetailAddObject(jsonObject) {
        var response = $.parseJSON(jsonObject);
        var blIsInArray = false;
        for (var i = 0; i < serviceOrderDetail.length; i++) {
            var obj = $.parseJSON(serviceOrderDetail[i]);
            if (response.DocketNumber == obj.DocketNumber) {
                blIsInArray = true;
            }
        }
        if (!blIsInArray) {
            serviceOrderDetail.push(jsonObject);
            var deletebuton = ' <a class="btn btn-danger btn-sm btn-outline bold pull-right" id="btn_service_order_detail_table_row_' + response.DocketNumber + '""><i class="fa fa-remove" aria-hidden="true"></i></a>';
            var tr = '<tr id = "service_order_detail_table_row_' + response.DocketNumber + '" ><td>' + response.DocketNumber + '</td><td>' + response.Price + '</td><td>' + response.ServiceName + '</td><td>' + deletebuton + '</td></tr>';
            $("#service_order_detail_table_body").append(tr);
        }
        else {
            $.notify( "This docket number already added.");
        }
    }

    function tableReLoad(oldStatus, newStatus) {

        if (oldStatus == "0" || newStatus == "0") {
            tableneworder.ajax.reload();
        }
        if (oldStatus == "1" || newStatus == "1") {
            tableinprocessorder.ajax.reload();
        }
        if (oldStatus == "2" || newStatus == "2") {
            tabledispatchedorder.ajax.reload();
        }
        if (oldStatus == "3" || newStatus == "3") {
            tabledeliveredorder.ajax.reload();
            if (false == true) {
                tabledeliveredorderwithmissingproducts.ajax.reload();
            }
        }
        if (oldStatus == "4" || newStatus == "4") {
            tableneworder.ajax.reload();
            tableinprocessorder.ajax.reload();
            tabledispatchedorder.ajax.reload();
            tabledeliveredorder.ajax.reload();
            if (false == true) {
                tabledeliveredorderwithmissingproducts.ajax.reload();
            }
            tablecanceledorder.ajax.reload();
        }

    }

    $.fn.dataTable.ext.errMode = 'none';
    $(".select2").select2({
        placeholder: function () {
            $(this).data('placeholder');
        },
        theme: "bootstrap",
        minimumResultsForSearch: -1
    });



    $('#cb_export_IsInStock').on('ifChecked', function (event) {
        $('#txt_export_IsInStock').val("With canceled items.");
    });

    $('#cb_export_IsInStock').on('ifUnchecked', function (event) {
        $('#txt_export_IsInStock').val("Without canceled items.");
    });

    //checking Data
    var staffData;
    var waitTime;
    var degree = 0;
    var soundCounter = 0;
    var maxSoundCounter = 1;

    if (true == true) {
        maxSoundCounter = 5;
    }

    var sound = new Howl({
        src: ['/assets/raw/notify.mp3'],
        loop: true,
        onplay: function () {
            if (soundCounter === maxSoundCounter - 1) {
                sound.loop(false);
            }
        },
        onend: function () {
            soundCounter++;
            if (soundCounter === maxSoundCounter - 1) {
                sound.loop(false);
            }
        }
    });

    var isDeliveryStaffEnable = true == true;
    if (isDeliveryStaffEnable) {
        GetDeliveryStaff();
    }

    _onload();

    timeout();
    function timeout() {
        setTimeout(function () {
            if (!$('#myModal').is(':visible')) {
                _onload();
            }
            timeout();
        }, 60000);
    }

    function _onload() {
        $.ajax({
            type: "GET",
            url: '/Order/CheckNewOrder',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (data) {
                if (data.NoData == "false") {
                    $('#table-in-process-order').DataTable().ajax.reload();
                    $('#table-new-order').DataTable().ajax.reload();
                    tabledeliveredorder.ajax.reload();
                    tabledispatchedorder.ajax.reload();
                    tablecanceledorder.ajax.reload();

                    $.notify(data.Message);
                    if (!sound.playing()) {
                        sound.play();
                    }
                }
                else if (data.NoData == "true") {
                    if (sound.playing() && true != true) {
                        sound.pause();
                    }
                }
                else if (data.NoData == "error") { }

                //data = undefined;
                $('.loading').hide();
            },
            error: function (exception) {
                console.log(exception);
                $('.loading').hide();
            }
        });
    }

    var table = $('#table-order-detail').DataTable();

    var includedColumns = [
        { "mDataProp": "name", "responsivePriority": 1 },
        { "mDataProp": "address", "responsivePriority": 2 },
        { "mDataProp": "created_at", "responsivePriority": 5 },
        { "mDataProp": "FormattedTotal", "responsivePriority": 3, "sClass": "alignRight" },
        { "mDataProp": "partner", "responsivePriority": 4 }
    ];
   

      var tableneworder = $('#table-new-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "0" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "cache": false,
        responsive: true,
        "order": [],
        "aoColumns": includedColumns,
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    var tableconfirmedorder = $('#table-confirmed-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "1" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "cache": false,
        responsive: true,
        "order": [],
        "aoColumns": includedColumns,
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    var tableinprocessorder = $('#table-in-process-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "2" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "cache": false,
        responsive: true,
        "order": [],
        "aoColumns": [
            { "mDataProp": "name", "responsivePriority": 1 },
            { "mDataProp": "address", "responsivePriority": 2 },
            { "mDataProp": "created_at", "responsivePriority": 5 },
            { "mDataProp": "FormattedTotal", "responsivePriority": 3, "sClass": "alignRight" },
            { "mDataProp": "partner", "responsivePriority": 4 }
        ],
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    var tabledispatchedorder = $('#table-dispatched-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "3" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "cache": false,
        responsive: true,
        "order": [],
        "aoColumns": [
            { "mDataProp": "name", "responsivePriority": 1 },
            { "mDataProp": "address", "responsivePriority": 2 },
            { "mDataProp": "created_at", "responsivePriority": 5 },
            { "mDataProp": "FormattedTotal", "responsivePriority": 3, "sClass": "alignRight" },
            { "mDataProp": "partner", "responsivePriority": 4 }
        ],
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });

    $.datepicker.regional[""].dateFormat = 'dd/mm/yy';
    $.datepicker.setDefaults($.datepicker.regional['']);

    var tabledeliveredorder = $('#table-delivered-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "4" });
            aoData.push({ name: "missingProducts", value: "false" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "fixedHeader": true,
        "cache": false,
        "order": [],
        "sDom": '<"top">t<"bottom"ilp<"clear">>',
        "aoColumns": [
            { "mDataProp": "name" },
            { "mDataProp": "address" },
            { "mDataProp": "DeliveredDate" },
            { "mDataProp": "FormattedTotal", "sClass": "alignRight" }
        ],
        "columnDefs": [{
            "targets": 2,
            "data": "DeliveredDate",
            "render": function (data, type, full, meta) {
                return GetFormattedDate(data);
            }
        }],
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    var tabledeliveredorderwithmissingproducts = $('#table-delivered-order-with-missing-products').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "4" });
            if (false == true) {
                aoData.push({ name: "missingProducts", value: "true" });
            }
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "fixedHeader": true,
        "cache": false,
        "order": [],
        "sDom": '<"top">t<"bottom"ilp<"clear">>',
        "aoColumns": [
            { "mDataProp": "name" },
            { "mDataProp": "address" },
            { "mDataProp": "DeliveredDate" },
            { "mDataProp": "FormattedTotal", "sClass": "alignRight" }
        ],
        "columnDefs": [{
            "targets": 2,
            "data": "DeliveredDate",
            "render": function (data, type, full, meta) {
                return GetFormattedDate(data);
            }
        }],
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    var tablecanceledorder = $('#table-canceled-order').DataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/Order/GetOrderTable",
        "fnServerParams": function (aoData) {
            aoData.push({ name: "orderstatus", value: "5" });
        },
        "sServerMethod": "GET",
        "bPaginate": false,
        "cache": false,
        "order": [],
        "sDom": '<"top">t<"bottom"ilp<"clear">>',
        "aoColumns": [
            { "mDataProp": "name" },
            { "mDataProp": "address" },
            { "mDataProp": "DeliveredDate" },
            { "mDataProp": "FormattedTotal", "sClass": "alignRight" }
        ],
        "columnDefs": [{
            "targets": 2,
            "data": "DeliveredDate",
            "render": function (data, type, full, meta) {
                return GetFormattedDate(data);
            }
        }],
        "language": {
            "lengthMenu": "_MENU_",

        },
        "createdRow": function (row, data, dataIndex) {
            if (data.BannedUser == true) {
                $(row).addClass('banned');
            }
        }
    });
    function SetupColumnSearch(table) {
        /* Setup column-level search input fields. */
        $(table.table().header()).find('th').each(function ($index) {
            var title = $(this).text();
            if ($index === 0 || $index === 1) {
                $(this).html('<input type="text" placeholder="' + title + '"id="' + table.table().node().id + '-' + title.toLowerCase() + '" oninput="stopPropagation(event)" onclick="stopPropagation(event);" />');
            }
            else if ($index === 2) {
                $(this).html('<input type="text" class="datepicker datatable_datepicker" placeholder="Date from" id="' + table.table().node().id + '-start-date" oninput="stopPropagation(event)" onclick="stopPropagation(event);" /><input type="text" class="datepicker datatable_datepicker" placeholder="Date to" id="' + table.table().node().id + '-end-date" oninput="stopPropagation(event)" onclick="stopPropagation(event);" />');
            }
            else if ($index === 3) {
                $(this).html('<input type="text" placeholder="Price from" id="' + table.table().node().id + '-start-number" oninput="stopPropagation(event)" onclick="stopPropagation(event);" /><input type="text" placeholder="Price to" id="' + table.table().node().id + '-end-number" oninput="stopPropagation(event)" onclick="stopPropagation(event);" />');
            }
        });

        /* Setup column-level searches on enter key only. */
        table.columns().every(function () {
            var columnInfo = this;
            var searchValue = '';

            $('input', columnInfo.header()).on('keyup change', function () {
                DatatableGetSearchParams(columnInfo, this);
            });
        });
    }

    function DatatableGetSearchParams(columnInfo, inputInfo) {
        if (columnInfo.search() !== inputInfo.value) {
            if (columnInfo.index() === 0 || columnInfo.index() === 1) {
                searchValue = inputInfo.value;
            }
            else if (columnInfo.index() === 2 || columnInfo.index() === 3) {
                var searchParam = columnInfo.search();
                if (inputInfo.id.indexOf("start") > -1) {
                    var lastPart = searchParam;

                    if (searchParam !== undefined && searchParam.indexOf("~") > -1) {
                        lastPart = searchParam.split("~")[1];
                    }

                    searchValue = inputInfo.value + "~" + lastPart;
                }
                else {
                    var firstPart = searchParam;

                    if (searchParam !== undefined && searchParam.indexOf("~") > -1) {
                        firstPart = searchParam.split("~")[0];
                    }

                    searchValue = firstPart + "~" + inputInfo.value;
                }
            }

            columnInfo.search(searchValue).draw();
        }
    }

    SetupColumnSearch(tabledeliveredorder);
    SetupColumnSearch(tabledeliveredorderwithmissingproducts);
    SetupColumnSearch(tablecanceledorder);

    $('#table-new-order').on('click', 'tbody tr', function (e) {

        var rowCount = tableneworder.row(this).count();
        if (rowCount != 0) {
            var data = tableneworder.row(this).data();
            var id = e.target.id;
            if (id === 'newOrderStatusChange' || id === 'buttonImage') {
                UpdateOrderStatus(data.id, 0);
            }
            else {
                GetNewOrderItemDetail(data.id);
                $('#myModal').modal('show');
            }
        }
    });

    $('#table-in-process-order').on('click', 'tbody tr', function () {
        var rowCount = tableinprocessorder.row(this).count();
        if (rowCount != 0) {
            var data = tableinprocessorder.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });
    $('#table-confirmed-order').on('click', 'tbody tr', function () {
        var rowCount = tableconfirmedorder.row(this).count();
        if (rowCount != 0) {
            var data = tableconfirmedorder.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });

    $('#table-dispatched-order').on('click', 'tbody tr', function () {
        var rowCount = tabledispatchedorder.row(this).count();
        if (rowCount != 0) {
            var data = tabledispatchedorder.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });

    $('#table-delivered-order').on('click', 'tbody tr', function () {
        var rowCount = tabledeliveredorder.row(this).count();
        if (rowCount != 0) {
            var data = tabledeliveredorder.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });

    $('#table-delivered-order-with-missing-products').on('click', 'tbody tr', function () {
        var rowCount = tabledeliveredorderwithmissingproducts.row(this).count();
        if (rowCount != 0) {
            var data = tabledeliveredorderwithmissingproducts.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });

    $('#table-canceled-order').on('click', 'tbody tr', function () {
        var rowCount = tablecanceledorder.row(this).count();
        if (rowCount != 0) {
            var data = tablecanceledorder.row(this).data();
            GetNewOrderItemDetail(data.id);
            $('#myModal').modal('show');
        }
    });

    $('#button_service_order_dropp_off').on('click', function () {
        var orderId = $('#service-order-dropp_off_id').val();
        if (orderId != undefined && orderId != "") {
            GetNewOrderItemDetail(orderId);
            $('#myModal').modal('show');
        }
    });

    $('#button_service_order_picked_up').on('click', function () {
        var orderId = $('#service-order-userid_picked_up_id').val();
        if (orderId != undefined && orderId != "") {
            GetNewOrderItemDetail(orderId);
            //var docketNo = $('#service-order-docket-number').val();
            //$('#order-detail-modal-title').text('Picked Up order for Laundry : ' + docketNo);
            $('#myModal').modal('show');
        }
    });

    function GetNewOrderItemDetail(_orderId) {

        //$('#order-detail-modal-title').text('Order');
        $("#order-picked-up-service").hide();
        
        $('#order-objectid').val('');
        $('#order-userid').val('');
        $('#order-name').val('');
        $('#order-surname').val('');
        $('#order-mobile').val('');
        $('#order-address').val('');
        $('#order-address-description').val('');
        $('#order-address-line').val('');
        $('#order-note').val('');
        $('#order-status').val('');
        $('#order-used-point-exchange').val('');
        $('#total-price').html('');
        $('#total-discount-price').html('');
        $('#total-normal-price').html('');
        $("#status-type").html('');
        $('#order-created-date').html('');
        $("#order-status-date").html('');
        $(".modal-footer").show();
        $("#button_cancel_order").show();
        $("#button_update_order").show();
        $("#button_update_order_status").show();
        $('#order-picked-up-service').val('')
        $("#order-picked-up-service-div").hide();
        $("#order-drop-off-service-div").hide();
        $("#order-stamp-orders-div").hide();
        // $("#table-order-detail tbody").html();
        $.ajax({
            type: "GET",
            url: "/Order/GetNewOrderItem?ObjectId=" + _orderId,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            async: false,
            beforeSend: function () { $('.loading').show(); },
            complete: function () { $('.loading').hide(); },
            success: function (data) {

                if (data.SurName == null) {
                    data.SurName = "";
                }

                $('#order-objectid').val(data.id);
                $('#order-userid').val(data.patient_id);
                $('#order-name').val(data.patient.first_name);
                $('#order-surname').val(data.patient.last_name);
                $('#order-mobile').val(data.patient.contact_number);
                $('#order-note').val(data.notes);
                $('#order-status').val(data.status.id);
                $('#total-price').append(data.FormattedTotal);
                $("#order-created-date").append(GetFormattedDate(data.CreatedDate));
                $("#button_print_order").attr("href", "/orders/" + data.id + "/print");
                $("#button_update_order").attr("href", "/orders/" + data.id + "/edit");
                $('#order_detail_drop_off_total').val('');
                $('.status-holder').addClass('btn-' + data.status.code);
                $('.status-holder span').html(data.status.message);

                if(data,status.id != 4)
                    $('.status-holder').addClass('dropdown-toggle');
                
                $('a#change-status').attr('data-order-id', data.id);
               


                
                if ('true' == "true") {
                    if (data.OrderImageId == undefined || data.OrderImageId == '') {
                        $("#button_order_detail_image").hide();
                    } else {
                        $("#button_order_detail_image").show();
                    }
                }

                switch (data.status_id) {
                    case 0:
                        $("#status-date-label").hide();
                        $("#staff-group").hide();
                        $("#button_order_detail_add").hide();
                        $("#button_cancel_order_detail").hide();
                        $('#order-estimated-delivery-time').attr("disabled", false);
                        break;
                    case 1:
                        $("#status-type").append('ConfirmedDate');
                        $("#order-status-date").append(GetFormattedDate(data.ConfirmedDate));
                        $("#status-date-label").show();
                        $("#button_order_detail_add").show();
                        $("#button_cancel_order_detail").show();
                        break;
                    case 2:
                        $("#status-type").append('In Processed');
                        $("#order-status-date").append(GetFormattedDate(data.InprocessDate));
                        $("#status-date-label").show();
                        $("#staff-group").show();
                        $("#button_order_detail_add").show();
                        $("#button_cancel_order_detail").show();
                        $('#order-estimated-delivery-time').attr("disabled", false);
                        $('#order-delivery-staff').attr("disabled", false);
                        if (data.DeliveryStaffID != null) {
                            $("#order-delivery-staff").val(data.DeliveryStaffID).trigger('change');
                        }
                        break;
                    case 3:
                        $("#status-type").append("Dispatched");
                        $("#order-status-date").append(GetFormattedDate(data.DispatchedDate));
                        $("#status-date-label").show();
                        $("#staff-group").show();
                        $("#button_order_detail_add").hide();
                        $("#button_cancel_order_detail").hide();
                        $('#order-estimated-delivery-time').attr("disabled", true);
                        if (data.DeliveryStaffID != null) {
                            $("#order-delivery-staff").val(data.DeliveryStaffID).trigger('change');
                            $('#order-delivery-staff').attr("disabled", true);
                        }
                        break;
                    case 4:
                        $("#status-type").append("Delivery");
                        $("#order-status-date").append(GetFormattedDate(data.DeliveredDate));
                        $("#status-date-label").show();
                        $("#staff-group").show();
                        $("#button_order_detail_add").hide();
                        $("#button_cancel_order_detail").hide();
                        $('#order-estimated-delivery-time').attr("disabled", true);
                        if (data.DeliveryStaffID != null) {
                            $("#order-delivery-staff").val(data.DeliveryStaffID).trigger('change');
                            $('#order-delivery-staff').attr("disabled", true);
                        }
                        $("#button_cancel_order").hide();
                        $("#button_update_order").hide();
                        $("#button_update_order_status").hide();
                        if (false == true) {
                            $("#order-picked-up-service-text").removeClass("textbox_service_order");
                            if (data.PickedUpServiceOrder != undefined && data.PickedUpServiceOrder != null) {
                                $("#order-picked-up-service-text").val("Laundry pick up order completed " + data.PickedUpDocketNumbers);
                            }
                        }
                        break;
                    case 5:
                        $("#order-payment-div").hide();
                        if (data.DeliveredDate != undefined && data.DeliveredDate != null && data.DeliveredDate != '' && data.DeliveredDate != '/Date(-62135596800000)/') {
                            $("#status-type").append("Canceled");
                            $("#order-status-date").append(GetFormattedDate(data.DeliveredDate));
                            $("#status-date-label").show();
                        }
                        else {
                            $("#status-date-label").hide();
                        }
                        $("#staff-group").hide();
                        $("#button_order_detail_add").hide();
                        $("#button_cancel_order_detail").hide();
                        $('#order-estimated-delivery-time').attr("disabled", true);
                        if (data.DeliveryStaffID != null) {
                            $("#order-delivery-staff").val(data.DeliveryStaffID).trigger('change');
                            $('#order-delivery-staff').attr("disabled", true);
                        }
                        $(".modal-footer").hide();
                        break;
                    default:
                }
                table.destroy();
                if(data.Orders==null){
                    data.Orders = [];
                }
                table = $('#table-order-detail').DataTable({
                    paging: false,
                    searching: false,
                    data: data.Orders,
                    cache: false,
                    responsive: true,
                    "aaSorting": [[2, "asc"]],
                    "columns": [
                        {
                            "mData": "IsAvailable",
                            "bSearchable": false,
                            "bSortable": false,
                            "responsivePriority": 2,
                            "mRender": function (data, type, full) {
                                if (false == true) {
                                    if ($('#order-status').val() < 2) {
                                        if (data)
                                            return '<input type="checkbox" checked>';
                                        else
                                            return '<input type="checkbox">';
                                    }
                                    else {
                                        if (data)
                                            return '<input type="checkbox" checked disabled>';
                                        else
                                            return '<input type="checkbox" disabled>';
                                    }
                                }
                                else {
                                    return '';
                                }
                            }
                        },
                        {
                            "sName": "ImageUrl",
                            "bSearchable": false,
                            "bSortable": false,
                            "responsivePriority": 5,
                            "sClass": "hidden-xs hidden-sm",
                            "mRender": function (data, type, full) {
                                return '<img src="' + full.ImageUrl + '" width="50" height="50" />'
                            }
                        },
                        { "mDataProp": "name", "responsivePriority": 1 },
                        { "mDataProp": "description", "responsivePriority": 8, "sClass": "hidden-xs hidden-sm hidden-md" },
                        { "mDataProp": "FormattedPricePerItem", "responsivePriority": 9, "sClass": "alignRight hidden-xs hidden-sm hidden-md" },
                        { "mDataProp": "Quantity", "responsivePriority": 4, "sClass": "alignRight hidden-xs" },
                        { "mDataProp": "sum", "responsivePriority": 7, "sClass": "alignRight hidden-xs hidden-sm" },
                        { "mDataProp": "FormattedDiscount", "responsivePriority": 6, "sClass": "alignRight text-danger hidden-xs hidden-sm" },
                        { "mDataProp": "FormattedPrice", "responsivePriority": 3, "sClass": "alignRight hidden-xs" },
                    ],
                    "createdRow": function (row, data, index) {
                        if (data.IsCanceled != null && data.IsCanceled != undefined && data.IsCanceled == true) {
                            $(row).addClass("cancel-item");
                        }
                        else {
                            $(row).removeClass("cancel-item");
                        }
                    }
                });
                

                if (false == false) {
                    table.column(0).visible(false);
                }

                if (false == true) {
                    stampRewardTable.destroy();
                    stampRewardTable = $('#table-order-detail-stamp-reward-list').DataTable({
                        paging: false,
                        searching: false,
                        data: data.StampRewardList,
                        cache: false,
                        responsive: true,
                        "aaSorting": [],
                        "columns": [
                            {
                                "sName": "ImageUrl",
                                "bSearchable": false,
                                "bSortable": false,
                                "responsivePriority": 3,
                                "sClass": "hidden-xs hidden-sm",
                                "mRender": function (data, type, full) {
                                    return '<img src="' + full.ImageUrl + '" width="50" height="50" />'
                                }
                            },
                            { "mDataProp": "ProductName", "responsivePriority": 1 },
                            { "mDataProp": "StampTitle", "responsivePriority": 2 }
                        ]
                    });
                }
            }
        });
    }

    $('#table-order-detail').on('draw.dt', function () {
        if (false == true) {
            //turn_on_icheck();
            isAvalible_calculate();
        }
    });

    //$('#table-order-detail').on('ifChanged', 'input[type=checkbox]', function () {
    //    //var orderId = $('#order-objectid').val();
    //    //addChangeOrdersId(orderId);
    //});

    $('#myModal').on('show.bs.modal', function (e) {
        $('#table-order-detail').hide();
        $('#table-order-detail-stamp-reward-list').hide();
    });

    $('#myModal').on('shown.bs.modal', function (e) {
        $('#table-order-detail').show();
        $('#table-order-detail-stamp-reward-list').show();
        table.columns.adjust().responsive.recalc();
    });

    $('#myModal').on('responsive-resize.dt', function (e, datatable, columns) {
        var tableColCount = $("#table-order-detail").find("tbody tr:first td").length;
        var stampTableColCount = $("#table-order-detail-stamp-reward-list").find("tbody tr:first td").length;
        if (tableColCount == columns.length) {
            if (false == true) {
                for (var i in columns) {
                    var index = parseInt(i, 10) + 1;
                    var state = columns[i] == true ? true : false;
                    $('#table-order-detail th:nth-child(' + (index) + ')').toggle(state);
                }
            }
        }

        if (stampTableColCount == columns.length) {
            if (false == true) {
                for (var i in columns) {
                    var index = parseInt(i, 10) + 1;
                    var state = columns[i] == true ? true : false;
                    $('#table-order-detail-stamp-reward-list th:nth-child(' + (index) + ')').toggle(state);
                }
            }
        }
    });

    function turn_on_icheck() {
        $('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square-blue'
        });
    }

    function isAvalible_calculate() {
        var isAvalible_normal_price = 0;
        var isAvalible_discount_price = 0;
        var isAvalible_total_price = 0;
        var dropOffTotal = 0;
        var usedPointsExchange = 0;

        if ($('#order-used-point-exchange').val() != undefined && $('#order-used-point-exchange').val() != null && $('#order-used-point-exchange').val() != "") {
            usedPointsExchange = $('#order-used-point-exchange').val();
        }

        if ($('#order_detail_drop_off_total').val() != undefined && $('#order_detail_drop_off_total').val() != null && $('#order_detail_drop_off_total').val() !="") {
            dropOffTotal = $('#order_detail_drop_off_total').val();
        }

        $('#isAvalible-normal-price').html('');
        $('#isAvalible-discount-price').html('');
        $('#isAvalible-total-price').html('');

        var detailData = $('#table-order-detail').DataTable().rows().data();
        for (var i = 0; i < detailData.length; i++) {
            var order_item = detailData[i];

            if (order_item.IsAvailable) {
                isAvalible_normal_price += order_item.NormalPrice;
                isAvalible_total_price += order_item.Price;
                dropOffTotal = Number(dropOffTotal) + Number(order_item.Price);
            }
        }

        isAvalible_total_price = isAvalible_total_price - Number(usedPointsExchange);
        isAvalible_discount_price = isAvalible_normal_price - isAvalible_total_price;

        $('#isAvalible-normal-price').append(isAvalible_normal_price.toFixed(2));
        $('#isAvalible-discount-price').append(isAvalible_discount_price.toFixed(2));
        $('#isAvalible-total-price').append(isAvalible_total_price.toFixed(2));

        if (false == true) {
            $('#top_total_of_all_service').html('');
            $('#top_total_of_all_service').append('<b>AED  ' + Number(dropOffTotal).toFixed(2)) + '</b>';
            $('#top_total_of_grocery_service').html('');
            $('#top_total_of_grocery_service').append('AED ' + isAvalible_total_price.toFixed(2));
        }
    }

    $('#table-order-detail').on('click', 'tbody tr', function () {
        var cell_clicked = table.cell(this).data();
        var row_clicked = $(this).closest('tr');
        var detailItem = table.row(row_clicked).data();
        var _objectid = $('#order-objectid').val();
        if (detailItem != undefined) {
            var _productId = detailItem.ProductId;
            var _promotionId = detailItem.PromotionId;
            $("#order-detail-image").attr("src", "");
            $('#order-detail-product').val('');
            $('#order-detail-quantity').val('');
            $('#order-detail-price-per-item').val('');
            $('#order-detail-price').val('');
            $('#order-detail-discount').val('');
            $('#order-detail-product-id').val('');
            $('#order-detail-promotion-id').val('');
            $('#order-detail-quantity').prop("disabled", false);
            $('#order-detail-price-per-item').prop("disabled", true);
            $('#button_update_order_detail').show();
            $('#button_cancel_order_detail').show();
            $('#div-order-detail-discount').show();
            $('#order-detail-cancel').hide();

            $.ajax({
                type: "GET",
                url: "/Order/GetDetailItem",
                data: { ProductId: _productId, ObjectId: _objectid, PromotionId: _promotionId },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                cache: false,
                success: function (Detaildata) {
                    if (Detaildata.IsCanceled) {
                        $('#order-detail-quantity').prop("disabled", true);
                        $('#order-detail-price-per-item').prop("disabled", true);
                        $('#button_update_order_detail').hide();
                        $('#button_cancel_order_detail').hide();
                        $('#order-detail-cancel').show();
                    }
                    else {
                        $('#button_update_order_detail').show();
                        $('#button_cancel_order_detail').show();
                    }
                    var promotionType = Detaildata.PromotionType;
                    if (promotionType > 0) {
                        if (promotionType == 9) {
                            $('#order-detail-quantity').prop("disabled", true);
                            $('#order-detail-price-per-item').prop("disabled", true);
                            $('#button_update_order_detail').hide();
                            $('#button_cancel_order_detail').hide();
                        }
                    }
                    else {
                        $('#div-order-detail-discount').hide();
                    }

                    $("#order-detail-image").attr("src", Detaildata.ImageUrl);
                    $('#order-detail-product').val(Detaildata.Product);
                    $('#order-detail-quantity').val(Detaildata.Quantity);
                    $('#order-detail-price-per-item').val(Detaildata.PricePerItem);
                    $('#order-detail-price').val(Detaildata.Price);
                    $('#order-detail-discount').val(Detaildata.Discount);
                    $('#order-detail-product-id').val(_productId);
                    $('#order-detail-promotion-id').val(_promotionId);
                    $('#order-detail-original-quantity').val(Detaildata.Quantity);
                    $('#order-detail-original-price-per-item').val(Detaildata.PricePerItem);
                    $('#order-detail-original-discount').val(Detaildata.Discount);
                }
            });
            $('#orderDetailEditModal').modal('show');
        }
    });

    $('#table-order-detail').on('ifToggled', 'input[type="checkbox"]', function () {
        var row_clicked = $(this).closest('tr');
        var detailItem = table.row(row_clicked).data();
        var _objectid = $('#order-objectid').val();
        var _productId = detailItem.ProductId;

        $.ajax({
            type: "GET",
            url: "/Order/UpdateDetailItemStatus",
            data: { ProductId: _productId, ObjectId: _objectid },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (Detaildata) {
                $('#total-price').html('');
                $('#total-discount-price').html('');
                $('#total-normal-price').html('');
                $('#total-price').append(Detaildata.Total);
                $('#total-discount-price').html(Detaildata.DiscountTotal);
                $('#total-normal-price').html(Detaildata.NormalPriceTotal);

                table.destroy();
                table = $('#table-order-detail').DataTable({
                    paging: false,
                    searching: false,
                    data: Detaildata.newData,
                    cache: false,
                    responsive: true,
                    "aaSorting": [[ 2, "asc" ]],
                    "columns": [
                        {
                            "mData": "IsAvailable",
                            "bSearchable": false,
                            "bSortable": false,
                            "responsivePriority": 2,
                            "mRender": function (data, type, full) {
                                if (false == true) {
                                    if ($('#order-status').val() < 2) {
                                        if (data)
                                            return '<input type="checkbox" checked>';
                                        else
                                            return '<input type="checkbox">';
                                    }
                                    else {
                                        if (data)
                                            return '<input type="checkbox" checked disabled>';
                                        else
                                            return '<input type="checkbox" disabled>';
                                    }
                                }
                                else {
                                    return '';
                                }
                            }
                        },
                        {
                            "sName": "ImageUrl",
                            "bSearchable": false,
                            "bSortable": false,
                            "responsivePriority": 5,
                            "mRender": function (data, type, full) {
                                return '<img src="' + full.ImageUrl + '" width="50" height="50" />'
                            }
                        },
                        { "mDataProp": "Product", "responsivePriority": 1 },
                        { "mDataProp": "Description", "responsivePriority": 8 },
                        { "mDataProp": "FormattedPricePerItem", "responsivePriority": 9, "sClass": "alignRight" },
                        { "mDataProp": "Quantity", "responsivePriority": 4, "sClass": "alignRight" },
                        { "mDataProp": "FormattedNormalPrice", "responsivePriority": 7, "sClass": "alignRight" },
                        { "mDataProp": "FormattedDiscount", "responsivePriority": 6, "sClass": "alignRight text-danger" },
                        { "mDataProp": "FormattedPrice", "responsivePriority": 3, "sClass": "alignRight" },
                    ],
                    "createdRow": function (row, data, index) {
                        if (data.IsCanceled != null && data.IsCanceled != undefined && data.IsCanceled == true) {
                            $(row).addClass("cancel-item");
                        }
                        else {
                            $(row).removeClass("cancel-item");
                        }
                    }
                });
                if (false == false) {
                    table.column( 0 ).visible( false );
                }

                if (false == true) {
                    stampRewardTable.destroy();
                    stampRewardTable = $('#table-order-detail-stamp-reward-list').DataTable({
                        paging: false,
                        searching: false,
                        data: Detaildata.StampRewardList,
                        cache: false,
                        responsive: true,
                        "aaSorting": [],
                        "columns": [
                            {
                                "sName": "ImageUrl",
                                "bSearchable": false,
                                "bSortable": false,
                                "responsivePriority": 3,
                                "sClass": "hidden-xs hidden-sm",
                                "mRender": function (data, type, full) {
                                    return '<img src="' + full.ImageUrl + '" width="50" height="50" />'
                                }
                            },
                            { "mDataProp": "ProductName", "responsivePriority": 1 },
                            { "mDataProp": "StampTitle", "responsivePriority": 2 }
                        ]
                    });
                }

                $('.loading').hide();
            },
            error: function (err) {
                $('.loading').hide();
            }
        });
    });

    $('#button_update_order').on('click', function () {

        var status = $("#order-status").val();
        var name = $('#order-name').val();
        var surname = $('#order-surname').val();
        var phone = $('#order-mobile').val();
        var address = $('#order-address').val();
        var address_description = $('#order-address-description').val();
        var address_line = $('#order-address-line').val();
        var objectid = $('#order-objectid').val();
        var staff = $("#order-delivery-staff option:selected").val();
        var estimatedDeliveryTime = $('#order-estimated-delivery-time option:selected').val();

        var orderId = $('#order-objectid').val();
        var isOrderDetailChange = searchChangeOrdersId(orderId);

        if (status > 1 && isDeliveryStaffEnable && (staff == undefined || staff == "none")) {
            $.notify("Select valid delivery staff");
        } else if (status < 2 && isOrderDetailChange == true) {
            $('#update_confirm_model').modal('show');
        } else {
            UpdateOrder(objectid, name, surname, phone, address, staff, address_description, address_line, estimatedDeliveryTime, status);
        }
    });

    $("#user-detail-image1").on('click', function () {
        $('#userInsuranceCardImageModal').modal('show');
    });

    $("#user-detail-image2").on('click', function () {
        $('#userIDCardImageModal').modal('show');
    });

    $('#button_user_detail').on('click', function () {

        $('#user-insuramce-provider').val("");
        $('#user-expiry-date').val("");
        $('#user-emirates-id').val("");
        $("#user-detail-image1").attr("src", "");
        $("#user-detail-image2").attr("src", "");
        $("#userInsuranceCardImage").attr("src", "");
        $("#userIDCardImage").attr("src", "");

        var user_id = $('#order-userid').val();
        $.ajax({
            type: "GET",
            url: "/Order/GetUserItemDetail",
            data: { endUserId: user_id},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (UserData) {

                $('#user-insuramce-provider').val(UserData.InsuranceProviderCompany);
                $('#user-expiry-date').val(UserData.insurance_expiry);
                $('#user-emirates-id').val(UserData.id_number);

                if (UserData.InsuranceCardImageUrl == null || UserData.InsuranceCardImageUrl == "") {
                    $("#user-detail-image1").hide();
                }
                else {
                    $("#user-detail-image1").show();
                    $("#user-detail-image1").attr("src", UserData.InsuranceCardImageUrl);
                    $("#userInsuranceCardImage").attr("src", UserData.InsuranceCardImageUrl);
                }

                if (UserData.UserIDCardImageUrl == null || UserData.UserIDCardImageUrl == "") {
                    $("#user-detail-image2").hide();
                }
                else {
                    $("#user-detail-image2").show();
                    $("#user-detail-image2").attr("src", UserData.UserIDCardImageUrl);
                    $("#userIDCardImage").attr("src", UserData.UserIDCardImageUrl);
                }

                $('.loading').hide();
            },
            error: function (err) {
                $('.loading').hide();
            }
        });

        $('#userDetailModal').modal('show');
    });

    $('#button_update_order_status').on('click', function () {

        var status = $("#order-status").val();
        var orderId = $('#order-objectid').val();
        var isOrderDetailChange = searchChangeOrdersId(orderId);

        if (status < 2 && isOrderDetailChange) {
            $('#update_status_confirm_model').modal('show');
        }
        else {
            if (false == true && status == 1) {
                $('#normalWarningTextForOrderStatusChange').hide();
                $('#specialWarningTextForOrderStatusChange').show();
            }
            else {
                $('#normalWarningTextForOrderStatusChange').show();
                $('#specialWarningTextForOrderStatusChange').hide();
            }

            if (false == true && status == 2 && $('#order-picked-up-service').val() != undefined && $('#order-picked-up-service').val() != '') {
                serviceOrderDetail = [];
                $("#service_order_detail_table_body").empty();
                $('#update_order_status_confirm_with_drop_off_model').modal('show');
            }
            else {
                $('#update_order_status_confirm_model').modal('show');
            }
        }

    });

    $('#button_cancel_order').on('click', function () {
        $('#cancel_confirm_model').modal('show');
    });

    $('#button_cancel_order_confirm').on('click', function () {
        var objectid = $('#order-objectid').val();
        UpdateOrderStatus(objectid, 4);
    });

    $('#button_order_detail_add').on('click', function () {
        $("#order-product-add-product").select2({
            placeholder: function () {
                $(this).data('placeholder');
            },
            theme: "bootstrap"
        });
        $("#order-product-add-product").val('').trigger('change');
        $('#order-product-add-quantity').val('');
        $("#order-insure-rate").val('').trigger('change');
        $('#orderProductAdd').modal('show');
    });

    $('#button-order-product-add-confirm').on('click', function () {
        var orderId = $('#order-objectid').val();
        var productId = $('#order-product-add-product option:selected').val();
        var quantity = $('#order-product-add-quantity').val();
        if (orderId != undefined && orderId != '' && productId != undefined && productId != '' && quantity != undefined && quantity != '') {
            $('#add_product_confirm_model').modal('show');
        }
        else {
            $.notify("Please choose product and enter quantity.");
        }
    });

    $('#button_add_product_confirm').on('click', function () {
        var orderId = $('#order-objectid').val();
        var productId = $('#order-product-add-product option:selected').val();
        var quantity = $('#order-product-add-quantity').val();
        var insureRate = $("#order-insure-rate option:selected").val();
        if (orderId != undefined && orderId != '' && productId != undefined && productId != '' && quantity != undefined && quantity != '') {
            addChangeOrdersId(orderId);
            InsertDetailItem(orderId, productId, quantity, insureRate);
        }
    });

    $('#button_cancel_order').on('click', function () {
        $('#cancel_confirm_model').modal('show');
    });

    $('#button_update_confirm').on('click', function () {
        $('#update_confirm_model').modal('hide');
        var name = $('#order-name').val();
        var surname = $('#order-surname').val();
        var phone = $('#order-mobile').val();
        var address = $('#order-address').val();
        var address_description = $('#order-address-description').val();
        var address_line = $('#order-address-line').val();
        var status = $("#order-status").val();
        var objectid = $('#order-objectid').val();
        var staff = $("#order-delivery-staff option:selected").val();
        var estimatedDeliveryTime = $('#order-estimated-delivery-time option:selected').val();

        UpdateOrder(objectid, name, surname, phone, address, "", address_description, address_line, estimatedDeliveryTime, status);
    });

    $('#button_update_order_detail').on('click', function () {
        $('#update_detail_confirm_model').modal('show');
    });

    $('#button_update_status_confirm').on('click', function () {
        $('#update_status_confirm_model').modal('hide');
        if (false == true && status == 1) {
            $('#normalWarningTextForOrderStatusChange').hide();
            $('#specialWarningTextForOrderStatusChange').show();
        }
        else {
            $('#normalWarningTextForOrderStatusChange').show();
            $('#specialWarningTextForOrderStatusChange').hide();
        }

        if (false == true && status == 2 && $('#order-picked-up-service').val() != undefined && $('#order-picked-up-service').val() != '') {
            serviceOrderDetail = [];
            $("#service_order_detail_table_body").empty();
            $('#update_order_status_confirm_with_drop_off_model').modal('show');
        }
        else {
            $('#update_order_status_confirm_model').modal('show');
        }
    });

    $('#button_update_detail_confirm').on('click', function () {
        $('#update_detail_confirm_model').modal('hide');
        var objectid = $('#order-objectid').val();
        var productid = $('#order-detail-product-id').val();
        var quantity = $('#order-detail-quantity').val();
        var pricePerItem = $('#order-detail-price-per-item').val();
        var price = $('#order-detail-price').val();
        var promotionid = $('#order-detail-promotion-id').val();
        var orderId = $('#order-objectid').val();
        var status = $("#order-status").val();
        addChangeOrdersId(orderId);
        UpdateOrderDetailItem(objectid, productid, promotionid, quantity, price, pricePerItem, status);
    });

    $('#button_status_update_confirm').on('click', function () {
        $('#update_order_status_confirm_model').modal('hide');

        var status = $("#order-status").val();
        var name = $('#order-name').val();
        var surname = $('#order-surname').val();
        var phone = $('#order-mobile').val();
        var address = $('#order-address').val();
        var address_description = $('#order-address-description').val();
        var address_line = $('#order-address-line').val();
        var status = $("#order-status").val();
        var objectid = $('#order-objectid').val();
        var staff = $("#order-delivery-staff option:selected").val();
        var estimatedDeliveryTime = $('#order-estimated-delivery-time option:selected').val();

        if (status != 0 && isDeliveryStaffEnable && (staff == undefined || staff == "none")) {
            $.notify("Select valid delivery staff");
        }
        else {
            GrandeUpdateStatus(objectid, status, name, surname, phone, address, staff, address_description, address_line, estimatedDeliveryTime, '', '');
        }
    });

    $('#button_order_add_service_detail').on('click', function () {
        var docketNumber = $("#order-docket-number").val();
        var price = $("#service-order-initial-price").val();
        var Name = $("#service-order-service-name option:selected").val();
        if (docketNumber != undefined && docketNumber.trim() != '') {
            if ($.isNumeric(price) && price > 0) {
                if (Name != undefined && Name.trim() != '') {
                    var jsonObject = '{ "DocketNumber" : "' + docketNumber + '", "Price" : "' + parseFloat(Math.round(price * 100) / 100).toFixed(2) + '", "ServiceName":"' + Name + '"}';
                    serviceOrderDetailAddObject(jsonObject);
                    $('#service_order_add_detail_modal').modal('hide');
                }
                else {
                    $.notify("Select Service Name");
                }
            }
            else {
                $.notify("Enter Service Price Correctly");
            }
        }
        else {
            $.notify("Enter Docket Number");
        }
    });

    $('#button_service_order_add_detail_modal').on('click', function () {
        $('#order-docket-number').val('');
        $("#service-order-initial-price").val('');
        $("#service-order-service-name").val('').val('Dry Cleaning').trigger('change');
        $('#service_order_add_detail_modal').modal('show');

    });

    $('#button_status_update_confirm_with_drop_off').on('click', function () {

        if (serviceOrderDetail.length > 0) {
            $('#update_order_status_confirm_with_drop_off_model').modal('hide');
            var name = $('#order-name').val();
            var surname = $('#order-surname').val();
            var phone = $('#order-mobile').val();
            var address = $('#order-address').val();
            var address_description = $('#order-address-description').val();
            var address_line = $('#order-address-line').val();
            var status = $("#order-status").val();
            var objectid = $('#order-objectid').val();
            var staff = $("#order-delivery-staff option:selected").val();
            var estimatedDeliveryTime = $('#order-estimated-delivery-time option:selected').val();

            if (status != 0 && isDeliveryStaffEnable && (staff == undefined || staff == "none")) {
                $.notify("Select valid delivery staff");
            }
            else {
                GrandeUpdateStatus(objectid, status, name, surname, phone, address, staff, address_description, address_line, estimatedDeliveryTime);
            }
        }
        else {
            $.notify("Enter Service Detail");
        }
    });

    $('#button_cancel_order_detail').on('click', function () {
        $('#cancel_detail_confirm_model').modal('show');
    });

    $('#button_cancel_detail_confirm').on('click', function () {
        $('#cancel_detail_confirm_model').modal('hide');
        var objectid = $('#order-objectid').val();
        var productid = $('#order-detail-product-id').val();
        var promotionid = $('#order-detail-promotion-id').val();
        var status = $("#order-status").val();

        CancelOrderDetailItem(objectid, productid, promotionid, true, status);
        var orderId = $('#order-objectid').val();
        addChangeOrdersId(orderId);
    });

    $('#order-detail-price-per-item').on('input propertychange paste', function () {
        clearTimeout(waitTime);
        waitTime = setTimeout(function () {
            var newDiscount = 0;
            var quantity = $('#order-detail-quantity').val();
            var pricePerItem = $('#order-detail-price-per-item').val();
            var originalPricePerItem = $('#order-detail-original-price-per-item').val();
            var originalDiscount = $('#order-detail-original-discount').val();
            if (originalPricePerItem > 0) {
                newDiscount = originalDiscount * (pricePerItem / originalPricePerItem);
            }

            $('#order-detail-price').val(((quantity * pricePerItem) - newDiscount).toFixed(2));
            $('#order-detail-discount').val(newDiscount.toFixed(2));
        }, 1000);
    });

    $('#order-detail-quantity').on('input propertychange paste', function () {
        clearTimeout(waitTime);
        waitTime = setTimeout(function () {
            var newDiscount = 0;
            var quantity = $('#order-detail-quantity').val();
            var pricePerItem = $('#order-detail-price-per-item').val();
            var originalQuantity = $('#order-detail-original-quantity').val();
            var originalDiscount = $('#order-detail-original-discount').val();
            if (originalQuantity > 0) {
                newDiscount = originalDiscount * (quantity / originalQuantity);
            }

            $('#order-detail-price').val(((quantity * pricePerItem) - newDiscount).toFixed(2));
            $('#order-detail-discount').val(newDiscount.toFixed(2));
        }, 1000);
    });

    $('#button_print_delivered_order').on('click', function () {
        $('#delivered_report_name').val('');
        $('#delivered_report_address').val('');
        $('#delivered_report_price_min').val('');
        $('#delivered_report_price_max').val('');
        $('#delivered_report_date_min').val('');
        $('#delivered_report_date_max').val('');
        $('#modal_report_param').modal('show');
    });

    $('#button_delivered_print_confirm').on('click', function () {
        var name = $('#delivered_report_name').val();
        var address = $('#delivered_report_address').val();
        var min_price = $('#delivered_report_price_min').val();
        var max_price = $('#delivered_report_price_max').val();

        var start_date = '';
        var end_date = '';

        var min_date = $('#delivered_report_date_min').val();
        var max_date = $('#delivered_report_date_max').val();

        if (min_date != undefined && min_date != "") {
            start_date = $.datepicker.formatDate("dd/mm/yy", new Date(min_date));
        }

        if (max_date != undefined && max_date != "") {
            end_date = $.datepicker.formatDate("dd/mm/yy", new Date(max_date));
        }

        window.open("/Order/PrintDeliveredOrder?_Name=" + encodeURIComponent(name) + "&_Address=" + encodeURIComponent(address) + "&_FromPrice=" + encodeURIComponent(min_price) + "&_ToPrice=" + encodeURIComponent(max_price) + "&_StartDate=" + encodeURIComponent(start_date) + "&_EndDate=" + encodeURIComponent(end_date));
    });

    $('#button_print_delivered_service_order').on('click', function () {
        $('#delivered_service_report_name').val('');
        $('#delivered_report_address').val('');
        $('#delivered_service_report_price_min').val('');
        $('#delivered_service_report_price_max').val('');
        $('#delivered_service_report_date_min').val('');
        $('#delivered_service_report_date_max').val('');
        $('#modal_service_report_param').modal('show');
    });

    $('#button_delivered_service_print_confirm').on('click', function () {
        var name = $('#delivered_service_report_name').val();
        var address = $('#delivered_report_address').val();
        var min_price = $('#delivered_service_report_price_min').val();
        var max_price = $('#delivered_service_report_price_max').val();

        var start_date = '';
        var end_date = '';

        var min_date = $('#delivered_service_report_date_min').val();
        var max_date = $('#delivered_service_report_date_max').val();

       if (min_date != undefined && min_date != "") {
            start_date = $.datepicker.formatDate("dd/mm/yy", new Date(min_date));
        }

        if (max_date != undefined && max_date != "") {
            end_date = $.datepicker.formatDate("dd/mm/yy", new Date(max_date));
        }

        window.open("/Order/PrintDeliveredServiceOrder?_Name=" + encodeURIComponent(name) + "&_FromPrice=" + encodeURIComponent(min_price) + "&_ToPrice=" + encodeURIComponent(max_price) + "&_StartDate=" + encodeURIComponent(start_date) + "&_EndDate=" + encodeURIComponent(end_date));
    });

    $('#orderImageModalPrint').on('click', function () {
        var mywindow = window.open('');//, 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title> Prescription </title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1> Prescription </h1>');
        mywindow.document.write(document.getElementById('order-image-modal-div').innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    });

    function UpdateOrder(_objectid, _name, _surname, _phone, _address, _staff, _addressdescription, _addressline, _estimatedDeliveryTime, _status) {
        var orderId = $('#order-objectid').val();
        removeChangeOrdersId(orderId);
        return $.ajax({
            type: "GET",
            url: "/Order/UpdateOrderItem",
            data: { objectId: _objectid, name: _name, surname: _surname, phone: _phone, address: _address, deliverystaff: _staff, addressdescription: _addressdescription, addressline: _addressline, estimatedDeliveryTime: _estimatedDeliveryTime },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $.notify(data.Message);
                $.ajax({
                    type: "GET",
                    url: "/Order/CheckNewOrder",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (data) {
                        tableReLoad(_status, data.Status);
                    }
                });
            },
            error: function (data) {
                $.notify(data.Message);
            }
        });
    };

    function UpdateOrderStatus(_objectid, _status, _staff, _estimatedDeliveryTime) {
        return $.ajax({
            type: "GET",
            url: "/Order/UpdateOrderStatus",
            data: { objectId: _objectid, status: _status, deliverystaff: _staff, estimatedDeliveryTime: _estimatedDeliveryTime, docketNumber: serviceOrderDetail.toString()},
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (data) {
                $.notify(data.Message);
                serviceOrderDetail = [];
                if (_status === 4)
                    $('#cancel_confirm_model').modal('hide');
                else {
                    $('#update_order_status_confirm_model').modal('hide');
                    $('#update_order_status_confirm_with_drop_off_model').modal('hide');
                }

                $('#myModal').modal('hide');
                tableReLoad(_status, data.Status);

                if (false == true) {
                    serviceOrderOnLoad();
                }
                $('.loading').hide();
            },
            error: function (data) {
                $('.loading').hide();
                $.notify(data.Message);
            }
        });
    };

    function CancelOrderDetailItem(_objectid, _productid, _promotionid, _isCanceled, _status) {
        $.ajax({
            type: "GET",
            url: "/Order/CancelDetailItem",
            data: { ProductId: _productid, ObjectId: _objectid, PromotionId: _promotionid, IsCanceled: _isCanceled },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (data) {
                $.notify(data.message);
                if (data.success) {
                    $('#orderDetailEditModal').modal('hide');
                    $('#total-price').html('');
                    $('#total-normal-price').html('');
                    $('#total-discount-price').html('');
                    $('#total-price').append(data.Total);
                    $('#total-normal-price').append(data.NormalPriceTotal);
                    $('#total-discount-price').append(data.DiscountTotal);

                    tableReLoad(_status, _status);
                    table.clear();
                    table.rows.add(data.Orders);
                    table.draw();
                    $('.loading').hide();
                }
            },
            error: function (data) {
                $('.loading').hide();
                $.notify(data.message);
            }
        });
    };
    function UpdateOrderDetailItem(_objectid, _productid, _promotionid, _quantity, _price, _pricePerItem, status) {
        $.ajax({
            type: "GET",
            url: "/Order/UpdateDetailItem",
            data: { ProductId: _productid, ObjectId: _objectid, PromotionId: _promotionid, Quantity: _quantity, Price: _price, PricePerItem: _pricePerItem },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (data) {
                $.notify(data.Message);
                if (data.Success) {
                    $('#orderDetailEditModal').modal('hide');
                    $('#total-price').html('');
                    $('#total-normal-price').html('');
                    $('#total-discount-price').html('');
                    $('#total-price').append(data.Total);
                    $('#total-normal-price').append(data.NormalPriceTotal);
                    $('#total-discount-price').append(data.DiscountTotal);

                    tableReLoad(status, status);

                    if (false == true) {
                        tabledeliveredorderwithmissingproducts.ajax.reload();
                    }
                    if (false == true) {
                        serviceOrderOnLoad();
                    }
                    table.clear();
                    table.rows.add(data.Orders);
                    table.draw();
                    $('.loading').hide();
                }
                else {
                    $('.loading').hide();
                }
            },
            error: function (data) {
                $('.loading').hide();
                $.notify(data.Message);
            }
        });
    };

    function InsertDetailItem(_orderId, _productId, _quantity, _insureRate) {
        $.ajax({
            type: "GET",
            url: "/Order/InsertDetailItem",
            data: { id: _orderId, ProductId: _productId, Quantity: _quantity, insureRate: _insureRate },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            beforeSend: function () { $('.loading').show(); },
            success: function (data) {
                if (data.success) {
                    $('#total-price').html('');
                    $('#total-normal-price').html('');
                    $('#total-discount-price').html('');
                    $('#total-price').append(data.Total);
                    $('#total-normal-price').append(data.NormalPriceTotal);
                    $('#total-discount-price').append(data.DiscountTotal);
                    table.clear();
                    table.rows.add(data.Orders);
                    table.draw();
                }

                $.notify(data.message);
                $('#orderProductAdd').modal('hide');
                $('#add_product_confirm_model').modal('hide');
                $('.loading').hide();
            },
            error: function (data) {
                $('.loading').hide();
                $.notify(data.message);
            }
        });
    };

    function DeleteOrder(_objectid) {
        $.ajax({
            type: "GET",
            url: "/Order/DeleteOrder",
            data: { objectId: _objectid },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            success: function (data) {
                $.notify(data.Message);
                $('#delete_confirm_model').modal('hide');
                $('#myModal').modal('hide');

                tableinprocessorder.ajax.reload();
                tableneworder.ajax.reload();
                tabledeliveredorder.ajax.reload();
                tabledispatchedorder.ajax.reload();
                tablecanceledorder.ajax.reload();

                if (false == true) {
                    tabledeliveredorderwithmissingproducts.ajax.reload();
                }
                if (false == true) {
                    serviceOrderOnLoad();
                }
            },
            error: function (data) {
                $.notify(data.Message);
            }
        });
    };

    function GetFormattedDate(date) {
        var dateString = date.substr(6);
        var jsDate = new Date(parseInt(dateString));

        if (date == null || date == undefined || date == '' || jsDate.getFullYear() < 2000) {
            return "";
        }

        var month = jsDate.getMonth() + 1;
        var dateString = ("0" + jsDate.getDate()).slice(-2) + "." + ("0" + month).slice(-2) + "." + jsDate.getFullYear() + "&nbsp;-&nbsp;" + ("0" + jsDate.getHours()).slice(-2) + ":" + ("0" + jsDate.getMinutes()).slice(-2);
        return dateString;
    };

    function GetDeliveryStaff() {
        $.ajax({
            type: "GET",
            url: "/Order/GetDeliveryStaff",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            cache: false,
            async: false,
            success: function (data) {
                staffData = data;
                $('#order-delivery-staff').find('option').remove().end().append('<option value="none">Select Staff</option>').val('none');
                $.each(staffData, function (index, data) {
                    if (data.SurName === undefined) {
                        data.SurName = "";
                    }
                    $('#order-delivery-staff').append("<option value='" + data.Name + "'>" + data.Name + " " + data.SurName + "</option>")
                });
            }
        });
    };

    function GrandeUpdateStatus(_objectid, _status, _name, _surname, _phone, _address, _staff, _addressdescription, _addressline, _estimatedDeliveryTime) {
        return UpdateOrder(_objectid, _name, _surname, _phone, _address, _staff, _addressdescription, _addressline, _estimatedDeliveryTime, _status).then(UpdateOrderStatus(_objectid, _status, _staff, _estimatedDeliveryTime));
    };

    function GetOrderDetailImage(id) {
        $.ajax({
            type: "GET",
            url: "/Order/GetOrderDetailImage",
            dataType: "json",
            data: { 'id': '' + id + '' },
            cache: false,
            success: function (result) {
                if (result.success) {
                    $("#detailImage").attr("src", result.ImageBase64);
                    $('#detailImage-id').val(result.OrderImageId);
                    $('#orderImageModal').modal('show');
                }
                else
                    $.notify("Order doesn't have image.");
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    $('#button_order_detail_image').on('click', function () {
        var id = $('#order-objectid').val();
        if (id !== undefined && id !== '')
            GetOrderDetailImage(id);
    });

    $('#button_export_order_list').on('click', function () {
        $('#txt_export_start_date').val('');
        $('#txt_export_end_date').val('');
        $("#cb_export_IsInStock").attr("checked", false);
        $('#txt_export_IsInStock').val("Without canceled items.");
        $('#modal_export_data_range').modal('show');
    });

    $('#button_export_print_delivered_confirm').on('click', function () {
        var start_date = $('#txt_export_start_date').val();
        var end_date = $('#txt_export_end_date').val();
        var isInStock = false;
        if ($("#cb_export_IsInStock").prop("checked")) {
            isInStock = true;
        }
        if (start_date == "") {
            $.notify("You must set a start date");
        }
        else {
            window.open("/Order/ExportOrderList?startDate=" + start_date + "&endDate=" + end_date + "&isInStockEnabled=" + isInStock + "&statusValue=3");
        }
    });

    $('#button_export_print_canceled_confirm').on('click', function () {
        var start_date = $('#txt_export_start_date').val();
        var end_date = $('#txt_export_end_date').val();
        var isInStock = false;
        if ($("#cb_export_IsInStock").prop("checked")) {
            isInStock = true;
        }
        if (start_date == "") {
            $.notify("You must set a start date");
        }
        else {
            window.open("/Order/ExportOrderList?startDate=" + start_date + "&endDate=" + end_date + "&isInStockEnabled=" + isInStock + "&statusValue=4");
        }
    });

    $("#orderImageModalRotateLeftButton").on('click', function () {
        degree += -90;
        $("#detailImage").rotate(-90);
        $("#detailImage").css("max-width", "100%");
    });

    $("#orderImageModalRotateRightButton").on('click', function () {
        degree += 90;
        $("#detailImage").rotate(90);
        $("#detailImage").css("max-width", "100%");
    });

    $("#userInsuranceCardImageRotateLeftButton").on('click', function () {
        degree += -90;
        $("#userInsuranceCardImage").rotate(-90);
        $("#userInsuranceCardImage").css("max-width", "100%");
    });

    $("#userInsuranceCardImageRotateRightButton").on('click', function () {
        degree += 90;
        $("#userInsuranceCardImage").rotate(90);
        $("#userInsuranceCardImage").css("max-width", "100%");
    });

    $("#userIDCardImageRotateLeftButton").on('click', function () {
        degree += -90;
        $("#userIDCardImage").rotate(-90);
        $("#userIDCardImage").css("max-width", "100%");
    });

    $("#userIDCardImageRotateRightButton").on('click', function () {
        degree += 90;
        $("#userIDCardImage").rotate(90);
        $("#userIDCardImage").css("max-width", "100%");
    });

    $("#orderImageModalUpdateButton").on('click', function () {
        var id = $("#detailImage-id").val();
        if (id != undefined && id != '' && degree != undefined && degree != 0) {
            $.ajax({
                type: "get",
                url: "/Order/UpdateOrderDetailImage",
                dataType: "json",
                data: { 'id': '' + id + '', 'degree': degree },
                cache: false,
                beforeSend: function () { $('.loading').show(); },
                success: function (result) {
                    $('.loading').hide();
                    if (result.success) {
                        $('#orderImageModal').modal('hide');
                        $.notify(result.message);
                    }
                    else
                        $.notify(result.message);
                },
                error: function (data) {
                    $('.loading').hide();
                    console.log(data);
                }
            });
        }
        else {
            $.notify("Image not changed");
        }
    });

    $('#orderImageModal').on('hidden.bs.modal', function () {
        var parentDiv = $('#detailImage').parent();
        $('#detailImage').remove();

        var img = document.createElement("img");
        img.id = "detailImage";
        parentDiv.append(img);
        $("#detailImage").css("max-width", "100%");
        degree = 0;
    });

    $('.datepicker').datepicker();

    function addChangeOrdersId(orderId) {
        var blIsInArray = false;
        for (var i = 0; i < changeOrdersId.length; i++) {
            var obj = changeOrdersId[i];
            if (orderId == obj) {
                blIsInArray = true;
            }
        }
        if (!blIsInArray) {
            changeOrdersId.push(orderId);
        }
    }

    function removeChangeOrdersId(orderId) {
        var blIsDeleteInArray = false;
        for (var i = 0; i < changeOrdersId.length; i++) {
            var obj = changeOrdersId[i];
            if (orderId == obj) {
                changeOrdersId.splice(i, 1);
                blIsDeleteInArray = true;
            }
        }
        return blIsDeleteInArray;
    }

    function searchChangeOrdersId(orderId) {
        var blIsDeleteInArray = false;
        for (var i = 0; i < changeOrdersId.length; i++) {
            var obj = changeOrdersId[i];

            if (orderId == obj) {
                blIsDeleteInArray = true;
                break;
            }
        }

        if (false == true) {
            var orderStatus = $("#order-status").val();
            if (blIsDeleteInArray == false && orderStatus == "1") {
                var detailData = $('#table-order-detail').DataTable().rows().data();
                for (var i = 0; i < detailData.length; i++) {
                    var order_item = detailData[i];

                    if (!order_item.IsAvailable) {
                        blIsDeleteInArray = true;
                        break;
                    }
                }
            }
        }
        return blIsDeleteInArray;
    }
});

