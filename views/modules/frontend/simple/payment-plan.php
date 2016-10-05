<?php if (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0) : ?>

    <?php if (count($invoice['partial_payments']) > 1) : ?>

        <h3>Payment Plan</h3>
            <ol>
                <?php foreach ($invoice['partial_payments'] as $part) : ?>
                    <li>
                        <h4><?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?> <?php if ($part['due_date'] != 0) : ?>due on <?php echo format_date($part['due_date']); ?><?php endif; ?> <?php echo (empty($part['notes'])) ? '' : $part['notes']; ?></h4>
                        <?php if (!$part['is_paid']) : ?>
                                <?php echo anchor($part['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
                        <?php else: ?>
                        <p>This part of your invoice's payment has been paid. Thank You.</p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>

    <?php else: ?>

        <?php if ( ! $is_paid): ?>
                <?php echo anchor($invoice['partial_payments'][1]['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
        <?php else: ?>
            <p>This invoice has been paid.  Thank You.</p>
        <?php endif; ?>

    <?php endif; ?>

<?php endif;?>