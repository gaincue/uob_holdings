<?php
defined("BASEPATH") or exit("No direct script access allowed");
$template = [
    "view" => "template/vw_core",
    "page_title" => "View Holdings",
];

$details = json_decode(
    $this->load->view(
        "_vw_view_holding_details",
        [],
        true
    ),
    true
);

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<div class="container-fluid">
    <div class="row pb-2" id="holding_ifa">
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

    <div class="py-2 collapse" id="div-selected-client" style="position: sticky; top: 98px; z-index: 1;">
        <div class="card">
            <div class="card-header">Selected Client</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="selected_client_tbl" class="table table-striped table-borderless display" style="width: 100%">
                        <thead>
                            <tr>
                                <th scope="col">Account No</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Account Type</th>
                                <th scope="col" colspan="4" style='text-align: center;'>Holdings Summary</th>
                                <th scope="col">Statement</th>
                                <th scope="col">Info</th>
                                <th scope="col">Adviser Code</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2 collapse" id="div-client-list">
        <div class="card">
            <div class="card-header">View Holdings</div>
            <div class="card-body">
                <button id="btn-export-excel" class="btn btn-danger">Export to Excel</button>
                <div class="table-responsive">
                    <table id="client_holding_tbl" class="table table-striped table-borderless display" style="width: 100%">
                        <thead>
                            <tr class="tr-delete">
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            <tr>
                                <th scope="col">Account No</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Account Type</th>
                                <th scope="col" colspan="4" style='text-align: center;'>Holdings Summary</th>
                                <th scope="col">Statement</th>
                                <th scope="col">Info</th>
                                <th scope="col">Adviser Code</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?= $details['content']['table'] ?>
</div>

<?= $details['content']['modal'] ?>
<?php $this->load->view("template/_loading"); ?>

<?php
$template["content"] = ob_get_clean();

/*
 * ---------
 *  HEADER
 * ---------
 */
ob_start();
?>
<style>
    #selected_client_tbl th,
    #selected_client_tbl td,
    #client_holding_tbl th,
    #client_holding_tbl td {
        min-width: 60px;
        width: 100px;
        text-align: center;
    }

    #selected_client_tbl th:nth-child(6),
    #selected_client_tbl td:nth-child(6),
    #client_holding_tbl th:nth-child(6),
    #client_holding_tbl td:nth-child(6) {
        min-width: 60px;
    }

    #selected_client_tbl th:nth-child(2),
    #selected_client_tbl td:nth-child(2),
    #client_holding_tbl th:nth-child(2),
    #client_holding_tbl td:nth-child(2) {
        min-width: 250px;
        text-align: left;
    }

    #selected_client_tbl th:nth-child(1),
    #selected_client_tbl td:nth-child(1),
    #client_holding_tbl th:nth-child(1),
    #client_holding_tbl td:nth-child(1),
    #selected_client_tbl th:nth-child(3),
    #selected_client_tbl td:nth-child(3),
    #client_holding_tbl th:nth-child(3),
    #client_holding_tbl td:nth-child(3) {
        text-align: left;
    }
