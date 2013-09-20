
<?php if ($count_users > 1) : ?>
    <?php echo __('global:user'); // User ?>
<?php endif; ?>

<?php echo __('timesheet:date'); // Date ?>
<?php echo __('timesheet:duration'); // Duration ?>
<?php echo __('timesheet:taskname'); // Task Name ?>
<?php echo __('global:notes'); // Notes ?>


<?php foreach($times as $item) : ?>

    <?php if ($count_users > 1) : ?>
        <!-- User first and last name -->
        <?php echo $item['first_name'].' '.$item['last_name']; ?>
    <?php endif; ?>
    <!-- Start/end time -->
    <?php echo $item['start_time'];?> - <?php echo $item['end_time'];?>
    <!-- Date -->
    <?php echo format_date($item['date']);?>
    <!-- Minutes -->
    <?php echo timespan(0, (int) $item['minutes'] * 60);?>
    <!-- Task name -->
    <?php echo $tasks[$item['task_id']]['name'];?>
    <!-- Task notes -->
    <?php echo $item['note'];?>

<?php endforeach; ?>
