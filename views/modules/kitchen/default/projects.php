<?php if ($projects): ?>

    <div class="section">
        <h2><?php echo __('global:projects'); ?></h2>

        <?php $prev_milestone = 'x'; ?>

        <?php foreach ($projects as $project): ?>
          <div class="project id-<?php echo $project->id; ?>">
            <h4><?php echo $project->name; ?></h4>

            <p><?php echo lang('projects:due_date') ?>: <?php echo format_date($project->due_date); ?></p>
            <p><?php echo lang('projects:is_completed') ?>: <?php echo ($project->completed ? __('global:yes') : __('global:no')); ?></p>
            <p><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/project/'.$project->id, __('kitchen:comments_x', array($project->total_comments))); ?></p>

            <?php $started = false; ?>
            <?php foreach ($project->tasks as $task): ?>
                <?php if ($task['milestone_name'] !== $prev_milestone): ?>

                    <?php if ($started): ?>
                        </table>
                    <?php endif; ?>
                    <?php $started = true; ?>

                    <div class="milestone">
                        <h4><?php echo (!empty($task['milestone_name']) ? $task['milestone_name'] : lang('tasks:no_milestones')); ?></h4>
                        <p><?php echo nl2br(escape($task['milestone_description'])); ?></p>
                    </div> <?php // .milestone ?>

                    <table>
                        <tr>
                          <th><?php echo __('timesheet:taskname') ?></th>
                          <th><?php echo lang('tasks:hours') ?></th>
                          <th><?php echo lang('tasks:due_date') ?></th>
                          <th><?php echo __('global:status') ?></th>
                          <th><?php echo __('global:notes') ?></th>
                        </tr>

                        <?php $prev_milestone = $task['milestone_name']; ?>
                <?php endif; ?> <?php // $task['milestone_name'] !== $prev_milestone ?>

                <tr>
                    <td>
                        <?php if ($task['completed'] == '1'): ?>
                            <strike><?php echo $task['name']; ?></strike>
                        <?php else: ?>
                            <?php echo $task['name']; ?>
                        <?php endif ?>
                    </td>
                    <td><?php echo format_hours($task['tracked_hours']); ?></td>
                    <td><?php echo $task['due_date'] ? format_date($task['due_date']) : __('global:na'); ?></td>
                    <td>
                        <?php if ($task['status_title']): ?>
                            <span class="status-<?php echo $task['status_id'] ?>"><?php echo $task['status_title'] ?></span>
                        <?php else: ?>
                            <span><?php echo ($task['completed']) ? __('gateways:completed') : __('global:na'); ?></span>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/task/'.$task['id'], __('kitchen:comments_x', array($task['total_comments']))); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><?php echo auto_typography($task['notes']);?></td>
                </tr>

            <?php endforeach; ?> <?php // tasks ?>
            <?php $prev_milestone = 'x'; ?>

            </table>

          </div> <?php // .project ?>
        <?php endforeach; ?> <?php // projects ?>

    </div> <?php // .section ?>

<?php endif; ?>