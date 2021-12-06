<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Inter Switch Transaction'
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>

<style>
    #tbl-own-fund-data tbody td:nth-child(4) {
        text-align: right;
    }
</style>

<div class="py-5">
    <div class="container">
        <div class="row pb-2" id="div-ifa">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>IFA</b></div>
                    <div class="card-body">
                        <select id="slt-ifa" class="form-control">
                            <option value="">Please select</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row collapse" id="div-client">
            <div class="col-md-12">
                <?php $this->load->view("general/_vw_search_client", [
                    "search_type" => "order",
                    "account_type" => "wrap"
                ]); ?>
            </div>
        </div>
        <div class="pt-2 collapse" id="div-switch-out">
            <div class="card">
                <div class="card-header"> Switch Out From</div>
                <div class="card-body col-md-12">
                    <div class="row border-bottom border-dark">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-5"><label class="col-form-label"><b>Fund Name</b></label></div>
                                <div class="col-md-5"><label class="col-form-label"><b>Fund House</b></label></div>
                            </div>
                        </div>
                        <div class="col-md-2"><label class="col-form-label"><b>Unit Owned</b></label></div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6"><label class="col-form-label"><b>Switch Unit(s)</b></label></div>
                                <div class="col-md-6"><label class="col-form-label"><b>Switch Percentage(%)</b></label></div>
                            </div>
                        </div>
                        <div class="col-md-1"><label class="col-form-label"><b>Switch All</b></label></div>
                        <div class="col-md-1"><label class="col-form-label"><b>Info</b></label></div>
                    </div>
                    <div id="div-holding">
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-2 collapse" id="div-switch-in">
            <div class="card">
                <div class="card-header">Switch Into</div>
                <div class="card-body">
                    <div class="row border-bottom border-dark">
                        <div class="col-md-1"><i class="fa fa-trash-o fa-fw py-2 px-3" id="i-fund-delete-all"></i></div>
                        <div class="col-md-3"><label class="col-form-label"><b>Fund House</b></label></div>
                        <div class="col-md-4"><label class="col-form-label"><b>Fund Name</b></label></div>
                        <div class="col-md-2"><label class="col-form-label"><b>Allocation (%)</b></label></div>
                        <div class="col-md-2"><label class="col-form-label"><b>Switch In Charge (%)</b></label></div>
                    </div>
                    <div id="div-fund-transaction">
                        <div class="div-fund-transaction-row">
                            <div class="row pt-2">
                                <div class="col-md-1"><i class="fa fa-trash-o fa-fw py-2 px-3 i-fund-delete"></i></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select class="form-control slt-fund-house">
                                            <option value=''>Select Fund House</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control slt-fund">
                                            <option value=''>Select Fund</option>
                                        </select>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" step=1 class="form-control ipt-payment-allocation" placeholder="Allocation" min=0>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" step="0.01" class="form-control ipt-sale-charge" placeholder="Switch In Charge" min=0>
                                        <span class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row pt-12">
                        <div class="col-md-12">

                            <div style="float: right;">

                                Percentage(%) :
                                <div id="allocation_leftover">0/100%</div>
                                <div id="allocation_note"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row pt-2">
                        <div class="col-md-2">
                            <btn id="btn-add-funds" class="btn btn-danger">Add More Funds</btn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2 collapse" id="div-saf-documentation">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b> SAF Documentation</b></div>
                    <div class="card-body">
                        <div class="row pt-2 collapse show" id="div-investor-saf-buttons">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-danger" data-target="#modal_saf" id="btn_create_investor_saf" data-toggle="modal">Create Investor SAF
                                </button>
                                <button class="btn btn-danger" data-target="#modal_saf_excp" data-toggle="modal">Create
                                    Investor SAF-Exceptional Declaration
                                </button>

                            </div>

                            <div class="col-md-12 text-center">
                                <button class="btn btn-danger" data-target="#modal_saf" style="display: none;margin: 0 auto;margin-top: 10px;" id="btn_edit_investor_saf" data-toggle="modal">
                                    View/Edit Investor SAF
                                </button>
                                <button class="btn btn-danger" data-target="#modal_saf_excp" style="display: none;margin: 0 auto;margin-top: 10px" id="btn_edit_investor_saf_declare" data-toggle="modal">
                                    View/Edit Investor SAF-Exceptional Declaration
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-danger" id="btn_print">Print</button>
                                <button class="btn btn-danger" id="btn-add">Add To Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <table id="switch_out_selected" class="table table-striped table-borderless display" style="display: none">
        <thead>
            <tr>
                <th>No</th>
                <th>Fund ID</th>
                <th>Fund Name</th>
                <th>Switch Amount</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div class="col-md-12">
    <table id="switch_in_selected" class="table table-striped table-borderless display" style="display: none">
        <thead>
            <tr>
                <td>No</td>
                <td>Fund House</td>
                <td>Fund ID</td>
                <td>Fund Name</td>
                <td>Allocation</td>
                <td>Switch In Charge (%)</td>
            </tr>
        </thead>
        <tbody></tbody>
    </table>


