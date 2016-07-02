<div class="content">

  <?php // Client details ?>
  <div class="client-details">
    <h1 class="client-name"><?php echo client_name($client); ?></h1>
    <div class="account-totals">
      <p class="unpaid-balance"><?php echo __('kitchen:unpaid_balance', array(Currency::format($client->unpaid_total))) ?></p>
      <p class="total-to-date"><?php echo __('kitchen:total_paid_to_date', array(Currency::format($client->paid_total)))?></p>
      <?php if ($this->clients_m->get_has_had_credit($client->id)): ?>
        <p class="credit-balance"><?php echo __('global:credit_balance'); ?>: <?php echo Currency::format($this->clients_m->get_balance($client->id)); ?></p>
      <?php endif; ?>
    </div>
  </div>


  <?php // Latest invoice ?>
  <?php if ( $latest ): ?>
    <div class="latest-invoice">
      <h4><?php echo __('kitchen:latest_invoice')?></h4>
      <h3><a href="<?php echo site_url($latest->unique_id);?>"><?php echo __('invoices:invoicenumber', array($latest->invoice_number)); ?></a></h3>

      <p><?php echo __('projects:due_date')?>: <?php echo $latest->due_date ? format_date($latest->due_date) : '<em>'.__('global:na').'</em>'; ?></p>
      <p><?php echo __('invoices:amount')?>: <?php echo Currency::format($latest->billable_amount, $latest->currency_code); ?></p>

      <?php if ($latest->is_paid) : ?>
        <?php echo __('invoices:thisinvoicewaspaidon', array(format_date($latest->payment_date))); ?>
      <?php else: ?>
        <?php echo __('invoices:thisinvoiceisunpaid'); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>


  <?php // Invoices ?>
  <?php if ( count($invoices) ): ?>

    <div class="section">
      <h2><?php echo __('global:invoices')?></h2>

      <table>
        <thead>
          <tr>
            <th><?php echo lang('invoices:number') ?></th>
            <th><?php echo lang('invoices:due') ?></th>
            <th><?php echo lang('invoices:amount') ?></th>
            <th><?php echo __('global:paid') ?></th>
            <th><?php echo __('global:unpaid') ?></th>
            <th><?php echo lang('invoices:is_paid') ?></th>
            <th><?php echo lang('invoices:view') ?></th>
            <th><?php echo lang('global:notes') ?></th>
          </tr>
        </thead>

        <?php foreach ($invoices as $invoice): ?>
          <tr class="<?php echo ($invoice->paid ? 'paid' : 'unpaid'); ?>">
            <td><?php echo $invoice->invoice_number; ?></td>
            <td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>'.__('global:na').'</em>';?></td>
            <td><?php echo Currency::format($invoice->billable_amount, $invoice->currency_code); ?></td>
            <td><?php echo Currency::format($invoice->paid_amount, $invoice->currency_code); ?></td>
            <td><?php echo Currency::format($invoice->unpaid_amount, $invoice->currency_code); ?></td>
            <td><?php echo __($invoice->paid ? 'global:paid' : ($invoice->paid_amount > 0 ? "invoices:partially_paid" : 'global:unpaid')); ?></td>
            <td><?php echo anchor($invoice->unique_id, lang('invoices:view')); ?></td>
            <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$invoice->id, __('kitchen:comments_x', array($invoice->total_comments))); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>

    </div> <?php // .invoices ?>

  <?php endif; ?>


  <?php // Estimates ?>
  <?php if ( count($estimates) ): ?>

    <div class="section">
      <h2><?php echo __('global:estimates'); ?></h2>

      <table id="kitchen-estimates"  class="kitchen-table" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
          <th><?php echo __('estimates:estimatenumber', array('')) ?></th>
          <th><?php echo __('estimates:estimatedate') ?></th>
          <th><?php echo lang('invoices:amount') ?></th>
          <th><?php echo lang('global:status') ?></th>
          <th><?php echo lang('estimates:view') ?></th>
          <th><?php echo lang('global:notes') ?></th>
        </tr>
        </thead>

        <?php foreach ($estimates as $estimate): ?>
          <tr>
            <td><?php echo $estimate->invoice_number; ?></td>
            <td><?php echo $estimate->date_entered ? format_date($estimate->date_entered) : '<em>'.__('global:na').'</em>';?></td>
            <td><?php echo Currency::format($estimate->amount, $estimate->currency_code); ?></td>
            <td><?php echo __('global:'. ($estimate->status ? ($estimate->status == "ACCEPTED" ? "accepted" : "rejected") : "unanswered")); ?></td>
            <td><?php echo anchor($estimate->unique_id, lang('estimates:view')); ?></td>
            <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$estimate->id, __('kitchen:comments_x', array($estimate->total_comments))); ?></td>
          </tr>
        <?php endforeach; ?>

      </table>

    </div>

  <?php endif; ?>


  <?php // Credit notes ?>
  <?php if ( count($credit_notes) ): ?>

    <div class="section">
      <h2><?php echo __('global:credit_notes'); ?></h2>

      <table>
        <thead>
        <tr>
          <th><?php echo lang('invoices:amount'); ?></th>
          <th><?php echo lang('credit_notes:view'); ?></th>
          <th><?php echo lang('global:notes'); ?></th>
        </tr>
        </thead>

        <?php foreach ($credit_notes as $credit_note): ?>
          <tr>
            <td><?php echo Currency::format($credit_note->amount, $credit_note->currency_code); ?></td>
            <td><?php echo anchor($credit_note->unique_id, __('credit_notes:view')); ?></td>
            <td><?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$credit_note->id, __('kitchen:comments_x', array($credit_note->total_comments))); ?></td>
          </tr>
        <?php endforeach ?>

      </table>

    </div>

  <?php endif; ?>


  <?php // Projects ?>
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



  <?php // Proposals ?>
  <?php if ( count($proposals) ): ?>

    <div class="section">

      <h2><?php echo __('proposals:proposal') ?></h2>

      <table>
        <thead>
        <tr>
          <th><?php echo __('proposals:number') ?></th>
          <th><?php echo __('proposals:proposal_title') ?></th>
          <th><?php echo __('proposals:estimate') ?></th>
          <th><?php echo __('proposals:status') ?></th>
          <th><?php echo __('global:notes') ?></th>
        </tr>
        </thead>
        <?php foreach ($proposals as $proposal): ?>
          <tr>
            <td><?php echo $proposal->proposal_number; ?></td>
            <td><?php echo $proposal->title; ?></td>
            <td><?php echo ($proposal->amount > 0 ? Currency::format($proposal->amount) : __('global:na')); ?></td>
            <td><?php echo __('proposals:' . (!empty($proposal->status) ? strtolower($proposal->status) : 'noanswer'), array(format_date($proposal->last_status_change))); ?></td>
            <td>
              <?php echo anchor('proposal/'.$proposal->unique_id, lang('proposals:view')); ?>
              <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/proposal/'.$proposal->id, __('kitchen:comments_x', array($proposal->total_comments))); ?>
            </td>
          </tr>
        <?php endforeach ?>
      </table>

    </div> <?php // .section ?>

  <?php endif; ?>


</div> <?php // .content ?>
