<?php if ( count($invoices) ): ?>

    <div class="section">
        <h2><?php echo __('global:invoices')?></h2>

        <table>
            <thead>
                <tr>
                    <th><?php echo lang('invoices:number') ?></th>
                    <th><?php echo lang('invoices:due') ?></th>
                    <th><?php echo lang('invoices:amount') ?></th>
                    <th><?php echo __('global:paid') ?></th>
                    <th><?php echo __('global:unpaid') ?></th>
                    <th><?php echo lang('invoices:is_paid') ?></th>
                    <th><?php echo lang('invoices:view') ?></th>
                    <th><?php echo lang('global:notes') ?></th>
                </tr>
            </thead>

            <?php foreach ($invoices as $invoice): ?>
                <tr class="<?php echo ($invoice->paid ? 'paid' : 'unpaid'); ?>">
                    <td><?php echo $invoice->invoice_number; ?></td>
                    <td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>'.__('global:na').'</em>';?></td>
                    <td><?php echo Currency::format($invoice->billable_amount, $invoice->currency_code); ?></td>
                    <td><?php echo Currency::format($invoice->paid_amount, $invoice->currency_code); ?></td>
                    <td><?php echo Currency::format($invoice->unpaid_amount, $invoice->currency_code); ?></td>
                    <td><?php echo __($invoice->paid ? 'global:paid' : ($invoice->paid_amount > 0 ? "invoices:partially_paid" : 'global:unpaid')); ?></td>
                    <td><?php echo anchor($invoice->unique_id, lang('invoices:view')); ?></td>
                    <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$invoice->id, __('kitchen:comments_x', array($invoice->total_comments))); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

<?php endif; ?>