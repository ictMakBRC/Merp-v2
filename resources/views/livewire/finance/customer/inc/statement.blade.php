<div class="row">
    <div class="col-md-4">
        <div class="form-group select-placeholder">
            <select class="selectpicker" name="range" id="range" data-width="100%"
                onchange="render_customer_statement()">

                <option value='["2024-01-30","2024-01-30"]'>
                    Today </option>
                <option value='["2024-01-29","2024-02-04"]'>
                    This Week</option>
                <option value='["2024-01-01","2024-01-31"]' selected>
                    This Month</option>
                <option value='["2023-12-01","2023-12-31"]'>
                    Last Month</option>
                <option value='["2024-01-01","2024-12-31"]'>
                    This Year</option>
                <option value='["2023-01-01","2023-12-31"]'>
                    Last Year</option>
                <option value="period">Period</option>
            </select>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="text-right _buttons pull-right">

            <a href="#" id="statement_print" target="_blank" class="btn btn-default btn-with-tooltip mright5"
                data-toggle="tooltip" title="Print" data-placement="bottom">
                <i class="fa fa-print"></i>
            </a>

            <a href="" id="statement_pdf" class="btn btn-default btn-with-tooltip mright5" data-toggle="tooltip"
                title="View PDF" data-placement="bottom">
                <i class="fa-regular fa-file-pdf"></i>
            </a>

            <a href="#" class="btn-with-tooltip btn btn-default" data-toggle="modal"
                data-target="#statement_send_to_client"><span data-toggle="tooltip" data-title="Send to Email"
                    data-placement="bottom"><i class="fa-regular fa-envelope"></i></span></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <h4 class="tw-font-semibold tw-mb-0">
            Customer Statement</h4>
    </div>
    <div class="clearfix"></div>

    <div class="col-md-12 mtop15">
        <div class="row">
            <div class="col-md-12">
                <address class="text-right">
                </address>
            </div>
            <div class="col-md-12">
                <hr />
            </div>
            <div class="col-md-7">
                <address>
                    <p>To:</p>
                    <b>{{ $requestable->name }}</b>
                </address>
            </div>
            <div id="statement-html"></div>
        </div>
    </div>
</div>
<div class="modal fade email-template" data-editor-id=".tinymce-1" id="statement_send_to_client" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="" id="send_statement_form" method="post"
            accept-charset="utf-8">
            <input type="hidden" name="csrf_token_name" value="625bf45e77f3eb53ad67721a407af6f4" />
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        Account Summary </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="text-danger">Failed to auto select customer contacts. Make sure that the
                                    customer has active contacts and associated contacts with email notifications for
                                    Invoices enabled.</p>
                                <hr />
                                <div class="select-placeholder form-group" app-field-wrapper="send_to[]"><label
                                        for="send_to[]" class="control-label">Email to</label><select id="send_to[]"
                                        name="send_to[]" class="selectpicker" multiple="1" data-width="100%"
                                        data-none-selected-text="Nothing selected" data-live-search="true"></select>
                                </div>
                            </div>
                            <div class="form-group" app-field-wrapper="cc"><label for="cc"
                                    class="control-label">CC</label><input type="text" id="cc" name="cc"
                                    class="form-control" value=""></div>
                            <hr />
                            <h5 class="bold">Preview Email Template</h5>
                            <hr />
                            <div class="form-group" app-field-wrapper="email_template_custom"><textarea
                                    id="email_template_custom" name="email_template_custom"
                                    class="form-control tinymce-1"
                                    rows="4">Dear {contact_firstname} {contact_lastname}, &lt;br&gt;&lt;br&gt;Its been a great experience working with you.&lt;br&gt;&lt;br&gt;Attached with this email is a list of all transactions for the period between {statement_from} to {statement_to}&lt;br&gt;&lt;br&gt;For your information your account balance due is total:&amp;#160;{statement_balance_due}&lt;br&gt;&lt;br&gt;Please contact us if you need more information.&lt;br&gt; &lt;br&gt;Kind Regards,&lt;br&gt;{email_signature}</textarea>
                            </div>
                            <input type="hidden" name="template_name" value="client-statement" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" autocomplete="off" data-loading-text="Please wait..."
                        class="btn btn-primary">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>