<div class="content">

  <h1><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br><?php echo __('tickets:support_tickets'); ?></h1>
  <div class="ticket">
    <div class="ticket-create">

      <h3><?php echo __("tickets:submit_new"); ?></h3>

      <?php echo form_open_multipart(Settings::get('kitchen_route') . '/' . $client->unique_id . '/new_ticket/', array('class' => 'form-holder row')) ?>
        <div>
          <label for="subject" style="width:20%;"><?php echo __('tickets:ticket_subject'); ?></label>
          <input type="text" id="subject" name="subject">
        </div>

        <div>
          <label for="message"><?php echo __('tickets:ticket_message'); ?></label>
          <div class="textarea">
            <?php
            echo form_textarea(array(
              'name' => 'message',
              'id' => 'message',
              'style' => 'display:inline-block;width:100%;',
              'value' => '',
              'rows' => 10,
              'cols' => 55
            ));
            ?>
          </div>
        </div>

        <div>
          <label for="ticketfile">Attach a file:</label> <input type="file" id="ticketfile" name="ticketfile">
        </div>

        <div>
          <label for="priority" style="width:13.5%;display: inline-block;"><?php echo __('tickets:ticket_priority'); ?></label>
          <?php echo form_dropdown('priority_id', $priorities, 0, 'style="width:54%;" class="sel_priority"'); ?></span>
        </div>

        <div>
          <label for="status" style="width:13.5%;display: inline-block;"><?php echo __('tickets:ticket_status'); ?></label>
          <?php echo form_dropdown('status_id', $statuses, ($statuses[2] === "Open" ? 2 : 0), 'style="width:54%;"'); ?>
        </div>

        <input type="hidden" name="is_billable" class="ticket_is_billable" value="0" />
        <input type="hidden" name="ticket_amount" class="ticket_amt" value="0" />

        <div>
          <input type="submit" id="submit" class="button" value="<?php echo __("global:save"); ?>">
          <a href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/tickets/'); ?>" class="button"><?php echo __("global:cancel")?></a>
        </div>
      </form>

    </div>
  </div>

</div>

<script>
  $('textarea').redactor(redactor_options);
</script>