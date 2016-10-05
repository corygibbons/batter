<h3><?php echo __("tickets:leave_a_response"); ?></h3><br/>
<div class="ticketconvo">
    <?php echo form_open_multipart(Settings::get('kitchen_route') . '/' . $client->unique_id . '/tickets/' . $current_ticket->id); ?>
        <textarea name="message" style="width: 100%; height: 130px; margin-bottom: 10px;"></textarea><br />
        <div class="six columns" style='margin-bottom: 10px;'>
            <label for='ticketfile' style="width: 11%;display: inline-block;"><?php echo __('global:attach_file'); ?>:</label> <input type="file" id="ticketfile" name="ticketfile">
        </div>
        <div class="six columns end" style="margin-bottom:10px;">
            <label for="status" style="width: 11%;display: inline-block;"><?php echo __('tickets:ticket_status'); ?></label>
            <span class="sel-item"><?php echo form_dropdown('status_id', $statuses, $current_ticket->status_id, 'style="width:54%;"'); ?></span>
        </div>

        <input type="submit" class="submit" value="Update Ticket">
    <?php echo form_close(); ?>
</div>