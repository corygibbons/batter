<?php if (count($invoice['partial_payments']) == 1 and $invoice['partial_payments'][1]['due_date'] != 0) : ?>
    <p>Your invoice #<?php echo $invoice['invoice_number'];?> totaling <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?> <?php echo ($invoice['partial_payments'][1]['over_due']) ? 'was' : 'is'; ?> due on <?php echo format_date($invoice['partial_payments'][1]['due_date']);?></p>
<?php else: ?>
    <p>Your invoice #<?php echo $invoice['invoice_number'];?> totals <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?>.</p>
<?php endif; ?>