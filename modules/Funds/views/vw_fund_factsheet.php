<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Fund Factsheet'
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>
<a id="goTopBtn"></a>

<div class="py-5">
    <div class="container">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4 collapse" id="div-factsheet">
            <div class="col-md-12">

                <div id="box-nav" class="list-group">
                    <div class="text-center">
                        <ul style="padding: 0px; margin: 0px;">
                            <li class="list-group-item">
                                <a href="#fund_info_div">Fund Info</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_house_div">Fund House</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_charges_div">Fund Charges</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_holidays_div">Fund Holidays</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_performance_annualized_div">Annualized Returns</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_performance_cumulative_div">Cumulative Return</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_others_div">Other Figures</a>
                            </li>
                            <li class="list-group-item">
                                <a href="#fund_prospectus_div">Fund Prospectus</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-md-3"><a class="btn btn-link" href="#">Snapshot</a></div>
                    <div class="col-md-3"><a class="btn btn-link" href="#">Charges</a></div>
                    <div class="col-md-3"><a class="btn btn-link" href="#">Prospectus</a></div>
                    <div class="col-md-3"><a class="btn btn-link" href="#">Performance</a></div>
                </div>

                <br> -->

                <div class="row pt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 data-value="fund_name" data-type="text">Fund 1</h1>
                                        <p data-value="investment_objective" data-type="text">-</p>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-2"><label class="col-form-label"><b>Asset Class</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="asset_class" data-type="selector"></label></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Sector</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="sector" data-type="selector"></label></div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Geographical Allocation</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="geographical_allocation" data-type="selector"></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Available</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="active_status" data-type="boolean"></label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="fund_info_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Info</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Launch Date</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="launch_date" data-type="date">March 3, 2014</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Launch Price</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="fund_price" data-type="price">RM X.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Latest NAV Price </b></label></div>
                                    <div class="col-md-4"><label class="col-form-label"><span data-value="latest_nav" data-type="navprice">RM X.XXXX</span> (Last Updated Date: <span data-value="latest_dealing_date" data-type="date">RM X.XXXX</span>)</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Historical Income Distribution</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value data-type="historical_income_distribution">-</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Approved by EPF</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="epf_approval" data-type="boolean">No</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Shariah Compliant</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="shariah_compliant" data-type="boolean">No</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Morningstar Rating</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="star_rating" data-type="rating">8 - High Risk</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Fund Size</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="fund_size" data-type="number">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Minimum Initial Investment</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="min_inv_amt" data-type="price">RM XX.XX</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Minimum Subsequent Investment</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="min_sub_inv_amt" data-type="price">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Minimum RSP Investment</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="min_inv_rsp_amt" data-type="price">RM XX.XX</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Minimum Redemption Unit</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="min_redemption_unit_amt" data-type="number">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Minimum Holding</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="min_holding_amt" data-type="number">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Cooling-off Period</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="cooling_off_days" data-type="day">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Distribution Policy</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="distribution_policy" data-type="text">RM XX.XX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Buy Processing Time</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="subscription_processing_days" data-type="day">RM XX.XX</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Redemption Processing Time</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="redemption_processing_days" data-type="day">RM XX.XX</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_house_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund House</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12"><a class="btn btn-link" href="maintenance_fund_house_info.html" id="a-fund-house">Fund House 1</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_charges_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Charges</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Fund Sales Charge</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="max_sale_charge_perc" data-type="percent">X.X %</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Annual Management Charge</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="annual_management_fee" data-type="charge">X.X %</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Trustee Fee</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="trustee_fee" data-type="charge">X.X %</label></div>
                                    <div class="col-md-2"><label class="col-form-label"><b>Other Significant Fees</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value data-type="other_fee">X.X %</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><label class="col-form-label"><b>Annual Expense Ratio *</b></label></div>
                                    <div class="col-md-4"><label class="col-form-label" data-value="annual_expense_ratio" data-type="charge">X.X %</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_holidays_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Holidays</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>The table below shows the fund holidays for this fund within the next 10 business days.</p>
                                    </div>
                                </div>
                                <table class="table table-striped table-borderless">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbd-holiday">
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>There will be no pricing on holidays declared by individual fund managers. Pricing of the funds will be resumed on the following business day.&nbsp;<br><br>The above fund holidays are based on the latest information provided by the individual fund managers. Omissions may occur in the event that is not informed on time.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_performance_annualized_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Performance (Bid-to-Bid Annualized Returns) (Last Updated Date: <span data-value="latest_dealing_date" data-type="date">24/04/2019</span>)</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-6"><label class="col-form-label"><b>Period</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>3-mth</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>1-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>2-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>3-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>5-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>10-yr</b></label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-6"><label class="col-form-label"><b>Bid to Bid Returns (%) - RM</b></label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.3 Month" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.1 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.2 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.3 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.5 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.10 Year" data-type="text">X.X %</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>The performance figures in the table above are calculated using bid-to-bid prices, with any income or dividends reinvested. Performance figures of over 1 year are annualised.(Eg. A 33.1% gain in 3 years works out to a 10% gain per year when annualised.)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_performance_cumulative_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Performance (Bid-to-Bid Cumulative Return) (Last Updated Date: <span data-value="latest_dealing_date" data-type="date">24/04/2019</span>)</p>
                            </div>
                            <div class="card-body">                            
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-6"><label class="col-form-label"><b>Period</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>1-wk</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>3-mth</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>6-mth</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>1-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>2-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>3-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>5-yr</b></label></th>
                                                <th class="col-md-1 text-center"><label class="col-form-label"><b>10-yr</b></label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-6"><label class="col-form-label"><b>Bid to Bid Returns (%) - RM</b></label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.1 Week" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.3 Month" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.6 Month" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.1 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_return.2 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_cumulative_return.3 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_cumulative_return.5 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-1 text-center"><label class="col-form-label" data-value="performance_type_cumulative_return.10 Year" data-type="text">X.X %</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Performance figures are absolute returns based on the price of the fund as at <span data-value="latest_dealing_date" data-type="date">24/04/2019</span> (Last updated on <span data-value="latest_dealing_date" data-type="date">24/04/2019</span>),on NAV-to-NAV basis,with dividends being 'reinvested' on the dividend date.</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center"><label class="col-form-label"><b>Calendar Year Total Returns</b></label></div>
                                </div>
                            
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2"><label class="col-form-label"><b>Calendar Year</b></label></th>
                                                <?php for ($i = 1, $year = intval(date("Y")) - 1; $i <= 5; $i++, $year--) { ?>
                                                    <th class="col-md-2 text-center"><label class="col-form-label"><b><?= $year ?></b></label></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-2"><b>Returns (%) - RM</b></td>
                                                <td class="col-md-2 text-center"><label class="col-form-label" data-value="performance_type_calendar_year_return.1 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-2 text-center"><label class="col-form-label" data-value="performance_type_calendar_year_return.2 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-2 text-center"><label class="col-form-label" data-value="performance_type_calendar_year_return.3 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-2 text-center"><label class="col-form-label" data-value="performance_type_calendar_year_return.4 Year" data-type="text">X.X %</label></td>
                                                <td class="col-md-2 text-center"><label class="col-form-label" data-value="performance_type_calendar_year_return.5 Year" data-type="text">X.X %</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="div-chart" style="width:100%; height:500px;" class='no-data'></div>
                                        <?php if ($login_type == LOGIN_TYPE_BFE) { ?>
                                            <div class="text-center">
                                                <a class="text-center" id="a-chart-center">Click here to see how the fund has peformed against other funds or and index. </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                
                            
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>                                            
                                                <th class="col-md-6"><label class="col-form-label"><b>Period</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>1-yr high</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>1-yr low</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>3-yr high</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>3-yr low</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>All time high</b></label></th>
                                                <th class="col-md-1"><label class="col-form-label"><b>All time low</b></label></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-md-6"><label class="col-form-label"><b>Price (RM)</b></label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="1_year_high" data-type="text">X.XXXX</label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="1_year_low" data-type="text">X.XXXX</label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="3_year_high" data-type="text">X.XXXX</label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="3_year_low" data-type="text">X.XXXX</label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="all_high" data-type="text">X.XXXX</label></td>
                                                <td class="col-md-1"><label class="col-form-label" data-value="all_low" data-type="text">X.XXXX</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><i>Historical prices shown are the NAV prices and are based on the fund's currency. Please click on the value to see the actual date. The "All time high" and "All time low" prices are the highest and the lowest NAV prices from the first dealing date since inception and the latest available dealing date respectively. </i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_others_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Other figures</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6"><label class="col-form-label"><b>3-yr Annualised Volatility</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="performance_type_volatility.3 Year" data-type="percent">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><label class="col-form-label"><b>3-yr Sharpe Ratio</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="performance_type_sharpe_ratio.3 Year" data-type="percent">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><i>The above figures (as of <span data-value="latest_dealing_date" data-type="date">24/04/2019</span>): Last updated on <span data-value="latest_dealing_date" data-type="date">24/04/2019</span></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fund_prospectus_div" class="row pt-4 scrollspy">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <p>Fund Prospectus, Reports &amp; Factsheet</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3"><label class="col-form-label"><b>Prospectus PDF</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="supporting_document.prospectus" data-type="pdf">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"><label class="col-form-label"><b>Semi-annual Report PDF</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="supporting_document.semiannual_report" data-type="pdf">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"><label class="col-form-label"><b>Annual Report PDF</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="supporting_document.annual_report" data-type="pdf">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"><label class="col-form-label"><b>Product Highlight Sheet PDF</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="supporting_document.phs" data-type="pdf">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"><label class="col-form-label"><b>Fund Factsheet PDF</b></label></div>
                                    <div class="col-md-6"><label class="col-form-label" data-value="supporting_document.factsheet" data-type="pdf">RM X.XXXX</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <p>Disclaimer : </p>

                                        <!--                                        <p><i>Important: Past performance does not necessarily indicate the future or likely performance of any fund.</i></p>-->
                                        <!--                                        <p><i>This fact sheet is compiled from the individual fund management company's public information material, and meant for information only. Whilst all attempts have been made to present the information accurately and completely, it is inevitable that mistakes and omissions occur. Readers are advised to read the prospectus before making any investment decision.</i></p>-->
                                        <p>UOB Kay Hian Securities (M) Sdn Bhd is a non exclusive distributor of the funds that you select. This compilation is prepared by UOB Kay Hian Securities (M) Sdn Bhd in its capacity as an institutional unit trust agent for specific Funds. You are advised to read and understand the relevant prospectus for the Funds. Such prospectus has been registered with the Securities Commission which takes no responsibility for its contents and is obtainable at any of our offices, website and authorised agents. You should consider the fees and charges involved and consult your financial adviser if you are in doubt about any feature or nature of the funds. The prices of units and distribution payable if any may go down as well as up and past performance of the fund is no guarantee for its future performance. Any issue of units to which the prospectus relates will only be made on receipt of the application form referred to in and accompanying the prospectus. Please be advised that any information that falls outside designated prospectus on same herein does not form part of electronic prospectus. The collective investment schemes are offered solely on the basis of the information contained in the electronic prospectus.</p>
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

<button id="btn-toggle-modalotherfee" data-target="#modal_other_fee" data-toggle="modal" style="display: none;"></button>
<button id="btn-toggle-modalhistoricalincomedistribution" data-target="#modal_historical_income_distribution" data-toggle="modal" style="display: none;"></button>
<div class="modal" id="modal_other_fee">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Other Fee</h5> <button type="button" class="close" data-dismiss="modal"> <span>×</span> </button>
            </div>
            <div class="modal-body">
                <p><b>Remark:</b></p>
                <div id="modal-other-fee-body"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_historical_income_distribution">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historical Income Distribution</h5> <button type="button" class="close" data-dismiss="modal"> <span>×</span> </button>
            </div>
            <div class="modal-body">
                <p id="div-mhid-fund-name"></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Excluding Date</th>
                            <th>Reinvestment Date</th>
                            <th>Gross Income Distribution Rate</th>
                            <th>Net Income Distribution Rate</th>
                        </tr>
                    </thead>
                    <tbody id="tbd-mhid">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    .list-group-item.active {
        color: white;
        background-color: #c33b32;
        border-color: #c33b32;

    }

    .list-group-item.active>a {
        color: white;
    }

    .text-white {
        color: white;
    }

    .list-group-item {
        background-color: #FCFCFC;
        width: 100%;
        cursor: pointer;
    }
</style>
<?php $this->load->view('template/_plugin_css_highchart'); ?>
<?php
$template['header'] = ob_get_clean();

/*
 * ---------
 *  FOOTER
 * ---------
 */
ob_start();
?>
<?php $this->load->view('template/_plugin_js_highchart'); ?>
<script>
    autoHideLoadingOnInit = false;

    var chart, loading_chart = false,
        loading_fund_detail = false,
        loading_holiday = false,
        load_historical_income_distribution;
    window.addEventListener("DOMContentLoaded", function() {

        var btn = $('#goTopBtn');
        btn.addClass('show');
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, '300');
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

        chart = Highcharts.chart('div-chart', {
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
                type: 'spline',
                zoomType: 'x'
            },
            title: {
                text: 'Performance Chart over Last 3 Years'
            },
            tooltip: {
                xDateFormat: '%B %e, %Y',
                shared: true,
                split: false,
                enabled: true
            },
            xAxis: {
                type: 'datetime',
                labels: {
                    format: '{value:%b %Y}'
                }
            },
            yAxis: {
                title: {
                    text: 'Total Return'
                },
                labels: {
                    formatter: function() {
                        return (this.value + 100) + "%";
                    }
                }
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: false
                    }
                }
            },
            series: []
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
                getFundDetail(value);
        });

        //sidebar scrollspy
        // $(window).bind('scroll', function() {
        //     var currentTop = $(window).scrollTop() + 300;
        //     var elems = $('.scrollspy');
        //     elems.each(function(index) {
        //         var elemTop = $(this).offset().top;
        //         var elemBottom = elemTop + $(this).height();
        //         if (currentTop >= elemTop && currentTop <= elemBottom) {
        //             // console.log(currentTop)
        //             var id = $(this).attr('id');
        //             var navElem = $('a[href="#' + id + '"]');
        //             navElem.parent().addClass('active').siblings().removeClass('active');
        //         }
        //     })

        // });


        $('.list-group li').click(function(e) {
            e.preventDefault()

            $that = $(this);
            var href = $(this).find('a').attr('href');

            console.log("onclick " + href)


            $('html, body').animate({
                scrollTop: $(href).offset().top - 200
            }, 500, function() {
                // $that.parent().find('li').removeClass('active');
                // $that.addClass('active');
            });

        });

    });

    function getFundList(fund_house, completion) {
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

                if (completion != undefined)
                    completion();
                else
                    hideLoading();
            }
        });
    }

    function getFundDetail(fund) {
        showLoading();

        load_historical_income_distribution = false;
        var tbd_holiday = $('#tbd-holiday');
        tbd_holiday.html('');
        <?php if ($login_type == LOGIN_TYPE_BFE) { ?>
            $('#a-chart-center').attr('href', '<?= base_url() ?>chart_center?funds[]=' + fund);
        <?php } ?>
        loadChart(fund, $('#slt-fund option:selected').text());

        loading_fund_detail = true;
        loading_holiday = true;
        ajaxRequest({
            url: "<?= base_url() ?>fund_factsheet/_detail",
            data: {
                fund: fund
            },
            method: "get",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var fund = data.fund;

                        $("[data-value]").each(function() {
                            var $this = $(this);
                            var type = $this.data("type");
                            var fields = $this.data("value");

                            if (type == "selector")
                                selectorHandle(fields, $this, fund);
                            else if (type == "historical_income_distribution")
                                historicalIncomeDistributionHandle($this, fund);
                            else if (type == "other_fee")
                                otherFeeHandle($this, fund);
                            else {
                                fields = fields.split(".");
                                var value;
                                $.each(fields, function(index, v) {
                                    if (index == 0) {
                                        value = fund[v];
                                    } else {
                                        if (value != undefined) {
                                            value = value[v];
                                        }
                                    }
                                });

                                if (type == "price")
                                    $this.text(getPrice(fund.fund_currency, addCommaToNumber(value, 2, null)));
                                else if (type == "navprice")
                                    $this.text(getPrice(fund.fund_currency, addCommaToNumber(value, 4, null)));
                                else if (type == "date")
                                    $this.text(getDate(value, "MMM D, YYYY"));
                                else if (type == "boolean")
                                    $this.text(getBoolean(value));
                                else if (type == "percent")
                                    $this.text(getPercent(value));
                                else if (type == "charge")
                                    $this.text(getCharge(value));
                                else if (type == "day")
                                    $this.text(getDay(value));
                                else if (type == "rating")
                                    $this.text(getRating(value));
                                else if (type == "pdf")
                                    $this.html(getPdf(value));
                                else if (type == "number")
                                    $this.text(addCommaToNumber(value));
                                else
                                    $this.text(value || "-");
                            }
                        });
                        break;
                }

                $('#div-factsheet').collapse('show');
                // $('#box-nav').show();

                loading_fund_detail = false;
                if (!loading_chart && !loading_fund_detail && !loading_holiday)
                    hideLoading();
            }
        });

        ajaxRequest({
            url: "<?= base_url() ?>fund_factsheet/_holidays",
            method: "get",
            data: {
                fund: fund
            },
            success: function(json) {
                var status = json.status;
                var data = json.data;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    if (data.holidays.length > 0) {
                        $.each(data.holidays, function(index, value) {
                            tbd_holiday.append("<tr><td>" + getDate(value.holiday_date, "D MMMM YYYY") + "</td><td>" + value.description + "</td></tr>");
                        });
                    } else {
                        tbd_holiday.append('<tr><td colspan="2">No Holidays</td></tr>');
                    }
                }

                loading_holiday = false;
                if (!loading_chart && !loading_fund_detail && !loading_holiday)
                    hideLoading();
            }
        })
    }

    function getPrice(currency, price) {
        if (price == null || price == undefined)
            return "-";

        var pricing = "";
        if (currency == null || currency == undefined)
            pricing = "";
        else
            pricing = currency + " ";
        pricing += price;
        return pricing;
    }

    function getDate(date, format) {
        if (date == null || date == undefined)
            return "-";

        return moment(date, "YYYY-MM-DD kk:mm:ss").format(format);
    }

    function getBoolean(boolean) {
        if (boolean == null || boolean == undefined || boolean != 1)
            return "No";

        return "Yes";
    }

    function getPercent(value) {
        if (value == null || value == undefined)
            return "-";
        return addCommaToNumber(value) + "%";
    }

    function getCharge(value) {
        if (value == null || value == undefined)
            return "-";
        return addCommaToNumber(value, 3) + "%";
    }

    function getDay(value) {
        if (value == null || value == undefined)
            return "-";
        return "T + " + value + " business days";
    }

    function getRating(value) {
        if (value != null && value != undefined) {
            if (value == 5)
                return "5-Star";
            else if (value == 4)
                return "4-Star";
            else if (value == 3)
                return "3-Star";
            else if (value == 2)
                return "2-Star";
            else if (value == 1)
                return "1-Star";
        }
        return "-";
    }

    function getPdf(value) {
        if (value == null || value == undefined)
            return "-";
        return '<a target="_blank" href="<?= base_url() ?>file?f=' + value["file_path"].replace("\\", "/") + value["file_name"] + '"><i class="fa fa-file"></i></a>';
    }

    function selectorHandle(type, element, fund) {
        var value = fund[type];
        if (value == null || value == undefined)
            element.text("-");
        else {
            var field = "";
            if (type == "asset_class")
                field = "main_categories";
            else if (type == "sector")
                field = "specialist_sectors";
            else if (type == "geographical_allocation")
                field = "geographical_sectors";

            element.html('<a href="<?= base_url() ?>fund_selector?' + field + '=' + encodeURI(value) + '">' + value + '</a>');
        }

    }

    function historicalIncomeDistributionHandle(element, fund) {
        if (fund.has_historical_income_distribution != 1)
            element.text("-");
        else
            element.html('<a href=""><i class="fa fa-list-alt"></i></a>');
        $('#div-mhid-fund-name').text(fund.fund_name);

        $('a', element).click(function(evt) {
            evt.preventDefault();

            if (!load_historical_income_distribution) {
                showLoading();

                ajaxRequest({
                    url: "<?= base_url() ?>fund_factsheet/_historical_income_distribution",
                    data: {
                        fund: fund.fund_id
                    },
                    method: "get",
                    success: function(json) {
                        var status = json.status;
                        var data = json.data;

                        var tbd_mhid = $('#tbd-mhid');
                        tbd_mhid.html('');
                        if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                            $.each(data.income_distructions, function(index, hid_value) {
                                tbd_mhid.append('<tr>' +
                                    '<td>' + hid_value.distribution_desc + '</td>' +
                                    '<td>' + moment(hid_value.excluding_date, 'YYYY-MM-DD HH:mm:ss.SSS').format('D-MMM-YYYY') + '</td>' +
                                    '<td>' + (hid_value.reinvestment_date != null ? moment(hid_value.reinvestment_date, 'YYYY-MM-DD HH:mm:ss.SSS').format('D-MMM-YYYY') : '-') + '</td>' +
                                    '<td>' + (hid_value.gross_income_dis_rate || '-') + '</td>' +
                                    '<td>' + (hid_value.net_income_dis_rate || '-') + '</td>' +
                                    '</tr>');
                            });
                        }

                        load_historical_income_distribution = true;
                        $("#btn-toggle-modalhistoricalincomedistribution").click();
                        hideLoading();
                    }
                })
            } else
                $("#btn-toggle-modalhistoricalincomedistribution").click();
        });
    }

    function otherFeeHandle(element, fund) {
        if (fund.min_redemption_fee_perc != null || fund.max_redemption_fee_perc != null || fund.switch_fee != null)
            element.html('<a href=""><i class="fa fa-info-circle"></i></a>');
        else
            element.text("-");

        var switchfee = fund.switch_fee;
        var minredemptionfee = fund.min_redemption_fee_perc;
        var maxredemptionfee = fund.max_redemption_fee_perc;

        var html = "";
        if (switchfee != undefined)
            html += "<p>Switch Fee: " + fund.fund_currency + addCommaToNumber(switchfee) + "</p>";

        if (minredemptionfee != undefined && maxredemptionfee != undefined) {
            if (minredemptionfee == maxredemptionfee)
                html += "<p>Redemption Fee: " + addCommaToNumber(minredemptionfee) + "% of the NAV per unit.</p>";
            else
                html += "<p>Redemption Fee: " + addCommaToNumber(minredemptionfee) + "% to " + addCommaToNumber(maxredemptionfee) + "% of the NAV per unit.</p>";
        } else if (minredemptionfee != undefined)
            html += "<p>Redemption Fee: At least " + addCommaToNumber(minredemptionfee) + "% of the NAV per unit.</p>";
        else if (maxredemptionfee != undefined)
            html += "<p>Redemption Fee: Up to " + addCommaToNumber(maxredemptionfee) + "% of the NAV per unit.</p>";

        $('#modal-other-fee-body').html(html);

        $('a', element).click(function(evt) {
            evt.preventDefault();
            $("#btn-toggle-modalotherfee").click();
        });
    }

    function loadChart(chart_fund, chart_fund_name) {
        loading_chart = true;
        ajaxRequest({
            url: '<?= base_url() ?>chart_center/_fund_chart_data',
            data: {
                funds: [chart_fund],
                duration: "3year",
                sma_values: []
            },
            method: 'get',
            success: function(json) {
                var status = json.status;
                var data = json.data;

                // div_chart.removeClass('no-data');

                while (chart.series.length > 0)
                    chart.series[0].remove(true);

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $.each(data.chart_data, function(index, value) {
                        value.name = chart_fund_name;
                        chart.addSeries(value, false);
                    })
                }

                chart.update({
                    xAxis: {
                        min: new Date(data.from).getTime(),
                        max: new Date(data.to).getTime()
                    }
                }, false);

                // if (!(chart && chart.series && chart.series.length > 0))
                //     div_chart.addClass('no-data');

                chart.redraw();

                loading_chart = false;
                if (!loading_chart && !loading_fund_detail && !loading_holiday)
                    hideLoading();
            }
        });
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>