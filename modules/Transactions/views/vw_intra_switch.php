<?php
defined("BASEPATH") or exit("No direct script access allowed");

$template = [
    "view" => "template/vw_core",
    "page_title" => "Intra Switch Transaction",
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>

<!-- custom params to quick access user -->
<?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si']) && isset($_GET['clientname']) && isset($_GET['clienttype'])) { ?>
    <script>
        var paramClientCode = "<?php echo $_GET['clientcode']; ?>"
        var paramIsWrap = "<?php echo $_GET['iswrap']; ?>"
        var paramSi = "<?php echo $_GET['si']; ?>"
        var paramClientName = "<?php echo $_GET['clientname']; ?>"
        var paramClientType = "<?php echo $_GET['clienttype']; ?>"
    </script>
<?php } else { ?>
    <script>
        var paramClientCode = null
        var paramIsWrap = null
        var paramSi = null
        var paramClientName = null
        var paramClientType = null
    </script>
<?php } ?>

<div class="py-5">
    <div class="container">
        <div class="row pb-2" id="switchIfa">
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

        <?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si']) && isset($_GET['clientname']) && isset($_GET['clienttype'])) { ?>
            <!-- hide search if these are set -->
            <div class="pt-2 collapse show" id="div-client-information-preload">
                <div class="card">
                    <div class="card-header"><b>Client Information</b></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label">
                                    <b>Account No</b>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_acc_num">
                                        <?php echo $_GET['clientcode']; ?>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">
                                    <b>Client Name</b>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_name">
                                        <?php echo urldecode($_GET['clientname']); ?>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label"><b>Account Type</b></label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_acc_type">
                                        <?php
                                            if ($_GET['iswrap'] == 1) {
                                                echo "Wrap ", $_GET['clienttype'];
                                            } else {
                                                echo $_GET['clienttype'];
                                            }
                                        ?>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row collapse" id="switchClient">
                <div class="col-md-12">
                    <?php $this->load->view("general/_vw_search_client", ["search_type" => "order", "account_type" => $type == FUND_TYPE_PRS || $type == FUND_TYPE_EPF ? "non-wrap-personal" : "all"]); ?>
                </div>
            </div>
        <?php } ?>

        <div class="row pt-2 collapse" id="switchOut">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Switch Out From</div>
                    <div class="card-body">
                        <div class="form-group row"><label for="" class="col-2 col-form-label">Fund Name</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <select id="out_fund_list" class="form-control">
                                        <option value="">Select fund</option>
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="own_fund_table">
                                <thead>
                                    <tr>
                                        <th>Fund Type</th>
                                        <th>Available Units</th>
                                        <th>Indicative Market Price</th>
                                        <th>Indicative Market Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div id="own_fund_type"></div>
                                        </td>
                                        <td>
                                            <div id="own_fund_unit"></div>
                                        </td>
                                        <td>
                                            <div id="own_fund_indicative_price"></div>
                                        </td>
                                        <td>
                                            <div id="own_fund_indicative_value"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row" id="out_allocation_div" style="display: none"><label for="fund_percentage" class="col-2 col-form-label"><b>Allocation (%)</b></label>
                            <div class="col-10">
                                <div class="form-group row">
                                    <div class="col-10 col-md-12">
                                        <div id="leftover_percentage">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Switch Percentage(s)</th>
                                                        <th>Switch Unit(s)</th>
                                                        <th>Switch All</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <input id="ipt-switch-perc" class="form-control" type="number" step="0.01" value="0" placeholder="%">
                                                                <span class="error text-danger"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input id="ipt-switch-amount" class="form-control" type="number" step="0.01" value="0" placeholder="Unit">
                                                                <span class="error text-danger"></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input id="ipt-checkbox-all" type='checkbox'>
                                                                <span class="error text-danger"></span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-2 collapse" id="switchInto">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Switch Into</div>
                    <div class="card-body">
                        <div class="row">
                            <label for="inputpasswordh" class="col-2 col-form-label">Fund Name</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <select id="to_fund_list" class="form-control">
                                        <option value="">Select fund</option>
                                    </select>
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="col-2 col-form-label">Indicative Price</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="indicative_price" value="0" placeholder="Indicative Price" readonly>
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="" class="col-2 col-form-label">Switch In Charge</label>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <input type="number" step="0.01" id="switch_in_charge" class="form-control" placeholder="Switch In Charge" min=0>
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
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
                                <button class="btn btn-danger" data-target="#modal_saf" id="btn_create_investor_saf" data-toggle="modal">Create Investor SAF</button>
                                <button class="btn btn-danger" data-target="#modal_saf_excp" data-toggle="modal">Create Investor SAF-Exceptional Declaration</button>

                            </div>

                            <!-- <div style="text-align: center;"> -->
                            <button class="btn btn-danger" data-target="#modal_saf" style="display: none;margin: 0 auto;margin-top: 10px;" id="btn_edit_investor_saf" data-toggle="modal">View/Edit Investor SAF</button>
                            <button class="btn btn-danger" data-target="#modal_saf_excp" style="display: none;margin: 0 auto;margin-top: 10px" id="btn_edit_investor_saf_declare" data-toggle="modal">View/Edit Investor SAF-Exceptional Declaration</button>
                            <!-- </div> -->
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
<?php $this->load->view("order/_vw_password"); ?>
<?php $this->load->view("order/_vw_saf"); ?>
<?php $this->load->view("template/_loading"); ?>
<?php
$template["content"] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<script>
    autoHideLoadingOnInit = false;

    var is_wrap, selectedFundId, selectedFundPortfolioCode, client_code, is_si,
        ifa_code,
        validate_ajax;
    window.addEventListener("DOMContentLoaded", function() {
        $('#out_fund_list').on('change', function() {
            var selectedOption = $(this).children("option:selected");
            var selectedFundHouse = selectedOption.data('fundhouse');
            var selectedCurrency = selectedOption.data('currency');
            selectedFundId = selectedOption.val();
            selectedFundPortfolioCode = selectedOption.data("portfoliocode");
            if (selectedFundPortfolioCode == "null") {
                selectedFundPortfolioCode = null;
            }
            toggle_sale_charge(is_wrap, $('#to_fund_list > option:selected').data('assetclass') || '', selectedOption.data('assetclass') || '');

            if (selectedFundId != "") {
                showLoading();
                $('#switchInto, #div-saf-documentation').collapse('show');

                $("#out_allocation_div").show();
                $("#own_fund_table").show();
                $("#saf_div").show();
                $("#own_fund_type").text(selectedOption.data('fundtype'));
                $("#own_fund_unit").text(addCommaToNumber(selectedOption.data('unit')));
                <?php if ($type == FUND_TYPE_PRS) { ?>
                    $("#own_fund_unit").html(
                        $("#own_fund_unit").text() +
                        "<br>Account A: " + addCommaToNumber(selectedOption.data('acc-a')) +
                        "<br>Account B: " + addCommaToNumber(selectedOption.data('acc-b'))
                    );
                <?php } ?>
                $("#own_fund_indicative_price").text(selectedOption.data('latestnav').toFixed(4));
                $("#own_fund_indicative_value").text(addCommaToNumber(selectedOption.data('marketvalue')));

                ajaxRequest({
                    url: "<?= base_url() ?>transaction/_<?= $type == FUND_TYPE_PRS ? "prs_" : ($type == FUND_TYPE_EPF ? "epf_" : "") ?>fund_list",
                    data: {
                        "fund_house": selectedFundHouse,
                        "currency": selectedCurrency,
                        "is_si": is_si ? 1 : 0
                    },
                    method: "get",
                    success: function(json) {

                        var errorMessage = "No fund house available at the moment.";
                        var status = json.status;

                        switch (status) {
                            case <?= RESPONSE_STATUS_SUCCESS ?>:
                                var fund_data = json['data'];
                                var fund_elements = fund_data['funds'];
                                var to_dropdownList = $("#to_fund_list");

                                $("option:not(:first-child)", to_dropdownList).remove();

                                for (var i = 0; i < fund_elements.length; i++) {

                                    if (selectedFundId !== fund_elements[i]['fund_id']) {
                                        to_dropdownList.append('<option value="' + fund_elements[i]['fund_id'] + '" data-price="' + fund_elements[i]['latest_nav'] + '" data-assetclass="' + fund_elements[i]['asset_class_id'] + '">' + fund_elements[i]['fund_name'] + (fund_elements[i].is_holiday ? " (Holiday)" : "") + '</option>');
                                    }

                                }
                                break;
                        }
                        hideLoading();
                    }
                });
            }
        });

        $('#to_fund_list').change(function() {
            var $this = $(this);
            toggle_sale_charge(is_wrap, $('> option:selected', $this).data('assetclass') || '', $('#out_fund_list > option:selected').data('assetclass') || '');
            if ($this.val() != "") {
                $('#indicative_price').val($('option:selected', $this).data('price'));
            }
        });

        $('#ipt-switch-amount').on('keyup blur', function() {
            var $this = $(this);
            var unit = $this.val();
            var total_unit = getAllUnit();

            if (unit <= total_unit) {
                var display_unit = (unit / total_unit * 100).toFixed(2);
                $("#ipt-switch-perc").val(display_unit);
            } else {
                alert("Switch unit percentage exceed limit.");
                $this.val(total_unit);
                $("#ipt-switch-perc").val("100.00");
            }
        });
        $('#ipt-switch-perc').on('keyup blur', function() {
            var $this = $(this);
            var percentage = $this.val();
            var total_unit = getAllUnit();

            if (percentage <= 100) {
                var display_perc = (total_unit / 100 * percentage).toFixed(2);
                $("#ipt-switch-amount").val(display_perc);
            } else {
                alert("Switch unit percentage exceed limit.");
                $this.val(100);
                $("#ipt-switch-amount").val(total_unit);
            }
        });
        $('#ipt-checkbox-all').change(function() {
            if ($(this).prop('checked')) {
                var $this = $(this);
                var ipt_amount = $("#ipt-switch-amount");
                ipt_amount.val(getAllUnit());
                $("#ipt-switch-perc").val("100.00");

                realtimeValidation(ipt_amount);
            }
        });

        $("#btn_print").click(function() {
            var divToPrint = document.getElementById("own_fund_table");
            var divToPrint2 = document.getElementById("to_fund_list");
            var html = "<h3><b><u>INTRASWITCH ORDER</u></b></h3><br>";
            html += "Client Name : " + $("#client_name").html() + "<br>";
            html += "Client ID : " + $('#client_acc_num').data("clientcode") + "<br>";
            html += "Switch Out Fund : <b>" + $("#out_fund_list option:selected").text() + "</b><br>";
            html += divToPrint.outerHTML + "<br>";

            html += "Switch In Fund : <b>" + $("#to_fund_list option:selected").text() + "<b><br>";
            html += "Indicative Price : <b>" + $("#indicative_price").val() + "<b><br>";
            html += "Switch In Charge : <b>" + $("#switch_in_charge").val() + "<b><br>";

            printHtml(html);
        });

        $(document).on('blur', '#ipt-switch-perc, #ipt-switch-amount', function(e) {
            realtimeValidation($("#ipt-switch-amount"));
        });
        $(document).on('blur', '#out_fund_list, #to_fund_list, #switch_in_charge', function(e) {
            realtimeValidation($(this));
        });

        $("#btn-add").click(function() {
            var percentage = $("#ipt-switch-perc").val();
            var unit = $("#ipt-switch-amount").val();
            var total_unit = getAllUnit();
            var calc_unit = (total_unit / 100 * percentage).toFixed(2);
            var calc_perc = (unit / total_unit * 100).toFixed(2);

            if (unit == calc_unit || percentage == calc_perc) {
                togglePassword();
            } else {
                alert("The unit and percentage is not tally. Please check again.");
            }
        })

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
                                $("#switchClient").collapse("show");
                            else
                                $("#switchClient").collapse("hide");
                        })
                    } else {
                        $("#switchIfa").remove();
                        $("#switchClient").collapse("show");
                    }

                    <?php if ($type == FUND_TYPE_PRS) { ?>
                        initPrs(json.data);
                    <?php } ?>
                }

                hideLoading();
            }
        })

        // if clientcode, iswrap, si is passed via url parameter
        if (paramClientCode != null && paramIsWrap != null && paramSi != null && window.select_client_handle !== undefined) {
            var element = $('<div></div>', {
                'data-iswrap': paramIsWrap,
                'data-si': paramSi,
                'data-clientcode': paramClientCode
            })
            select_client_handle(element);
        }
    });

    function submit_password(password) {
        add_order(password);
    }

    function add_order(password) {
        showLoading();

        var bool_can_submit = true;

        var out_fund_id = selectedFundId;
        var out_unit = $("#ipt-switch-amount").val();
        var out_percentage = $("#ipt-switch-perc").val();
        var in_fund_id = $('#to_fund_list').val();
        var sale_charge = $("#switch_in_charge").val();

        // if (in_fund_id != "" && (is_wrap || sale_charge != "") && out_fund_id != "" && out_unit != "") {
        var final_arr = new Array();
        final_arr.push({
            fund_id: in_fund_id,
            charge: sale_charge,
            type: "B"
        })

        final_arr.push({
            fund_id: out_fund_id,
            unit: out_unit,
            percent: out_percentage,
            portfolio_code: selectedFundPortfolioCode,
            type: "S"
        });

        ajaxRequest({
            url: "<?= base_url() ?>transaction/_intra_switch<?= $type == FUND_TYPE_PRS ? "_prs" : ($type == FUND_TYPE_EPF ? "_epf" : "") ?>",
            data: {
                "password": password,
                "client_code": client_code,
                "saf_form": saf_form,
                "funds": final_arr,
                "ifa_code": ifa_code
            },
            method: "post",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        alert("Intraswitch request submitted successfully.");
                        location.reload();
                        return;
                    default:
                        alert(JSON.stringify(data));
                }
                hideLoading();
            }
        });
        // } else {
        //     alert("Please complete fund details.")
        //     hideLoading();
        // 
    }

    function init_search_client() {
        $('#switchOut, #switchInto, #div-saf-documentation').collapse('hide');
    }

    function select_client_handle(element) {
        client_code = element.data('clientcode');
        is_wrap = element.data('iswrap') == 1;
        is_si = element.data('si') == 1;

        toggle_sale_charge(is_wrap, "", "");

        $('#switchOut').collapse('show');
        $('#switchInto, #div-saf-documentation').collapse('hide');
        $("#out_allocation_div").hide();
        $("#own_fund_table").hide();
        pumpFundDataOwned(client_code);
    }

    function toggle_sale_charge(is_wrap, in_fund_type, out_fund_type) {
        var disabled = is_wrap ||
            !(
                (out_fund_type == "FXINC" || out_fund_type == "MNMKT") &&
                in_fund_type == "EQUTY"
            );

        var ipt_sale_charge = $('#switch_in_charge');
        ipt_sale_charge.prop("disabled", disabled);
        if (disabled)
            ipt_sale_charge.val('');
    }

    function pumpFundDataOwned(client_code_pump) {
        showLoading();

        $("#out_fund_list > option:not(:first-child)").remove();

        var loaded_holding = false,
            loaded_saf = false;
        ajaxRequest({
            url: "<?= base_url() ?>transaction/_<?= $type == FUND_TYPE_PRS ? "prs_" : ($type == FUND_TYPE_EPF ? "epf_" : "") ?>holding_list",
            data: {
                "client_code": client_code_pump,
                "fund_type": "A",
                "ifa_code": ifa_code,
                "intra_avail": true
            },
            method: "get",
            success: function(json) {

                var errorMessage = "No fund house available at the moment.";
                var status = json.status;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var fund_data = json['data'];
                        var fund_elements = fund_data['funds'];
                        var out_dropdownList = $("#out_fund_list");

                        $.each(fund_elements, function(index, value) {
                            var pending_unit = (value['unit'] - value['pending_unit']).toFixed(2);
                            var html = '<option value="' + value['fund_id'] + '" ' +
                                'data-portfoliocode="' + (value['portfolio_code'] == null ? "" : value['portfolio_code']) + '" ' +
                                'data-fundtype="' + value['fund_type'] + '" ' +
                                'data-currency="' + value['fund_currency'] + '" ' +
                                'data-unit="' + pending_unit + '" ' +
                                'data-latestnav="' + value['latest_nav'] + '" ' +
                                'data-marketvalue="' + (value['latest_nav'] * pending_unit) + '" ' +
                                'data-fundhouse="' + value['fund_house_id'] + '" ';
                            <?php if ($type == FUND_TYPE_PRS) { ?>
                                html += "data-acc-a=\"" + (value.sub_acc['A'] || 0) + "\" " + "data-acc-b=\"" + (value.sub_acc['B'] || 0) + "\" ";
                            <?php } ?>
                            html += 'data-assetclass="' + value['asset_class_id'] + '">' + value['fund_name'] + (value.is_holiday ? " (Holiday)" : "");
                            if (value["portfolio_name"] != null) {
                                html += ' (Portfolio: ' + value["portfolio_name"] + ')';
                            }
                            html += '</option>'
                            out_dropdownList.append(html);
                        });
                        break;
                }

                loaded_holding = true;
                if (loaded_holding && loaded_saf)
                    hideLoading();
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
                if (loaded_holding && loaded_saf)
                    hideLoading();
            }
        });
    }

    function getAllUnit() {
        var unit = parseFloat($('#out_fund_list > option:selected').data('unit'));
        return unit;
    }

    <?php if ($type == FUND_TYPE_PRS) { ?>
        var prs_percentage;

        function initPrs(data) {
            prs_percentage = data.prs_percentage;

            $("#s-prs-penalty").text(addCommaToNumber(data.prs_penalty_fee))
        }
    <?php } ?>

    function realtimeValidation(element) {
        if (validate_ajax != undefined) {
            validate_ajax.abort();
            validate_ajax = undefined;
        }

        let $this = element;

        let slt_out_fund = $("#out_fund_list");
        let ipt_out_amount = $("#ipt-switch-amount");
        var slt_in_fund = $('#to_fund_list');
        var ipt_sale_charge = $("#switch_in_charge");

        var portfolio_code = $("option:selected", slt_out_fund).data("portfoliocode");
        let data = {
            "client_code": client_code,
            "funds": [{
                    fund_id: slt_in_fund.val(),
                    charge: ipt_sale_charge.val(),
                    type: "B"
                },
                {
                    fund_id: slt_out_fund.val(),
                    unit: ipt_out_amount.val(),
                    portfolio_code: portfolio_code == "null" ? null : portfolio_code,
                    type: "S"
                }
            ],
            "ifa_code": ifa_code
        }

        validate_ajax = ajaxRequest({
            url: "<?= base_url() ?>transaction/_validate_order/<?= $type == FUND_TYPE_PRS ? "prs/" : ($type == FUND_TYPE_EPF ? "epf/" : "") ?>intraswitch",
            data: data,
            method: "post",
            success: function(json) {
                if (json.status === <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $(".form-control-error").removeClass("form-control-error");
                    $(".error").html("");
                } else {
                    var status = json.status;
                    var data = json.data;

                    if (data.msg) {
                        let fundError = data.msg;
                        var errorMessage = undefined;
                        if ($this.attr("id") == "out_fund_list") {
                            errorMessage = fundError["funds[1][portfolio_code]"] || fundError["funds[1][fund_id]"];
                        } else if ($this.attr("id") == "ipt-switch-amount") {
                            errorMessage = fundError["funds[1][amount]"] || fundError["funds[1][unit]"];
                        } else if ($this.attr("id") == "to_fund_list") {
                            errorMessage = fundError["funds[0][amount]"] || fundError["funds[0][fund_id]"];
                        } else if ($this.attr("id") == "switch_in_charge") {
                            errorMessage = fundError["funds[0][charge]"];
                        }
                        toggleErrorMessage(errorMessage, $this);

                        if (slt_out_fund.hasClass("form-control-error")) {
                            toggleErrorMessage(fundError["funds[1][portfolio_code]"] || fundError["funds[1][fund_id]"], slt_out_fund);
                        }
                        if (ipt_out_amount.hasClass("form-control-error")) {
                            toggleErrorMessage(fundError["funds[1][amount]"] || fundError["funds[1][unit]"], ipt_out_amount);
                        }
                        if (slt_in_fund.hasClass("form-control-error")) {
                            toggleErrorMessage(fundError["funds[0][amount]"] || fundError["funds[0][fund_id]"], slt_in_fund);
                        }
                        if (ipt_sale_charge.hasClass("form-control-error")) {
                            toggleErrorMessage(fundError["funds[0][charge]"], ipt_sale_charge);
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
</script>
<?php $template["footer"] = ob_get_clean(); ?>

<?= json_encode($template) ?>