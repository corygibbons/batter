<?php if ( count($proposals) ): ?>

    <div class="section">

        <h2><?php echo __('proposals:proposal') ?></h2>

        <table>
            <thead>
                <tr>
                    <th><?php echo __('proposals:number') ?></th>
                    <th><?php echo __('proposals:proposal_title') ?></th>
                    <th><?php echo __('proposals:estimate') ?></th>
                    <th><?php echo __('proposals:status') ?></th>
                    <th><?php echo __('global:notes') ?></th>
                </tr>
            </thead>
            <?php foreach ($proposals as $proposal): ?>
                <tr>
                    <td><?php echo $proposal->proposal_number; ?></td>
                    <td><?php echo $proposal->title; ?></td>
                    <td><?php echo ($proposal->amount > 0 ? Currency::format($proposal->amount) : __('global:na')); ?></td>
                    <td><?php echo __('proposals:' . (!empty($proposal->status) ? strtolower($proposal->status) : 'noanswer'), array(format_date($proposal->last_status_change))); ?></td>
                    <td>
                        <?php echo anchor('proposal/'.$proposal->unique_id, lang('proposals:view')); ?>
                        <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/proposal/'.$proposal->id, __('kitchen:comments_x', array($proposal->total_comments))); ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>

    </div>

<?php endif; ?>