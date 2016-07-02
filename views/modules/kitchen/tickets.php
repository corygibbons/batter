<div class="content">

  <h1><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br><?php echo __('tickets:support_tickets'); ?></h1>

  <?php if ($current_ticket): ?>
    <h2><?php echo $current_ticket->subject ?></h2>

    <?php $prev_date = ''; ?>
    <?php foreach ($current_ticket->activity as $ts => $activity): ?>

      <?php $date = date('jS M Y', $ts); ?>
      <?php if ($prev_date != $date) : $prev_date = $date; endif; ?>

      <?php if (isset($activity['post']) && $activity['post']):
        $is_staff = $activity['post']->user_id != null; ?>

        <div class="ticketconvo <?php echo $is_staff ? 'left' : 'right' ?>">
          <div class="image">
            <img src="<?php echo get_gravatar($is_staff ? $activity['post']->user->email : $current_ticket->client_email, 60); ?>" />
          </div>
          <div class="text">
            <h4><?php echo $activity['post']->user_name ?></h4>
            <p><?php echo nl2br($activity['post']->message) ?></p>
          </div>
        </div>

        <br class="clear">

        <?php if (!empty($activity['post']->orig_filename)): ?>
          <div class="files">
            <p><?php echo __('tickets:attachment') ?>:</p>
            <?php $ext = explode('.', $activity['post']->orig_filename);
              end($ext);
              $ext = current($ext); ?>
              <?php if ($ext == 'png' OR $ext == 'jpg' OR $ext == 'gif'): ?>
                <div class="image-preview">
                  <p><img src="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download_ticket_file/' . $activity['post']->real_filename); ?>" style="max-width:50%" /></p>
                </div>
              <?php endif; ?>
              <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
              <?php $style = empty($bg) ? '' : 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>
              <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download_ticket_file/' . $activity['post']->real_filename); ?>"><?php echo $activity['post']->orig_filename; ?></a>
          </div>
        <?php endif; ?>

      <?php endif ?>

      <?php if (isset($activity['history']) && $activity['history']): ?>
        <div class="notice" style="border-bottom: 1px solid <?php echo $activity['history']->status->background_color ?>;">
          <div><span style="background: <?php echo $activity['history']->status->background_color ?>; color: <?php echo $activity['history']->status->font_color ?>;"><?php echo __("tickets:user_updated_ticket", array($activity['history']->user_name, '<strong>'.$activity['history']->status->title.'</strong>', format_date($ts, true))); ?></span></div>
        </div>
      <?php endif ?>
    <?php endforeach ?>

    <h3><?php echo __("tickets:leave_a_response"); ?></h3><br/>
    <div class="ticketconvo">
      <?php echo form_open_multipart(Settings::get('kitchen_route') . '/' . $client->unique_id . '/tickets/' . $current_ticket->id); ?>
      <textarea name="message" style="width: 100%; height: 130px; margin-bottom: 10px;"></textarea> <br />
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
  <?php endif ?> <?php // $current_ticket ?>

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

</div> <?php // .content ?>

<script>
    $('textarea').redactor(redactor_options);
</script>