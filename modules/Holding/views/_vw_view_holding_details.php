<?php
defined("BASEPATH") or exit("No direct script access allowed");
$template = [];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<div class="py-2 collapse" id="portfolio_ut_prs">
    <ul class="nav nav-pills">
        <li class="nav-item"><a href="#" class="active nav-link" data-toggle="pill" data-target="#tabone">Holdings By Payment Method</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabtwo">Holdings By Allocation</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabthree">Holdings By Fund Currency</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabfour">Pending Transactions</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabfive">Historical Transactions</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabsix">Fund Performance (Absolute Returns)</a></li>
        <li class="nav-item"><a href="#" class="nav-link" data-toggle="pill" data-target="#tabseven">Fund Performance (Annualized Returns)</a></li>
    </ul>
    <div class="tab-content mt-2">
        <div class="tab-pane fade show active" id="tabone" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Current holdings in this investment account</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="holding_payment_tbl" style="font-size:11px; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Fund Name</th>
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
            <div class="card">
                <div class="card-header"> View Holdings by Payment Method</div>
                <div class="card-body">
                    <p>Profit &amp; Loss (MYR) Since Inception : </p>
                    <div id="loss_since_inspection_date"></div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cash</th>
                                    <th>EPF Account 1</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-success">
                                    <td>Cash Account (MYR)</td>
                                    <td id="cur_valuation_cash"></td>
                                    <td id="cur_valuation_epf"></td>
                                    <td id="cur_valuation_total"></td>
                                </tr>
                                <tr class="text-danger">
                                    <td>Deposit (MYR)</td>
                                    <td>
                                        <a href="#" style="color:#dc3545" data-toggle="modal" data-target="#modal_deposit" id="deposit_cash"></a>
                                    </td>
                                    <td id="deposit_epf"></td>
                                    <td id="deposit_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td>Fund Valuation (MYR)</td>
                                    <td id="fund_valuation_cash"></td>
                                    <td id="fund_valuation_epf"></td>
                                    <td id="fund_valuation_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td class="text-success">Capital Outflow</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modal_capital_outflow" id="outflow_cash"></a>
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modal_epf_outflow" id="outflow_epf"></a>
                                    </td>
                                    <td id="outflow_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td class="text-success">Pending (Withdrawal)</td>
                                    <td id="pending_withdraw_cash"></td>
                                    <td id="pending_withdraw_epf"></td>
                                    <td id="pending_withdraw_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td class="text-success">Pending (Sell)</td>
                                    <td id="pending_sell_cash"></td>
                                    <td id="pending_sell_epf"></td>
                                    <td id="pending_sell_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td class="text-success">Pending (Buy)</td>
                                    <td id="pending_buy_cash"></td>
                                    <td id="pending_buy_epf"></td>
                                    <td id="pending_buy_total"></td>
                                </tr>
                                <tr class="text-success">
                                    <td>Accrued Interest</td>
                                    <td id="interest_cash"></td>
                                    <td id="interest_epf"></td>
                                    <td id="interest_total"></td>
                                </tr>
                                <tr>
                                    <td>Profit &amp; Loss (MYR) Since Inception</td>
                                    <td id="pnl_cash"></td>
                                    <td id="pnl_epf"></td>
                                    <td id="pnl_total"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pt-2">
                <a class="btn btn-danger" href="#" data-toggle="modal" id="portfolio_tracking" data-target="#modal_portfolio" style="color:white">Portfolio Tracking</a>
            </div>
        </div>
        <div class="tab-pane fade" id="tabtwo" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Current holdings in this investment account</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="display: flex; width: 100%;">
                        <div>
                            <div id="div-chart-asset"></div>
                        </div>
                        <div>
                            <div id="div-chart-fund"></div>
                        </div>
                        <div>
                            <div id="div-chart-geographical"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabthree" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Current holdings in this investment account</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="div-holding-by-currency">
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabfour" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Transaction In Process</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="font-size:11px" id="payment_pending_tbl">
                            <thead>
                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Fund Name</th>
                                    <th>Transaction Date</th>
                                    <th>Investment Amount</th>
                                    <th>Sales/Tier Charge (%)</th>
                                    <th>Transaction Price</th>
                                    <th>Units</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Confirmation Date</th>
                                    <th>Remarks</th>
                                    <th>SAF documents</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabfive" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Transaction History</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="font-size:11px" id="ut_history_tbl">
                            <thead>
                                <tr>
                                    <th>Transaction Type</th>
                                    <th>Fund Name</th>
                                    <th>Transaction Date</th>
                                    <th>Investment Amount</th>
                                    <th>Sales/Tier Charge (%)</th>
                                    <th>Transaction Price</th>
                                    <th>Units</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Confirmation Date</th>
                                    <th>Remarks</th>
                                    <th>SAF documents</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabsix" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Absolute Fund Performance</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="absolute_fund_tbl" style="font-size:11px">
                            <thead>
                                <tr>
                                    <th>Fund Name</th>
                                    <th>Market Value (MYR)</th>
                                    <th>Weight</th>
                                    <th>1-mth</th>
                                    <th>3-mth</th>
                                    <th>6-mth</th>
                                    <th>1-yr</th>
                                    <th>2-yr</th>
                                    <th>3-yr</th>
                                    <th>5-yr</th>
                                    <th>10-yr</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabseven" role="tabpanel">
            <div class="card">
                <div class="card-header">
                    <h6>Annualized Funds Performance</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="annual_fund_tbl" style="font-size:11px">
                            <thead>
                                <tr>
                                    <th>Fund Name</th>
                                    <th>Market Value (MYR)</th>
                                    <th>Weight</th>
                                    <?php for ($i = 1, $year = intval(date("Y")) - 1; $i <= 5; $i++, $year--) { ?>
                                        <th><?= $year ?> (%)</th>
                                    <?php } ?>
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
<div class="py-2 collapse" id="cash_account">
    <div class="card">
        <div class="card-header"> Cash Account Summary</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="cash_account_table">
                    <thead>
                        <tr>
                            <th>Cash Account Number(Currency)</th>
                            <th>Available Balance</th>
                            <th>Ledger Balance</th>
                            <th>Available Balance (MYR)</th>
                            <th>Overdue Amount</th>
                            <th>View Transaction History</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="py-2 collapse" id="SAF">
    <div class="card">
        <div class="card-header"> Suitability Assessment Form (SAF)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="saf_tbl">
                    <thead>
                        <tr>
                            <th>Account No</th>
                            <th>Form Type</th>
                            <th>Create Date</th>
                            <th>Approve Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="py-2 collapse" id="summary_tab">
    <div class="card">
        <div class="card-header">Holdings Summary</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="summary_tab_tbl">
                    <thead>
                        <tr>
                            <th>Fund Name</th>
                            <th>Investment Amount (MYR)</th>
                            <th>P/L (MYR)</th>
                            <th>P/L (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Cash Account Holdings</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="cash_acc_btm_tbl">
                    <thead>
                        <tr>
                            <th>Cash Account Number (Currency)</th>
                            <th>Available Balance</th>
                            <th>Ledger Balance</th>
                            <th>Available Balance (MYR)</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$template['content'] = [];
$template['content']["table"] = ob_get_clean();

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<div class="modal" id="modal_info">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consolidated Account View</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="consolidated_tbl">
                        <thead>
                            <tr>
                                <th>Account No</th>
                                <th>Client Name</th>
                                <th>Account Type</th>
                                <th>Unit Trust (MYR)</th>
                                <th>Cash Account</th>
                                <th>EPF (MYR)</th>
                                <th>PRS (MYR)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="transaction_history">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction History</h5>
                <div id="trans_history_trust_id"></div>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="trans_history_tbl">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Transaction Date</th>
                                <th>Status</th>
                                <th>Transaction Number</th>
                                <th>Transaction Type</th>
                                <th>Remarks</th>
                                <th>Transaction Currency</th>
                                <th>Sales Charge</th>
                                <th>Inflow</th>
                                <th>Outflow</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_deposit">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deposit</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="deposit_tbl">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Transaction Date</th>
                                <th>Amount (MYR)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_capital_outflow">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capital Outflow (Funds Withdrawal)</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="capital_outflow_tbl">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Fund Name</th>
                                <th>Transaction Date</th>
                                <th>Redemption Method</th>
                                <th>Redemption Amount (MYR)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_epf_outflow">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EPF Outflow (Funds Withdrawal)</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="epf_outflow_tbl">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Fund Name</th>
                                <th>Transaction Date</th>
                                <th>Redemption Method</th>
                                <th>Redemption Amount (MYR)</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_portfolio">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Portfolio Tracking </h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="portfolio_tracking_tbl">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Branch</th>
                                <th>Fund</th>
                                <th>Porfolio id</th>
                                <th>Percentage</th>
                                <th>Amount</th>
                                <th>Tracking Type</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a id="btn_new_tracking" class="btn btn-danger" href="#" data-toggle="modal" data-target="#modal_portfolio_tracking_form" data-dismiss="modal" style="color:white">New Tracking</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_portfolio_tracking_form">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Portfolio Tracking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ipt-tracking-action">
                <div class="row form-group">
                    <div class="col-md-4 text-right">
                        <h6>Client</h6>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" id="tracking_client" class="form-control" placeholder="-" disabled="disabled">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4 text-right">
                        <h6>Percentage (%)</h6>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input id="ipt-tracking-percentage" type="number" min="0" class="form-control" placeholder="-">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-4 text-right">
                        <h6>Fund Holding</h6>
                    </div>
                    <div class="col-md-8 input-group">
                        <select id="slt-tracking-portfolio" class="form-control"></select>
                        <input type="text" id="ipt-tracking-portfolio" class="form-control" placeholder="-" disabled="disabled">
                        <input type="hidden" id="ipt-tracking-no">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_save_tracking" class="btn btn-danger">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_client_info">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Client Information</h5>
                <button type="button" class="close" id="btn_dismiss_client_summary" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header"> Account Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Account Type</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_type"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Account No</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_number"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Account Status</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_status"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>User Login</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_user_id"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Wrap Fee (%)</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_wrap_fee"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Risk Profile</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_risk_profile"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 div-client-summary-applicant">
                    <div class="card-header"> Personal Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Salutation</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_account_salutation"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Client Name</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_name"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>New IC Number/Passport</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_ic"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Gender</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_gender"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Date of Birth (D/M/Y)</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_dob"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Nationality</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_nationality"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Race</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_race"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>EPF Account No</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_epf_no"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>PPA Account No</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_ppa_no"></strong>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="col-md-4">
                                <h6>User Login</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_user_id"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 div-client-summary-applicant">
                    <div class="card-header">Contact Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Home Phone Number</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_home_phone"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Office Phone Number</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_office_phone"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Mobile Phone Number</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_mobile_phone"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Email</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_client_email"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header"> E-Statement</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>E-Statement Status</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_estatement_status"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 div-client-summary-applicant">
                    <div class="card-header">Permanent Address</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Address</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_add1"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>State</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_add2"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Postal Code</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_add3"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Country/Region</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_add4"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 div-client-summary-applicant">
                    <div class="card-header">Employment Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Occupation</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_employment_occupation"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Name of Employer</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_employment_employer"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Annual Salary</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_employment_annual_salary"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Local Bank Account</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Bank Name</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_local_bank_name"></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Bank Account</h6>
                            </div>
                            <div class="col-md-8">
                                <strong id="summary_local_bank_acc"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="div-client-summary-applicants"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_print" class="btn btn-danger">Print</button>
                <button type="button" class="btn btn-secondary" id="btn_close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
$template['content']["modal"] = ob_get_clean();

/*
 * ---------
 *  HEADER
 * ---------
 */
ob_start();
?>
<style>
    .dataTable ul {
        padding-left: 15px;
    }

    .text-success a {
        color: #28a745;
        text-decoration: underline;
    }

    .text-danger a {
        text-decoration: underline;
    }

    .tr-group {
        background-color: #c33b32;
        color: #fff;
    }

    tfoot {
        border-top: solid 3px #999;
        background-color: #eee;
    }

    .s-up {
        color: #06c506;
    }

    .s-down {
        color: #f00;
    }

    .s-none {
        color: #999;
        font-size: 13px;
    }

    #portfolio_ut_prs .nav-link {
        border: 1px solid #000000;
    }
