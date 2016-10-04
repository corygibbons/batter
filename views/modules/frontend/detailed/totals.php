<div class="invoice--totals">

    <div class="rw"><hr></div>

        <div class="total-row">
            <div class="what"><?php echo __('invoices:subtotal'); ?></div>
            <div class="value"><?php echo Currency::format($invoice['sub_total'], $invoice['currency_code']); ?></div>
        </div>
        <div class="total-row">
            <div class="what"></div>
            <div class="value"></div>
        </div>

        <?php foreach ($invoice['discounts'] as $discount): ?>
            <div class="total-row">
                <div class="what"><?php echo $discount['is_fixed'] ? __('items:fixed_discount', array(Currency::symbol($invoice['currency_code']))) : __('invoices:discount_percentage', array($discount['value'] + 0)); ?></div>
                <div class="value"><?php echo Currency::format($discount['gross_amount'], $invoice['currency_code']); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if (count($invoice['discounts']) > 0) : ?>
            <div class="total-row">
                <div class="what"><?php echo __('invoices:sub_total_after_discounts'); ?></div>
                <div class="value"><?php echo Currency::format($invoice['sub_total_after_discounts'], $invoice['currency_code']); ?></div>
            </div>
        <?php endif; ?>

        <?php $has_taxes = false; ?>
        <?php foreach ($invoice['taxes'] as $id => $total): ?>
            <?php if ($id > 0): ?>
                <?php $has_taxes = true; ?>
                <?php $tax = Settings::tax($id); ?>
                <div class="total-row">
                    <div class="what"><?php echo $tax['name'] . ' (' . $tax['value'] . '%):'; ?></div>
                    <div class="value"><?php echo Currency::format($total, $invoice['currency_code']); ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($has_taxes and count($invoice['taxes']) > 1): ?>
            <div class="total-row">
                <div class="what"><?php echo __('invoices:totaltax'); ?></div>
                <div class="value"><?php echo Currency::format($invoice['tax_total'], $invoice['currency_code']); ?></div>
            </div>
        <?php endif; ?>

<div class="rw"><hr></div>

        <div class="total-row">
            <div class="what"><?php echo __('invoices:total'); ?></div>
            <div class="value"><?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?></div>
        </div>


        <?php if ($invoice['paid_amount']): ?>
            <div class="total-row">
                <div class="what"><?php echo __('invoice:paid_amount'); ?></div>
                <div class="value"><?php echo Currency::format($invoice['paid_amount'], $invoice['currency_code']); ?></div>
            </div>

            <div class="total-row">
                <div class="what"><?php echo __('invoices:due'); ?></div>
                <div class="value"><?php echo Currency::format(round($invoice['unpaid_amount'], 2), $invoice['currency_code']); ?></div>
            </div>
        <?php endif ?>

        <div class="total-row">
            <div class="what"><?php echo __('invoices:due'); ?></div>
            <div class="value"><?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>' . __('global:na') . '</em>'; ?></div>
        </div>


</div>