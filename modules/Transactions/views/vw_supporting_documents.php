<?php
defined('BASEPATH') or exit('No direct script access allowed');

$template = [
    'view' => 'template/vw_core',
    'page_title' => 'Upload Supporting Document',
];

/*
 * ---------
 *  CONTENT
 * ---------
 */
ob_start();
?>

<!-- custom params to quick access user -->
<?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si']) && isset($_GET['clientname']) && isset($_GET['clienttype'])) { ?>
    <script>
        var paramClientCode = "<?php echo $_GET['clientcode']; ?>"
        var paramIsWrap = "<?php echo $_GET['iswrap']; ?>"
        var paramSi = "<?php echo $_GET['si']; ?>"
        var paramClientName = "<?php echo $_GET['clientname']; ?>"
        var paramClientType = "<?php echo $_GET['clienttype']; ?>"
    </script>
<?php } else { ?>
    <script>
        var paramClientCode = null
        var paramIsWrap = null
        var paramSi = null
        var paramClientName = null
        var paramClientType = null
    </script>
<?php } ?>


<div class="py-5">
    <div class="container">
        <div class="row pb-2" id="div-ifa">
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

        <?php if (isset($_GET['clientcode']) && isset($_GET['iswrap']) && isset($_GET['si']) && isset($_GET['clientname']) && isset($_GET['clienttype'])) { ?>
            <!-- hide search if these are set -->
            <div class="pt-2 collapse show" id="div-client-information-preload">
                <div class="card">
                    <div class="card-header"><b>Client Information</b></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label">
                                    <b>Account No</b>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_acc_num">
                                        <?php echo $_GET['clientcode']; ?>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">
                                    <b>Client Name</b>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_name">
                                        <?php echo urldecode($_GET['clientname']); ?>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="col-form-label"><b>Account Type</b></label>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">
                                    <div id="client_acc_type">
                                        <?php
                                        if ($_GET['iswrap'] == 1) {
                                            echo "Wrap ", $_GET['clienttype'];
                                        } else {
                                            echo $_GET['clienttype'];
                                        }
                                        ?>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row collapse" id="div-client">
                <div class="col-md-12">
                    <?php $this->load->view("general/_vw_search_client", ["search_type" => "order"]); ?>
                </div>
            </div>
        <?php } ?>

        <div class="row pt-2 collapse" id="div-supporting-documents">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Supporting Documents</b></div>
                    <div class="card-body">
                        <div>
                            <label>Browse</label>
                            <div class="wrap-FormInput validate-input">
                                <input id='ipt-files' class="FormInput" type="file" style="opacity: 0;" name="files" data-url="<?= base_url() ?>file/upload" multiple>
                                <span class="focus-FormInput"></span>
                                <label class="label-FormInput" for="ipt-files">
                                    <span class="lnr lnr-file-add m-b-2"></span>
                                </label>
                            </div>
                            <div>
                                <i>Supported File Type: png, jpg, jpeg, pdf</i>
                            </div>
                            <div>
                                <i>Maximum File Size: 10mb</i>
                            </div>
                            <div id="div-progress" class="progress" style="display: none;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                            <br>

                            <label>Files</label>
                            <div id="div-results"></div>
                            <br>

                            <button class="btn btn-danger" id="btn-clear">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2 collapse" id="div-order">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Cash Deposit</b></div>
                    <div class="card-body table-responsive">
                        <table id="transaction_tbl" class="table table-striped table-borderless display">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Order Status</th>
                                    <th scope="col">Document</th>
                                    <th scope="col">Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2 collapse" id="div-remark">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><b>Remark</b></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wrap-FormInput wrap-FormInput-WithoutLabel validate-input">
                                    <textarea id="ta-remark" class="FormInput" style="min-height: 300px;"></textarea>
                                    <span class="focus-FormInput"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-12 text-right">
                                <!-- <button class="btn btn-danger">Print</button> -->
                                <button class="btn btn-danger" data-target="#modal_password" data-toggle="modal">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button id="btn-osd-doc-modal-info" style="display:none" data-target='#osd_doc_modal_info' data-toggle="modal"></button>
<div class="modal" id="osd_doc_modal_info" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Order ID
                    <div id="modal_order_id"></div>
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="order_no">

                <div id="div-supp-doc">
                    <h5>Supporting Document</h5>
                    <table id="tbl_supp_doc" class=" table">

                        <thead>
                            <tr>
                                <th>Uploaded At</th>
                                <th>File Name</th>
                                <th>Remark</th>
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

<?php $this->load->view("order/_vw_password") ?>
<?php $this->load->view('template/_loading'); ?>
<?php
$template['content'] = ob_get_clean();

/*
 * --------
 *  HEADER
 * --------
 */
