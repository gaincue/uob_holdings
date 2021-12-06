<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Overall Holding',
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<div class="dashboard">
    <div class="py-5">
        <div class="container-fluid">
            <?php $this->load->view("_vw_client_info", ['client_code' => $client_code, 'ifa_code' => $ifa_code]) ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Overall Holding</div>
                        <div class="card-body">
                            <div class="row" data-dp="row">
                                <div class="col-md-6">
                                    <div>From</div>
                                    <div class="form-group">
                                        <input class="form-control" data-dp="from" data-select="datepicker" id="ipt-from">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>To</div>
                                    <div class="form-group">
                                        <input class="form-control" data-dp="to" data-select="datepicker" id="ipt-to">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-md-12">
                                    <button class="btn btn-danger" id="btn-search">Search</button>
                                    <button class="btn btn-danger" id="btn-print" style="display: none;">Print</button>
                                </div>
                            </div>
                            <div class="row collapse pt-4" id="div-table">
                                <div class="col-md-12" style="text-align:center">
                                    <div class="table-responsive">
                                        <div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Amount Invested</th>
                                                        <th>Value as at <span class="s-date">11-Nov-2021</span></th>
                                                        <th>Unrealised Gains / (Losses)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-asset">
                                                </tbody>

                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Amount Deposited</th>
                                                        <th></th>
                                                        <th>Value as at <span class="s-date">11-Nov-2021</span></th>
                                                        <th>Gains / (Losses)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-order">
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
    </div>
</div>

<?php $this->load->view('template/_loading'); ?>
<?php
$template['content'] = ob_get_clean();

/*
 * ---------
 *  HEADER
 * ---------
 */
ob_start();
?>
<style>
    #div-table thead tr {
        background-color: #c33b32;
        color: #ffffff;
    }

    #div-table tbody * {
        text-align: right;
        font-size: 13px;
    }

    .tr-sub-group-header {
        font-weight: bold;
        font-style: italic;
    }

    .tr-sub-group-footer {
        background-color: #eee;
    }

    .tr-sub-group-footer.top-border {
        border-top: solid 3px #999;
    }