</div>
<?php $this->load->view("order/_vw_saf") ?>
<?php $this->load->view("order/_vw_password") ?>
<?php $this->load->view('template/_loading'); ?>
<?php
$template['content'] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<script>
    autoHideLoadingOnInit = false;

    var client_code, is_wrap, div_fund_transaction_row, is_si,
        ifa_code,
        loadingFundHouse = true,
        loadingElements = true,
        validate_ajax;
    window.addEventListener("DOMContentLoaded", function() {
        var switch_in = $("#switch_in_selected").DataTable({
            "bPaginate": false, // Show paging
            "searching": false, // Show Search
            "info": false, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">',

        });

        var switch_out = $("#switch_out_selected").DataTable({
            "bPaginate": false, // Show paging
            "searching": false, // Show Search
            "info": false, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">',

        });


        $("#btn_print").click(function() {

            document.getElementById("switch_out_selected").style.display = "table";
            document.getElementById("switch_out_selected").style.width = "100%";
            document.getElementById("switch_in_selected").style.display = "table";
            document.getElementById("switch_in_selected").style.width = "100%";
            //Switch out selected
            switch_out.clear().draw();
            $(".ipt-switch-fund:checked").each(function(index, value) {
                var $this = $(this);
                var row = $this.closest("tr");

                var fund_id = $this.val();
                var fund_name = $('.ipt-switch-name', row).text();
                var holding_unit = $('.ipt-switch-amount', row).val();

                switch_out.row.add([
                    index + 1,
                    fund_id,
                    fund_name,
                    holding_unit
                ]);
            });
            switch_out.draw();

            // switch_out
            switch_in.clear().draw();
            $('.div-fund-transaction-row').each(function(index, value) {
                var row = $(value);
                var fund_id = $(".slt-fund", row).val();
                var fund_name = $(".slt-fund option:selected", row).text();
                var fund_house = $(".slt-fund-house option:selected", row).text();
                var allocation = $(".ipt-payment-allocation", row).val();
                var sale_charge = $(".ipt-sale-charge", row).val();

                switch_in.row.add([
                    index + 1,
                    fund_house,
                    fund_id,
                    fund_name,
                    allocation,
                    sale_charge
                ]);
            });
            switch_in.draw();

            var divToPrint = document.getElementById("switch_out_selected");
            var divToPrint2 = document.getElementById("switch_in_selected");
            var html = "<h3><b><u>INTERSWITCH ORDER</u></b></h3><br>";
            html += "Client Name : " + $("#client_name").html() + "<br>";
            html += "Client ID : " + $('#client_acc_num').data("clientcode") + "<br>";
            html += "Switch Out Fund" + "<br>";
            html += divToPrint.outerHTML + "<br>";
            html += "Switch Out Fund" + "<br>";
            html += divToPrint2.outerHTML + "<br>";

            printHtml(html);

            $("#switch_out_selected").hide();
            $("#switch_in_selected").hide();
        });

        $("#btn-add").click(function() {
            var elements = $(".ipt-switch-fund:checked"),
                valid = true;
            for (var e of elements) {
                var $this = $(e);
                var row = $this.closest(".div-holding-item");

                var percentage = $('.ipt-switch-perc', row).val();
                var unit = $('.ipt-switch-amount', row).val();
                var total_unit = getAllUnit(row);
                var calc_unit = (total_unit / 100 * percentage).toFixed(2);
                var calc_perc = (unit / total_unit * 100).toFixed(2);

                if (unit != calc_unit && percentage != calc_perc) {
                    valid = false;
                    break;
                }
            }

            if (valid) {
                togglePassword();
            } else {
                alert("The unit and percentage is not tally. Please check again.");
            }
        })

        get_fund_house_list();

        ajaxRequest({
            url: "<?= base_url() ?>transaction/_elements",
            data: {
                type: "<?= $type ?>"
            },
            method: "get",
            success: function(json) {
                if (json.status === <?= RESPONSE_STATUS_SUCCESS ?>) {
                    if (json.data.ifa !== undefined) {
                        var sltIfa = $("#slt-ifa");
                        $.each(json.data.ifa, function(i, ifa) {
                            sltIfa.append('<option value="' + ifa.ifa_code + '">' + ifa.ifa_name + '</option>');
                        });

                        sltIfa.change(function() {
                            ifa_code = $(this).val();
                            if (ifa_code)
                                $("#div-client").collapse("show");
                            else
                                $("#div-client").collapse("hide");
                        })
                    } else {
                        $("#div-ifa").remove();
                        $("#div-client").collapse("show");
                    }
                }

                loadingElements = false;
                if (!loadingFundHouse && !loadingElements)
                    hideLoading();
            }
        })
    });

    function init_search_client() {
        $('#div-switch-out, #div-switch-in, #div-saf-documentation').collapse('hide');
    }

    function initializeOrderCart() {
        initField();

        // add fund row
        $('#btn-add-funds').click(function() {
            $('#div-fund-transaction').append(div_fund_transaction_row.clone());

            $('.ipt-switch-fund[data-fundhouse]:checked').each(function(index, fh) {
                var fund_house_id = $(this).data('fundhouse');
                $('.slt-fund-house option[value="' + fund_house_id + '"]', row).hide();
            });

            toggle_sale_charge(is_wrap);
            // disable_sale_charge();
        });

        // delete all fund
        $("#i-fund-delete-all").click(function() {
            $('.div-fund-transaction-row').remove();
            calculationAllocation();

            realtimeValidation("in", $(this));
        });
    }

    function initField() {
        // switch out
        $(document).on("change", ".ipt-switch-fund", function() {
            var $this = $(this);
            var fund_house_id = $this.data('fundhouse');
            var hide = $('.ipt-switch-fund[data-fundhouse="' + fund_house_id + '"]:checked').length > 0;
            var options = $('.slt-fund-house option[value="' + fund_house_id + '"]');

            if (hide) {
                options.hide();
                $('.slt-fund-house').each(function(index, e) {
                    var slt = $(this);
                    if (slt.val() == fund_house_id) {
                        slt.closest('.div-fund-transaction-row').find('.i-fund-delete').click();
                    }
                });
            } else {
                options.show();
            }
        });

        $(document).on("keyup blur", '.ipt-switch-amount', function() {
            var $this = $(this);
            var row = $this.closest('.div-holding-item');
            var ipt_switch_perc = $('.ipt-switch-perc', row);
            var ipt_checkbox = $('.ipt-checkbox-all', row);
            var unit = $this.val();
            var total_unit = getAllUnit(row);

            if (unit <= total_unit) {
                var display_unit = (unit / total_unit * 100).toFixed(2);
                ipt_switch_perc.val(display_unit);
                ipt_checkbox.prop('checked', unit >= total_unit);
            } else {
                alert("Switch unit percentage exceed limit.");
                $this.val(total_unit);
                ipt_switch_perc.val("100.00");
                ipt_checkbox.prop('checked', true);
            }
        });
        $(document).on("keyup blur", '.ipt-switch-perc', function() {
            var $this = $(this);
            var row = $this.closest('.div-holding-item');
            var ipt_switch_amount = $('.ipt-switch-amount', row);
            var ipt_checkbox = $('.ipt-checkbox-all', row);
            var percentage = $this.val();
            var total_unit = getAllUnit(row);

            if (percentage <= 100) {
                var display_perc = (total_unit / 100 * percentage).toFixed(2);
                ipt_switch_amount.val(display_perc);
                ipt_checkbox.prop('checked', percentage >= 100);
            } else {
                alert("Switch unit percentage exceed limit.");
                $this.val(100);
                ipt_switch_amount.val(total_unit);
                ipt_checkbox.prop('checked', true);
            }
        });
        $(document).on("change", '.ipt-checkbox-all', function() {
            if ($(this).prop('checked')) {
                var $this = $(this);
                var row = $this.closest('.div-holding-item');
                var ipt_switch_perc = $('.ipt-switch-perc', row);
                var ipt_switch_amount = $('.ipt-switch-amount', row);

                ipt_switch_amount.val(getAllUnit(row));
                ipt_switch_perc.val("100.00");

                realtimeValidation("out", ipt_switch_amount, row);
            }
        });
        $(document).on("click", '.i-info', function() {
            var row = $(this).closest('.div-holding-item');
            $('.collapse', row).collapse('toggle');
        });

        // switch in
        // delete fund row
        $(document).on('click', '.i-fund-delete', function() {
            $(this).closest('.div-fund-transaction-row').remove();
            calculationAllocation();
        });

        // select fund house
        $(document).on('change', ".slt-fund-house", function() {
            if ($(this).val() != '') {
                showLoading();
                var row = $(this).closest('.div-fund-transaction-row');
                $(".collapse", row).collapse('hide');
                $('.slt-fund > option', row).not(':first').remove();

                ajaxRequest({
                    url: "<?= base_url() ?>transaction/_fund_list",
                    data: {
                        "fund_house": $(this).val(),
                        "is_si": is_si ? 1 : 0
                    },
                    method: "get",
                    success: function(json) {
                        var status = json.status;
                        var data = json.data;

                        switch (status) {
                            case <?= RESPONSE_STATUS_SUCCESS ?>:
                                $.each(data.funds, function(index, value) {
                                    $('.slt-fund', row).append(
                                        "<option " +
                                        "value=\"" + value.fund_id + "\" " +
                                        "data-fundname=\"" + value.fund_name + (value.is_holiday ? " (Holiday)" : "") + "\" " +
                                        "data-fundcurr=\"" + value.fund_currency + "\" " +
                                        "data-minsalecharge=\"" + (value.min_sale_charge_perc || "-") + "\" " +
                                        "data-maxsalecharge=\"" + (value.max_sale_charge_perc || "-") + "\" " +
                                        "data-mininv=\"" + (value.min_inv_amt || "-") + "\" " +
                                        "data-minsubinv=\"" + (value.min_sub_inv_amt || "-") + "\">" + value.fund_name + (value.is_holiday ? " (Holiday)" : "") + "</option>");
                                });
                                break;
                        }
                        hideLoading();
                    }
                });
            }
        })

        // select fund
        $(document).on('change', ".slt-fund", function() {
            if ($(this).val() != '') {
                var row = $(this).closest('.div-fund-transaction-row');

                var option = $("option:selected", this);
                $('.td-fund-currency', row).html(option.data('fundcurr') + " / 1.000");
                $('.td-min-sale-charge', row).html(option.data('minsalecharge'));
                $('.td-max-sale-charge', row).html(option.data('maxsalecharge'));
                $('.td-min-inv', row).html(option.data('mininv'));
                $('.td-min-sub-inv', row).html(option.data('minsubinv'));
                $('.s-fund', row).html(option.data('fundname'));
                $(".collapse", row).collapse('show');
            }
        });

        // toggle details
        $(document).on('click', 'a[data-toggle=collapse]', function() {
            var row = $(this).closest('.div-fund-transaction-row');
            var option = $(".slt-fund > option:selected", row);
            if (option.val() != '') {
                $(".collapse", row).collapse('toggle');
            }
        })

        $(document).on('keyup blur', ".ipt-payment-allocation", function() {
            calculationAllocation();
        });

        $(document).on('blur', '.ipt-switch-amount, .ipt-switch-perc, .ipt-switch-fund', function(e) {
            var $this = $(this);
            var row = $this.closest('.div-holding-item');
            if ($('.ipt-switch-fund', row).is(':checked')) {
                realtimeValidation("out", $('.ipt-switch-amount', row), row);
            } else {
                $('.form-control-error', row).removeClass('form-control-error');
                $('.error', row).text('');
            }
        });

        $(document).on('change', '.ipt-payment-allocation', function(e) {
            calculationAllocation();
        });

        $(document).on('blur', '.ipt-payment-allocation, .slt-fund', function(e) {
            var $this = $(this);
            var row = $this.closest('.div-fund-transaction-row');
            realtimeValidation("in", $this, row);
        });
    }

    function realtimeValidation(type, element, row = undefined) {
        if (validate_ajax != undefined) {
            validate_ajax.abort();
            validate_ajax = undefined;
        }

        var $this = element;
        var out_funds = getOwnedDataSelected();
        var in_funds = [];
        $('.div-fund-transaction-row').each(function(index, value) {
            var f_row = $(this);
            var fund_id = $(".slt-fund", f_row).val();
            var allocation = $(".ipt-payment-allocation", f_row).val();
            var sale_charge = $(".ipt-sale-charge", f_row).val();

            in_funds.push({
                fund_id: fund_id,
                amount: allocation,
                charge: sale_charge,
                type: "B"
            });
        });

        validate_ajax = ajaxRequest({
            url: "<?= base_url() ?>transaction/_validate_order/interswitch",
            data: {
                "client_code": client_code,
                "ifa_code": ifa_code,
                "funds": out_funds.concat(in_funds)
            },
            method: "post",
            success: function(json) {
                if (json.status === <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $(".form-control-error").removeClass("form-control-error");
                    $(".error").html("");
                } else {
                    var status = json.status;
                    var data = json.data;

                    if (data.msg) {
                        let withdrawError = data.msg;
                        var errorMessage = undefined;

                        if (withdrawError['switch_out'] == undefined) {
                            var elements = $('.error-so');
                            elements.removeClass('error-so');
                            toggleErrorMessage(undefined, elements);
                        }

                        if (withdrawError['total_percentage'] == undefined) {
                            var elements = $('.error-tp');
                            elements.removeClass('error-tp');
                            toggleErrorMessage(undefined, elements);
                        }

                        var out_fund_length = out_funds.length;
                        var index = undefined;
                        if (type == "out") {
                            for (var i = 0; i < out_fund_length; i++) {
                                var fund = out_funds[i];
                                if (fund.type == "S") {
                                    var fund_id = $this.closest('.div-holding-item').find('.ipt-switch-fund').val();

                                    if (fund.fund_id == fund_id) {
                                        index = i;
                                        break;
                                    }
                                }
                            }

                            if ($this.hasClass('ipt-switch-amount')) {
                                errorMessage = withdrawError["funds[" + index + "][unit]"];
                            }
                        } else {
                            index = out_fund_length + $('.div-fund-transaction-row').index($this.closest('.div-fund-transaction-row'));

                            if ($this.hasClass('ipt-payment-allocation')) {
                                errorMessage = withdrawError["funds[" + index + "][amount]"];
                            } else if ($this.hasClass('slt-fund')) {
                                errorMessage = withdrawError["funds[" + index + "][fund_id]"];
                            } else if ($this.hasClass('ipt-sale-charge')) {
                                errorMessage = withdrawError["funds[" + index + "][charge]"];
                            }

                            var ipt_payment_allocation = $('.ipt-payment-allocation', row);
                            var slt_fund = $('.slt-fund', row);
                            var ipt_sale_charge = $('.ipt-sale-charge', row);

                            if (ipt_payment_allocation.hasClass("form-control-error")) {
                                toggleErrorMessage(withdrawError["funds[" + index + "][amount]"], ipt_payment_allocation);
                            }
                            if (slt_fund.hasClass("form-control-error")) {
                                toggleErrorMessage(withdrawError["funds[" + index + "][fund_id]"], slt_fund);
                            }
                            if (ipt_sale_charge.hasClass("form-control-error")) {
                                toggleErrorMessage(withdrawError["funds[" + index + "][charge]"], ipt_sale_charge);
                            }
                        }
                        toggleErrorMessage(errorMessage, $this);

                        $('.ipt-payment-allocation').each(function() {
                            var input = $(this);
                            var input_row = input.closest('.div-fund-transaction-row');
                            var input_index = out_fund_length + $('.div-fund-transaction-row').index(input_row);

                            if (input.val().trim() != '' || input.hasClass('form-control-error'))
                                toggleErrorMessage(withdrawError["funds[" + input_index + "][amount]"], input);
                        })

                        if (withdrawError['switch_out']) {
                            var elements = $('.ipt-switch-amount');
                            elements.addClass('error-so');
                            toggleErrorMessage(withdrawError["switch_out"], elements);
                        }

                        if (withdrawError['total_percentage']) {
                            var elements = $('.ipt-payment-allocation');
                            elements.addClass('error-tp');
                            toggleErrorMessage(withdrawError["total_percentage"], elements);
                        }
                    }
                }
            }
        })
    }

    function toggleErrorMessage(error, input) {
        if (error) {
            input.addClass("form-control-error");
            input.closest(".form-group").find(".error").text(error);
        } else {
            input.removeClass("form-control-error");
            input.closest(".form-group").find(".error").text("");
        }
    }

    function calculationAllocation() {
        var int_allocation = 0;

        $('.div-fund-transaction-row').each(function(index, value) {
            var row = $(value);
            var allocation = $(".ipt-payment-allocation", row).val();
            var temp_int = parseInt(allocation);
            int_allocation = int_allocation + temp_int;
        });

        if (int_allocation > 100) {
            $("#allocation_note").html("<font color='red'>Allocation must not exceed 100%</font>");
            $("#allocation_leftover").html("<font color='red'>" + int_allocation + "</font>  /100%" || "0/100%");
        } else {
            $("#allocation_note").html("");
            $("#allocation_leftover").html(int_allocation + " /100%" || "0/100%");
        }
    }

    function get_fund_house_list() {
        ajaxRequest({
            url: "<?= base_url() ?>fund_house/_list",
            data: {},
            method: "get",
            success: function(json) {
                var errorMessage = "No fund house available at the moment.";
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var slt_fund_house = $('.slt-fund-house');
                        $.each(data.fund_houses, function(index, value) {
                            slt_fund_house.append("<option value=\"" + value.fund_house_id + "\">" + value.fund_house_name + "</option>");
                        });
                        break;
                }

                initializeOrderCart();

                loadingFundHouse = false;
                if (!loadingFundHouse && !loadingElements)
                    hideLoading();
            }
        });
    }

    function pumpFundDataOwned(client_code) {
        showLoading();

        var divHolding = $("#div-holding");
        divHolding.html("");

        var loaded_holding = false,
            loaded_saf = false;
        ajaxRequest({
            url: "<?= base_url() ?>transaction/_holding_list",
            data: {
                "client_code": client_code,
                "fund_type": "A",
                "ifa_code": ifa_code
            },
            method: "get",
            success: function(json) {

                var errorMessage = "No fund house available at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var fund_data = json['data'];
                        var fund_elements = fund_data['funds'];

                        for (var i = 0; i < fund_elements.length; i++) {
                            var unit = (fund_elements[i]['unit'] - fund_elements[i]['pending_unit']).toFixed(2);

                            var row = '<div class="div-holding-item" style="margin-top: 10px;">';

                            row += "<div class=\"row\">";
                            row += "<div class=\"col-md-5\">";
                            row += "<div class=\"row\">";
                            row += "<div class=\"col-md-2\">" +
                                "<input class=\"ipt-switch-fund\" type=\"checkbox\" value=\"" + fund_elements[i]['fund_id'] + "\" data-fundhouse=\"" + fund_elements[i]["fund_house_id"] + "\" data-unit=\"" + unit + "\" data-portfoliocode=\"" + (fund_elements[i]['portfolio_code'] == null ? "" : fund_elements[i]['portfolio_code']) + "\" >" +
                                "</div>";
                            row += "<div class=\"col-md-5\">" + "<div class=\"ipt-switch-name\">" + fund_elements[i]['fund_name'] + (fund_elements[i].is_holiday ? " (Holiday)" : "") + "</div>";
                            if (fund_elements[i]['portfolio_name'] != null)
                                row += "<div><strong>(Portfolio: " + fund_elements[i]['portfolio_name'] + ")</strong></div>"
                            row += "</div>";
                            row += "<div class='col-md-5'>" + fund_elements[i]['fund_house_name'] + "</div>";
                            row += "</div>";
                            row += "</div>";

                            row += "<div class='col-md-2'>" + addCommaToNumber(unit) + "</div>";

                            row += "<div class=\"col-md-3\">";
                            row += "<div class=\"row\">";
                            row += "<div class=\"col-md-6\">" +
                                "<div class=\"form-group\">" +
                                "<input class=\"form-control ipt-switch-amount\" type=\"number\" step=\"0.01\" value=\"0\" placeholder=\"Unit\">" +
                                "<span class='error text-danger'></span>" +
                                "</div>" +
                                "</div>";
                            row += "<div class=\"col-md-6\">" +
                                "<div class=\"form-group\">" +
                                "<input class=\"form-control ipt-switch-perc\" type=\"number\" step=\"0.01\" value=\"0\" placeholder=\"%\">" +
                                "<span class='error text-danger'></span>" +
                                "</div>" +
                                "</div>";
                            row += "</div>";
                            row += "</div>";

                            row += "<div class=\"col-md-1\">" +
                                "<input class='ipt-checkbox-all' type='checkbox' style='margin-left: 20px;'></input>" +
                                "</div>";
                            row += "<div class=\"col-md-1\">" +
                                "<i class=\"fa fa-info-circle py-2 px-3 i-info\"></i>" +
                                "</div>";
                            row += "</div>";

                            row += '<div class="collapse row">';
                            row += '<div class="col-md-12"><hr /></div>';
                            row += '<div class="col-md-2"></div>';
                            row += "<div class='col-md-2'><b>Currency Code / Rate</b><br>" + fund_elements[i]['fund_currency'] + "/" + parseFloat(fund_elements[i]['latest_sell_rate']).toFixed(4) + "</div>";
                            row += "<div class='col-md-2'><b>Min Initial Inv Amount</b><br>" + addCommaToNumber(fund_elements[i]['min_inv_amt']) + "</div>";
                            row += "<div class='col-md-2'><b>Min Subseq.Inv Amount</b><br>" + addCommaToNumber(fund_elements[i]['min_sub_inv_amt']) + "</div>";
                            row += "<div class='col-md-2'><b>Min Sales Charge (%)</b><br>" + addCommaToNumber(fund_elements[i]['min_sale_charge_perc'] || "-") + "</div>";
                            row += "<div class='col-md-2'><b>Max Sales Charge (%)</b><br>" + (fund_elements[i]['max_sale_charge_perc'] || "-") + "</div>";
                            row += '</div>';

                            divHolding.append(row);
                        }
                        break;
                }

                loaded_holding = true;
                if (loaded_holding && loaded_saf) {
                    setupForm();
                    hideLoading();
                }
            }
        });

        ajaxRequest({
            url: "<?= base_url() ?>client/latest_saf/_view",
            data: {
                code: client_code,
                ifa_code: ifa_code
            },
            method: "get",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    displaySafForm(data.saf);
                    displaySafDeclareForm(data.saf);

                    if (data.saf.saf_type == '<?= SAF_DECLARE_FORM ?>') {
                        $("#btn_edit_investor_saf").hide();
                        $("#btn_edit_investor_saf_declare").show();
                        get_saf_declare_form_data();
                    } else if (data.saf.saf_type == '<?= SAF_FORM ?>') {
                        $("#btn_edit_investor_saf").show();
                        $("#btn_edit_investor_saf_declare").hide();
                        get_saf_form_data();
                    } else {
                        saf_form = {};
                        $("#btn_edit_investor_saf").hide();
                        $("#btn_edit_investor_saf_declare").hide();
                    }
                }

                loaded_saf = true;
                if (loaded_holding && loaded_saf) {
                    setupForm();
                    hideLoading();
                }
            }
        });
    }

    function setupForm() {
        div_fund_transaction_row = $('.div-fund-transaction-row').first().clone();
    }

    function getOwnedDataSelected() {
        var outFund = new Array();

        $(".ipt-switch-fund:checked").each(function() {
            var $this = $(this);
            var row = $this.closest(".div-holding-item");

            var fund_id = $this.val();
            var portfolio_code = $this.data('portfoliocode')
            if (portfolio_code == "null") {
                portfolio_code = null
            }
            var holding_unit = $('.ipt-switch-amount', row).val();
            var holding_perc = $('.ipt-switch-perc', row).val();

            outFund.push({
                fund_id: fund_id,
                unit: holding_unit,
                percent: holding_perc,
                portfolio_code: portfolio_code,
                type: "S"
            })
        });

        return outFund;
    }

    function add_order(password) {
        showLoading();

        var sell_arr = getOwnedDataSelected();
        var buy_arr = new Array();
        var allocation_total = 0;
        var bool_can_submit = true;

        $('.div-fund-transaction-row').each(function(index, value) {
            var row = $(value);
            var slt_fund = $(".slt-fund", row);
            var fund_id = slt_fund.val();
            var allocation = $(".ipt-payment-allocation", row).val();
            var sale_charge = $(".ipt-sale-charge", row).val();

            var integer = parseInt(allocation, 10);
            allocation_total += integer;

            if (fund_id != "" && (is_wrap || sale_charge != "") && allocation != "") {
                buy_arr.push({
                    fund_id: fund_id,
                    amount: allocation,
                    charge: sale_charge,
                    type: "B"
                });
            } else {
                bool_can_submit = false;
            }
        });

        if (!allocation_total == 100) {
            alert("Total allocation must be 100%.")
            hideLoading();
        } else if (sell_arr.length < 1 || buy_arr.length < 1 || !bool_can_submit) {

            alert("Please complete fund details.")
            hideLoading();
        } else {
            var final_arr = sell_arr.concat(buy_arr);

            ajaxRequest({
                url: "<?= base_url() ?>transaction/_inter_switch",
                data: {
                    "password": password,
                    "client_code": client_code,
                    "ifa_code": ifa_code,
                    "saf_form": saf_form,
                    "funds": final_arr
                },
                method: "post",
                success: function(json) {
                    var status = json.status;
                    var data = json.data;

                    switch (status) {
                        case <?= RESPONSE_STATUS_SUCCESS ?>:
                            alert("Interswitch request submitted successfully.");
                            location.reload();
                            return;
                        default:
                            alert(JSON.stringify(data));
                    }
                    hideLoading();
                }
            });
        }
    }

    function select_client_handle(element) {
        client_code = element.data('clientcode');
        is_si = element.data('si') == 1;
        is_wrap = element.data('iswrap') == 1;
        toggle_sale_charge(is_wrap);

        $(".div-fund-transaction-row:not(:first-child)").remove();
        $(".div-fund-transaction-row:first-child select, .div-fund-transaction-row:first-child input").val("");
        $(".slt-fund option:not(:first-child)").remove();
        $(".div-fund-transaction-row:not(:first-child)").remove();

        $("#div-switch-out, #div-switch-in, #div-saf-documentation").collapse('show');
        pumpFundDataOwned(client_code);
    }

    function toggle_sale_charge(is_wrap) {
        var ipt_sale_charge = $('.ipt-sale-charge');
        ipt_sale_charge.prop("disabled", is_wrap);
        if (is_wrap)
            ipt_sale_charge.val('');
    }

    function submit_password(password) {
        add_order(password);
    }

    function getAllUnit(row) {
        var label = 'unit';
        var unit = parseFloat($('.ipt-switch-fund', row).data(label));
        return unit;
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>