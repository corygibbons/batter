
<?php echo str_ireplace('http://', '//', logo(false, false));?>

<h2>Hi <?php echo $invoice['first_name'].' '.$invoice['last_name'];?></h2>

<?php if (count($invoice['partial_payments']) == 1 and $invoice['partial_payments'][1]['due_date'] != 0) : ?>

    Your invoice #<?php echo $invoice['invoice_number'];?>
    totaling <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?>
    <?php echo ($invoice['partial_payments'][1]['over_due']) ? 'was' : 'is'; ?>
    due on <?php echo format_date($invoice['partial_payments'][1]['due_date']);?>

<?php else: ?>

    Your invoice #<?php echo $invoice['invoice_number'];?>
    totals <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?>.

<?php endif; ?>





<?php if (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0) : ?>

    <?php if (count($invoice['partial_payments']) > 1) : ?>


        <h3>Payment Plan</h3>

        <?php foreach ($invoice['partial_payments'] as $part) : ?>

            <h4><?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?>
            <?php if ($part['due_date'] != 0) : ?>due on <?php echo format_date($part['due_date']); ?><?php endif; ?>
            <?php echo (empty($part['notes'])) ? '' : $part['notes']; ?></h4>

            <?php if (!$part['is_paid']) : ?>
                <?php echo anchor($part['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
            <?php else: ?>
                This part of your invoice's payment has been paid. Thank You.
            <?php endif; ?>

        <?php endforeach; ?>


    <?php else: ?>
        
        <?php if ( ! $is_paid): ?>
            <?php echo anchor($invoice['partial_payments'][1]['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
        <?php else: ?>
            This invoice has been paid.  Thank You.
        <?php endif; ?>
    
    <?php endif; ?>

<?php endif; ?>





<?php if ($invoice['description'] != ''): ?>

    <h3>Description</h3>
    <?php echo $invoice['description']; ?>

<?php endif; ?>




<?php if ($invoice['notes'] != ''): ?>

    <h3>Notes</h3>
    <?php echo $invoice['notes']; ?>

<?php endif; ?>




<?php if ( ! empty($files)): ?>

    <h3>Files for Download</h3>
    
    <?php if ( ! $is_paid): ?>
        These files will be available for download once the invoice has been fully paid.
    <?php endif; ?>


    <?php foreach ($files as $file): ?>

        <?php if ($is_paid): ?>

            <?php echo anchor('files/download/'.$invoice['unique_id'].'/'.$file['id'], $file['orig_filename']); ?>

        <?php else: ?>

            <?php echo $file['orig_filename']; ?>

        <?php endif; ?>

    <?php endforeach; ?>


<?php endif; ?>
