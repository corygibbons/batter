<div id="table_wrapper">
    <table class="timesheet-table">
        <tr>
            <?php if ($count_users > 1) : ?><th class="timesheet_user">User</th><?php endif; ?>
            <th class="timesheet_date"  ><?php echo __('timesheet:date');?></th>
            <th class="timesheet_duration"  ><?php echo __('timesheet:duration');?></th>
            <th class="timesheet_task" ><?php echo __('timesheet:taskname');?> </th>
            <th class="timesheet_notes" ><?php echo __('global:notes');?></th>
        </tr>

        <?php foreach($times as $item) : ?>
            <?php include('timesheet/item.php'); ?>
        <?php endforeach; ?>
    </table>
</div>