ob_start();
?>
<style>
    .bar {
        height: 5px;
        background: green;
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
<script defer src="<?= base_url() ?>assets/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script defer src="<?= base_url() ?>assets/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script defer src="<?= base_url() ?>assets/jquery-file-upload/js/jquery.fileupload.js"></script>

<script>
    autoHideLoadingOnInit = false;

    var order_tbl, uploadDatas = new Array(),
        uploadIndex = 0,
        ifa_code;
    window.addEventListener("DOMContentLoaded", function() {
        order_tbl = $("#transaction_tbl").DataTable({
            "bPaginate": true, // Show paging
            "searching": false, // Show Search
            "info": true, // Show Info
            "fixedHeader": false, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">',
            "columnDefs": [{
                className: 'mdl-data-table__cell--non-numeric'
            }],
            "aoColumnDefs": [{
                bSortable: false,
                aTargets: [0]
            }],
            "createdRow": function(row, data, dataIndex) {
                $('#view_osd_document_detail', row).click(function() {
                    var $this = $(this);
                    getUploadedDocumentDetails(
                        $this.data("orderno"),
                    );
                });
            }
        });

        tbl_supp_doc = $("#tbl_supp_doc").DataTable({
            "bPaginate": true, // Show paging
            "searching": false, // Show Search
            "info": false, // Show Info
            "fixedHeader": true, // Fix header
            "dom": '<"top"i>rt<"bottom"flp><"clear">'
        });

        $('#btn-clear').click(function() {
            $('#div-results').html('');
        });

        $('#ipt-files').fileupload({
            dataType: 'json',
            sequentialUploads: true,
            submit: function(e, data) {
                data.formData = uploadFormData();
            },
            add: function(e, data) {
                uploadDatas.push(data);
                if (uploadIndex == 0) {
                    uploadIndex++;
                    data.submit();
                }
            },
            change: function(e, data) {
                $(this).prop('disabled', true);
                $('#div-progress').show();
                uploadIndex = 0;
                uploadDatas = new Array();
            },
            done: function(e, data) {
                if (data.result.status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    var div_input = $('<div class="div-supporting-document-file" data-value="' + data.result.data.file_name + '"></div>');
                    div_input.append('<i class="fa fa-trash-o fa-fw pr-3"></i>');
                    div_input.append('<label>' + data.files[0].name + '</label>');
                    $('.fa-trash-o', div_input).click(function() {
                        div_input.remove();
                    });
                    $('#div-results').append(div_input);
                } else {
                    alert(JSON.stringify(data.result))
                }

                var d = uploadDatas[uploadIndex++];
                if (d != undefined)
                    d.submit();
                else {
                    $(this).prop('disabled', false);
                    $('#div-progress').hide();
                }
            }
        })

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
                                $("#div-client").collapse("show");
                            else
                                $("#div-client").collapse("hide");
                        })
                    } else {
                        $("#div-ifa").remove();
                        $("#div-client").collapse("show");
                    }
                }

                hideLoading();
            }
        })

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

    function init_search_client() {
        $('#div-order, #div-remark, #div-supporting-documents').collapse('hide');
    }

    function select_client_handle(element) {
        showLoading();

        $('#div-order, #div-remark, #div-supporting-documents').collapse('show');
        order_tbl.clear();
        var client_code = element.data('clientcode');
        ajaxRequest({
            url: '<?= base_url() ?>transaction/supporting_document/_list',
            data: {
                client_code: client_code,
                ifa_code: ifa_code
            },
            method: 'get',
            success: function(json) {
                var status = json.status;
                var data = json.data;

                console.log(data)
                if (status == <?= RESPONSE_STATUS_SUCCESS ?>) {
                    $.each(data.orders, function(index, value) {

                        var view_osd_document_detail = "<button type=\"button\" id='view_osd_document_detail' data-orderno=\"" + value.order_no + "\"  aria-expanded=\"true\" class=\"btn btn-danger\">View</button>";


                        order_tbl.row.add([
                            '<input type="checkbox" class="ipt-checkbox" value="' + value.order_no + '" />',
                            value.client_name,
                            value.client_code_label,
                            value.order_no,
                            value.payment_curr_code + " " + addCommaToNumber(value.amount),
                            value.workflow_description,
                            view_osd_document_detail,
                            value.order_date
                        ]);
                    });
                }
                order_tbl.draw();

                hideLoading();
            }
        })
    }

    function submit_password(password) {
        showLoading();

        var client_code = $('#client_acc_num').data("clientcode");
        var orders = new Array();
        var files = new Array();
        var ic = $('.ipt-checkbox:checked');
        if (ic.length > 0) {
            ic.each(function() {
                orders.push($(this).val());
            });
        }
        var dsdp = $('.div-supporting-document-file');
        if (dsdp.length > 0) {
            dsdp.each(function() {
                files.push($(this).data('value'));
            });
        }

        ajaxRequest({
            url: '<?= base_url() ?>transaction/supporting_document/_upload',
            data: {
                password: password,
                client_code: client_code,
                orders: orders,
                files: files,
                remark: $("#ta-remark").val(),
                ifa_code: ifa_code
            },
            method: "post",
            success: function(json) {
                var status = json.status;
                var data = json.data;

                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        alert("Supporting document uploaded successfully");
                        location.reload();
                        return;
                    default:
                        alert(JSON.stringify(data));
                }
                hideLoading();
            }
        });
    }

    function getUploadedDocumentDetails(orderId) {
        showLoading();
        $("#modal_order_id").text(orderId);

        ajaxRequest({
            url: "<?= base_url() ?>" + "order/_detail",
            data: data = {
                "order_no": orderId
            },
            method: "get",
            success: function(json) {
                var errorMessage = "No Transaction Available.";
                var status = json.status;
                var data = json.data;
                switch (status) {
                    case <?= RESPONSE_STATUS_SUCCESS ?>:
                        $('#btn-osd-doc-modal-info').click();
                        tbl_supp_doc.clear().draw();
                        var order_elements = data['order'];
                        $.each(order_elements['supp_docs'], function(i, file) {
                            tbl_supp_doc.row.add([
                                file['uploaded_date'],
                                '<a href="<?= base_url() ?>file?f=' + file['file_path'] + file['file_name'] + '" target="_blank">' + file['file_name'] + '</a>',
                                file['osd_remark'] || '-'
                            ])
                        })

                        tbl_supp_doc.draw();
                        break;
                }

                hideLoading();
            }
        });
    }
</script>
<?php $template['footer'] = ob_get_clean(); ?>

<?= json_encode($template); ?>