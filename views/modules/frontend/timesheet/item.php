<tr>
    <?php if ($count_users > 1) : ?><td class="timesheet_user"><?php echo $item['first_name'].' '.$item['last_name']; ?></td><?php endif; ?>
    <td class="timesheet_date" ><span class="time"><?php echo $item['start_time'];?> - <?php echo $item['end_time'];?><br /></span><span class="date"><?php echo format_date($item['date']);?></span></td>
    <td class="timesheet_duration"><?php echo timespan(0, (int) $item['minutes'] * 60);?></td>
    <td class="timesheet_task" ><?php echo $tasks[$item['task_id']]['name'];?></td>
    <td class="timesheet_notes" ><?php echo $item['note'];?></td>
</tr>