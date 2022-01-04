<?php
defined("BASEPATH") or exit("No direct script access allowed");

$sub_title = "";
if ($type == FUND_TYPE_PRS) {
    $sub_title = "PRS ";
} elseif ($type == FUND_TYPE_EPF) {
    $sub_title = "EPF ";
}

$action_label = "";
if ($action == ORDER_TYPE_BUY) {
    $action_label = "Buy ";
} elseif ($action == ORDER_TYPE_SELL) {
    $action_label = "Sell ";
}

$template = [
    "view" => "template/vw_core",
    "page_title" =>
    empty($order) ? ($action_label . " " . $sub_title . "Transaction (Unit Trust)") : "Modify Order",
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

<?php $this->load->view("template/_loading"); ?>

<div class="py-5">
    <div class="container">
        <?php if (empty($order)) { ?>
            <div class="row pb-2" id="order_ifa">
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
                <div class="row collapse" id="order_client">
                    <div class="col-md-12">
                        <?php $this->load->view("general/_vw_search_client", [
                            "search_type" => "order",
                            "account_type" =>
                            $type == FUND_TYPE_EPF || $type == FUND_TYPE_PRS
                                ? "non-wrap-personal"
                                : "all",
                        ]); ?>
                    </div>
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header"><b>Available Currency</b></div> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2"><label class="col-form-label"><b>Order Number</b></label></div>
                                <div class="col-md-4"><label class="col-form-label"><?= $order["order_no"] ?></label></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($action == ORDER_TYPE_BUY && $type != FUND_TYPE_EPF) { ?>
            <div class="row pt-2 collapse" id="order_balance">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><b>Available Currency</b></div>
                        <div class="card-body">
                            <table class="table table-borderless table-striped display" id="tbl_balance">
                                <thead>
                                    <tr>
                                        <th>Currency</th>
                                        <th>Amount Available For Investment<a href="#" data-toggle="tooltip" title="Your available investment amount is subject to sales charge deduction."><i class="fa fa-info-circle px-3 py-2"></i></a></th>
                                        <th>Overdue Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="col-md-12">
            <table id="order_tbl_hide" class="table table-striped table-borderless display" style="display: none">
                <thead>
                    <tr>
                        <?php if ($action == ORDER_TYPE_BUY) { ?>
                            <td>No</td>
                            <td>Fund ID</td>
                            <td>Payment Currency</td>
                            <td>Amount</td>
                            <td>Charge</td>
                        <?php } elseif ($action == ORDER_TYPE_SELL) { ?>
                            <td>No</td>
                            <td>Fund ID</td>
                            <td>Received Method</td>
                            <td>Unit</td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="row pt-2 collapse" id="order_cart">
            <div class="col-md-12">
                <?php if ($action == ORDER_TYPE_BUY) {
                    $this->load->view("order/_vw_buy_cart", [
                        "order" => $order ?? null,
                    ]);
                } elseif ($action == ORDER_TYPE_SELL) {
                    $this->load->view("order/_vw_sell_cart", [
                        "order" => $order ?? null,
                    ]);
                } ?>
            </div>
        </div>

        <?php if ($action == ORDER_TYPE_BUY) { ?>
            <div class="row pt-2 collapse " id="order_payment_summary">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><b> Payment Summary</b></div>
                        <div class="card-body">
                            <div class="row pt-2">
                                <div class="col-md-12">
                                    <table id="tbl-payment-summary" class="table"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pt-2 collapse" id="order_saf_documentation">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><b> SAF Documentation</b></div>
                        <div class="card-body">
                            <div class="row pt-2 collapse show" id="div-investor-saf-buttons">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-danger" data-target="#modal_saf" id="btn_create_investor_saf" data-toggle="modal">Create Investor SAF</button>
                                    <button class="btn btn-danger" data-target="#modal_saf_excp" data-toggle="modal">Create Investor SAF-Exceptional Declaration</button>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-danger" data-target="#modal_saf" style="display: none;margin: 0 auto;margin-top: 10px;" id="btn_edit_investor_saf" data-toggle="modal">View/Edit Investor SAF</button>
                                    <button class="btn btn-danger" data-target="#modal_saf_excp" style="display: none;margin: 0 auto;margin-top: 10px" id="btn_edit_investor_saf_declare" data-toggle="modal">View/Edit Investor SAF-Exceptional Declaration</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row pt-2 collapse " id="order_buttons">
            <div class="col-md-9"></div>
            <div class="col-md-3 text-right">
                <button class="btn btn-danger" id="btn_print">Print</button>
                <button class="btn btn-danger" data-target="#modal_password" data-toggle="modal">Add To Order</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("order/_vw_saf"); ?>
<?php $this->load->view("order/_vw_password"); ?>
<?php
$template["content"] = ob_get_clean(); /*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>

<script>
    autoHideLoadingOnInit = false;
    var ifa_code,
        loadingFundHouse = <?= $action == ORDER_TYPE_BUY ? "true" : "false" ?>,
        loadingElements = true;
    window.addEventListener("DOMContentLoaded", function() {
        $('[data-toggle="tooltip"]').tooltip();

        var print_tbl = $("#order_tbl_hide").DataTable({
            "bPaginate": false, // Show paging
            "searching": false, // Show Search
            "info": false, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">',

        });

        $("#btn_print").click(function() {
            document.getElementById("order_tbl_hide").style.display = "table";
            document.getElementById("order_tbl_hide").style.width = "100%";
            print_tbl.clear().draw();
            $('<?= $action == ORDER_TYPE_BUY
                    ? ".div-fund-transaction-row"
                    : ($action == ORDER_TYPE_SELL
                        ? ".div-holding-transaction-row"
                        : ".unknown") ?>').each(function(index, value) {
                var row = $(value);
                <?php if ($action == ORDER_TYPE_BUY) { ?>
                    var fund_id = $(".slt-fund>option:selected", row).text() + "(" + $(".slt-fund", row).val() + ")";
                    var payment_currency = $(".slt-payment-currency", row).val();
                    var amount = $(".ipt-amount", row).val();
                    var sale_charge = $(".ipt-sale-charge", row).val();
                    print_tbl.row.add([
                        index + 1,
                        fund_id,
                        payment_currency,
                        amount,
                        sale_charge
                    ]);
                <?php } elseif ($action == ORDER_TYPE_SELL) { ?>
                    var fund_id = $(".slt-holding>option:selected", row).text() + "(" + $(".slt-fund", row).val() + ")";
                    var received_method = $(".slt-receive-method", row).text();
                    var unit = $(".ipt-unit", row).val();
                    print_tbl.row.add([
                        index + 1,
                        fund_id,
                        received_method,
                        unit
                    ]);
                <?php } ?>
            });
            print_tbl.draw();
            var divToPrint = document.getElementById("order_tbl_hide");
            var html = "<h3><b><u>ORDER LIST</u></b></h3><br>";
            html += "Client Name : " + $("#client_name").html() + "<br>";
            html += "Client ID : " + $('#client_acc_num').data("clientcode") + "<br>";

            html += divToPrint.outerHTML;
            printHtml(html);
            $("#order_tbl_hide").hide();
        });

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
                                $("#order_client").collapse("show");
                            else
                                $("#order_client").collapse("hide");
                        })
                    } else {
                        $("#order_ifa").remove();
                        $("#order_client").collapse("show");
                    }

                    <?php if ($type == FUND_TYPE_PRS) { ?>
                        if (window.initPrs != undefined) initPrs(json.data);
                    <?php } elseif ($type == FUND_TYPE_EPF) { ?>
                        if (window.initEpf != undefined) initEpf(json.data);
                    <?php } ?>
                }

                loadingElements = false;
                initForm();

            }
        })

        calculate_payment_summary();

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

    function init_search_client() {
        $('#order_balance, #order_cart, #order_payment_summary, #order_saf_documentation, #order_buttons').collapse('hide');
    }

    function add_order(password) {
        showLoading();
        var funds = get_funds();
        var client_code = $('#client_acc_num').data("clientcode");

        var data = {
            <?php if (!empty($order)) { ?>
                order_no: '<?= $order["order_no"] ?>',
            <?php } else { ?>
                client_code: client_code,
                ifa_code: ifa_code,
            <?php } ?> "password": password,
            "funds": funds
        };
        <?php if ($action == ORDER_TYPE_BUY) { ?>
            data["saf_form"] = saf_form;
        <?php } ?>
        ajaxRequest({
            url: "<?= base_url() ?>transaction/<?= $action == ORDER_TYPE_BUY ? "_buy" : ($action == ORDER_TYPE_SELL ? "_sell" : "") ?>_<?= $type == FUND_TYPE_PRS ? "prs_" : ($type == FUND_TYPE_EPF ? "epf_" : "") ?>order",
            data: data,
            method: "post",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        alert("Order <?= empty($order) ? "created" : "update" ?> successfully");
                        <?php if (!empty($order)) { ?>
                            window.location = "<?= base_url() ?>transaction/amendment";
                        <?php } else { ?>
                            location.reload();
                        <?php } ?>
                        return;
                    default:
                        alert(JSON.stringify(data));
                }
                hideLoading();
            }
        });
    }
</script>
<?php $template["footer"] = ob_get_clean(); ?>

<?= json_encode($template) ?>