</style>
<?php
$template["header"] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<?php $this->load->view('template/_plugin_js_highchart'); ?>
<script>
    var currentClientId,
        currentClientIsWrap,
        client_holding_tbl,
        dataTableSetting,
        cash_account_table,
        cash_acc_btm_tbl,
        saf_tbl,
        portfolio_tracking_tbl,
        summary_tab_tbl,
        payment_pending_tbl,
        ut_history_tbl,
        trans_history_tbl,
        annual_fund_tbl,
        absolute_fund_tbl,
        holding_payment_tbl,
        consolidated_tbl,
        capital_outflow_tbl,
        epf_outflow_tbl,
        deposit_tbl,
        div_holding_by_currency,
        div_chart_asset,
        div_chart_fund,
        div_chart_geographical,
        pnl = {
            total_without_interest: undefined,
            interest: undefined
        };

    window.addEventListener("DOMContentLoaded", function() {
        $(document).ajaxStop(() => {
            if ($.active === 0) {
                hideLoading();
            }
        })

        jQuery.fn.dataTableExt.oSort['number-color-asc'] = function(a, b) {
            a = $(a).text();
            b = $(b).text();
            var x = (a == "Not Available") ? Number.NEGATIVE_INFINITY : a.replace(/,/, ".");
            var y = (b == "Not Available") ? Number.NEGATIVE_INFINITY : b.replace(/,/, ".");
            x = parseFloat(x);
            y = parseFloat(y);
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        };

        jQuery.fn.dataTableExt.oSort['number-color-desc'] = function(a, b) {
            a = $(a).text();
            b = $(b).text();
            var x = (a == "Not Available") ? Number.NEGATIVE_INFINITY : a.replace(/,/, ".");
            var y = (b == "Not Available") ? Number.NEGATIVE_INFINITY : b.replace(/,/, ".");
            x = parseFloat(x);
            y = parseFloat(y);
            return ((x < y) ? 1 : ((x > y) ? -1 : 0));
        };

        div_holding_by_currency = $('#div-holding-by-currency');
        initTable();

        // account_summary_div
        $("#btn_print").click(function() {
            document.getElementById("btn_dismiss_client_summary").style.display = "none";
            document.getElementById("btn_print").style.display = "none";
            document.getElementById("btn_close").style.display = "none";
            var divToPrint = $("#modal_client_info .modal-body");
            printHtml(divToPrint.html());
            document.getElementById("btn_dismiss_client_summary").style.display = "block";
            document.getElementById("btn_print").style.display = "block";
            document.getElementById("btn_close").style.display = "block";
        });

        $("#btn_new_tracking").on("click", function() {
            $("#slt-tracking-portfolio").show();
            $("#ipt-tracking-portfolio").hide();

            $("#ipt-tracking-portfolio").val('');
            $("#ipt-tracking-no").val('');
            $("#ipt-tracking-percentage").val('');
            $("#ipt-tracking-action").val("create");
        });

        $(document).on("click", ".btn_update_tracking", function() {
            var portfolio_code = $(this).data('portfolio_code');
            var fund_name = $(this).data('fund_name');
            var percentage = $(this).data('percentage');
            var tracking_type = $(this).data('tracking_type');
            var tracking_no = $(this).data('tracking_no');

            $("#slt-tracking-portfolio").hide();
            $("#ipt-tracking-portfolio").show();

            $("#ipt-tracking-portfolio").val((tracking_type == "F") ? fund_name : portfolio_code);
            $("#ipt-tracking-no").val(tracking_no);
            $("#ipt-tracking-percentage").val(percentage);
            $("#ipt-tracking-action").val("update");
        });

        $(document).on("click", ".btn_delete_tracking", function() {
            showLoading();
            var tracking_no = $(this).data('tracking_no');
            ajaxRequest({
                url: "<?= base_url() ?>tracking/_delete",
                data: {
                    tracking_no: tracking_no
                },
                method: "post",
                success: function(json) {
                    var status = json.status;

                    if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                        getPortfolioTracking();
                        getInactiveTracking();
                    } else {
                        alert(JSON.stringify(json.data))
                        hideLoading();
                    }
                }
            });
        });

        $('#modal_portfolio').on('show.bs.modal', function() {
            showLoading();

            getPortfolioTracking();
            getInactiveTracking();
        })

        $("#btn_save_tracking").click(function(e) {
            e.preventDefault();
            showLoading();

            var percentage = $('#ipt-tracking-percentage').val();

            if (!percentage) {
                alert("Percentage cannot be empty")
            } else {
                var data = {
                    client_code: currentClientId,
                    percentage: percentage
                }
                var action = $("#ipt-tracking-action").val();
                if (action == "create") {
                    var portfolio = JSON.parse($('#slt-tracking-portfolio').val());
                    data['id'] = portfolio.code;
                    data['tracking_type'] = portfolio.tracking_type;
                    data['status'] = 'A';
                } else {
                    data['tracking_no'] = $("#ipt-tracking-no").val();
                }

                ajaxRequest({
                    url: "<?= base_url() ?>tracking/_" + action,
                    data: data,
                    method: "post",
                    success: function(json) {
                        var status = json.status;

                        switch (status) {
                            case <?= RESPONSE_STATUS_SUCCESS ?>:
                                getPortfolioTracking();
                                getInactiveTracking();
                                $('.close:visible').click();
                                alert("Update successfully");
                                break;
                            case 3:
                                alert(JSON.stringify(json.data))
                                break;
                        }
                    }
                });
            }
        });

        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            var previos_tab = $(e.relatedTarget).data('target');
            var current_tab = $(e.target).data('target');

            if (current_tab == '#tabfour') {
                getClientUTByPaymentPending();
            } else if (current_tab == '#tabfive') {
                getClientUTByPaymentHistory();
            } else {
                if (previos_tab == "#tabfour" || previos_tab == "#tabfive") {
                    getClientAccruedInterest()
                    getClientHoldingPaymentTable();
                    getClientUTByPayment();
                }
            }
        })

        $('#deposit_cash').on('click', function() {
            showLoading();

            //Deposit
            ajaxRequest({
                url: "<?= base_url() ?>view_holdings/bfe/_client_pnl_transaction",
                data: {
                    client_code: currentClientId,
                    ifa_code: ifa_code || "",
                    payment_type: "CA",
                    type: "deposit"
                },

                method: "get",
                success: function(json) {
                    var errorMessage = "No client found at the moment.";
                    var status = json.status;
                    switch (status) {
                        case <?= RESPONSE_STATUS_SUCCESS ?>:
                            deposit_tbl.clear().draw();

                            var arr_data = json.data.transactions;
                            for (var i = 0; i < arr_data.length; i++) {
                                deposit_tbl.row.add([
                                    (arr_data[i]['type_name']),
                                    (arr_data[i]['order_date'] || "-"),
                                    addCommaToNumber(
                                        (
                                            arr_data[i]["amount"] || (0)
                                        )
                                    )
                                ]);
                            }
                            deposit_tbl.draw();
                            break;
                    }
                }
            });
        })

        $('#outflow_cash').on('click', function() {
            showLoading();

            //Cash outflow
            ajaxRequest({
                url: "<?= base_url() ?>view_holdings/bfe/_client_pnl_transaction",
                data: {
                    client_code: currentClientId,
                    ifa_code: ifa_code || "",
                    payment_type: "CA",
                    type: "capital_outflow"
                },

                method: "get",
                success: function(json) {
                    var errorMessage = "No client found at the moment.";
                    var status = json.status;
                    switch (status) {
                        case <?= RESPONSE_STATUS_SUCCESS ?>:
                            capital_outflow_tbl.clear().draw();
                            var arr_data = json.data.transactions;
                            for (var i = 0; i < arr_data.length; i++) {
                                capital_outflow_tbl.row.add([
                                    (arr_data[i]['type_name']),
                                    (arr_data[i]['fund_name'] || "-"),
                                    (arr_data[i]['order_date'] || "-"),
                                    ("Cash Account"),

                                    addCommaToNumber(
                                        (
                                            arr_data[i]["amount"] || (0)
                                        )
                                    )
                                ]);
                            }
                            capital_outflow_tbl.draw();
                            break;
                    }
                }
            });
        })

        $('#outflow_epf').on('click', function() {
            showLoading();

            //EPF Outflow
            ajaxRequest({
                url: "<?= base_url() ?>view_holdings/bfe/_client_pnl_transaction",
                data: {
                    client_code: currentClientId,
                    ifa_code: ifa_code || "",
                    payment_type: "E",
                    type: "capital_inflow"
                },

                method: "get",
                success: function(json) {
                    var errorMessage = "No client found at the moment.";
                    var status = json.status;
                    switch (status) {
                        case <?= RESPONSE_STATUS_SUCCESS ?>:
                            epf_outflow_tbl.clear().draw();

                            var arr_data = json.data.transactions;
                            for (var i = 0; i < arr_data.length; i++) {
                                epf_outflow_tbl.row.add([
                                    (arr_data[i]['type_name']),
                                    (arr_data[i]['fund_name'] || "-"),
                                    (arr_data[i]['order_date'] || "-"),
                                    ("EPF"),
                                    addCommaToNumber(
                                        (
                                            arr_data[i]["amount"] || (0)
                                        )
                                    )
                                ]);
                            }
                            epf_outflow_tbl.draw();
                            break;
                    }
                }
            });
        })
    });

    function initTable() {
        dataTableSetting = function(options = undefined) {
            var settings = {
                "bPaginate": true, // Show paging
                "searching": true, // Show Search
                "info": true, // Show Info
                "fixedHeader": false, // Fix header
                "dom": '<"top"i>rt<"bottom"flp><"clear">'
            }
            if (options) {
                $.each(options, function(k, v) {
                    settings[k] = v;
                })
            }
            return settings;
        }

        cash_account_table = $("#cash_account_table").DataTable(
            dataTableSetting({
                createdRow: function(row, data, dataIndex) {
                    $('#link_cash_acc_history', row).click(function() {
                        $("#trans_history_trust_id").text(" - " + $(this).data("trust-no") || "-");
                        getClientSummaryTransData($(this).data("trust-no"))
                    });
                }
            })
        );

        cash_acc_btm_tbl = $("#cash_acc_btm_tbl").DataTable(dataTableSetting());

        saf_tbl = $("#saf_tbl").DataTable(dataTableSetting());

        portfolio_tracking_tbl = $("#portfolio_tracking_tbl").DataTable(dataTableSetting());

        summary_tab_tbl = $("#summary_tab_tbl").DataTable(dataTableSetting());

        payment_pending_tbl = $("#payment_pending_tbl").DataTable(dataTableSetting());

        ut_history_tbl = $("#ut_history_tbl").DataTable(dataTableSetting());

        trans_history_tbl = $("#trans_history_tbl").DataTable(dataTableSetting());

        annual_fund_tbl = $("#annual_fund_tbl").DataTable(dataTableSetting({
            "columnDefs": [{
                targets: [3, 4, 5, 6, 7],
                type: "number-color"
            }]
        }));

        absolute_fund_tbl = $("#absolute_fund_tbl").DataTable(dataTableSetting({
            "columnDefs": [{
                targets: [3, 4, 5, 6, 7, 8, 9, 10],
                type: "number-color"
            }]
        }));

        holding_payment_tbl = $("#holding_payment_tbl").DataTable(dataTableSetting({
            "columnDefs": [{
                "visible": false,
                "targets": 0
            }],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(0, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="tr-group"><td colspan="12">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        }));


        consolidated_tbl = $("#consolidated_tbl").DataTable(dataTableSetting());

        capital_outflow_tbl = $("#capital_outflow_tbl").DataTable(dataTableSetting());

        epf_outflow_tbl = $("#epf_outflow_tbl").DataTable(dataTableSetting());

        deposit_tbl = $("#deposit_tbl").DataTable(dataTableSetting());

        // Order by the grouping
        $('#holding_payment_tbl tbody').on('click', 'tr.tr-group', function() {
            var currentOrder = holding_payment_tbl.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                holding_payment_tbl.order([0, 'desc']).draw();
            } else {
                holding_payment_tbl.order([0, 'asc']).draw();
            }
        });
    }

    function displayClientInfo(client_code) {
        currentClientId = client_code;

        getClientName();
    }

    function displayCashAccount(client_code, is_wrap) {
        toggleTable("cash_account");
        currentClientId = client_code;
        currentClientIsWrap = is_wrap;

        getClientSummary();
    }

    function displayUniTrust(client_code, is_wrap) {
        toggleTable("portfolio_ut_prs");

        currentClientId = client_code;
        currentClientIsWrap = is_wrap;
        pnl = {
            total_without_interest: undefined,
            interest: undefined
        };

        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('show');
        $('.tab-pane').removeClass('active');

        $('.nav-link[data-target="#tabone"]').addClass('active');
        $('.tab-pane#tabone').addClass('show');
        $('.tab-pane#tabone').addClass('active');

        getClientAccruedInterest()
        getClientHoldingPaymentTable();
        getClientUTByPayment();
    }

    function displaySaf(client_code) {
        toggleTable("SAF");
        currentClientId = client_code;

        getClientSAFList();
    }

    function displaySummary(client_code, is_wrap) {
        toggleTable("summary_tab");
        currentClientId = client_code;
        currentClientIsWrap = is_wrap;

        getClientSummaryTabUpperPart();
        getClientSummaryTabBottomPart();
    }

    function displayAccounts(client_code) {
        currentClientId = client_code;

        getConsolidatedTable();
    }

    function toggleTable(elementId) {
        if (elementId != 'portfolio_ut_prs') $("#portfolio_ut_prs").collapse("hide");
        if (elementId != 'SAF') $("#SAF").collapse("hide");
        if (elementId != 'summary_tab') $("#summary_tab").collapse("hide");
        if (elementId != 'cash_account') $("#cash_account").collapse("hide");

        var tab = $("#" + elementId);
        if (!tab.hasClass("show")) tab.collapse("show");
    }

    //Initialize List
    function getClientHoldingPaymentTable() {
        showLoading()

        // holding_payment_tbl
        holding_payment_tbl.clear().draw()
        absolute_fund_tbl.clear().draw()
        annual_fund_tbl.clear().draw()
        div_holding_by_currency.html("");

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/value_of_portfolio/client/_list",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.funds;
                        var chart_asset_data = {};
                        var chart_fund_data = {};
                        var chart_geographical_data = {};
                        var fund_by_currency = {};
                        var m_holding_total = {};
                        var m_grand_total = {
                            invest_amt: 0,
                            curr_amt: 0,
                            profit: 0,
                            portfolio_perc: 0
                        };
                        var holding_total = {};
                        var grand_total = {};

                        var group_funds = {};
                        arr_data.forEach((i, index) => {
                            // data init
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
                            // data init

                            // list data preparation
                            if (group_funds[i['fund_name']] == undefined) {
                                group_funds[i['fund_name']] = i;
                            } else {
                                group_funds[i['fund_name']]['m_portfolio_perc'] += i['m_portfolio_perc'];
                            }

                            var total_data = {
                                type: payment_method,
                                payment_method: payment_method,
                                invest_amt: Math.round((parseFloat(i['m_inv_amt']) || 0) * 100) / 100,
                                curr_amt: Math.round((parseFloat(i['m_curr_value']) || 0) * 100) / 100,
                                profit: Math.round((parseFloat(i['m_profit']) || 0) * 100) / 100,
                                portfolio_perc: i['m_portfolio_perc']
                            }
                            m_holding_total = generateTotalData(m_holding_total, total_data, key)
                            m_grand_total = generateTotalData(m_grand_total, total_data, null)

                            if (holding_total[i['fund_currency']] == undefined) {
                                holding_total[i['fund_currency']] = {}
                            }
                            if (grand_total[i['fund_currency']] == undefined) {
                                grand_total[i['fund_currency']] = {
                                    invest_amt: 0,
                                    curr_amt: 0,
                                    profit: 0,
                                    portfolio_perc: 0
                                }
                            }
                            total_data = {
                                type: payment_method,
                                payment_method: payment_method,
                                invest_amt: Math.round((parseFloat(i['inv_amt']) || 0) * 100) / 100,
                                curr_amt: Math.round((parseFloat(i['curr_value']) || 0) * 100) / 100,
                                profit: Math.round((parseFloat(i['profit']) || 0) * 100) / 100,
                                portfolio_perc: i['portfolio_perc']
                            }
                            holding_total[i['fund_currency']] = generateTotalData(holding_total[i['fund_currency']], total_data, key)
                            grand_total[i['fund_currency']] = generateTotalData(grand_total[i['fund_currency']], total_data, null)
                            // list data preparation

                            // holding table data
                            if (key.includes("prs")) {
                                i['account_type'] = 'Account ' + i['fund_sub_acc'];
                            } else {
                                i['account_type'] = 'UnitTrust';
                            }

                            i['group'] = payment_method;
                            i['payment_method'] = payment_method;
                            holding_payment_tbl.row.add(unitTrustTableAppendRow(i));

                            i['group'] = i['fund_currency'];
                            if (fund_by_currency[i['fund_currency']] == undefined) {
                                fund_by_currency[i['fund_currency']] = [];
                            }
                            fund_by_currency[i['fund_currency']].push(unitTrustTableAppendRow(i, false));
                            // holding table data
                        })

                        for (var key in group_funds) {
                            var i = group_funds[key];

                            // pie chart data
                            var unit = parseFloat(i['unit']);
                            chart_asset_data = generatePieChartData(chart_asset_data, i['asset_class'] || "Others", unit);
                            chart_fund_data = generatePieChartData(chart_fund_data, i['fund_name'], i['m_portfolio_perc']);
                            chart_geographical_data = generatePieChartData(chart_geographical_data, i['geographical_allocation'] || "Others", unit);
                            // pie chart data

                            // performance table data
                            // absolute fund tbl
                            absolute_fund_tbl.row.add([
                                (i['fund_name'] || "-"),
                                (parseFloat(i['latest_nav']).toFixed(4) || "-"),
                                i['m_portfolio_perc'],
                                displayAmount(i.performance_type_return, '1 Month'),
                                displayAmount(i.performance_type_return, '3 Month'),
                                displayAmount(i.performance_type_return, '6 Month'),
                                displayAmount(i.performance_type_return, '1 Year'),
                                displayAmount(i.performance_type_return, '2 Year'),
                                displayAmount(i.performance_type_cumulative_return, '3 Year'),
                                displayAmount(i.performance_type_cumulative_return, '5 Year'),
                                displayAmount(i.performance_type_cumulative_return, '10 Year'),
                            ]);

                            annual_fund_tbl.row.add([
                                (i['fund_name'] || "-"),
                                (parseFloat(i['latest_nav']).toFixed(4) || "-"),
                                i['m_portfolio_perc'],
                                displayAmount(i.performance_type_calendar_year_return, '1 Year'),
                                displayAmount(i.performance_type_calendar_year_return, '2 Year'),
                                displayAmount(i.performance_type_calendar_year_return, '3 Year'),
                                displayAmount(i.performance_type_calendar_year_return, '4 Year'),
                                displayAmount(i.performance_type_calendar_year_return, '5 Year'),
                            ]);
                            // performance table data
                        };

                        createPieChart("div-chart-asset", "Asset Allocation", 'Unit', chart_asset_data);
                        createPieChart("div-chart-fund", "Fund Allocation", 'Percentage of Portfolio (%)', chart_fund_data);
                        createPieChart("div-chart-geographical", "Geographical Allocation", 'Unit', chart_geographical_data);

                        if (Object.keys(fund_by_currency).length == 0) {
                            drawFundByCurrencyTable(div_holding_by_currency, [], {}, {
                                invest_amt: 0,
                                curr_amt: 0,
                                profit: 0,
                                portfolio_perc: 0
                            });
                        } else {
                            $.each(fund_by_currency, function(fsi, funds) {
                                drawFundByCurrencyTable(div_holding_by_currency, funds, holding_total[fsi], grand_total[fsi]);
                            });
                        }
                        break;
                }

                holding_payment_tbl.draw();
                absolute_fund_tbl.draw();
                annual_fund_tbl.draw();

                // footer
                var tfoot = $('#holding_payment_tbl tfoot');
                drawFooter(tfoot, m_holding_total, m_grand_total);
                // footer
            }
        });
    }

    function drawFundByCurrencyTable(elem_div, funds, holding_total, grand_total) {
        var elem_table = $('<table class="table" style="font-size:11px; width: 100%"><thead><tr><th></th><th>Fund Name</th><th>Payment Method</th><th>Investment Date</th><th>Available Units</th><th>Weighted Average Cost</th><th>Investment Amount</th><th>NAV</th><th>NAV Date</th><th>Current Value</th><th>Percentage of Portfolio (%)</th><th>Profit</th><th>Profit&nbsp; (%)</th></tr></thead><tbody></tbody><tfoot></tfoot></table>');
        elem_div.append(elem_table);
        var datatableTable = elem_table.DataTable(dataTableSetting({
            "columnDefs": [{
                "visible": false,
                "targets": 0
            }],
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;

                api.column(0, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="tr-group"><td colspan="12">' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            }
        }));
        $.each(funds, function(fi, fund) {
            datatableTable.row.add(fund)
        });

        datatableTable.draw();

        var tfoot = elem_table.find('tfoot');
        drawFooter(tfoot, holding_total, grand_total);
    }

    function generateTotalData(arr, value, type) {
        var data = arr;
        if (type) data = data[type];

        if (data == undefined) {
            data = {
                type: value.type,
                payment_method: value.payment_method,
                invest_amt: 0,
                curr_amt: 0,
                profit: 0,
                portfolio_perc: 0
            }
        }

        data.invest_amt += value.invest_amt;
        data.curr_amt += value.curr_amt;
        data.profit += value.profit;
        data.portfolio_perc += value.perc_portfolio;

        if (type) arr[type] = data;
        else arr = data;

        return arr;
    }

    function generatePieChartData(arr, key, value) {
        if (arr[key] === undefined) {
            arr[key] = 0;
        }
        arr[key] += value;
        return arr;
    }

    function displayAmount(data, key) {
        if (data != null && data[key] != null) {
            var className = '';
            if (data[key] > 0)
                className = ' class="s-up"';
            else if (data[key] < 0)
                className = ' class="s-down"';
            return '<span' + className + '>' + data[key] + '</span>';
        }
        return '<span class="s-none">Not Available</span>';
    }

    function unitTrustTableAppendRow(data, currency_myr = true) {
        return [
            data['group'],
            (data['fund_name'] || "-"),
            data['payment_method'],
            data['inception_date'] ? data['inception_date'].substring(0, 10) : "-",
            (addCommaToNumber(parseFloat(data['unit']) || 0)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_average_nav' : 'average_nav']) || 0, 4)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_inv_amt' : 'inv_amt']) || 0)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_latest_nav' : 'latest_nav']) || 0, 4)),
            data['latest_nav_date'] ? data['latest_nav_date'].substring(0, 10) : "-",
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_curr_value' : 'curr_value']) || 0)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_portfolio_perc' : 'portfolio_perc']) || 0)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_profit' : 'profit']) || 0)),
            (addCommaToNumber(parseFloat(data[currency_myr ? 'm_profit_perc' : 'profit_perc']) || 0))
        ];
    }

    function drawFooter(tfoot, holding_total, grand_total) {
        tfoot.html('');

        holding_total = Object.keys(holding_total).sort().reduce(
            (obj, key) => {
                obj[key] = holding_total[key];
                return obj;
            }, {}
        );

        for (var key in holding_total) {
            var t = holding_total[key];
            var profit_percent = t.profit / t.invest_amt * 100;
            if (key == "prsA") {
                tfoot.append(
                    unitTrustTableFooterRow({
                        name: 'PRS Account A Total',
                        payment_method: t.payment_method,
                        account_type: 'Account A',
                        invest_amt: t.invest_amt,
                        curr_amt: t.curr_amt,
                        profit: t.profit,
                        profit_perc: profit_percent
                    }, 0.7)
                );
            } else if (key == "prsB") {
                tfoot.append(
                    unitTrustTableFooterRow({
                        name: 'PRS Account B Total',
                        payment_method: t.payment_method,
                        account_type: 'Account B',
                        invest_amt: t.invest_amt,
                        curr_amt: t.curr_amt,
                        profit: t.profit,
                        profit_perc: profit_percent
                    }, 0.3)
                );
            } else {
                tfoot.append(
                    unitTrustTableFooterRow({
                        name: t['type'] + ' Total',
                        payment_method: t.payment_method,
                        account_type: 'UnitTrust',
                        invest_amt: t.invest_amt,
                        curr_amt: t.curr_amt,
                        portfolio_perc: t.portfolio_perc,
                        profit: t.profit,
                        profit_perc: profit_percent
                    })
                );
            }
        }

        var profit_percent = grand_total.profit / grand_total.invest_amt * 100;
        tfoot.append(
            unitTrustTableFooterRow({
                name: 'Grand Total',
                payment_method: '-',
                account_type: '-',
                invest_amt: grand_total.invest_amt,
                curr_amt: grand_total.curr_amt,
                portfolio_perc: grand_total.portfolio_perc,
                profit: grand_total.profit,
                profit_perc: profit_percent
            })
        );
    }

    function unitTrustTableFooterRow(data) {
        return '<tr>' +
            '<th>' + data['name'] + '</th>' +
            '<th>' + data['payment_method'] + '</th>' +
            '<th>-</th>' +
            '<th>-</th>' +
            '<th>-</th>' +
            '<th>' + addCommaToNumber(data['invest_amt']) + '</th>' +
            '<th>-</th>' +
            '<th>-</th>' +
            '<th>' + addCommaToNumber(data['curr_amt']) + '</th>' +
            '<th>' + addCommaToNumber(data['portfolio_perc']) + '</th>' +
            '<th>' + addCommaToNumber(data['profit']) + '</th>' +
            '<th>' + addCommaToNumber(data['profit_perc']) + '</th>' +
            '</tr>'
    }

    function getClientUTByPaymentHistory() {
        showLoading()
        ut_history_tbl.clear().draw();
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_ut_by_payment_history",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        initOrderList(ut_history_tbl, json.data.orders, currentClientIsWrap);
                        break;
                }
            }
        });
    }

    function getClientUTByPaymentPending() {
        showLoading()
        payment_pending_tbl.clear().draw();
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_ut_by_payment_pending",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        initOrderList(payment_pending_tbl, json.data.orders, currentClientIsWrap);
                        break;
                }
            }
        });
    }

    function getClientAccruedInterest() {
        ajaxRequest({
            url: "<?= base_url() ?>cash_withdrawal/_interest",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || "",
                currency: "MYR"
            },
            method: "get",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $("#interest_cash").html(addCommaToNumber(data.interest));
                    $("#interest_epf").text(addCommaToNumber(0));
                    $("#interest_total").text(addCommaToNumber(data.interest));

                    pnl.interest = data.interest
                    showPnl();
                }
            }
        })
    }

    function initOrderList(tbl, list, is_wrap) {
        $.each(list, function(index, item) {
            var saf_link = item['file_path'] == undefined ? "-" : "<a href=\"<?= base_url() ?>file?f=" + item['file_path'] + item['file_name'] + "\" target=\"_blank\">View Investor SAF Details</a>";
            var fund_name = item['fund_name'] || "-";
            var amount = addCommaToNumber(item[is_wrap ? 'net_amount' : 'amount'] || "-");
            var charge = addCommaToNumber(item['sale_charge_perc'] || "-");
            var nav = addCommaToNumber(item['nav'] || "-", 4);
            var unit = addCommaToNumber(item['unit'] || "-");

            if (item['order_type'] === "<?= ORDER_TYPE_SWITCH ?>") {
                // switch out
                fund_name = "<div><b>Switch Out</b></div><ul>";
                charge = "<div><b>Switch Out</b></div><ul>";
                amount = "<div><b>Switch Out</b></div><ul>";
                nav = "<div><b>Switch Out</b></div><ul>";
                unit = "<div><b>Switch Out</b></div><ul>";
                $.each(item['funds']['out'], function(i, f) {
                    fund_name += "<li>" + f["fund_name"] + "</li>";
                    charge += "<li>" + addCommaToNumber(f["sale_charge_perc"] || "-") + "</li>";
                    amount += "<li>" + addCommaToNumber(f[is_wrap ? 'net_amount' : 'amount'] || "-") + "</li>";
                    nav += "<li>" + addCommaToNumber(f["nav"] || "-", 4) + "</li>";
                    unit += "<li>" + addCommaToNumber(f["unit"] || "-") + "</li>";
                })

                // switch in
                fund_name += "</ul><br><div><b>Switch In</b></div><ul>";
                charge += "</ul><br><div><b>Switch In</b></div><ul>";
                amount += "</ul><br><div><b>Switch In</b></div><ul>";
                nav += "</ul><br><div><b>Switch In</b></div><ul>";
                unit += "</ul><br><div><b>Switch In</b></div><ul>";
                $.each(item['funds']['in'], function(i, f) {
                    fund_name += "<li>" + f["fund_name"] + "</li>";
                    charge += "<li>" + addCommaToNumber(f["sale_charge_perc"] || "-") + "</li>";
                    amount += "<li>" + addCommaToNumber(f[is_wrap ? 'net_amount' : 'amount'] || "-") + "</li>";
                    nav += "<li>" + addCommaToNumber(f["nav"] || "-", 4) + "</li>";
                    unit += "<li>" + addCommaToNumber(f["unit"] || "-") + "</li>";
                })
                fund_name += "</ul>";
                amount += "</ul>";
            }

            tbl.row.add([
                (item['order_type_name'] || "-"),
                fund_name,
                (item['submission_date'] || item['order_date'] || "-"),
                amount,
                charge,
                nav,
                unit,
                (item['payment_mode_name'] || "-"),
                (item['workflow_description'] || "-"),
                (item['confirmed_date'] || "-"),
                (item['remarks'] || "-"),
                (saf_link),

            ]);
        });
        tbl.draw();
    }

    function getConsolidatedTable() {
        showLoading()
        consolidated_tbl.clear().draw();
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_products",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {

                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.info;

                        for (var i = 0; i < arr_data.length; i++) {
                            consolidated_tbl.row.add([
                                (arr_data[i]['client_code_label'] || "-"),
                                (arr_data[i]['client_name'] || 0),
                                (arr_data[i]['clnt_type_description'] || 0),
                                (addCommaToNumber(arr_data[i]['unit_trust'] || 0)),
                                (addCommaToNumber(arr_data[i]['m_nett_cash_account'] || 0)),
                                (addCommaToNumber(arr_data[i]['epf'] || 0)),
                                (addCommaToNumber(arr_data[i]['prs'] || 0)),
                                // (arr_data[i]['xirr'] || 0),
                            ]);
                        }
                        consolidated_tbl.draw();
                        break;
                }
            }
        });
    }

    function getClientSummaryTabUpperPart() {
        showLoading()
        summary_tab_tbl.clear().draw();

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/value_of_portfolio/client/_list",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {

                var status = json.status;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.funds;
                        var list = {},
                            total_inv = 0,
                            total_profit = 0;

                        arr_data.forEach((i, index) => {
                            if (list[i.fund_id] === undefined) {
                                list[i.fund_id] = {
                                    fund_name: i['fund_name'],
                                    inv_amt: 0,
                                    profit: 0
                                };
                            }
                            list[i.fund_id].inv_amt += Math.round((parseFloat(i['inv_amt']) || 0) * 100) / 100;
                            list[i.fund_id].profit += Math.round((parseFloat(i['profit']) || 0) * 100) / 100;
                        });
                        $.each(list, function(index, i) {
                            total_inv += i.inv_amt;
                            total_profit += i.profit;

                            summary_tab_tbl.row.add([
                                (i.fund_name || "-"),
                                (addCommaToNumber(i.inv_amt || 0)),
                                (addCommaToNumber(i.profit || 0)),
                                (addCommaToNumber(i.profit / i.inv_amt * 100 || 0)),
                            ]);
                        })

                        var tfoot = $('#summary_tab_tbl tfoot');
                        tfoot.html("");
                        tfoot.append("<tr>" +
                            "<th>Total</th>" +
                            "<th>" + addCommaToNumber(total_inv) + "</th>" +
                            "<th>" + addCommaToNumber(total_profit) + "</th>" +
                            "<th>" + addCommaToNumber(total_profit / total_inv * 100) + "</th>" +
                            "</tr>"
                        );
                        summary_tab_tbl.draw();
                        break;
                }
            }
        });
    }

    function getClientSummaryTabBottomPart() {
        showLoading()
        cash_acc_btm_tbl.clear().draw();

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_cash_account",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.summaries;
                        for (var i = 0; i < arr_data.length; i++) {
                            cash_acc_btm_tbl.row.add([
                                arr_data[i]['trust_no'] + " (" + arr_data[i]['currency'] + ")",
                                (addCommaToNumber(arr_data[i]['nett_available_balance'] || 0)),
                                (addCommaToNumber(arr_data[i]['nett_ledger_balance'] || 0)),
                                (addCommaToNumber(arr_data[i]['nett_m_available_balance'] || 0)),
                            ]);
                        }
                        cash_acc_btm_tbl.draw();
                        break;
                }
            }
        });
    }

    function getClientSAFList() {
        showLoading()
        saf_tbl.clear().draw();

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_acc_saf",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.saf;

                        if (arr_data) {
                            for (var i = 0; i < arr_data.length; i++) {

                                var saf_link = "<a href=\"<?= base_url() ?>file?f=" + arr_data[i]['file_path'] + arr_data[i]['file_name'] + "\" id='link_cash_acc_history' target=\"_blank\" >View Investor SAF Details</a>";

                                saf_tbl.row.add([
                                    arr_data[i]['saf_no'],
                                    (arr_data[i]['saf_form_type'] || ("-")),
                                    (arr_data[i]['order_created_at'] || ("-")),
                                    (arr_data[i]['approved_date'] || ("-")),
                                    saf_link
                                ]);
                            }
                            saf_tbl.draw();
                        }
                        break;
                }
            }
        });
    }

    function getClientUTByPayment() {
        showLoading()
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_pnl",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.info;
                        $("#loss_since_inspection_date").text(arr_data['inception_date'] || ("-"));

                        var cur_a = parseFloat(arr_data['cash_account_cash'] || 0);
                        var cur_b = parseFloat(arr_data['cash_account_epf'] || 0);
                        $("#cur_valuation_cash").text(addCommaToNumber(cur_a.toFixed(2)));
                        $("#cur_valuation_epf").text(addCommaToNumber(cur_b.toFixed(2)));
                        $("#cur_valuation_total").text(addCommaToNumber((cur_a + cur_b).toFixed(2)));

                        var trs_a = parseFloat(arr_data['deposit_cash'] || 0);
                        var trs_b = parseFloat(arr_data['deposit_epf'] || 0);
                        $("#deposit_cash").text(addCommaToNumber(trs_a.toFixed(2)));
                        $("#deposit_epf").text(addCommaToNumber(trs_b.toFixed(2)));
                        $("#deposit_total").text(addCommaToNumber((trs_a + trs_b).toFixed(2)));

                        var fvc_a = parseFloat(arr_data['fund_valution_cash'] || 0);
                        var fvc_b = parseFloat(arr_data['fund_valution_epf'] || 0);
                        $("#fund_valuation_cash").text(addCommaToNumber((fvc_a.toFixed(2))));
                        $("#fund_valuation_epf").text(addCommaToNumber((fvc_b.toFixed(2))));
                        $("#fund_valuation_total").text(addCommaToNumber(((fvc_a + fvc_b).toFixed(2))));

                        var out_a = parseFloat(arr_data['outflow_cash'] || 0);
                        var out_b = parseFloat(arr_data['outflow_epf'] || 0);
                        $("#outflow_cash").text(addCommaToNumber(out_a.toFixed(2)));
                        $("#outflow_epf").text(addCommaToNumber(out_b.toFixed(2)));
                        $("#outflow_total").text(addCommaToNumber(((out_a + out_b).toFixed(2))));

                        var pending_withdraw_a = parseFloat(arr_data['pending_withdraw_cash'] || 0);
                        var pending_withdraw_b = parseFloat(arr_data['pending_withdraw_epf'] || 0);

                        $("#pending_withdraw_cash").html(addCommaToNumber(pending_withdraw_a));
                        $("#pending_withdraw_epf").html(addCommaToNumber(pending_withdraw_b));
                        $("#pending_withdraw_total").text(addCommaToNumber((pending_withdraw_a + pending_withdraw_b).toFixed(2)));

                        var pending_sell_a = parseFloat(arr_data['pending_sell_cash'] || 0);
                        var pending_sell_b = parseFloat(arr_data['pending_sell_epf'] || 0);

                        $("#pending_sell_cash").html(addCommaToNumber(pending_sell_a));
                        $("#pending_sell_epf").html(addCommaToNumber(pending_sell_b));
                        $("#pending_sell_total").text(addCommaToNumber((pending_sell_a + pending_sell_b).toFixed(2)));

                        var pending_buy_a = parseFloat(arr_data['pending_buy_cash'] || 0);
                        var pending_buy_b = parseFloat(arr_data['pending_buy_epf'] || 0);

                        $("#pending_buy_cash").html(addCommaToNumber(pending_buy_a));
                        $("#pending_buy_epf").html(addCommaToNumber(pending_buy_b));
                        $("#pending_buy_total").text(addCommaToNumber((pending_buy_a + pending_buy_b).toFixed(2)));

                        var pnl_a = (cur_a - trs_a + out_a + pending_withdraw_a + pending_sell_a + pending_buy_a + fvc_a) || 0;
                        var pnl_b = (cur_b - trs_b + out_b + pending_withdraw_b + pending_sell_b + pending_buy_b + fvc_b) || 0;
                        var pnl_ab = pnl_a + pnl_b;

                        pnl.total_without_interest = {
                            cash: pnl_a,
                            epf: pnl_b,
                            total: pnl_ab
                        }
                        showPnl();
                        break;
                }
            }
        });
    }

    function showPnl() {
        if (pnl.total_without_interest === undefined || pnl.interest === undefined) return;
        var pnl_a = pnl.total_without_interest.cash + pnl.interest;
        var pnl_b = pnl.total_without_interest.epf;
        var pnl_ab = pnl_a + pnl_b;

        var pnl_cash = $("#pnl_cash");
        pnl_cash.text(addCommaToNumber(pnl_a));
        if (pnl_a >= 0) {
            pnl_cash.removeClass('text-danger');
            pnl_cash.addClass('text-success');
        } else {
            pnl_cash.removeClass('text-success');
            pnl_cash.addClass('text-danger');
        }

        var pnl_epf = $("#pnl_epf");
        pnl_epf.text(addCommaToNumber(pnl_b));
        if (pnl_b >= 0) {
            pnl_epf.removeClass('text-danger');
            pnl_epf.addClass('text-success');
        } else {
            pnl_epf.removeClass('text-success');
            pnl_epf.addClass('text-danger');
        }

        var pnl_total = $("#pnl_total");
        pnl_total.text(addCommaToNumber(pnl_ab));
        if (pnl_ab >= 0) {
            pnl_total.removeClass('text-danger');
            pnl_total.addClass('text-success');
        } else {
            pnl_total.removeClass('text-success');
            pnl_total.addClass('text-danger');
        }
    }

    function getClientSummary() {
        showLoading()
        cash_account_table.clear().draw();

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_cash_account",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.summaries;
                        var overdues = json.data.overdues;

                        for (var i = 0; i < arr_data.length; i++) {

                            var transaction_history = "<a href=\"#\" id='link_cash_acc_history' data-toggle=\"modal\" data-trust-no=\"" + arr_data[i]['trust_no'] + "\" data-target=\"#transaction_history\" data-iswrap=\"" + currentClientIsWrap + "\">Transaction History</a>";
                            var overdue = 0;

                            for (var o of overdues) {
                                if (o.currency == arr_data[i]['currency']) {
                                    overdue += o.os_amount + o.accrued_int;
                                }
                            }

                            cash_account_table.row.add([
                                arr_data[i]['trust_no'] + '   (' + arr_data[i]['currency'] + ')',
                                (addCommaToNumber(arr_data[i]['nett_available_balance']) || 0),
                                (addCommaToNumber(arr_data[i]['nett_ledger_balance'] || 0)),
                                (addCommaToNumber(arr_data[i]['nett_m_available_balance'] || 0)),
                                addCommaToNumber(overdue),
                                transaction_history
                            ]);
                        }
                        cash_account_table.draw();
                        break;
                }
            }
        });
    }

    function getClientSummaryTransData(code) {
        showLoading();

        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_cash_account_history",
            data: {
                code: code,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.transactions;

                        trans_history_tbl.clear().draw();

                        for (var i = 0; i < arr_data.length; i++) {
                            var item = arr_data[i];
                            trans_history_tbl.row.add([
                                item['trust_date'],
                                item['created_at'],
                                (item['description'] || ("-")),
                                (item['trust_no'] || ("-")),
                                (item['trust_item_type_name'] || ("-")),
                                (item['trust_remark'] || ("-")),
                                (item['currency'] || ("-")),
                                (item['sales_charge'] || ("-")),
                                (
                                    item['trust_item_type'] == '<?= ORDER_TYPE_WITHDRAWAL ?>' ||
                                    item['trust_item_type'] == '<?= TRUST_ITEM_TYPE_AUTO_WITHDRAW ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_DEBIT_NOTE ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_BUY ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_WRAPFEES ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_PLATFORMFEES ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_TRANSFER_OUT ?>' ?
                                    "-" :
                                    addCommaToNumber(item[currentClientIsWrap && item['trust_item_type'] !== "<?= ORDER_TYPE_DEPOSIT ?>" ? 'm_nett_amount' : 'm_gross_amount'])
                                ),
                                (
                                    item['trust_item_type'] == '<?= ORDER_TYPE_WITHDRAWAL ?>' ||
                                    item['trust_item_type'] == '<?= TRUST_ITEM_TYPE_AUTO_WITHDRAW ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_DEBIT_NOTE ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_BUY ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_WRAPFEES ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_PLATFORMFEES ?>' ||
                                    item['trust_item_type'] == '<?= ORDER_TYPE_TRANSFER_OUT ?>' ?
                                    addCommaToNumber(item[!currentClientIsWrap && (item['trust_item_type'] == "<?= ORDER_TYPE_BUY ?>" || item['trust_item_type'] == "<?= ORDER_TYPE_WITHDRAWAL ?>") ? 'm_gross_amount' : 'm_nett_amount']) :
                                    "-"
                                ),
                            ]);
                        }
                        trans_history_tbl.draw();
                        break;
                }
            }
        });
    }

    function getClientName() {
        showLoading()
        ajaxRequest({
            url: "<?= base_url() ?>view_holdings/bfe/_client_info",
            data: {
                code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No client found at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var client_json = json.data.client;

                        $("#summary_client_type").text(client_json['clnt_type_description']);
                        $("#summary_account_number").text(client_json['client_code_label']);
                        $("#summary_account_status").text(client_json['status'] || "-");
                        $("#summary_account_salutation").text(client_json['salutation'] || "-");
                        $("#summary_account_user_id").text(client_json['login_id'] || "-");
                        $("#summary_account_wrap_fee").text(client_json['wrap_rate'] ? addCommaToNumber(client_json['wrap_rate']) : "-");
                        $("#summary_account_risk_profile").text(client_json['risk_profile'] || '-');

                        $("#summary_estatement_status").text(client_json['e_statement_description']);

                        $("#summary_local_bank_name").text(client_json['bank_name'] || "-");
                        $("#summary_local_bank_acc").text(client_json['bank_acc'] || "-");

                        var divApplicants = $("#div-client-summary-applicants");
                        divApplicants.html("");
                        var divApplicant = $(".div-client-summary-applicant");
                        if (client_json['applicants'] && client_json['applicants'].length > 0) {
                            divApplicant.hide();

                            $.each(client_json['applicants'], function(index, applicant) {
                                var clone = divApplicant.clone();

                                $("#summary_client_name", clone).text(applicant['client_name']);
                                $("#summary_client_ic", clone).text(applicant['new_ic'].trim() || applicant['old_ic'].trim() || "-");
                                $("#summary_client_gender", clone).text(applicant['gender'] || "-");
                                $("#summary_account_salutation", clone).text(applicant['salutation'] || "-");

                                var dob = applicant['dob'];
                                if (dob) {
                                    dob = moment(dob, "YYYY-MM-DD HH:mm:ss.SSS").format("D/M/YYYY")
                                } else {
                                    dob = '-';
                                }
                                $("#summary_client_dob", clone).text(dob);
                                $("#summary_client_nationality", clone).text(applicant['nationality'] || "-");
                                $("#summary_client_race", clone).text(applicant['race'] || "-");
                                $("#summary_client_epf_no", clone).text(applicant['epf_no'] || "-");
                                $("#summary_client_ppa_no", clone).text(applicant['ppa_no'] || "-");

                                var client_id = $("#summary_client_user_id", clone);
                                client_id.text(applicant['login_id'] || "-");

                                $("#summary_client_home_phone", clone).text(applicant['home'] || "-");
                                $("#summary_client_office_phone", clone).text(applicant['office'] || "-");
                                $("#summary_client_mobile_phone", clone).text(applicant['mobile'] || "-");
                                $("#summary_client_email", clone).text(applicant['email'] || "-");

                                $("#summary_add1", clone).text(applicant['addr1'] + " " + applicant['addr2'] + " " + applicant['addr3'] + " " + applicant['addr4'] + " " + applicant['addr5'] || "-");
                                $("#summary_add2", clone).text(applicant['state'] || "-");
                                $("#summary_add3", clone).text(applicant['postcode'] || "-");
                                $("#summary_add4", clone).text(applicant['country_name'] || "-");

                                $("#summary_employment_occupation", clone).text(applicant['occupation'] || "-");
                                $("#summary_employment_employer", clone).text(applicant['employer_name'] || "-");
                                $("#summary_employment_annual_salary", clone).text(applicant['annual_income'] || "-");

                                divApplicants.append('<h3 style="margin-top: 20px;">Applicant ' + (index + 1) + '</h3>');
                                divApplicants.append("<hr>");
                                divApplicants.append(clone);

                                client_id.closest('.row').show();

                                clone.show();
                            });
                        } else {
                            $("#summary_client_name").text(client_json['client_name']);
                            $("#summary_client_ic").text(client_json['new_ic'].trim() || client_json['old_ic'].trim() || "-");
                            $("#summary_client_gender").text(client_json['gender'] || "-");

                            var dob = client_json['dob'];
                            if (dob) {
                                dob = moment(dob, "YYYY-MM-DD HH:mm:ss.SSS").format("D/M/YYYY")
                            } else {
                                dob = '-';
                            }
                            $("#summary_client_dob").text(dob);
                            $("#summary_client_nationality").text(client_json['nationality'] || "-");
                            $("#summary_client_race").text(client_json['race'] || "-");
                            $("#summary_client_epf_no").text(client_json['epf_no'] || "-");
                            $("#summary_client_ppa_no").text(client_json['ppa_no'] || "-");

                            $("#summary_client_home_phone").text(client_json['home'] || "-");
                            $("#summary_client_office_phone").text(client_json['office'] || "-");
                            $("#summary_client_mobile_phone").text(client_json['mobile'] || "-");
                            $("#summary_client_email").text(client_json['email'] || "-");

                            $("#summary_add1").text(client_json['addr1'] + " " + client_json['addr2'] + " " + client_json['addr3'] + " " + client_json['addr4'] + " " + client_json['addr5'] || "-");
                            $("#summary_add2").text(client_json['state'] || "-");
                            $("#summary_add3").text(client_json['postcode'] || "-");
                            $("#summary_add4").text(client_json['country_name'] || "-");

                            $("#summary_employment_occupation").text(client_json['occupation'] || "-");
                            $("#summary_employment_employer").text(client_json['employer_name'] || "-");
                            $("#summary_employment_annual_salary").text(client_json['annual_income'] || "-");

                            divApplicant.show();
                        }
                        break;
                }
            }
        });
    }

    function getPortfolioTracking() {
        showLoading()

        portfolio_tracking_tbl.clear().draw();

        $('#tracking_client').val(currentClientId);

        ajaxRequest({
            url: "<?= base_url() ?>tracking/_list",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No tracking available at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var arr_data = json.data.tracking;

                        for (var i = 0; i < arr_data.length; i++) {
                            var updateBtn = '<button ' +
                                'class="btn_update_tracking btn btn-danger" ' +
                                'data-toggle="modal"  ' +
                                'data-tracking_no="' + (arr_data[i]['tracking_no'] || "") + '" ' +
                                'data-client_code="' + (arr_data[i]['client_code'] || "") + '" ' +
                                'data-portfolio_code="' + (arr_data[i]['portfolio_code'] || "") + '" ' +
                                'data-fund_name="' + (arr_data[i]['fund_name'] || "") + '" ' +
                                'data-percentage="' + (arr_data[i]['percentage'] || "") + '" ' +
                                'data-tracking_type="' + (arr_data[i]['tracking_type'] || "") + '" ' +
                                'data-target="#modal_portfolio_tracking_form" ' +
                                'data-dismiss="modal" ' +
                                'style="color:white">Update</button> ' +
                                '<button ' +
                                'class="btn_delete_tracking btn btn-danger" ' +
                                'href="#" ' +
                                'data-tracking_no="' + (arr_data[i]['tracking_no'] || "") + '" ' +
                                'style="color:white">Delete</button>'

                            portfolio_tracking_tbl.row.add([
                                (arr_data[i]['client_code'] || "-"),
                                (arr_data[i]['branch'] || "-"),
                                (arr_data[i]['fund_name'] || "-"),
                                (arr_data[i]['portfolio_code'] || "-"),
                                (arr_data[i]['percentage'] || "-"),
                                (arr_data[i]['amount'] || "-"),
                                (arr_data[i]['tracking_type_description'] || "-"),
                                (arr_data[i]['tracking_active_description'] || "-"),
                                updateBtn

                            ]);
                        }
                        portfolio_tracking_tbl.draw();
                        break;
                }
            }
        });
    }

    function getInactiveTracking() {
        showLoading()

        ajaxRequest({
            url: "<?= base_url() ?>tracking/_inactive",
            data: {
                client_code: currentClientId,
                ifa_code: ifa_code || ""
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No tracking available at the moment.";
                var status = json.status;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var slt_portfolio = $('#slt-tracking-portfolio');

                        $('#slt-tracking-portfolio')[0].options.length = 0;
                        var arr_fund = json.data.fund;
                        for (var i = 0; i < arr_fund.length; i++) {
                            var element = arr_fund[i];
                            var value = JSON.stringify({
                                code: element['code'],
                                tracking_type: element['tracking_type']
                            });

                            slt_portfolio.append("<option value=\'" + value + "\' >" + element['name'] + "</option>");
                        }

                        var arr_porfolio = json.data.portfolio;
                        for (var i = 0; i < arr_porfolio.length; i++) {
                            var element = arr_porfolio[i];
                            var value = JSON.stringify({
                                code: element['code'],
                                tracking_type: element['tracking_type']
                            });

                            slt_portfolio.append("<option value=\'" + value + "\' >" + element['name'] + "</option>");
                        }
                        break;
                }
            }
        });
    }

    function get_account_label(clnt_type_description, is_wrap) {
        var account_type = clnt_type_description;
        if (is_wrap)
            account_type = "Wrap " + account_type;
        return account_type;
    }

    function createPieChart(id, title, series, json) {
        var data = [];
        $.each(json, function(key, value) {
            data.push({
                name: key,
                y: value
            });
        })

        Highcharts.chart(id, {
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            "viewFullscreen",
                            'printChart',
                            'separator',
                            'downloadPNG',
                            'downloadJPEG',
                            'downloadPDF',
                            'downloadSVG',
                            'separator',
                            'downloadCSV',
                            'downloadXLS',
                        ]
                    }
                }
            },
            chart: {
                type: 'pie',
                zoomType: 'x',
            },
            title: {
                text: title
            },
            tooltip: {
                shared: true,
                split: false,
                enabled: true,
                valueDecimals: 2
            },
            plotOptions: {
                pie: {
                    tooltip: {
                        pointFormat: (series != 'Percentage of Portfolio (%)' ? 'Percentage: {point.percentage:.2f}%<br>' : '') + series + ': {point.y}',
                    }
                }
            },
            series: [{
                showInLegend: false,
                name: series,
                // colorByPoint: true,
                data: data
            }]
        });
    }
</script>
<?php
$template["footer"] = ob_get_clean();
?>

<?= json_encode($template) ?>