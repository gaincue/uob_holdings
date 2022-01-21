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
<div class="container-fluid holding holding-container">
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
</div>

<div class="mb-4 collapse" id="div-selected-client">
    <div class="container-fluid holding holding-container">
        <div class="d-flex justify-content-between align-items-center holding--spacing">
            <h4 class="holding--title">Selected Client</h4>
            <div class="d-flex">
                <div class="d-block" style="margin-right: 12px;">
                    <button id="btn-back-list" class="holding--pill active">Back</button>
                </div>

                <div class="d-block">
                    <button id="btn-export-excel" class="holding--pill active">Export</button>
                </div>
            </div>
        </div>
        <div class="table-responsive" style="margin-left: -10px; width: calc(100% + 10px)">
            <table id="selected_client_tbl" class="table table-borderless display" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col" data-selected-client-no>
                            <!-- set th value as account number -->
                        </th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Investment Amount</th>
                        <th scope="col">Cash Account</th>
                        <th scope="col">Holdings</th>
                        <th scope="col">Transactions</th>
                        <th scope="col">Unrealised P&L</th>
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

<div class="container-fluid holding holding-container">
    <div class="py-2 collapse" id="div-client-list">
        <div class="holding--spacing">
            <h4 data-account-count class="holding--title"></h4>
        </div>
        <div class="table-responsive holding--negative-margin">
            <table id="client_holding_tbl" class="table holding--table display" style="width: 100%">
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
                    <!-- <tr>
                        <th scope="col">Account No</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Account Type</th>
                        <th scope="col" colspan="4" style='text-align: center;'>Holdings Summary</th>
                        <th scope="col">Statement</th>
                        <th scope="col">Info</th>
                        <th scope="col">Adviser Code</th>
                    </tr> -->
                    <tr>
                        <th scope="col">Account No</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Investment Amount</th>
                        <th scope="col">Cash Account</th>
                        <th scope="col">Holdings</th>
                        <th scope="col">Transactions</th>
                        <th scope="col">Unrealised P&L</th>
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
    /* override for holdings page */
    .div-body {
        margin-top: 106px;
    }

    #client_holding_tbl tbody tr:hover {
        background-color: #f0f0f0;
    }

    #div-selected-client {
        background-color: white;
        box-shadow: 0px 14px 12px rgba(60, 76, 84, 0.05);
    }

    /* override pagination style */
    .ui.pagination.menu {
        border: none;
        box-shadow: none;
    }

    .ui.menu .item:before {
        all: initial;
    }

    .ui.pagination.menu a {
        text-decoration: none !important;
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
        selected_client_tbl = $("#selected_client_tbl")

        client_holding_tbl = $("#client_holding_tbl").DataTable({
            "bPaginate": true, // Show paging
            "searching": true, // Show Search
            "info": true, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"holding--top"f>rt<"holding--bottom"ipl><"clear">',
            "columnDefs": [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            "aoColumnDefs": [{
                bSortable: false,
                aTargets: [3, 4, 5, 6, 7, 8]
            }],
            "createdRow": function(row, data, dataIndex) {
                initClientRow(row, data);
            },
            "drawCallback": function(settings) {
                // wait until table is rendered and
                // set holding--bottom to tables width
                $('.holding--bottom').each(function() {
                    var width = $(this).prev().width()
                    $(this).width(width - 16)
                })
            },
            "oLanguage": {
                "oPaginate": {
                    'sNext': '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 18L15 12L9 6" stroke="#E0E0E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>',
                    'sPrevious': '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 18L9 12L15 6" stroke="#E0E0E0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>'
                }
            }
        });

        $("#client_holding_tbl .tr-delete").remove();

        $('#btn-back-list').click(function() {
            showLoading();

            $("#div-client-list").collapse("show");

            $('#div-selected-client').collapse('hide');
            $("#portfolio_ut_prs").collapse("hide");
            $("#SAF").collapse("hide");
            $("#summary_tab").collapse("hide");
            $("#cash_account").collapse("hide");

            currentClientId = null;
            currentClientIsWrap = null;

            hideLoading();
        });

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

                        // can we assume there is no pagination?
                        $('[data-account-count]').text(`${arr_clients.length} Accounts`)

                        for (var i = 0; i < arr_clients.length; i++) {
                            var client_elements = arr_clients[i];

                            // ToDo: set portfolio detail as investment amount
                            var portfolio_detail = "-";
                            if (client_elements['portfolio_detail'] != "NULL" && client_elements['portfolio_detail'] != null) {
                                portfolio_detail = client_elements['portfolio_detail'];
                            }

                            // ToDo: set payment_type as cash amount
                            var payment_type = "-";
                            if (client_elements['payment_type'] != "NULL" && client_elements['payment_type'] != null) {
                                payment_type = client_elements['payment_type'];
                            }

                            var client_name = "<a class='titlecase' href=\"#modal_client_info\" data-link_client_name data-client-no=\"" + client_elements['client_code'] + "\" data-toggle=\"modal\">" + client_elements['client_name'].toLowerCase() + "</a>";
                            var ut_tab = "<span data-client-no=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" data-ut_tab href=\"#\">" + portfolio_detail + " </span>";
                            var payment_type = "<a href=\"#\" data-link_cash_acc_summary data-client-no=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" class=\"collapsed\" aria-expanded=\"false\">" + payment_type + " </a>";
                            // var rsp = "<a href=\"#\" class=\"collapsed\" aria-expanded=\"false\">RSP</a>";
                            var saf = "<a class='dropdown-item' data-view_saf href=\"#\" data-client-no=\"" + client_elements['client_code'] + "\" class=\"collapsed\" aria-expanded=\"false\">View SAF</a>";
                            var holding_summary = "<a class='dropdown-item' data-holding_summary_view data-client-no=\"" + client_elements['client_code'] + "\"  href=\"#\" data-clientno=\"" + client_elements['client_code'] + "\" data-iswrap=\"" + client_elements['is_wrap'] + "\" aria-expanded=\"true\">View Summary</a>";
                            var total_account = "<a href=\"#modal_info\" data-toggle=\"modal\"  data-client-no=\"" + client_elements['client_code'] + "\" data-summary_acc aria-expanded=\"true\">" + client_elements['total_account'] + " Account(s)</a>";

                            // data to pass to buy page
                            var clientcode = client_elements['client_code']
                            var iswrap = client_elements['is_wrap']
                            var si = client_elements['si'] == 1 ? "1" : "0"
                            var clienttype = client_elements['clnt_type_description']
                            var clientname = encodeURIComponent(client_elements['client_name'])

                            // holding dropdown
                            var holding_wrapper =
                                `<div class="dropdown holding--dropdown" data-dropup-auto="false">
                                    <a
                                        class="holding--toggle"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        onclick="manualStopPropagation();"
                                    >
                                        Select
                                        <svg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                            <path d='M1 1L5 5L9 1' stroke='#C33B32' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                        </svg> 
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>${holding_summary}</li>
                                        <li>${saf}</li>
                                    </ul>
                                </div>
                                `

                            // quick and dirty redirection
                            // transaction dropdown
                            var transaction_wrapper =
                                `<div class="dropdown holding--dropdown" data-dropup-auto="false">
                                <a
                                    class="holding--toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    onclick="manualStopPropagation();"
                                >
                                    Select
                                    <svg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M1 1L5 5L9 1' stroke='#C33B32' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                    </svg> 
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#" onclick="manualStopPropagation();">
                                            Buy
                                            <svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M1 9L5 5L1 1' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/buy?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Buy Transaction</a>
                                            <a class="dropdown-item"  
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/buy_prs?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Buy PRS Transaction</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/buy_epf?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Buy EPF Transaction</a>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#" onclick="manualStopPropagation();">
                                            Sell
                                            <svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M1 9L5 5L1 1' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/sell?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Sell Transaction</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/sell_prs?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Sell PRS Transaction</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/sell_epf?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Sell EPF Transaction</a>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#" onclick="manualStopPropagation();">
                                            Switch
                                            <svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M1 9L5 5L1 1' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/inter_switch?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Inter Switch Transaction</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/intra_switch?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Intra Switch Transaction</a>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#" onclick="manualStopPropagation();">
                                            Cash
                                            <svg width='6' height='10' viewBox='0 0 6 10' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path d='M1 9L5 5L1 1' stroke-width='1.2' stroke-linecap='round' stroke-linejoin='round' />
                                            </svg>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>cash_deposit?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Cash Deposit</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>cash_withdrawal?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Cash Withdrawal</a>
                                            <a class="dropdown-item" 
                                                target="_blank"
                                                onclick="manualStopPropagation();"
                                                href="<?= base_url() ?>transaction/supporting_document/bfe?clientcode=${clientcode}&iswrap=${iswrap}&si=${si}&clientname=${clientname}&clienttype=${clienttype}">Upload Documents</a>
                                        </ul>
                                    </li>
                                </ul>
                            </div>`


                            client_holding_tbl.row.add([
                                client_elements['client_code_label'], // account no
                                client_name, // client name
                                get_account_label(client_elements['clnt_type_description'], client_elements['is_wrap']), // account type
                                ut_tab, // investment amount
                                payment_type, // cash account
                                holding_wrapper, // holding
                                transaction_wrapper, // transaction
                                '', // p&l
                                '<a target="_blank" data-client_statement href="<?= base_url() ?>client/monthly_client_statement?client_code=' + client_elements['client_code'] + '">View</a>', // statement
                                total_account, // info
                                (client_elements['avisor_code'] || "-") // advisor code
                            ]);
                        }
                        client_holding_tbl.draw();
                        break;
                }
                $("#div-client-list").collapse('show');
            }
        });
    }

    // cannot use stopPropagation because
    // it'll also prevent modal from popping
    // need hacks to reenable after false
    let canRowClick = true
    let rowClickTimeout

    function manualStopPropagation() {
        canRowClick = false
        clearTimeout(rowClickTimeout)
        rowClickTimeout = setTimeout(() => {
            canRowClick = true
        }, 300)
    }

    function initClientRow(row, data) {

        $('[data-link_client_name]', row).click(function() {
            displayClientInfo($(this).data("client-no"))
            manualStopPropagation()
        });

        $('[data-link_cash_acc_summary]', row).click(function() {
            displayCashAccount($(this).data("client-no"), $(this).data("iswrap") == 1);
            displaySelectedClient(row, data);
            manualStopPropagation()
        });


        $('[data-client_statement]', row).click(function() {
            manualStopPropagation()
        });

        // change to on row click
        // $('[data-ut_tab]', row).click(function() {
        //     displayUniTrust($(this).data("client-no"), $(this).data("iswrap") == 1);
        //     displaySelectedClient(row, data);
        // });

        // only applicable to client body, 
        // but not selected client
        try {
            row.addEventListener('click', function() {
                if (canRowClick) {
                    const clientNo = $('[data-ut_tab]', row).data("client-no")
                    const isWrap = $('[data-ut_tab]', row).data("iswrap") == 1

                    displayUniTrust(clientNo, isWrap);
                    displaySelectedClient(row, data);
                }
            })
        } catch (error) {
            console.log(error)
        }

        $('[data-view_saf]', row).click(function() {
            displaySaf($(this).data("client-no"))
            displaySelectedClient(row, data);
            manualStopPropagation()
        });

        $('[data-holding_summary_view]', row).click(function() {
            displaySummary($(this).data("client-no"), $(this).data("iswrap") == 1);
            displaySelectedClient(row, data);
            manualStopPropagation()
        });

        $('[data-summary_acc]', row).click(function() {
            displayAccounts($(this).data("client-no"))
            manualStopPropagation()
        });

    }

    function displaySelectedClient(row, data) {
        var clone = $(row).clone();

        // set selected client code in selected client table
        $('[data-selected-client-no]').text(data[0])

        var newRow = $('<tr></tr>')
        newRow.append('<td>' + data[1] + '</td>') // client name
        newRow.append('<td>' + data[2] + '</td>') // account type
        newRow.append('<td>' + data[3] + '</td>') // unit trust
        newRow.append('<td>' + data[4] + '</td>') // cash account
        newRow.append('<td>' + data[5] + '</td>') // holdings
        newRow.append('<td>' + data[6] + '</td>') // transations
        newRow.append('<td>' + data[7] + '</td>') // p&l
        newRow.append('<td>' + data[8] + '</td>') // statement
        newRow.append('<td>' + data[9] + '</td>') // info
        newRow.append('<td>' + data[10] + '</td>') // advisor code

        var tbody = $('tbody', selected_client_tbl);
        tbody.html('');
        tbody.append(newRow)
        $('#div-selected-client').collapse('show');

        initClientRow(newRow, data);

        // hide client list after select client
        $("#div-client-list").collapse("hide");
    }
</script>
<?= $details['footer'] ?>
<?php $template["footer"] = ob_get_clean(); ?>

<?= json_encode($template) ?>