<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Holding By Fund',
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Search Fund</b></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"><label for="slt-fund-house" class="col-form-label"><b>Fund House</b></label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select class="form-control" id="slt-fund-house">
                                    <option value="">Select Fund House</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><label for="slt-fund" class="col-form-label"><b>Fund Name</b></label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="slt-fund" class="form-control">
                                    <option value="">Select Fund Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="div-holdings" class="mt-2 collapse">
                        <div class="table-responsive">
                            <table class="table" id="tbl-holding" style="font-size:11px; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Client Code</th>
                                        <th>Client Name</th>
                                        <th>Payment Method</th>
                                        <th>Investment Date</th>
                                        <th>Available Units</th>
                                        <th>Weighted Average Cost (MYR)</th>
                                        <th>Investment Amount (MYR)</th>
                                        <th>NAV (MYR)</th>
                                        <th>NAV Date</th>
                                        <th>Current Value (MYR)</th>
                                        <th>Percentage of Portfolio (%)</th>
                                        <th>Profit (MYR)</th>
                                        <th>Profit&nbsp; (%)</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>

                        <div class="alert alert-warning" style="margin-top: 20px;">
                            * The indicative price for foreign currency fund auto convert in MYR.
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
 *  FOOTER
 * ---------
 */
ob_start();
?>
<script>
    autoHideLoadingOnInit = false;

    var tbl_holding
    window.addEventListener("DOMContentLoaded", function() {
        tbl_holding = $("#tbl-holding").DataTable({
            "bPaginate": true, // Show paging
            "searching": true, // Show Search
            "info": true, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"fi>rt<"bottom"lp><"clear">',
            "columns": [{
                data: (data, type, row, meta) => {
                    return data['client_code_label'] || "-";
                }
            }, {
                data: (data, type, row, meta) => {
                    return data['client_name'] || "-";
                }
            }, {
                data: (data, type, row, meta) => {
                    return data['payment_method'];
                }
            }, {
                data: (data, type, row, meta) => {
                    return data['inception_date'] ? data['inception_date'].substring(0, 10) : "-";
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber(parseFloat(data['unit']) || 0) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber((parseFloat(data['average_nav']) || 0), 4) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber(parseFloat(data['inv_amt']) || 0) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber((parseFloat(data['latest_nav']) || 0), 4) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return data['latest_nav_date'] ? data['latest_nav_date'].substring(0, 10) : "-";
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber(parseFloat(data['curr_value']) || 0) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + addCommaToNumber(parseFloat(data['portfolio_perc']) || 0) + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right"><span class="' + (data['profit'] < 0 ? 'text-danger' : 'text-success') + '">' +
                        addCommaToNumber(parseFloat(data['profit']) || 0) +
                        '</span>' + '</div>';
                }
            }, {
                data: (data, type, row, meta) => {
                    return '<div class="text-right">' + '<span class="' + (data['profit_perc'] < 0 ? 'text-danger' : 'text-success') + '">' +
                        addCommaToNumber(parseFloat(data['profit_perc']) || 0) +
                        '</span></div>';
                }
            }]
        });

        $('#slt-fund-house').change(function() {
            var $this = $(this);
            var value = $this.val();

            if (value != '')
                getFundList(value);
        });

        $('#slt-fund').change(function() {
            var $this = $(this);
            var value = $this.val();

            if (value != '')
                getHolding(value);
        });

        ajaxRequest({
            url: "<?= base_url() ?>fund_house/_list",
            data: {
                active_only: 'H'
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No fund house available at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var slt_fund_house = $('#slt-fund-house');
                        var arr_fund_house = json.data.fund_houses;
                        for (var i = 0; i < arr_fund_house.length; i++) {
                            var fundHouseElement = arr_fund_house[i];
                            slt_fund_house.append("<option value=\"" + fundHouseElement['fund_house_id'] + "\" data-description=\"" + fundHouseElement['fund_house_description'] + "\">" + fundHouseElement['fund_house_name'] + "</option>");
                        }
                        break;
                }

                <?php if (!empty($fund_house) && !empty($fund)) { ?>
                    var fund_house = "<?= $fund_house ?>";
                    var slt_fund_house = $('#slt-fund-house');
                    slt_fund_house.val(fund_house);

                    if (slt_fund_house.val() != null) {
                        getFundList(fund_house, function() {
                            var fund = "<?= $fund ?>";
                            var slt_fund = $('#slt-fund');
                            slt_fund.val(fund);

                            if (slt_fund.val() != null)
                                getFundDetail(fund);
                            else {
                                slt_fund.val('');
                                hideLoading();
                            }
                        });
                    } else {
                        slt_fund_house.val('');
                        hideLoading();
                    }
                <?php } else { ?>
                    hideLoading();
                <?php } ?>
            }
        });
    });

    function getFundList(fund_house) {
        showLoading();
        var slt_fund = $('#slt-fund');
        $('#div-factsheet').collapse('hide');
        $('option', slt_fund).not(':first').remove();

        var option = $('#slt-fund-house option:selected');
        var a_fund_house = $('#a-fund-house');
        a_fund_house.html(option.html());
        a_fund_house.attr('href', '<?= base_url() ?>fund_house/detail?code=' + option.val());

        ajaxRequest({
            url: "<?= base_url() ?>fund_house/_fund_list",
            data: {
                fund_house: fund_house,
                active_only: 'H'
            },
            method: "get",
            success: function(json) {
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var data = json['data'];
                        var funds = data['funds'];

                        var tbd_funds = $('#tbd-funds');
                        $.each(funds, function(index, value) {
                            let fund_name = value.fund_name;

                            if (value.active_status == "0") {
                                fund_name += " *"
                            }

                            slt_fund.append("<option value=\"" + value.fund_id + "\">" + fund_name + "</option>");
                        });

                        break;
                }

                hideLoading();
            }
        });
    }

    function getHolding(fund) {
        showLoading();

        tbl_holding.clear().draw()
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/value_of_portfolio/fund/_list",
            method: "get",
            data: {
                fund: fund,
                // ifa_code: "<?= $ifa_code ?? "" ?>",
            },
            success: function(json) {
                if (json.status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    json.data.funds.forEach((i, index) => {
                        var payment_method = "Cash Account";
                        var key = "cash_account";
                        if (i['payment_mode_code'] == "<?= PAYMENT_MODE_CASH_ACCOUNT ?>") {
                            payment_method = "Cash Account"
                            key = "cash_account";
                        } else if (i['payment_mode_code'] == "<?= PAYMENT_MODE_FPX ?>") {
                            payment_method = "FPX"
                            key = "fpx";
                        } else if (i['payment_mode_code'] == "<?= PAYMENT_MODE_CHEQUE ?>") {
                            payment_method = "Cheque"
                            key = 'cheque';
                        } else if (i['payment_mode_code'] == "<?= PAYMENT_MODE_INTERSWITCH ?>") {
                            payment_method = "Interswitch"
                            key = 'interswitch';
                        } else if (i['payment_mode_code'] == "<?= PAYMENT_MODE_ONLINE_BANKING ?>") {
                            payment_method = "Online Banking"
                            key = 'online_banking';
                        } else if (i['payment_mode_code'] == "<?= PAYMENT_MODE_EPF ?>") {
                            payment_method = "EPF"
                            key = 'epf';
                        }

                        if (i['prs_indicator'] == 1) {
                            key = "prs" + i['fund_sub_acc'];
                        }

                        i['portfolio_perc'] = Math.round((parseFloat(i['portfolio_perc']) || 0) * 100) / 100;
                        i['m_portfolio_perc'] = Math.round((parseFloat(i['m_portfolio_perc']) || 0) * 100) / 100;
                        i['group'] = payment_method;
                        i['payment_method'] = payment_method;
                        tbl_holding.row.add({
                            client_code_label: i['client_code_label'],
                            client_name: i['client_name'],
                            fund_name: i['fund_name'],
                            payment_method: i['payment_method'],
                            inception_date: i['inception_date'],
                            unit: (parseFloat(i['unit']) || 0),
                            average_nav: (parseFloat(i[ /*currency_myr ? 'm_average_nav' : */ 'average_nav']) || 0),
                            inv_amt: (parseFloat(i[ /*currency_myr ? 'm_inv_amt' : */ 'inv_amt']) || 0),
                            latest_nav: (parseFloat(i[ /*currency_myr ? 'm_latest_nav' : */ 'latest_nav']) || 0),
                            latest_nav_date: i['latest_nav_date'],
                            curr_value: (parseFloat(i[ /*currency_myr ? 'm_curr_value' : */ 'curr_value']) || 0),
                            portfolio_perc: (parseFloat(i[ /*currency_myr ? 'm_portfolio_perc' : */ 'portfolio_perc']) || 0),
                            profit: (parseFloat(i[ /*currency_myr ? 'm_profit' : */ 'profit']) || 0),
                            profit_perc: (parseFloat(i[ /*currency_myr ? 'm_profit_perc' : */ 'profit_perc']) || 0)
                        });
                    });
                }
                tbl_holding.draw();
                $('#div-holdings').collapse('show');

                hideLoading();
            }
        })
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>