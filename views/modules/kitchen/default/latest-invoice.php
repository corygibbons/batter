<?php if ( $latest ): ?>
    <div class="latest-invoice">
        <h4><?php echo __('kitchen:latest_invoice')?></h4>
        <h3><a href="<?php echo site_url($latest->unique_id);?>"><?php echo __('invoices:invoicenumber', array($latest->invoice_number)); ?></a></h3>

        <p><?php echo __('projects:due_date')?>: <?php echo $latest->due_date ? format_date($latest->due_date) : '<em>'.__('global:na').'</em>'; ?></p>
        <p><?php echo __('invoices:amount')?>: <?php echo Currency::format($latest->billable_amount, $latest->currency_code); ?></p>

        <?php if ($latest->is_paid) : ?>
            <?php echo __('invoices:thisinvoicewaspaidon', array(format_date($latest->payment_date))); ?>
        <?php else: ?>
            <?php echo __('invoices:thisinvoiceisunpaid'); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>