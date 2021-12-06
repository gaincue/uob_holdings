<?php
defined("BASEPATH") or exit("No direct script access allowed");

$template = [
    "view" => "template/vw_core",
    "page_title" => empty($order) ? "Cash Withdrawal" : "Modify Order",
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
            <div class="row pb-2" id="cash_withdrawal_ifa">
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
                <div class="row pb-2 collapse" id="cash_withdrawal_client">
                    <div class="col-md-12">
                        <?php $this->load->view("general/_vw_search_client", [
                            "search_type" => "order",
                        ]); ?>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>

        <div class="row collapse" id="cash_withdrawal_cash_acc_withdrawal">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Cash Account Withdrawal</b></div>
                    <div class="card-body">
                        <?php if (!empty($order)) { ?>
                            <div class="row form-group">
                                <div class="col-md-2"><label class="col-form-label"><b>Order Number</b></label></div>
                                <div class="col-md-4"><label class="col-form-label"><?= $order["order_no"] ?></label></div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Withdrawal Currency</b></label></div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select class="form-control" id="slt-withdrawal-currency">
                                                <option value="">Select Currency</option>
                                            </select>
                                            <span class=" error text-danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Withdrawal Amount</b></label></div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="number" min=1 step=0.01 class="form-control" placeholder="Enter Amount" id="ipt-withdrawal-amount">
                                            <span class=" error text-danger">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Receive Currency</b></label></div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select class="form-control" id="slt-receive-currency">
                                                <option value="">Select Currency</option>
                                            </select>
                                            <span class=" error text-danger">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Amount</b></label></div>
                                    <div class="col-md-8"><label class="col-form-label" id="l-net-amount">-</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Interest Earned</b></label></div>
                                    <div class="col-md-8"><label class="col-form-label" id="l-interest">-</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><label class="col-form-label"><b>Overdue Amount</b></label></div>
                                    <div class="col-md-8"><label class="col-form-label" id="l-overdue">-</label></div>
                                </div>
                                <div class="row" id="div-wrap-fee">
                                    <div class="col-md-4"><label class="col-form-label"><b>Wrap Fee</b></label></div>
                                    <div class="col-md-8"><label class="col-form-label" id="l-wrap-fee">-</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-danger" data-target="#modal_password" data-toggle="modal">
                                    <?= empty($order) ? "Withdraw" : "Save" ?>
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
    var client_code, ifa_code, wrap_fee = 0,
        validate_ajax, has_changed_withdraw_currency = false;

    autoHideLoadingOnInit = false;
    window.addEventListener("DOMContentLoaded", function() {
        $('#slt-withdrawal-currency').change(function() {
            has_changed_withdraw_currency = true;
            var $this = $(this);
            var value = $this.val();
            if (value != '') {
                showLoading();

                var selectedOption = $('option:selected', $this);
                var l_interest = $('#l-interest');

                // $('#l-gross-amount').text(value + " " + parseFloat(selectedOption.data('grossamount')).toFixed(2));
                $('#l-net-amount').text(value + " " + addCommaToNumber(selectedOption.data('netamount')));
                $('#l-overdue').text(value + " " + addCommaToNumber(selectedOption.data('overdue')));
                $('#l-wrap-fee').text("MYR" + " " + addCommaToNumber(wrap_fee));
                l_interest.text('-');

                ajaxRequest({
                    url: "<?= base_url() ?>cash_withdrawal/_interest",
                    data: {
                        <?php if (!empty($order)) { ?>
                            order_no: '<?= $order["order_no"] ?>',
                        <?php } else { ?>
                            client_code: client_code,
                            ifa_code: ifa_code,
                        <?php } ?>
                        currency: value,
                    },
                    method: "get",
                    success: function(json) {
                        var status = json.status;
                        var data = json.data;

                        if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                            l_interest.text(value + " " + addCommaToNumber(parseFloat(data.interest).toFixed(2)));
                        }
                        realtimeValidation($this);
                        hideLoading();
                    }
                })
            } else {
                // $('#l-gross-amount').text('-');
                $('#l-net-amount').text(addCommaToNumber('-'));
                $('#l-interest').text(addCommaToNumber('-'));
                $('#l-overdue').text(addCommaToNumber('-'));
                $('#l-wrap-fee').text(addCommaToNumber('-'));
                realtimeValidation($this);
            }
        });

        $(document).on('blur', '#slt-withdrawal-currency', function(e) {
            if (!has_changed_withdraw_currency) {
                realtimeValidation($(this));
            }
            has_changed_withdraw_currency = false;
        });

        $(document).on('blur', '#ipt-withdrawal-amount, #slt-receive-currency', function(e) {
            realtimeValidation($(this));
        });

        <?php if (!empty($order)) { ?>
            $("#cash_withdrawal_cash_acc_withdrawal").collapse('show');

            getOptions("");
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
                                    $("#cash_withdrawal_client").collapse("show");
                                else
                                    $("#cash_withdrawal_client").collapse("hide");
                            })
                        } else {
                            $("#cash_withdrawal_ifa").remove();
                            $("#cash_withdrawal_client").collapse("show");
                        }
                    }

                    hideLoading();
                }
            })
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

    function realtimeValidation(element) {
        if (validate_ajax != undefined) {
            validate_ajax.abort();
            validate_ajax = undefined;
        }

        let $this = element;
        let slt_withdraw_currency = $("#slt-withdrawal-currency");
        let slt_receive_currency = $("#slt-receive-currency");
        let ipt_amount = $("#ipt-withdrawal-amount");
        let data = {
            <?php if (!empty($order)) { ?>
                order_no: '<?= $order["order_no"] ?>',
            <?php } else { ?>
                client_code: client_code,
                ifa_code: ifa_code,
            <?php } ?> "currency": slt_withdraw_currency.val(),
            "amount": ipt_amount.val(),
            "receive_currency": slt_receive_currency.val()
        }

        validate_ajax = ajaxRequest({
            url: "<?= base_url() ?>transaction/_validate_order/cash_withdraw",
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
                        if ($this.attr("id") == "ipt-withdrawal-amount") {
                            errorMessage = withdrawError["amount"];
                        } else if ($this.attr("id") == "slt-withdrawal-currency") {
                            errorMessage = withdrawError["currency"];
                        } else if ($this.attr("id") == "slt-receive-currency") {
                            errorMessage = withdrawError["receive_currency"];
                        }
                        toggleErrorMessage(errorMessage, $this);

                        if (slt_withdraw_currency.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["currency"], slt_withdraw_currency);
                        }
                        if (slt_receive_currency.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["receive_currency"], slt_receive_currency);
                        }
                        if (ipt_amount.hasClass("form-control-error")) {
                            toggleErrorMessage(withdrawError["amount"], ipt_amount);
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

    function init_search_client() {
        $('#cash_withdrawal_cash_acc_withdrawal').collapse('hide');
    }

    function select_client_handle(element) {
        showLoading();

        var iswrap = element.data("iswrap") == '1';

        if (iswrap)
            $('#div-wrap-fee').show();
        else
            $('#div-wrap-fee').hide();

        // $('#l-gross-amount').text('-');
        $('#l-net-amount').text('-');
        $('#l-interest').text('-');
        $('#l-overdue').text('-');
        $('#l-wrap-fee').text('-');
        $('#ipt-withdrawal-amount').val('');
        $('#slt-withdrawal-currency option').not(':first').remove();
        $('#slt-receive-currency option').not(':first').remove();

        client_code = element.data("clientcode");
        getOptions(client_code);
    }

    function getOptions(client_code) {
        showLoading();

        ajaxRequest({
            url: "<?= base_url() ?>cash_withdrawal/_options",
            data: {
                <?php if (!empty($order)) { ?>
                    order_no: '<?= $order["order_no"] ?>',
                <?php } else { ?>
                    client_code: client_code,
                    ifa_code: ifa_code,
                <?php } ?>
            },
            method: "get",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                $(document).ready(
                    function() {
                        $('#slt-withdrawal-currency option[value = "MYR"]').insertBefore('#slt-withdrawal-currency option:eq(1)');
                    }
                );

                var slt_withdrawal_currency = $("#slt-withdrawal-currency");
                var slt_receive_currency = $("#slt-receive-currency");
                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $.each(data.balances, function(index, value) {
                        slt_withdrawal_currency.append("<option value=\"" + value.currency + "\" data-grossamount=\"" + value.gross_amount + "\" data-netamount=\"" + value.net_amount + "\" data-overdue=\"" + value.overdue + "\">" + value.currency + "</option>");
                    });
                    $.each(data.receive_currencies, function(index, value) {
                        slt_receive_currency.append("<option value=\"" + value.Code + "\">" + value.Code + "</option>");
                    })
                    wrap_fee = data.wrap_fee || 0;
                }

                <?php if (!empty($order)) { ?>
                    slt_withdrawal_currency.val('<?= $order["withdraw_curr_code"] ?>')
                    slt_receive_currency.val('<?= $order["payment_curr_code"] ?>')
                    $("#ipt-withdrawal-amount").val('<?= $order["amount"] ?>')

                    slt_withdrawal_currency.trigger("change");
                <?php } else { ?>
                    $("#cash_withdrawal_cash_acc_withdrawal").collapse('show');
                    hideLoading();
                <?php } ?>
            }
        })
    }

    function submit_password(password) {
        showLoading();

        var client_code = $('#client_acc_num').data("clientcode");
        var currency = $('#slt-withdrawal-currency').val();
        var receive_currency = $('#slt-receive-currency').val();
        var amount = $("#ipt-withdrawal-amount").val();

        ajaxRequest({
            url: "<?= base_url() ?>cash_withdrawal/<?= !empty($order) ? "_edit" : "_add" ?>",
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
                receive_currency: receive_currency,
            },
            method: "post",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    alert("Cash withdrawal <?= empty($order) ? "created" : "update" ?> successfully");
                    <?php if (!empty($order)) { ?>
                        window.location = "<?= base_url() ?>transaction/amendment";
                    <?php } else { ?>
                        location.reload();
                    <?php } ?>
                } else {
                    alert(JSON.stringify(data));
                    hideLoading();
                }
            }
        });
    }
</script>
<?php $template["footer"] = ob_get_clean(); ?>

<?= json_encode($template) ?>