</style>
<?php
$template['header'] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<script>
    autoHideLoadingOnInit = false;

    var holdings, cash_accounts, orders,
        loadingHolding = false,
        loadingCashAccount = false,
        loadingOrders = false;
    window.addEventListener("DOMContentLoaded", function() {
        $('#btn-search').click(function() {
            var from = $("#ipt-from").val();
            var to = $("#ipt-to").val();
            if (from && to) {
                showLoading()
                loadingHolding = true;
                loadingCashAccount = true;
                loadingOrders = true;

                getHolding(from, to);
                getCashAccount(from, to);
                getOrders(from, to);

                $('.s-date').text(
                    moment(to, "DD / MM / YYYY").format("D-MMM-YY"),
                );
            } else {
                alert("Please select the date range");
            }
        })

        $("#btn-print").click(function() {
            printHtml($("#div-table").html());
        })
    });

    function initClient() {
        hideLoading();
    }

    function getHolding(from, to) {
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/value_of_portfolio/client/_list",
            data: {
                client_code: '<?= $client_code ?? "" ?>',
                ifa_code: "<?= $ifa_code ?? "" ?>",
                from_date: from,
                to_date: to
            },
            method: "get",
            success: function(json) {
                var status = json.status;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    var list = {};
                    $.each(json.data.funds, function(index, fund) {
                        var item = list[fund.fund_currency] || {
                            currency: fund.fund_currency,
                            inv_amt: 0,
                            curr_value: 0,
                            profit: 0
                        }
                        item.inv_amt += parseFloat(fund.inv_amt);
                        item.curr_value += parseFloat(fund.curr_value);
                        item.profit += parseFloat(fund.profit);
                        list[fund.fund_currency] = item;
                    })
                    holdings = Object.values(list);
                }
                loadingHolding = false;
                drawTable();
            }
        });
    }

    function getCashAccount(from, to) {
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_cash_account",
            data: {
                code: '<?= $client_code ?? "" ?>',
                ifa_code: "<?= $ifa_code ?? "" ?>",
                from_date: from,
                to_date: to
            },
            method: "get",
            success: function(json) {
                var status = json.status;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    var list = {};
                    $.each(json.data.summaries, function(index, summary) {
                        var item = list[summary.currency] || {
                            currency: summary.currency,
                            nett_available_balance: 0,
                        }
                        item.nett_available_balance += parseFloat(summary.nett_available_balance);
                        list[summary.currency] = item;
                    })
                    cash_accounts = Object.values(list);
                }
                loadingCashAccount = false;
                drawTable();
            }
        })
    }

    function getOrders(from, to) {
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/overall_holding/_orders",
            data: {
                client_code: '<?= $client_code ?? "" ?>',
                ifa_code: "<?= $ifa_code ?? "" ?>",
                from_date: from,
                to_date: to
            },
            method: "get",
            success: function(json) {
                var status = json.status;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    orders = json.data.orders;
                }
                loadingOrders = false;
                drawTable();
            }
        })
    }

    function drawTable() {
        if (!loadingHolding && !loadingCashAccount && !loadingOrders) {
            $("#btn-print").show();

            var total_assets = {};

            var divTable = $("#div-table");
            var tbody = divTable.find('#tbody-asset');
            tbody.html('');

            if (holdings.length > 0) {
                tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="6">Total (Investment)</td></tr>')

                holdings = holdings.sort((a, b) => {
                    return a.currency > b.currency ? 1 : -1
                })
                $.each(holdings, function(index, holding) {
                    tbody.append(
                        '<tr>' +
                        '<td class="text-left" colspan="3">' + holding.currency + '</td>' +
                        '<td>' + addCommaToNumber(holding.inv_amt) + '</td>' +
                        '<td>' + addCommaToNumber(holding.curr_value) + '</td>' +
                        '<td>' + addCommaToNumber(holding.profit) + '</td>' +
                        '</tr>'
                    );

                    var total = total_assets[holding.currency] || {
                        currency: holding.currency,
                        inv_amt: 0,
                        curr_value: 0,
                        profit: 0
                    };
                    total.curr_value += holding.curr_value;
                    total_assets[holding.currency] = total;
                })
            }

            if (cash_accounts.length > 0) {
                tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="6">Total (Cash)</td></tr>')

                cash_accounts = cash_accounts.sort((a, b) => {
                    return a.currency > b.currency ? 1 : -1
                })
                $.each(cash_accounts, function(index, ca) {
                    tbody.append(
                        '<tr>' +
                        '<td colspan="4" class="text-left">' + ca.currency + '</td>' +
                        '<td>' + addCommaToNumber(ca.nett_available_balance) + '</td>' +
                        '<td></td>' +
                        '</tr>'
                    );

                    var total = total_assets[ca.currency] || {
                        currency: ca.currency,
                        inv_amt: 0,
                        curr_value: 0,
                        profit: 0
                    };
                    total.curr_value += ca.nett_available_balance;
                    total.profit += ca.nett_available_balance;
                    total_assets[ca.currency] = total;
                });
            }

            if (Object.keys(total_assets).length > 0) {
                tbody.append('<tr class="tr-sub-group-footer top-border"><th class="text-left" colspan="6">Total Portfolio Value</th></tr>')

                var totals = Object.values(total_assets).sort((a, b) => {
                    return a.currency > b.currency ? 1 : -1
                })
                $.each(totals, function(index, total) {
                    tbody.append(
                        '<tr class="tr-sub-group-footer">' +
                        '<th class="text-left" colspan="3">' + total.currency + '</th>' +
                        '<th></th>' +
                        '<th>' + addCommaToNumber(total.curr_value) + '</th>' +
                        '<th></th>' +
                        '</tr>'
                    );
                });
            }


            var currencies = Object.keys(total_assets);
            $.each(Object.keys(orders), function(index, currency) {
                if (!currencies.includes(currency)) {
                    currencies.push(currency);
                }
            });
            currencies = currencies.sort();

            tbody = divTable.find('#tbody-order');
            tbody.html('');

            if (currencies.length > 0) {
                $.each(currencies, function(index, currency) {
                    tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="6">' + currency + '</td></tr>');
                    var total_order = 0,
                        total_asset = (total_assets[currency] || {
                            curr_value: 0
                        }).curr_value || 0;

                    $.each(orders[currency], function(oi, order) {
                        var renderDate = true;
                        if (order.inject != 0) {
                            tbody.append(
                                '<tr>' +
                                '<td class="text-left">' + (renderDate ? order.date : "") + '</td>' +
                                '<td class="text-left">Cash Injection</td>' +
                                '<td>' + addCommaToNumber(order.inject) + '</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>'
                            );

                            total_order += order.inject;
                            renderDate = false;
                        }
                        if (order.redeem != 0) {
                            tbody.append(
                                '<tr>' +
                                '<td class="text-left">' + (renderDate ? order.date : "") + '</td>' +
                                '<td class="text-left">Redemption</td>' +
                                '<td>' + addCommaToNumber(order.redeem) + '</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>'
                            );

                            total_order -= order.redeem;
                            renderDate = false;
                        }
                        if (order.fee != 0) {
                            tbody.append(
                                '<tr>' +
                                '<td class="text-left">' + (renderDate ? order.date : "") + '</td>' +
                                '<td class="text-left">Fee</td>' +
                                '<td>' + addCommaToNumber(order.fee) + '</td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>'
                            );

                            total_order -= order.fee;
                            renderDate = false;
                        }
                    })

                    tbody.append(
                        '<tr class="tr-sub-group-footer top-border">' +
                        '<th class="text-left">Total</th>' +
                        '<th></th>' +
                        '<th>' + addCommaToNumber(total_order) + '</th>' +
                        '<th></th>' +
                        '<th>' + addCommaToNumber(total_asset) + '</th>' +
                        '<th>' + addCommaToNumber((total_asset - total_order) / total_order * 100) + '%</th>' +
                        '</tr>'
                    );
                });
            }

            divTable.collapse('show');
            hideLoading();
        }
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>