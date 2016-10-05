<h2><?php echo __("tickets:active_tickets"); ?></h2>
<table>
    <thead>
        <?php if (count($tickets) > 0) : ?>
            <tr>
                <th><?php echo __('global:subject') ?></th>
                <th><?php echo __('global:status') ?></th>
                <th><?php echo __('tickets:ticket_priority') ?></th>
                <th><?php echo __('global:created') ?></th>
                <th><?php echo __('global:updated') ?></th>
                <th><?php echo __('kitchen:responses') ?></th>
            </tr>
        <?php endif; ?>
    </thead>

    <tbody>
        <?php if (count($tickets) > 0) : ?>
            <?php foreach ($tickets as $ticket): ?>
                <tr class="ticket medium">
                    <td><?php echo anchor(Settings::get('kitchen_route') . '/' . $client->unique_id . '/tickets/' . $ticket->id, $ticket->subject); ?></td>
                    <td><span class="open" style="background-color: <?php echo $ticket->status_background_color; ?>"></span><?php echo $ticket->status_title; ?></td>
                    <td><?php echo $ticket->priority_title; ?></td>
                    <td><?php echo better_timespan($ticket->created, true); ?></td>
                    <td><?php echo better_timespan($ticket->latest, true); ?></td>
                    <td><?php echo __("kitchen:x_responses", array($ticket->response_count)); ?></td>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr class="ticket medium">
                <td colspan="7">
                    <?php echo __('kitchen:no_tickets_created'); ?>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>