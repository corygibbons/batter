<div class="invoice-row <?php echo ($invoice['type'] !== "DETAILED") ? 'estimate_table' : 'invoice_table'; ?>">
            <div class="column item">Item</div>
            <div class="column details">Details</div>
            <div class="column amount">Amount</div>
        </div>

        <?php if (!empty($invoice['items'])): ?>
            <?php foreach ($invoice['items'] as $item): ?>

                <?php if (in_array($item['type'], array("fixed_discount", "percentage_discount"))): ?>
                    <?php continue; ?>
                <?php endif; ?>

                <div class="invoice-row line-item">
                    <div class="rw"><hr></div>


                    <div class="column item"><?php echo escape($item['name']); ?></div>
                    <div class="column details">
                        <?php // Description ?>
                        <?php if ($item['description']): ?>
                            <div class="invoice-description"><?php echo nl2br(escape($item['description']));?></div>
                        <?php endif; ?>

                        <div class="small-details">
                        <?php if (!$has_only_flat_rate_items): ?>
                            <div class="more">Quantity: <?php echo $item['qty']; ?></div>
                        <?php endif; ?>

                        <?php if (!Settings::get("hide_tax_column") or $has_taxes): ?>
                            <div class="tax">Tax: <?php echo $item['tax_label']; ?></div>
                        <?php endif; ?>

                        <?php if ($invoice['has_discount']): ?>
                            <div class="discount">Discount: <?php echo($item['discount_is_percentage'] ? number_format($item['discount'], 2) . "%" : Currency::format($item['discount'], ($invoice['currency_code'] ? $invoice['currency_code'] : Currency::code()))); ?></div>
                        <?php endif; ?>

                        <div class="rate">Rate: <?php echo Currency::format($item['rate'], $invoice['currency_code'], true); ?></div>
                        </div>

                    </div> <?php // .column.detail ?>

                    <div class="column amount"><?php echo Currency::format($item['total'], $invoice['currency_code']); ?></div>


                </div>
            <?php endforeach; ?>
        <?php endif; ?>