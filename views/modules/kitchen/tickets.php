<h1><?php echo $client->first_name;?> <?php echo $client->last_name;?><br>Support Tickets</h1>










<?php // Submit a new ticket ?>

<h2>Submit a Ticket</h3>

<?php echo form_open(Settings::get('kitchen_route').'/'.$client->unique_id.'/new_ticket/', array('class' => 'form-holder row')) ?>

    <!-- Ticket subject -->
    <label for="subject" style="width:20%;"><?php echo __('tickets:ticket_subject'); ?></label>
    <input type="text" id="subject" name="subject" style="padding:6px;border-radius:5px;border:1px solid #ccc;width:53%;margin-left:30px;margin-bottom:10px;">

    <!-- Ticket message -->
    <label for="message" style="display:inline-block;vertical-align:top;"><?php echo __('tickets:ticket_message'); ?></label>
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
    
    <!-- Select priority -->
    <label for="priority" style="width:20%;"><?php echo __('tickets:ticket_priority'); ?></label>
    <?php echo form_dropdown('priority_id', $priorities, 0,'style="width:54%;margin-left:33px;" class="sel_priority"'); ?>

    <!-- Select status -->
    <label for="status" style="width:20%;"><?php echo __('tickets:ticket_status'); ?></label>
	<?php echo form_dropdown('status_id', $statuses, 0,'style="width:54%;margin-left:38px;"'); ?>

    <?php /*
    <input type="hidden" name="is_billable" class="ticket_is_billable" value="0" />
    <input type="hidden" name="ticket_amount" class="ticket_amt" value="0" />
    */ ?>

    <!-- Submit ticket -->
    <input type="submit" id="submit" class="blue-btn" value="Add Ticket" style="width:15%;">

</form>










<h2>Active Tickets</h2>

<?php if(count($tickets) > 0) : ?>

    <!-- Ticket headings if you need them -->
    <?php echo __('Status'); ?>
    <?php echo __('Priority'); ?>
    <?php echo __('Subject'); ?>
    <?php echo __('Created'); ?>
    <?php echo __('Updated'); ?>
    <?php echo __('Responses'); ?>

<?php endif; ?>

 
<?php if(count($tickets) > 0) : ?>

    <?php foreach ($tickets as $ticket): ?>

        <!-- Ticket status -->
        <?php echo $ticket->status_title; ?>
        <!-- Ticket priority -->
        <?php echo $ticket->priority_title; ?>
        <!-- Ticket suject -->
        <?php echo $ticket->subject; ?>
        <!-- Ticket created -->
        <?php echo days_ago($ticket->created).' ago'; ?>
        <!-- Ticket updated -->
        <?php echo days_ago(empty($ticket->latest_history) ? $ticket->created : $ticket->latest_history->created).' ago'; ?>
        <!-- Ticket responese -->
        <?php echo $ticket->response_count ?> Responses
        <!-- View ticket conversation -->
        <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/tickets/'.$ticket->id, 'View Conversation'); ?>

    <?php endforeach ?>

<?php else : ?>

    No Tickets Created.

<?php endif; ?>



<?php if ($current_ticket): ?>

    <h2><?php echo $current_ticket->subject ?></h2>
	
    <?php 
	$prev_date = '';
	foreach ($current_ticket->activity as $ts => $activity): ?>

    	<?php 
    	$date = date('jS M Y', $ts);
    	if ($prev_date != $date): 
    		$prev_date = $date;
    	?>

        <?php endif ?>


        <?php if (isset($activity['post']) && $activity['post']): 
        	$is_staff = $activity['post']->user_id != null; ?>

            <img src="<?php echo get_gravatar($is_staff ? $activity['post']->user->email : $current_ticket->client_email, 60); ?>" />

            <!-- Username -->
        	<?php echo $activity['post']->user_name ?>
            <!-- Ticket message -->
        	<?php echo nl2br($activity['post']->message) ?>



        	<?php if(!empty($activity['post']->orig_filename)): ?>

                <!-- Attachment heading -->
                <?php echo __('tickets:attachment') ?>:

        		<?php $ext = explode('.', $activity['post']->orig_filename); end($ext); $ext = current($ext); ?>	
        		<?php if($ext == 'png' OR $ext == 'jpg' OR $ext == 'gif'): ?>

                    <img src="<?php echo site_url('admin/tickets/file/'.$activity['post']->real_filename); ?>" style="max-width:50%" />

                <?php endif; ?>
        		
                <?php $bg = asset::get_src($ext.'.png', 'img'); ?>
                <?php $style = empty($bg) ? '' : 'style="background: url('.$bg.') 1px 0px no-repeat;"'; ?>
        		
                <a href="<?php echo site_url('admin/tickets/file/'.$activity['post']->real_filename); ?>"><?php echo $activity['post']->orig_filename;?></a>

            <?php endif; ?>

        <?php endif ?>

        <?php if (isset($activity['history']) && $activity['history']): ?>

            <!-- Ticket status update notice -->
            <!--    $activity['history']->status->background_color, $activity['history']->status->font_color -->
            <?php echo $activity['history']->user_name ?> updated the ticket status to <strong><?php echo $activity['history']->status->title ?></strong> on <?php echo date('m/d/Y \a\t g:ia', $ts) ?>

        <?php endif ?>

    <?php endforeach ?>










    <h2>Leave a Response</h2>

    <?php echo form_open(Settings::get('kitchen_route').'/'.$client->unique_id.'/tickets/'.$current_ticket->id); ?>

        <!-- Text area -->
        <textarea name="message" style="width: 100%; height: 130px; margin-bottom: 10px;"></textarea> <br />

        <!-- Ticket Status -->
        <label for="status" style="width:20%;">Ticket Status</label>
        <?php echo form_dropdown('status_id', $statuses, $current_ticket->status_id,'style="width:54%;margin-left:38px;"'); ?>

        <!-- Submit button -->
        <input type="submit" class="submit" value="Update Ticket">

    <?php echo form_close(); ?>


<?php endif ?>
