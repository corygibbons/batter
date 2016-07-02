<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <?php

    switch ($invoice['type']) {
        case 'ESTIMATE':
            $number_wording = "estimates:estimatenumber";
            $title_wording = "global:estimate";
            $date_wording = "estimates:estimatedate";
            break;
        case "CREDIT_NOTE":
            $number_wording = "credit_notes:credit_note_number";
            $title_wording = "global:credit_note";
            $date_wording = "credit_notes:credit_note_date";
            break;
        default:
            $number_wording = "invoices:invoicenumber";
            $title_wording = "global:invoice";
            $date_wording = "invoices:invoicedate";
            break;
    }

    $number_wording = __($number_wording, array($invoice['invoice_number']));
    $title_wording = strtoupper(__($title_wording));
    $date_wording = __($date_wording);

    ?>

    <head>

        <?php $frontend_css = function_exists('frontend_css') ? frontend_css() : Settings::get('frontend_css'); ?>
        <?php $frontend_js = function_exists('frontend_js') ? frontend_js() : Settings::get('frontend_js'); ?>

        <title><?php echo $number_wording; ?> | <?php echo Business::getBusinessName(); ?></title>

        <!--metatags-->
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <link rel="mask-icon" href="<?php echo asset::get_src('mask-icon.svg', 'img'); ?>" color="rgb(232,163,75)">

        <script>
            estimateStatusUrl = '<?php echo site_url('ajax/set_estimate/' . $invoice['unique_id']); ?>/';
            is_archived = <?php echo $invoice['is_archived'] ? "true" : "false"; ?>;
        </script>

        <?php echo asset::js('jquery-1.11.0.min.js'); ?>
        <?php
        /*
         * If the current environment is "development", then the dev version of jQuery Migrate will be loaded,
         * which will generate console warnings about everything that needs updating.
         */
        ?>
        <?php echo asset::js('jquery-migrate-1.2.1' . (!IS_DEBUGGING ? '.min' : '') . '.js'); ?>

        <!-- CSS -->
        <?php echo asset::css('invoice.css', array('media' => 'all')); ?>
        <?php echo (asset::get_src('frontend.css', 'css') == "") ? "" : asset::css('frontend.css', array('media' => 'all')); ?>

        <link href='//fonts.googleapis.com/css?family=Cabin:400,700&amp;subset=latin&amp;v2' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Copse&amp;subset=latin&amp;v2' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

        <?php if (Settings::get('use_utf8_font') and $pdf_mode): ?>
            <style>.pdf, .pdf * {
                    font-family: "dejavu sans" !important;
                }</style>
        <?php endif; ?>

        <?php if (!empty($frontend_css)): ?>
            <link rel="stylesheet" href="<?php echo site_url("frontend_css/" . crc32($frontend_css) . '.css'); ?>"/>
        <?php endif; ?>

    </head>

    <body class="detailed-layout <?php echo $invoice['type'] == 'DETAILED' ? 'invoice' : strtolower($invoice['type']); ?> <?php echo logged_in() ? 'admin' : 'not-admin'; ?> <?php if ($pdf_mode): ?>pdf_mode pdf<?php else: ?>not-pdf<?php endif; ?> <?php echo $is_paid ? 'paid' : 'not-paid'; ?>">
        <?php if (!$pdf_mode): ?>
            <div id="buttonBar" data-status="<?php echo $invoice['status']; ?>">

                <div id="buttonHolders">

                    <?php if (logged_in()): ?>
                        <?php echo anchor('admin/invoices/' . (($invoice['type'] !== "DETAILED") ? human_invoice_type($invoice['type']) : 'all'), __('global:admin') . ' &rarr;', 'class="button"'); ?>
                    <?php endif; ?>
                    <?php echo anchor(Settings::get('kitchen_route') . '/' . $client_unique_id, __('global:client_area') . ' &rarr;', 'class="button"'); ?>

                    <?php if ($sendable): ?>
                        <?php echo anchor('admin/' . human_invoice_type($invoice['type']) . '/created/' . $invoice['unique_id'], __('global:send_to_client'), 'class="button"'); ?>
                    <?php endif; ?>

                    <?php if ($editable): ?>
                        <?php echo anchor('admin/' . human_invoice_type($invoice['type']) . '/edit/' . ($invoice['unique_id']), __($invoice['type'] == "DETAILED" ? 'invoices:edit' : (strtolower($invoice['type']) . 's:edit')), 'class="button"'); ?>

                    <?php endif; ?>

                    <div id="pdf">
                        <a href="<?php echo site_url('pdf/' . $invoice['unique_id']); ?>" target="_blank" title="<?php echo __('global:downloadpdf'); ?>" id="download_pdf" class="button"><?php echo __('global:downloadpdf'); ?></a>
                    </div>
                    <!-- /pdf -->
                    <?php $admin_login = logged_in() ? 'admin' : '#'; ?>
                    <?php if ($invoice['type'] === "ESTIMATE"): ?>
                        <?php if ($editable): ?>
                            <?php echo anchor($admin_login, __('global:mark_as_unanswered'), 'class="unanswer button"'); ?>
                            <?php echo anchor($admin_login, __('global:mark_as_accepted'), 'class="admin accept button"'); ?>
                            <?php echo anchor($admin_login, __('global:mark_as_rejected'), 'class="admin reject button"'); ?>
                        <?php else: ?>
                            <?php echo anchor($admin_login, __('global:reject_estimate'), 'class="client reject button"'); ?>
                            <?php echo anchor($admin_login, __('global:accept_estimate'), 'class="client accept button"'); ?>
                        <?php endif; ?>
                        <?php echo anchor($admin_login, __('global:estimate_rejected'), 'class="rejected button"'); ?>
                        <?php echo anchor($admin_login, __('global:estimate_accepted'), 'class="accepted button"'); ?>
                    <?php endif; ?>
                    <?php if (!$is_paid and $invoice['type'] == 'DETAILED' and (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0)) { ?>
                        <div id="paypal">
                            <a href="<?php echo $invoice['partial_payments'][$invoice['next_part_to_pay']]['payment_url']; ?>" class="button">
                                <?php if (count($invoice['partial_payments']) > 1) : ?>
                                    <?php echo __('partial:pay_part_x_now', array($invoice['next_part_to_pay'])); ?>
                                <?php else: ?>
                                    <?php echo __('partial:proceedtopayment') ?>
                                <?php endif; ?>
                            </a>
                        </div><!-- /paypal -->
                    <?php } ?>
                    <?php if ($invoice['type'] === "DETAILED"): ?>
                        <?php if (!$editable): ?>
                            <?php if ($is_paid) : ?>
                                <span class="paidon"><?php echo __('invoices:thisinvoicewaspaidon', array(format_date($invoice['payment_date']))); ?></span>
                            <?php else: ?>
                                <span class="paidon"><?php echo __('invoices:thisinvoiceisunpaid'); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($is_paid) : ?>
                                <span class="paidon"><?php echo __('invoices:paidon', array(format_date($invoice['payment_date']))); ?>.</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <!-- /buttonHolders -->

            </div><!-- /buttonBar -->
            <script>
                $('#buttonBar').each(function () {
                    var status = $(this).data('status');

                    $('.estimate.admin .client.accept, .estimate.admin .client.reject, .estimate.not-admin .admin.accept, .estimate.not-admin .admin.reject, .estimate.not-admin .unanswer.button').hide();

                    if (status == 'ACCEPTED') {
                        $('.accept, .reject, .rejected').hide();
                    } else {
                        if (status == 'REJECTED') {
                            $('.accept, .reject, .accepted').hide();
                        } else {
                            $('.unanswer.button, .rejected, .accepted').hide();
                        }
                    }
                });
            </script>
        <?php endif; ?>
        <div id="wrapper">
            <div id="header">
                <div id="envelope" <?php if (!$pdf_mode): ?> style="padding:60px 0 0 0" <?php endif; ?>>
                    <table cellspacing="0" cellpadding="0" style="padding: 0 0px;">
                        <tr>
                            <td class="invoice-logo" style="text-align:left;vertical-align:<?php echo (Business::getLogo(true, false) != '') ? "top" : "bottom"; ?>;" id="company-info-holder">
                                <?php echo Business::getLogo(false, false, 2, array('use_business_name' => $invoice['type'] != 'ESTIMATE')); ?>
                                <p><?php echo Business::getHtmlEscapedMailingAddress(); ?></p>
                            </td>

                            <td style="text-align:right; vertical-align:top;" class="tight" id="invoice-details-holder">
                                <div id="details-wrap">
                                    <p class="detailed-number"><?php echo $number_wording; ?></p>

                                    <h2><?php echo $title_wording; ?></h2>

                                    <p class="date"><?php echo $date_wording; ?>:
                                        <span><?php echo $invoice['date_entered'] ? format_date($invoice['date_entered']) : '<em>' . __('global:na') . '</em>'; ?></span>
                                    </p>
                                    <?php if ($invoice['type'] === "DETAILED") : ?>
                                        <p class="due-date"><?php echo __('invoices:due'); ?>: <span>
                                                                        <?php if (count($invoice['partial_payments']) == 1) : ?>
                                                                            <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>' . __('global:na') . '</em>'; ?>
                                                                        <?php else: ?>
                                                                            <?php echo __("invoices:see_payment_schedule_below"); ?>
                                                                        <?php endif; ?>
                                                                        </span></p>
                                        <?php if ($invoice['is_paid'] == 1): ?>
                                            <span class="paidon"><?php echo __('invoices:paidon', array(format_date($invoice['payment_date']))); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <!-- /details-wrap -->
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /envelope -->

                <div id="clientInfo">
                    <div id="billing-info">
                        <table cellspacing="0" cellpadding="0" id="billing-table">
                            <tr>
                                <td style="width: 240px; vertical-align:top;">
                                    <h2><?php echo $invoice['company']; ?></h2>

                                    <p><?php echo escape($invoice['first_name'] . ' ' . $invoice['last_name']); ?><br/>
                                        <?php echo escape(nl2br($invoice['address'])); ?></p></td>
                                <td style="width: <?php echo (!$pdf_mode) ? "560px" : "300px" ?>; vertical-align:top;">
                                    <?php if (!empty($invoice['description'])): ?>
                                        <h3><?php echo __('global:description'); ?>:</h3>
                                        <?php echo escape(auto_typography($invoice['description'])); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <br/> <br/>
                    </div>
                </div>
                <!-- /clientInfo -->

            </div>
            <!-- /header -->
            <?php echo $template['body']; ?>
            <div id="footer">

            </div>
            <!-- /footer -->
        </div>
        <!-- /wrapper -->
        <?php if ($invoice['type'] == 'DETAILED'): ?>

            <?php

            // ====================
            // = Remittence slips =
            // ====================

            /*
                If you wish to remove this option delete everyting between

                === PAYMENT SLIP ====

                === END PAYMENT SLIP ===

            */


            ?>

            <?php // 	=== PAYMENT SLIP ====	 ?>

            <?php if ($pdf_mode and Settings::get('include_remittance_slip')): ?>
                <div style="page-break-before: always;"></div>
                <div id="wrapper">
                    <div id="header">
                        <div id="envelope" class="remittance_slip">
                            <table border="0" cellspacing="5" cellpadding="5">
                                <tr>
                                    <td width="400px" class="remittance-notes">
                                        <?php echo nl2br(get_instance()->invoice_m->remittance_slip($invoice)); ?>
                                    </td>
                                    <td width="200px" class="remittance-details">
                                        <p>
                                            <strong><?php echo __('invoices:number') ?>:</strong> <?php echo $invoice['invoice_number']; ?>
                                            <br/>
                                            <strong><?php echo __('invoices:due'); ?>:</strong> <?php echo Currency::format(round($invoice['unpaid_amount'], 2), $invoice['currency_code']); ?>
                                            <br/>
                                            <strong><?php echo __('invoices:due') ?>:</strong>
                                            <?php if (count($invoice['partial_payments']) == 1) : ?>
                                                <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>' . __('global:na') . '</em>'; ?>
                                            <?php else: ?>
                                                <?php echo __("invoices:see_payment_schedule"); ?>
                                            <?php endif; ?>
                                        </p>

                                        <p>
                                            <strong><?php echo __('invoices:mail_to') ?>:</strong><br/><span class='site_name'><?php echo Business::getBusinessName(); ?>
                                                <br/></span><span class="mailing-address"><?php echo Business::getHtmlEscapedMailingAddress(); ?></span>
                                        </p>
                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php // === END PAYMENT SLIP === ?>
        <?php endif; ?>

        <script src="<?php echo asset::get_src('invoices.js', 'js'); ?>"></script>
        <?php if (!empty($frontend_js)): ?>
            <script src="<?php echo site_url("frontend_js/" . crc32($frontend_js) . '.js'); ?>"></script>
        <?php endif; ?>
    </body>
</html>