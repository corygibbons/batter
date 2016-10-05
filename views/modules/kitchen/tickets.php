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

                <?php // Individual message ?>
                <?php include('tickets/individual.php'); ?>

                <?php // Files ?>
                <?php include('tickets/files.php'); ?>

            <?php endif ?>

            <?php // History ?>
            <?php include('tickets/history.php'); ?>

        <?php endforeach ?>

        <?php // Leave a response ?>
        <?php include('tickets/reply.php'); ?>

    <?php endif ?> <?php // $current_ticket ?>

    <?php // Tickets ?>
    <?php include('tickets/tickets.php'); ?>

</div> <?php // .content ?>

<script>
    $('textarea').redactor(redactor_options);
</script>