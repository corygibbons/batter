<?php if ( count($credit_notes) ): ?>

    <div class="section">
        <h2><?php echo __('global:credit_notes'); ?></h2>

        <table>
            <thead>
                <tr>
                    <th><?php echo lang('invoices:amount'); ?></th>
                    <th><?php echo lang('credit_notes:view'); ?></th>
                    <th><?php echo lang('global:notes'); ?></th>
                </tr>
            </thead>

            <?php foreach ($credit_notes as $credit_note): ?>
                <tr>
                    <td><?php echo Currency::format($credit_note->amount, $credit_note->currency_code); ?></td>
                    <td><?php echo anchor($credit_note->unique_id, __('credit_notes:view')); ?></td>
                    <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$credit_note->id, __('kitchen:comments_x', array($credit_note->total_comments))); ?></td>
                </tr>
            <?php endforeach ?>

        </table>

    </div>

<?php endif; ?>