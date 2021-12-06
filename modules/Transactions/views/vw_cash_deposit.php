<?php
defined("BASEPATH") or exit("No direct script access allowed");

$template = [
    "view" => "template/vw_core",
    "page_title" => empty($order) ? "Cash Deposit" : "Modify Order",
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>

<!-- custom params to quick access user -->
<?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si'])) { ?>
    <script>
        var paramClientCode = "<?php echo $_GET['clientcode']; ?>"
        var paramIsWrap = "<?php echo $_GET['iswrap']; ?>"
        var paramSi = "<?php echo $_GET['si']; ?>"
    </script>
<?php } else { ?>
    <script>
        var paramClientCode = null
        var paramIsWrap = null
        var paramSi = null
    </script>
<?php } ?>

<div class="py-5">
    <div class="container">
        <?php if (empty($order)) { ?>
            <div class="row pb-2" id="cash_deposit_ifa">
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

            <?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si'])) { ?>
                <!-- hide search if these are set -->
            <?php } else { ?>
                <div class="row pb-2 collapse" id="cash_deposit_client">
                    <div class="col-md-12">
                        <?php $this->load->view("general/_vw_search_client", [
                            "search_type" => "order",
                        ]); ?>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>

        <div class="row collapse" id="cash_deposit_cash_acc_deposit">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Cash Account Deposit</b></div>
                    <div class="card-body">
                        <?php if (!empty($order)) { ?>
                            <div class="row form-group">
                                <div class="col-md-2"><label class="col-form-label"><b>Order Number</b></label></div>
                                <div class="col-md-4"><label class="col-form-label"><?= $order["order_no"] ?></label></div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-2"><label class="col-form-label"><b>Deposit Method</b></label></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select id="slt-deposit-method" class="form-control">
                                        <option value="">Select Deposit Method</option>
                                    </select>
                                    <span class=" error text-danger">
                                </div>
                            </div>
                            <div class="col-md-2"><label class="col-form-label"><b>Deposit Currency</b></label></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="slt-deposit-currency">
                                        <option value="">Select Currency</option>
                                    </select>
                                    <span class=" error text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><label class="col-form-label"><b>Deposit Amount</b></label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="ipt-amount" class="form-control" placeholder="Enter Deposit Amount">
                                    <span class=" error text-danger">
                                </div>
                            </div>
                            <div class="col-md-2"><b>Sales Charge</b></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="ipt-sale-charge" type="text" class="form-control" placeholder="Enter Sales Charge">
                                    <span class=" error text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><label class="col-form-label"><b>UOB Kay Hian Account</b></label></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="slt-bank">
                                        <option value="">Select Bank</option>
                                    </select>
                                    <span class=" error text-danger">
                                </div>
                            </div>
                            <div class="col-md-2"><label class="col-form-label"><b>Bank Branch</b></label></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="slt-bank-branch">
                                        <option value="">Select Bank Branch</option>
                                    </select>
                                    <span class=" error text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><b>Cheque Number</b></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Cheque Number" id="ipt-cheque-number">
                                    <span class=" error text-danger">
                                </div>
                            </div>
                            <div class="col-md-2"><label class="col-form-label"><b>Cheque Date</b></label></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Enter Cheque Date" id="ipt-cheque-date" data-select="datepicker" />
                                    <span class=" error text-danger">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-danger" data-target="#modal_password" data-toggle="modal">
                                    <?= empty($order) ? "Deposit" : "Save" ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("order/_vw_password"); ?>
<?php $this->load->view("template/_loading"); ?>
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

    var bankBranches, branch, ifa_code, client_code, validate_ajax;
    window.addEventListener("DOMContentLoaded", function() {
        var loadingOptions = true,
            loadingElements = true;
        ajaxRequest({
            url: "<?= base_url() ?>cash_deposit/_options",
            data: {},
            method: "get",
            success: function(json) {
                var status = json.status;
                var data = json.data;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        var slt_deposit_method = $('#slt-deposit-method');
                        $.each(data.deposit_methods, function(index, value) {
                            slt_deposit_method.append("<option value=\"" + value.payment_mode_code + "\">" + value.payment_mode_name + "</option>")
                        });
                        break;
                }

                <?php if (empty($order)) { ?>
                    loadingOptions = false;
                    if (!loadingOptions && !loadingElements)
                    <?php } ?>
                    init();
            }
        })

        $('#slt-bank').change(function() {
            var value = $(this).val();

            if (value != "") {
                var slt_bank = $('#slt-bank-branch');
                $('option:not(:first-child)', slt_bank).remove();
                $.each(bankBranches[value], function(index, value) {
                    slt_bank.append("<option value=\"" + value.bank_subcode + "\">" + value.description + "</option>")
                });
            }
        });

        $('#slt-deposit-method').change(function() {
            inputControl($(this));
        })

        $("#slt-deposit-method, #slt-deposit-currency, #ipt-amount, #ipt-sale-charge, #slt-bank, #slt-bank-branch, #ipt-cheque-number").on('blur', function() {
            realtimeValidation($(this));
        })
        $("#ipt-cheque-date").on('change', function() {
            realtimeValidation($(this))
        });
        $("#ipt-cheque-date").on('click', function() {
            var $this = $(this);
            var val = $this.val();
            var date = val ? $.datePicker.defaults.dateParse(val) : null;
            var widget = $.datePicker.api.show({
                views: {
                    month: {
                        show: val ? date : '',
                        selected: val ? [date] : []
                    }
                },
                element: $this,
                callbacks: {
                    onHide: function() {
                        realtimeValidation($this)
                    }
                }
            });
            $this.data('widget', widget);
        });

        <?php if (!empty($order)) { ?>
            $("#cash_deposit_cash_acc_deposit").collapse('show');
        <?php } else { ?>
            ajaxRequest({
                url: "<?= base_url() ?>transaction/_elements",
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
                                    $("#cash_deposit_client").collapse("show");
                                else
                                    $("#cash_deposit_client").collapse("hide");
                            })
                        } else {
                            $("#cash_deposit_ifa").remove();
                            $("#cash_deposit_client").collapse("show");
                        }
                    }

                    loadingElements = false;
                    if (!loadingOptions && !loadingElements)
                        init();
                }
            })

            // inputControl($('#slt-deposit-method'));
        <?php } ?>

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

    function init() {
        hideLoading();
        <?php if (!empty($order)) { ?>
            $("#slt-deposit-method").val('<?= $order["payment_mode_code"] ?>')
            $("#ipt-amount").val('<?= $order["amount"] ?>')
            $("#ipt-sale-charge").val('<?= $order["percentage"] ?>')
            $("#ipt-cheque-number").val('<?= $order["cheque_no"] ?? "" ?>')
            $("#ipt-cheque-date").val('<?= !empty($order["cheque_date"])
                                            ? date_format(
                                                date_create_from_format(
                                                    "Y-m-d H:i:s.u",
                                                    $order["cheque_date"] . "000"
                                                ),
                                                "d / m / Y"
                                            )
                                            : "" ?>')

            inputControl($('#slt-deposit-method'), function() {
                $("#slt-deposit-currency").val('<?= $order["payment_curr_code"] ?>')
                $("#slt-bank").val('<?= $order["bank_code"] ?? "" ?>');
                $("#slt-bank").trigger("change")
                $("#slt-bank-branch").val('<?= $order["bank_subcode"] ?? "" ?>')
            });
        <?php } ?>
    }

    function inputControl(element, ajaxCallback = undefined) {
        var slt_currency = $('#slt-deposit-currency');

        var value = element.val();

        if (value != "") {
            var not_require_bank = value == '<?= PAYMENT_MODE_FPX ?>';
            var slt_bank = $('#slt-bank, #slt-bank-branch');
            slt_bank.prop('disabled', not_require_bank);

            if (not_require_bank)
                slt_bank.val('');

            var ipt_cheque_details = $('#ipt-cheque-number, #ipt-cheque-date');
            var not_require_cheque = value != '<?= PAYMENT_MODE_CHEQUE ?>';
            ipt_cheque_details.prop('disabled', not_require_cheque);
            if (not_require_cheque)
                ipt_cheque_details.val('');

            if (value == '<?= PAYMENT_MODE_FPX ?>')
                slt_currency.val('MYR');

            getPaymentMethodOptions(value, ajaxCallback);
        }
        var options = $('> option:not([value="MYR"]):not(:first)', slt_currency);
        if (value == "<?= PAYMENT_MODE_FPX ?>")
            options.hide();
        else
            options.show();
    }

    function getPaymentMethodOptions(paymentMethod, ajaxCallback = undefined) {
        showLoading();
        bankBranches = {};
        var slt_bank = $('#slt-bank');
        var slt_deposit_currency = $('#slt-deposit-currency');
        $('option:not(:first-child)', slt_bank).remove();
        $('option:not(:first-child)', slt_deposit_currency).remove();

        ajaxRequest({
            url: "<?= base_url() ?>cash_deposit/payment_method/_options",
            method: "post",
            data: {
                payment_method: paymentMethod,
                branch: branch
            },
            success: function(json) {
                var status = json.status;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    var data = json.data;
                    $.each(data.banks, function(index, value) {
                        bankBranches[value.bank_code] = value.branches;
                        slt_bank.append("<option value=\"" + value.bank_code + "\">" + value.bank_name + "</option>")
                    });

                    $.each(data.currencies, function(index, value) {
                        slt_deposit_currency.append("<option value=\"" + value.Code + "\">" + value.Code + "</option>")

                    });
                    $('#slt-deposit-currency option[value = "MYR"]').insertBefore('#slt-deposit-currency option:eq(1)');
                }

                if (ajaxCallback) {
                    ajaxCallback();
                }

                hideLoading();
            }
        })
    }

    function realtimeValidation(element) {
        if (validate_ajax != undefined) {
            validate_ajax.abort();
            validate_ajax = undefined;
        }

        let $this = element;
        let slt_deposit_method = $("#slt-deposit-method");
        let slt_currency = $("#slt-deposit-currency");
        let ipt_amount = $("#ipt-amount");
        let ipt_sale_charge = $("#ipt-sale-charge");
        let slt_bank = $("#slt-bank");
        let slt_bank_branch = $("#slt-bank-branch");
        let ipt_cheque_number = $("#ipt-cheque-number");
        let ipt_cheque_date = $("#ipt-cheque-date");
        let data = {
            <?php if (!empty($order)) { ?>
                order_no: '<?= $order["order_no"] ?>',
            <?php } else { ?>
                client_code: client_code,
                ifa_code: ifa_code,
            <?php } ?> "currency": slt_currency.val(),
            "amount": ipt_amount.val(),
            "sales_charge": ipt_sale_charge.val(),
            "payment_method": slt_deposit_method.val(),
            "bank": slt_bank.val(),
            "bank_branch": slt_bank_branch.val(),
            "cheque_number": ipt_cheque_number.val(),
            "cheque_date": ipt_cheque_date.val()
        }

        validate_ajax = ajaxRequest({
            url: "<?= base_url() ?>transaction/_validate_order/cash_deposit",
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
                        let withdrawError = data.msg;
                        var errorMessage = undefined;
                        if ($this.attr("id") == "slt-deposit-method") {
                            errorMessage = withdrawError["payment_method"];
                        } else if ($this.attr("id") == "slt-deposit-currency") {
                            errorMessage = withdrawError["currency"];
                        } else if ($this.attr("id") == "ipt-amount") {
                            errorMessage = withdrawError["amount"];
                        } else if ($this.attr("id") == "ipt-sale-charge") {
                            errorMessage = withdrawError["sales_charge"];
                        } else if ($this.attr("id") == "slt-bank") {
                            errorMessage = withdrawError["bank"];
                        } else if ($this.attr("id") == "slt-bank-branch") {
                            errorMessage = withdrawError["bank_branch"];
                        } else if ($this.attr("id") == "ipt-cheque-number") {
                            errorMessage = withdrawError["cheque_number"];
                        } else if ($this.attr("id") == "ipt-cheque-date") {
                            errorMessage = withdrawError["cheque_date"];
                        }

                        toggleErrorMessage(errorMessage, $this);

                        if (slt_deposit_method.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["payment_method"], slt_deposit_method);
                        }
                        if (slt_currency.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["currency"], slt_currency);
                        }
                        if (ipt_amount.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["amount"], ipt_amount);
                        }
                        if (ipt_sale_charge.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["sales_charge"], ipt_sale_charge);
                        }
                        if (slt_bank.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["bank"], slt_bank);
                        }
                        if (slt_bank_branch.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["bank_branch"], slt_bank_branch);
                        }
                        if (ipt_cheque_number.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["cheque_number"], ipt_cheque_number);
                        }
                        if (ipt_cheque_date.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["cheque_date"], ipt_cheque_date);
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

    <?php if (empty($order)) { ?>

        function init_search_client() {
            $('#cash_deposit_cash_acc_deposit').collapse('hide');
        }

        function select_client_handle(element) {
            client_code = element.data("clientcode");
            branch = element.data('branch');
            var is_wrap = element.data('iswrap') == 1;
            var ipt_sale_charge = $('#ipt-sale-charge');
            ipt_sale_charge.prop("disabled", !is_wrap);
            if (is_wrap)
                ipt_sale_charge.val('');

            $("#cash_deposit_cash_acc_deposit").collapse('show');
        }
    <?php } ?>

    function submit_password(password) {
        showLoading();

        var client_code = $('#client_acc_num').data("clientcode");
        var currency = $('#slt-deposit-currency').val();
        var amount = $('#ipt-amount').val();
        var sale_charge = $('#ipt-sale-charge').val();
        var method = $('#slt-deposit-method').val();
        var bank = $('#slt-bank').val();
        var bank_branch = $('#slt-bank-branch').val();
        var cheque_number = $('#ipt-cheque-number').val();
        var cheque_date = $('#ipt-cheque-date').val();

        ajaxRequest({
            url: '<?= base_url() ?>cash_deposit/<?= empty($order) ? "_add" : "_edit" ?>',
            data: {
                <?php if (!empty($order)) { ?>
                    order_no: '<?= $order["order_no"] ?>',
                <?php } else { ?>
                    client_code: client_code,
                    ifa_code: ifa_code,
                <?php } ?>
                password: password,
                currency: currency,
                amount: amount,
                sales_charge: sale_charge,
                payment_method: method,
                bank: bank,
                bank_branch: bank_branch,
                cheque_number: cheque_number,
                cheque_date: cheque_date
            },
            method: "post",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        alert("Cash deposit <?= empty($order) ? "created" : "update" ?> successfully");
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