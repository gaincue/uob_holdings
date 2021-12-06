<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Realised Gains',
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
        <div class="container-fluid holding holding-container">
            <?php $this->load->view("_vw_client_info", ['client_code' => $client_code, 'ifa_code' => $ifa_code]) ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Realised Gains</div>
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
                                                    <th>Account Type</th>
                                                    <th>Transaction Date</th>
                                                    <th>Unit Sold</th>
                                                    <th>Amount Invested</th>
                                                    <th>Net Average **<br />Purchased Price</th>
                                                    <th>Net Selling Price</th>
                                                    <th>Net Redemption Proceeds</th>
                                                    <th>Realised Gains / (Losses)</th>
                                                    <th>Realised Gains / (Losses) (%)</th>
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

    var orders, interest,
        loadingOrder = false,
        loadingInterest = false;
    window.addEventListener("DOMContentLoaded", function() {
        $('#btn-search').click(function() {
            var from = $("#ipt-from").val();
            var to = $("#ipt-to").val();
            if (from && to) {
                showLoading()
                loadingOrder = true;
                loadingInterest = true;

                getOrders(from, to);
                getInterest(from, to);

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

    function getOrders(from, to) {
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/realised_gains/_orders",
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
                    orders = [];
                    $.each(json.data.orders, function(index, order) {
                        if (order.order_type == '<?= ORDER_TYPE_SWITCH ?>') {
                            $.each(order.funds.out, function(index, fund) {
                                var currency = fund.fund_curr_code;
                                if (orders[currency] == undefined) orders[currency] = [];
                                orders[currency].push({
                                    order_type: order['order_type'],
                                    fund_name: fund['fund_name'],
                                    payment_method: order['payment_mode_name'],
                                    submission_date: fund['submission_date'] || order['order_date'],
                                    unit: fund['unit'],
                                    investment_amount: fund['unit'] * fund['average_nav'],
                                    average_nav: fund['average_nav'],
                                    amount: fund['unit'] * fund['nav'],
                                    nav: fund['nav'],
                                    profit: fund['profit'],
                                    profit_perc: fund['profit_perc']
                                });
                            })
                        } else {
                            var currency = order.fund_curr_code;
                            if (orders[currency] == undefined) orders[currency] = [];
                            orders[currency].push({
                                order_type: order['order_type'],
                                fund_name: order['fund_name'],
                                payment_method: order['payment_mode_name'],
                                submission_date: order['submission_date'] || order['order_date'],
                                unit: order['unit'],
                                investment_amount: order['unit'] * order['average_nav'],
                                average_nav: order['average_nav'],
                                amount: order['unit'] * order['nav'],
                                nav: order['nav'],
                                profit: order['profit'],
                                profit_perc: order['profit_perc']
                            });
                        }
                    })
                }
                loadingOrder = false;
                drawTable();
            }
        });
    }

    function getInterest(from, to) {
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/realised_gains/_interest",
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
                    interest = json.data.interest;
                }
                loadingInterest = false;
                drawTable();
            }
        })
    }

    function drawTable() {
        if (!loadingOrder && !loadingInterest) {
            $("#btn-print").show();

            var divTable = $("#div-table");
            var tbody = divTable.find('tbody');
            tbody.html('');

            var total = {};
            var orderCurrencies = Object.keys(orders);
            if (orderCurrencies.length > 0) {
                orderCurrencies = orderCurrencies.sort();
                for (var currency of orderCurrencies) {
                    tbody.append('<tr class="tr-sub-group-header"><td class="text-left" colspan="10">' + currency + '</td></tr>')

                    total[currency] = 0;
                    var list = orders[currency].sort((a, b) => {
                        return a.submission_date > b.submission_date ? 1 : -1
                    })
                    for (var order of list) {
                        var isTranfer = order.order_type == '<?= ORDER_TYPE_TRANSFER_OUT ?>'
                        tbody.append(
                            '<tr>' +
                            '<td class="text-left">' + order.fund_name + '</td>' +
                            '<td class="text-left">' + order.payment_method + '</td>' +
                            '<td class="text-left">' + (order.submission_date.substring(0, 10)) + '</td>' +
                            '<td>' + addCommaToNumber(order.unit) + '</td>' +
                            '<td>' + (isTranfer ? "-" : addCommaToNumber(order.investment_amount)) + '</td>' +
                            '<td>' + (isTranfer ? "-" : addCommaToNumber(order.average_nav, 4)) + '</td>' +
                            '<td>' + addCommaToNumber(order.nav, 4) + '</td>' +
                            '<td>' + addCommaToNumber(order.amount) + '</td>' +
                            '<td>' + (isTranfer ? "-" : addCommaToNumber(order.profit)) + '</td>' +
                            '<td>' + (isTranfer ? "-" : addCommaToNumber(order.profit_perc)) + '</td>' +
                            '</tr>'
                        );

                        if (!isTranfer)
                            total[currency] += parseFloat(order.profit);
                    }
                }
            }

            tbody.append(
                '<tr>' +
                '<td class="text-left" colspan="8">Interest Earned</td>' +
                '<td>' + addCommaToNumber(interest) + '</td>' +
                '<td></td>' +
                '</tr>'
            );

            if (total["MYR"] == undefined) total["MYR"] = 0;
            total["MYR"] += parseFloat(interest);

            if (Object.keys(total).length > 0) {
                tbody.append('<tr class="tr-sub-group-footer top-border"><th class="text-left" colspan="10">Total Realised Gains / Losses</th></tr>')
                for (var currency in total) {
                    tbody.append(
                        '<tr class="tr-sub-group-footer">' +
                        '<th class="text-left" colspan="8">' + currency + '</th>' +
                        '<th>' + addCommaToNumber(total[currency]) + '</th>' +
                        '<th></th>' +
                        '</tr>'
                    );
                }
            }

            divTable.collapse('show');
            hideLoading();
        }
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>