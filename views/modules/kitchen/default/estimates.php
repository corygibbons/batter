<?php if ( count($estimates) ): ?>

    <div class="section">
        <h2><?php echo __('global:estimates'); ?></h2>

        <table id="kitchen-estimates"  class="kitchen-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?php echo __('estimates:estimatenumber', array('')) ?></th>
                    <th><?php echo __('estimates:estimatedate') ?></th>
                    <th><?php echo lang('invoices:amount') ?></th>
                    <th><?php echo lang('global:status') ?></th>
                    <th><?php echo lang('estimates:view') ?></th>
                    <th><?php echo lang('global:notes') ?></th>
                </tr>
            </thead>

            <?php foreach ($estimates as $estimate): ?>
                <tr>
                    <td><?php echo $estimate->invoice_number; ?></td>
                    <td><?php echo $estimate->date_entered ? format_date($estimate->date_entered) : '<em>'.__('global:na').'</em>';?></td>
                    <td><?php echo Currency::format($estimate->amount, $estimate->currency_code); ?></td>
                    <td><?php echo __('global:'. ($estimate->status ? ($estimate->status == "ACCEPTED" ? "accepted" : "rejected") : "unanswered")); ?></td>
                    <td><?php echo anchor($estimate->unique_id, lang('estimates:view')); ?></td>
                    <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$estimate->id, __('kitchen:comments_x', array($estimate->total_comments))); ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

    </div>

<?php endif; ?>