</style>
<?= $details['header'] ?>
<?php
$template["header"] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<script>
    var ifa_code, client_holding_tbl, selected_client_tbl;

    autoHideLoadingOnInit = false;
    window.addEventListener("DOMContentLoaded", () => {
        selected_client_tbl = $("#selected_client_tbl");

        client_holding_tbl = $("#client_holding_tbl").DataTable({
            "bPaginate": true, // Show paging
            "searching": true, // Show Search
            "info": true, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">',
            "columnDefs": [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            "aoColumnDefs": [{
                bSortable: false,
                aTargets: [3, 4, 5, 6, 7, 8]
            }],
            "createdRow": function(row, data, dataIndex) {
                initClientRow(row);
            }
        });

        $("#client_holding_tbl .tr-delete").remove();

        $('#btn-export-excel').click(function() {
            showLoading();

            ajaxRequest({
                url: "<?= base_url() ?>view_holdings/bfe/_export_excel",
                data: {},
                method: "get",
                success: function(json) {
                    if (json.status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                        files_download([{
                            url: "<?= base_url() ?>view_holdings/bfe/exported?f=" + json.data.filename
                        }]);
                    }
                    hideLoading();
                }
            })
        });

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/_elements",
            data: {},
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
                                initialList(ifa_code);
                            else
                                $("#div-client-list").collapse("hide");
                        })

                        $("#holding_ifa").show();
                    } else {
                        $("#holding_ifa").remove();
                        initialList();
                    }
                }
            }
        })
    })

    function initialList(ifa = undefined) {
        showLoading();

        ifa_code = ifa;
        client_holding_tbl.clear().draw();
        $("#div-client-list").collapse("show");

        var data = {};
        if (ifa_code != undefined) {
            data['ifa_code'] = ifa_code;
        }

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client",
            data: data,
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_clients = json.data.summary;

                        for (var i = 0; i < arr_clients.length; i++) {
                            var client_elements = arr_clients[i];


                            var portfolio_detail = "-";
                            if (client_elements['portfolio_detail'] != "NULL" && client_elements['portfolio_detail'] != null) {
                                portfolio_detail = client_elements['portfolio_detail'];
                            }

                            var payment_type = "-";
                            if (client_elements['payment_type'] != "NULL" && client_elements['payment_type'] != null) {
                                payment_type = client_elements['payment_type'];
                            }

                            var client_name = "<a href=\"#modal_client_info\" id='link_client_name' data-client-no=\"" + client_elements['client_code'] + "\" data-toggle=\"modal\">" + client_elements['client_name'] + "</a>";
                            var ut_tab = "<a data-client-no=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" id='ut_tab' href=\"#\">" + portfolio_detail + " </a>";
                            var payment_type = "<a href=\"#\" id='link_cash_acc_summary' data-client-no=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" class=\"collapsed\" aria-expanded=\"false\">" + payment_type + " </a>";
                            // var rsp = "<a href=\"#\" class=\"collapsed\" aria-expanded=\"false\">RSP</a>";
                            var saf = "<a id='view_saf' href=\"#\" data-client-no=\"" + client_elements['client_code'] + "\" class=\"collapsed\" aria-expanded=\"false\">SAF</a>";
                            var holding_summary = "<a id='holding_summary_view' data-client-no=\"" + client_elements['client_code'] + "\"  href=\"#\" data-clientno=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" aria-expanded=\"true\">Summary</a>";
                            var total_account = "<a href=\"#modal_info\" data-toggle=\"modal\"  data-client-no=\"" + client_elements['client_code'] + "\" id='summary_acc' aria-expanded=\"true\">" + client_elements['total_account'] + " Account(s)</a>";

                            client_holding_tbl.row.add([
                                client_elements['client_code_label'],
                                client_name,
                                get_account_label(client_elements['clnt_type_description'], client_elements['is_wrap']),
                                ut_tab,
                                // port_folio,
                                // bond,
                                payment_type,
                                // rsp,
                                saf,
                                holding_summary,
                                '<a target="_blank" href="<?= base_url() ?>client/monthly_client_statement?client_code=' + client_elements['client_code'] + '"><i class="fa fa-file-text-o"></i></a>',
                                total_account,
                                (client_elements['avisor_code'] || "-")
                            ]);
                        }
                        client_holding_tbl.draw();
                        break;
                }
                $("#div-client-list").collapse('show');
            }
        });
    }

    function initClientRow(row) {
        $('#link_client_name', row).click(function() {
            displayClientInfo($(this).data("client-no"))
        });

        $('#link_cash_acc_summary', row).click(function() {
            displayCashAccount($(this).data("client-no"), $(this).data("iswrap") == 1);
            displaySelectedClient(row);
        });

        $('#ut_tab', row).click(function() {
            displayUniTrust($(this).data("client-no"), $(this).data("iswrap") == 1);
            displaySelectedClient(row);
        });

        $('#view_saf', row).click(function() {
            displaySaf($(this).data("client-no"))
            displaySelectedClient(row);
        });

        $('#holding_summary_view', row).click(function() {
            displaySummary($(this).data("client-no"), $(this).data("iswrap") == 1);
            displaySelectedClient(row);
        });

        $('#summary_acc', row).click(function() {
            displayAccounts($(this).data("client-no"))
        });
    }

    function displaySelectedClient(row) {
        var clone = $(row).clone();
        initClientRow(clone);

        var tbody = $('tbody', selected_client_tbl);
        tbody.html('');
        tbody.append(clone);
        $('#div-selected-client').collapse('show');
    }
</script>
<?= $details['footer'] ?>
<?php $template["footer"] = ob_get_clean(); ?>

<?= json_encode($template) ?>