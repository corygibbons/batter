<div class="ticketconvo <?php echo $is_staff ? 'left' : 'right' ?>">
    <div class="image">
        <img src="<?php echo get_gravatar($is_staff ? $activity['post']->user->email : $current_ticket->client_email, 60); ?>" />
    </div>
    <div class="text">
        <h4><?php echo $activity['post']->user_name ?></h4>
        <p><?php echo nl2br($activity['post']->message) ?></p>
    </div>
</div>