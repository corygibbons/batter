<div class='invoice-payments'>
    <?php if ($invoice['type'] === "DETAILED") : ?>
        <?php $has_gateway = (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0); ?>
        <?php if (count($invoice['partial_payments']) > 1) : ?>
            <h2 style="margin-top: 0;" class="main-header-style orange" id="payment-plan-header"><?php echo __('partial:partialpayments'); ?></h2>
            <div class="payment-plan">
                <ol>
                    <?php foreach ($invoice['partial_payments'] as $part) : ?>
                        <li>
                            <span class="amount"><?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?></span> <?php if ($part['due_date'] != 0) : ?><?php echo __('partial:dueondate', array('<span class="dueon">' . format_date($part['due_date']) . '</span>')); ?><?php endif; ?> <?php echo (empty($part['notes'])) ? '' : '- ' . $part['notes']; ?>
                            <?php if (!$part['is_paid']) : ?>
                                <?php if ($pdf_mode) : ?>
                                    <?php if ($has_gateway): ?>
                                        <?php echo " &raquo; " . __('partial:topaynowgoto', array('<a href="' . $part['payment_url'] . '">' . $part['payment_url'] . '</a>')); ?>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if ($has_gateway): ?>
                                        <?php echo " &raquo; " . anchor($part['payment_url'], __('partial:proceedtopayment'), 'class="simple-button"'); ?>
                                    <?php endif ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo " &raquo; " . __('partial:partpaidthanks'); ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>