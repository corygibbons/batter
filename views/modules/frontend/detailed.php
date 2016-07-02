<?php if (isset($invoice['id'])): ?>

    <?php
    $has_only_flat_rate_items = true;
    foreach ($invoice['items'] as $item) {
        if (in_array($item['type'], array("fixed_discount", "percentage_discount"))) {
            continue;
        } else {
            if ($item['type'] !== "flat_rate" && $item['type'] !== "expense") {
                $has_only_flat_rate_items = false;
            }
        }
    }

    $rowspan = 4;

    if ($invoice['paid_amount']) {
        $rowspan++;
    }

    $has_taxes = false;
    foreach ($invoice['taxes'] as $id => $total) {
        if ($id > 0) {
            $has_taxes = true;
            $rowspan++;
        }
    }

    if ($has_taxes and count($invoice['taxes']) > 1) {
        $rowspan++;
    }

    $rowspan += count($invoice['discounts']);
    if (count($invoice['discounts']) > 0) {
        $rowspan++;
    }

    foreach ($invoice['discounts'] as $discount) {
        $rowspan++;
    }

    $colspan = $invoice['has_discount'] ? 5 : 4;

    if ($has_only_flat_rate_items) {
        $colspan--;
    }

    if (!Settings::get("hide_tax_column") or $has_taxes) {
        $colspan++;
    }

    ?>

    <div id="content">
        <table id="<?php echo ($invoice['type'] !== "DETAILED") ? 'estimate_table' : 'invoice_table'; ?>">
            <thead>
                <tr>
                    <th><?php echo __('global:description'); ?></th>
                    <?php if (!$has_only_flat_rate_items): ?>
                        <th><?php echo __('invoices:timequantity'); ?></th>
                    <?php endif; ?>
                    <th><?php echo __('invoices:ratewithcurrency', array($invoice['currency_code'] ? $invoice['currency_code'] : Currency::code())); ?></th>
                    <?php if (!Settings::get("hide_tax_column") or $has_taxes): ?>
                        <th><?php echo __('global:tax'); ?></th>
                    <?php endif; ?>
                    <?php if ($invoice['has_discount']): ?>
                        <th><?php echo __('invoices:discount'); ?></th>
                    <?php endif; ?>
                    <th><?php echo __('invoices:total'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (!empty($invoice['items'])):
                    $class = '';
                    foreach ($invoice['items'] as $item):
                        ?>

                        <?php if (in_array($item['type'], array("fixed_discount", "percentage_discount"))): ?>
                        <?php continue; ?>
                    <?php endif; ?>

                        <tr class="<?php echo $class; ?> invoice-desc-row">
                            <td>
                                <img src="<?php echo asset::get_src('bg-invoice-arrow.gif', 'img'); ?>" alt="&gt;"/> <?php echo escape($item['name']); ?>
                            </td>
                            <?php if (!$has_only_flat_rate_items): ?>
                                <td><?php echo $item['qty']; ?></td>
                            <?php endif; ?>
                            <td><?php echo Currency::format($item['rate'], $invoice['currency_code'], true); ?></td>
                            <?php if (!Settings::get("hide_tax_column") or $has_taxes): ?>
                                <td><?php echo $item['tax_label']; ?></td>
                            <?php endif; ?>
                            <?php if ($invoice['has_discount']): ?>
                                <td><?php echo($item['discount_is_percentage'] ? number_format($item['discount'], 2) . "%" : Currency::format($item['discount'], ($invoice['currency_code'] ? $invoice['currency_code'] : Currency::code()))); ?></td>
                            <?php endif; ?>
                            <td><?php echo Currency::format($item['total'], $invoice['currency_code']); ?></td>
                        </tr>

                        <?php if ($item['description']): ?>
                        <tr>
                            <td colspan="<?php echo $colspan; ?>"><?php echo nl2br(escape($item['description'])); ?></td>
                        </tr>
                    <?php endif; ?>
                        <?php
                        $class = ($class == '' ? 'alt' : '');
                    endforeach;
                endif;
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="<?php echo $colspan - 2; ?>" rowspan="<?php echo $rowspan; ?>" class="invoice-notes" style=" vertical-align:top;">
                        <?php // Taxes Section  ?>
                        <?php if ($invoice['has_tax_reg']): ?>
                            <h3><?php echo __('settings:tax_reg') ?></h3>
                            <ul id="taxes">
                                <?php foreach ($invoice['taxes'] as $id => $total):
                                    $tax = Settings::tax($id);
                                    if (empty($tax['reg']))
                                        continue;
                                    ?>
                                    <li class="<?php echo underscore($tax['name']) ?>">
                                        <span class="name"><?php echo $tax['name'] ?>:</span>
                                        <span class="reg"><?php echo $tax['reg'] ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php $this->load->model("clients/clients_taxes_m"); ?>
                        <?php $client_taxes = $this->clients_taxes_m->fetch($invoice['client_id']); ?>
                        <?php if (count($client_taxes)): ?>
                            <h3><?php echo __('clients:tax_numbers') ?></h3>
                            <ul id="taxes">
                                <?php foreach ($client_taxes as $tax_id => $tax_reg):
                                    $tax = Settings::tax($tax_id);
                                    if (empty($tax_reg))
                                        continue;
                                    ?>
                                    <li class="<?php echo underscore($tax['name']) ?>">
                                        <span class="name"><?php echo $tax['name'] ?>:</span>
                                        <span class="reg"><?php echo $tax_reg ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php // END Taxes section ?>

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

                    </td>
                    <td class="total-heading"><?php echo __('invoices:subtotal'); ?>:</td>
                    <td class="total-values"><?php echo Currency::format($invoice['sub_total'], $invoice['currency_code']); ?></td>
                </tr>

                <?php foreach ($invoice['discounts'] as $discount): ?>
                    <tr dontbreak="true">
                        <td class="total-heading"><?php echo $discount['is_fixed'] ? __('items:fixed_discount', array(Currency::symbol($invoice['currency_code']))) : __('invoices:discount_percentage', array($discount['value'] + 0)); ?>:</td>
                        <td class="total-values"><?php echo Currency::format($discount['gross_amount'], $invoice['currency_code']); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (count($invoice['discounts']) > 0) : ?>
                    <tr dontbreak="true">
                        <td class="total-heading"><?php echo __('invoices:sub_total_after_discounts'); ?>:</td>
                        <td class="total-values"><?php echo Currency::format($invoice['sub_total_after_discounts'], $invoice['currency_code']); ?></td>
                    </tr>
                <?php endif; ?>

                <?php $has_taxes = false; ?>
                <?php foreach ($invoice['taxes'] as $id => $total): ?>
                    <?php if ($id > 0): ?>
                        <?php $has_taxes = true; ?>
                        <?php $tax = Settings::tax($id); ?>
                        <tr dontbreak="true">
                            <td class="total-heading"><?php echo $tax['name'] . ' (' . $tax['value'] . '%):'; ?></td>
                            <td class="total-values"><?php echo Currency::format($total, $invoice['currency_code']); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($has_taxes and count($invoice['taxes']) > 1): ?>
                    <tr dontbreak="true">
                        <td class="total-heading"><?php echo __('invoices:totaltax'); ?>:</td>
                        <td class="total-values"><?php echo Currency::format($invoice['tax_total'], $invoice['currency_code']); ?></td>
                    </tr>
                <?php endif; ?>

                <tr dontbreak="true" <?php echo ($invoice['paid_amount']) ? '' : 'class="invoice-total"' ?> >
                    <td class="total-heading" style=" vertical-align:top;"><?php echo __('invoices:total'); ?>:</td>
                    <td class="total-values" style=" vertical-align:top;"><?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?></td>
                </tr>

                <?php if ($invoice['paid_amount']): ?>

                    <tr dontbreak="true">
                        <td class="total-heading"><?php echo __('invoice:paid_amount'); ?>:</td>
                        <td class="total-values"><?php echo Currency::format($invoice['paid_amount'], $invoice['currency_code']); ?></td>
                    </tr>

                    <tr dontbreak="true" class="invoice-total">
                        <td class="total-heading" style=" vertical-align:top;"><?php echo __('invoices:due'); ?>:</td>
                        <td class="total-values" style=" vertical-align:top;"><?php echo Currency::format(round($invoice['unpaid_amount'], 2), $invoice['currency_code']); ?></td>
                    </tr>

                <?php endif ?>
                <tr dontbreak="true">
                    <?php if ($invoice['type'] === "DETAILED" and count($invoice['partial_payments']) == 1) : ?>
                        <td colspan="2" class="invoice-due-on"><?php echo __('invoices:due'); ?>: <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>' . __('global:na') . '</em>'; ?></td>
                    <?php else: ?>
                        <td colspan="2"></td>
                    <?php endif; ?>
                </tr>

            </tfoot>
        </table>

        <?php if (!empty($invoice['notes']) and $invoice['notes'] != "<p><br></p>"): ?>
            <h3><?php echo __('global:notes'); ?>:</h3>
            <?php echo escape($invoice['notes']); ?>
        <?php endif; ?>





        <?php //Files for download section ?>

        <?php if ($invoice['type'] === "DETAILED") : ?>
            <?php if ($files): ?>
                <?php
                $requires_payment = get_instance()->dispatch_return('decide_invoice_requires_payment_before_file_download', array('invoice' => &$invoice), 'boolean');
                $requires_payment = is_array($requires_payment) ? true : $requires_payment;
                $requires_payment = $requires_payment ? !$is_paid : false; # If requires payment and is paid, then no payment is required.
                ?>
                <div id="files" class="main-body-style">
                    <h2 class="main-header-style"><?php echo __('invoices:filestodownload'); ?></h2>

                    <div class="files-holder">
                        <?php if ($requires_payment): ?>
                            <p><?php echo __('invoices:fileswillbeavailableafterpay'); ?></p>
                        <?php endif; ?>
                        <ul id="list-of-files">
                            <?php foreach ($files as $file): ?>
                                <?php
                                $ext = explode('.', $file['orig_filename']);
                                end($ext);
                                $ext = current($ext);
                                ?>
                                <?php $bg = $pdf_mode ? '' : asset::get_src($ext . '.png', 'img'); ?>
                                <?php $style = empty($bg) ? '' : 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>
                                <?php if (!$requires_payment): ?>
                                    <li>
                                        <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url('files/download/' . $invoice['unique_id'] . '/' . $file['id']); ?>"><?php echo $file['orig_filename']; ?></a>
                                    </li>
                                <?php else: ?>
                                    <li class="file-to-download" <?php echo $style; ?> ><?php echo $file['orig_filename']; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <!-- /list-of-files -->
                    </div>
                    <!-- /files-holder -->
                </div><!-- /files -->
            <?php endif; ?>
            <?php if ($invoice['receipts']): ?>
                <div id="files" class="main-body-style">
                    <h2 class="main-header-style"><?php echo __('expenses:expense_receipts'); ?></h2>

                    <div class="files-holder">
                        <ul id="list-of-files">
                            <?php foreach ($invoice['receipts'] as $receipt): ?>
                                <?php
                                $ext = explode('.', $receipt);
                                end($ext);
                                $ext = current($ext);
                                ?>
                                <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
                                <?php $style = 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>
                                <li>
                                    <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url('uploads/' . $receipt); ?>"><?php echo array_end(explode("/", $receipt)); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <!-- /list-of-files -->

                    </div>
                    <!-- /files-holder -->
                </div><!-- /files -->
            <?php endif; ?>
        <?php endif; ?>

        <?php // End Files section ?>

    </div><!-- /content -->
<?php endif; ?>