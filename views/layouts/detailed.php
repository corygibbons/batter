<!DOCTYPE html>

<head>

    <title><?php echo __($invoice['type'] == 'ESTIMATE' ? 'estimates:estimatenumber' : 'invoices:invoicenumber', array($invoice['invoice_number']));?> | <?php echo Settings::get('site_name'); ?></title>

    <!--favicon-->
    <link rel="shortcut icon" href="" />

    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />



    <!-- Grab Google CDN's jQuery and jQuery UI, with a protocol relative URL; fall back to local if necessary -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo asset::get_src('jquery.min.js', 'js');?>">\x3C/script>')</script>

    <!-- CSS -->
    <?php echo asset::css('invoice.css', array('media' => 'all'), NULL, $pdf_mode); ?>

    
    <?php if (Settings::get('frontend_css')): ?>
    	<style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>

</head>




<body class="<?php echo $invoice['type'] == 'ESTIMATE' ? 'estimate' : 'invoice'; ?> <?php echo logged_in() ? 'admin' : 'not-admin';?> <?php if ($pdf_mode): ?>pdf_mode pdf<?php else: ?>not-pdf<?php endif;?>">




<?php if( ! $pdf_mode): ?>


    <?php if (logged_in()): ?>
        <?php echo anchor('admin/invoices/'.(($is_estimate) ? 'estimates' : 'all'), 'Admin &rarr;', 'class="button"'); ?>
    <?php endif; ?>

    <?php echo anchor(Settings::get('kitchen_route').'/'.$client_unique_id, 'Client Area &rarr;', 'class="button"'); ?>

    <?php if ($sendable): ?>
        <?php echo anchor('admin/'.($invoice['type'] == "ESTIMATE" ? 'estimates' : 'invoices').'/created/'.$invoice['unique_id'], 'Send to client', 'class="button"'); ?>
    <?php endif;?>
                        
    <?php if ($editable): ?>
        <?php echo anchor('admin/'.($invoice['type'] == "ESTIMATE" ? 'estimates' : 'invoices').'/edit/'.($invoice['unique_id']), 'Edit '.($invoice['type'] == "ESTIMATE" ? 'estimate' : 'invoice'), 'class="button"'); ?>
    <?php endif;?>
                    
    <!-- Download PDF -->
    <a href="<?php echo site_url('pdf/'.$invoice['unique_id']); ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>

    <?php $admin_login = logged_in() ? 'admin' : '#'; ?>

    <?php if ($is_estimate): ?>

        <?php if ($editable): ?>
            <?php echo anchor($admin_login, 'Mark as unanswered', 'class="unanswer button"'); ?>
            <?php echo anchor($admin_login, 'Mark as accepted', 'class="admin accept button"'); ?>
            <?php echo anchor($admin_login, 'Mark as rejected', 'class="admin reject button"'); ?>
        <?php else: ?>
            <?php echo anchor($admin_login, 'Reject estimate', 'class="client reject button"'); ?>
            <?php echo anchor($admin_login, 'Accept estimate', 'class="client accept button"'); ?>
        <?php endif; ?>

        <?php echo anchor($admin_login, 'Estimate Rejected', 'class="rejected button"'); ?>
        <?php echo anchor($admin_login, 'Estimate Accepted', 'class="accepted button"'); ?>

    <?php endif; ?>


    <?php if( ! $is_paid and $invoice['type'] != 'ESTIMATE' and (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0)){ ?>
        
        <!-- Paypal -->
        <a href="<?php echo $invoice['partial_payments'][$invoice['next_part_to_pay']]['payment_url']; ?>" class="button"><?php if (count($invoice['partial_payments']) > 1) : ?>Pay part #<?php echo $invoice['next_part_to_pay']; ?> of your invoice now<?php else: ?>Proceed to payment<?php endif;?></a>

    <?php } ?>


    <?php if (!$editable): ?>

    	<?php if ($is_paid): ?>
            <?php echo __('invoices:thisinvoicewaspaidon', array(format_date($invoice['payment_date'])));?>
        <?php elseif (!($is_estimate)) :?>
            <?php echo __('invoices:thisinvoiceisunpaid');?>
        <?php endif;?>

    <?php endif;?>








<?php endif; ?>











<!-- Company name -->
<?php echo logo(false, false, 2);?>

<!-- Company mailing address -->
<?php echo escape(nl2br(Settings::get('mailing_address'))); ?>


<!-- Invoice/estimate title -->
<h3><?php echo $invoice['type'] == 'ESTIMATE' ? __('global:estimate') : Settings::get('default_invoice_title'); ?></h3>

<!-- Invoice/estimate number -->
<?php echo __($invoice['type'] == 'ESTIMATE' ? 'estimates:estimatenumber' : 'invoices:invoicenumber', array($invoice['invoice_number']));?>

<!-- Invoice/estimate date -->
<?php echo __($invoice['type'] == 'ESTIMATE' ? 'estimates:estimatedate' : 'invoices:invoicedate'); ?>: <?php echo $invoice['date_entered'] ? format_date($invoice['date_entered']) : '<em>n/a</em>';?>

<!-- Invoice due date -->
<?php echo __('invoices:due'); ?>: <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?>

<?php if($invoice['is_paid'] == 1): ?>
    <!-- If paid, payment date -->
    <?php echo __('invoices:paidon', array(format_date($invoice['payment_date'])));?>
<?php endif; ?>









<!-- Client name -->
<h3><?php echo $invoice['company'];?></h3>

<!-- Client first name and last name -->
<?php echo escape($invoice['first_name'].' '.$invoice['last_name']);?>

<!-- Client address -->
<?php echo escape(nl2br($invoice['address']));?>

<?php if ( ! empty($invoice['description'])): ?>

    <!-- Description heading -->
    <h3><?php echo __('global:description');?>:</h3>
    <!-- The description -->
	<?php echo escape(auto_typography($invoice['description']));?>

<?php endif; ?>










<?php echo $template['body']; ?>










<?php if ($invoice['type'] != 'ESTIMATE'): ?>


    <?php // Payment slip ?>

    <?php if($pdf_mode and Settings::get('include_remittance_slip')): ?>

        <h2>How to Pay</h2>
        View invoice online at <?php echo anchor($invoice['unique_id']); ?>
        You may pay in person, online, or by mail using this payment voucher. Please provide your payment information below.
        Enclosed Amount: __________________________________

        Invoice #: <?php echo $invoice['invoice_number'];?><br/>
        Total: <?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?><br/>
        Due: <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?>

        <h3>Mail To:</h3>
        <?php echo Settings::get('site_name'); ?>
        <?php echo nl2br(Settings::get('mailing_address')); ?>

    <?php endif; ?>

    <?php // End payment slip ?>


<?php endif; // is not estimate ?>










</body>
</html>