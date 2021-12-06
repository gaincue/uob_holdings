<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Value of Portfolio',
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
                        <div class="card-header">Value of Portfolio</div>
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
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Fund Name</th>
                                                    <th>Account Tyoe</th>
                                                    <th>Transaction Date</th>
                                                    <th>Units Held</th>
                                                    <th>Amount Invested</th>
                                                    <th>Net Average ** <br />Purchased Price</th>
                                                    <th>Closing Price as at <br /><span class="s-date">11-Nav-2020</span></th>
                                                    <th>Value as at <br /><span class="s-date">11-Nav-2020</span></th>
                                                    <th>Unrealised Gains / <br />(Losses)</th>
                                                    <th>Unrealised Gains / <br />(Losses) (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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

    var holdings, cash_accounts,
        loadingHolding = false,
        loadingCashAccount = false;
    window.addEventListener("DOMContentLoaded", function() {
        $('#btn-search').click(function() {
            var from = $("#ipt-from").val();
            var to = $("#ipt-to").val();
            if (from && to) {
                showLoading()
                loadingHolding = true;
                loadingCashAccount = true;

                $('.s-date').text(
                    moment(to, "DD / MM / YYYY").format("D-MMM-YY"),
                );

                getHolding(from, to);
                getCashAccount(from, to);
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
                    holdings = json.data.funds;
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
                    cash_accounts = json.data.summaries;
                }
                loadingCashAccount = false;
                drawTable();
            }
        })
    }

    function drawTable() {
        if (!loadingHolding && !loadingCashAccount) {
            $("#btn-print").show();

            var divTable = $('#div-table');
            var tbody = divTable.find('table tbody');
            tbody.html('');

            var funds = holdings.reduce(function(list, cur) {
                var currency = cur['fund_currency']
                if (list[currency] === undefined) list[currency] = [cur];
                else list[currency].push(cur);
                return list;
            }, {});

            $.each(funds, function(currency, list) {
                tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="10">Investment - <strong>' + currency + '</strong></td></tr>')

                var total_inv = 0,
                    total_current = 0,
                    total_profit = 0;
                $.each(list, function(idx, item) {
                    var payment_method = "Cash Account",
                        inv_amt = parseFloat(item.inv_amt),
                        curr_value = parseFloat(item.curr_value),
                        profit = parseFloat(item.profit);

                    total_inv += inv_amt;
                    total_current += curr_value;
                    total_profit += profit;

                    switch (item.payment_mode_code) {
                        case "<?= PAYMENT_MODE_CASH_ACCOUNT ?>":
                            payment_mode_code = "Cash Account";
                            break;
                        case "<?= PAYMENT_MODE_FPX ?>":
                            payment_mode_code = "FPX";
                            break;
                        case "<?= PAYMENT_MODE_CHEQUE ?>":
                            payment_mode_code = "Cheque";
                            break;
                        case "<?= PAYMENT_MODE_INTERSWITCH ?>":
                            payment_mode_code = "Interswitch";
                            break;
                        case "<?= PAYMENT_MODE_ONLINE_BANKING ?>":
                            payment_mode_code = "Online Banking";
                            break;
                        case "<?= PAYMENT_MODE_EPF ?>":
                            payment_mode_code = "EPF";
                            break;
                    }

                    tbody.append(
                        '<tr>' +
                        '<td class="text-left">' + item.fund_name + '</td>' +
                        '<td class="text-center">' + payment_method + '</td>' +
                        '<td class="text-center">' + (item.inception_date ? item.inception_date.substring(0, 10) : "-") + '</td>' +
                        '<td>' + addCommaToNumber(parseFloat(item.unit)) + '</td>' +
                        '<td>' + addCommaToNumber(inv_amt) + '</td>' +
                        '<td>' + addCommaToNumber(parseFloat(item.average_nav), 4) + '</td>' +
                        '<td>' + addCommaToNumber(parseFloat(item.latest_nav), 4) + '</td>' +
                        '<td>' + addCommaToNumber(curr_value) + '</td>' +
                        '<td>' + addCommaToNumber(profit) + '</td>' +
                        '<td>' + addCommaToNumber(parseFloat(item.profit_perc)) + '</td>' +
                        '</tr>'
                    );
                })

                tbody.append(
                    '<tr class="tr-sub-group-footer top-border">' +
                    '<th class="text-left" colspan="4">Total (Investment) - ' + currency + '</th>' +
                    '<th>' + addCommaToNumber(total_inv) + '</th>' +
                    '<th></th>' +
                    '<th></th>' +
                    '<th>' + addCommaToNumber(total_current) + '</th>' +
                    '<th>' + addCommaToNumber(total_profit) + '</th>' +
                    '<th>' + addCommaToNumber(total_profit / total_inv * 100) + '</th>' +
                    '</tr>'
                )
            });

            if (cash_accounts.length > 0) {
                tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="10">Cash Account (Currency)</td></tr>')

                $.each(cash_accounts, function(index, ca) {
                    tbody.append(
                        '<tr>' +
                        '<td colspan="7" class="text-left">UOB Kay Hian Trust Account (' + ca.currency + ')</td>' +
                        '<td>' + addCommaToNumber(parseFloat(ca.nett_available_balance)) + '</td>' +
                        '<td></td>' +
                        '<td></td>' +
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