<h1><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><?php echo empty($client->company) ? '' : ' - ' . $client->company; ?></h1>
Unpaid Balance: <?php echo Currency::format($client->unpaid_total); ?><br />
Total Paid To Date: <?php echo Currency::format($client->paid_total); ?>










<?php if ($latest): ?>

    <h2>Latest Invoice</h2>
    <h3>Invoice #<a href="<?php echo site_url($latest->unique_id);?>"><?php echo $latest->invoice_number; ?></a></h3>

    Due date: <?php echo $latest->due_date ? format_date($latest->due_date) : '<em>n/a</em>'; ?><br/>
    Amount: <?php echo Currency::format($latest->billable_amount, $latest->currency_code); ?><br/>

    <?php if ($latest->is_paid) : ?>
        <?php echo __('invoices:thisinvoicewaspaidon', array(format_date($latest->payment_date))); ?>
    <?php else: ?>
        <?php echo __('invoices:thisinvoiceisunpaid'); ?>
    <?php endif; ?>

<?php endif;?>










<?php if (count($invoices)): ?>



    <h2>Invoices</h2>
	
    <!-- Invoice table headings if you need them -->

    <?php echo lang('invoices:number'); // Invoice # ?>
    <?php echo lang('invoices:due'); // Due ?>
    <?php echo lang('invoices:amount'); // Amount ?>
    <?php echo lang('invoices:is_paid'); // Paid? ?>
    <?php echo lang('invoices:view'); // View Invoice ?>
    <?php echo lang('global:notes'); // Notes ?>


    <?php foreach ($invoices as $invoice): ?>

        <!-- Invoice number -->
        <?php echo $invoice->invoice_number; ?>
        <!-- Invoice due date -->
        <?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>n/a</em>';?>
        <!-- Invoice amount -->
        <?php echo Currency::format($invoice->billable_amount, $invoice->currency_code); ?>
        <!-- Invoice paid/unpaid -->
        <?php echo ($invoice->paid ? 'Paid' : 'Unpaid'); ?>
        <!-- Link to view invoice -->
        <?php echo anchor($invoice->unique_id, lang('invoices:view')); ?>
        <!-- Invoice notes -->
        <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$invoice->id, 'Comments ('.$invoice->total_comments.')'); ?>

	<?php endforeach ?>



<?php endif; // end count $invoices ?>










<?php if (count($estimates)): ?>



	<h2>Estimates</h2>

    <!-- Estimate table headings if you need them -->

    <?php echo lang('invoices:amount'); // Amount ?>
    <?php echo lang('estimates:view'); // View Estimate ?>
    <?php echo lang('global:notes'); // Notes ?>


	<?php foreach ($estimates as $estimate): ?>

        <!-- Estimate amount -->
		<?php echo Currency::format($estimate->amount); ?>

		<?php echo anchor($estimate->unique_id, lang('estimates:view')); ?>
		<?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$estimate->id, 'Comments ('.$estimate->total_comments.')'); ?>

	<?php endforeach ?>



<?php endif // end count $estimates ?>










<?php if ($projects): ?>



    <h2>Projects</h2>

	<?php $prev_milestone = null; ?>


	<?php foreach ($projects as $project): ?>		

        <!-- Project name -->
		<h4><?php echo $project->name; ?></h4>
        <!-- Due date -->
		<?php echo lang('projects:due_date') ?>: <?php echo format_date($project->due_date); ?>
        <!-- Completed? Yes/No -->
		<?php echo lang('projects:is_completed') ?>: <?php echo ($project->completed ? 'Yes' : 'No'); ?>
        <!-- Project comments -->
		<?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/project/'.$project->id, 'Comments ('.$project->total_comments.')'); ?>



			<?php foreach ($project->tasks as $task): ?>
				
				<?php if ($task['milestone_name'] !== $prev_milestone): ?>
					
                    <?php echo (!empty($task['milestone_name']) ?  $task['milestone_name'] :  lang('tasks:no_milestones')); // Milestone name ?>
                    <?php echo lang('tasks:hours'); // Hours ?>
                    <?php echo lang('tasks:due_date'); // Due date ?>
                    <?php echo __('global:status'); // Status ?>
                    <?php echo __('global:notes'); // Notes ?>

					<?php $prev_milestone = $task['milestone_name']; ?>

				<?php endif ?>
				
		
						
                <?php if ($task['completed'] == '1'): ?>
                    <!-- Task name (complete) -->
                    <strike><?php echo $task['name']; ?></strike>
                <?php else: ?>
                    <!-- Task name (incomplete) -->
                    <?php echo $task['name']; ?>
				<?php endif ?>
				
                <!-- Task hours -->
                <?php echo format_hours($task['tracked_hours']); ?>
                <!-- Task due date -->
                <?php echo $task['due_date'] ? format_date($task['due_date']) : 'N/A'; ?>

                <?php
                    // Some admin options that may be helpful
                    // $task['status_id'], $task['font_color'], $task['background_color'], $task['text_shadow'], $task['box_shadow']
                ?>

                <?php if ($task['status_title']): ?>
                    <!-- Task status title -->
                    <?php echo $task['status_title'] ?>
                <?php else: ?>
                    <?php echo ($task['completed']) ? __('gateways:completed') : __('proposals:na'); ?>
                <?php endif ?>

                <!-- Task comments -->
                <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/task/'.$task['id'], 'Comments ('.$task['total_comments'].')'); ?>
						
			<?php endforeach; // project task ?>



	<?php endforeach; // individual project ?>



<?php endif; // if projects ?>










<?php if (count($proposals)): ?>



	<h2><?php echo __('proposals:proposal') ?></h2>

    <!-- Proposal table headings if you need them -->

    <?php echo lang('proposals:number'); // Proposal # ?>
    <?php echo lang('proposals:proposal'); // Proposal ?>
    <?php echo lang('proposals:estimate'); // Estimate ?>
    <?php echo lang('proposals:status'); // Status ?>
    <?php echo __('global:notes'); // Notes ?>


	<?php foreach ($proposals as $proposal): ?>

        <!-- Proposal number -->
        <?php echo $proposal->proposal_number; ?>
        <!-- Proposal title -->
        <?php echo $proposal->title; ?>
        <!-- Proposal amount -->
        <?php echo ($proposal->amount > 0 ? Currency::format($proposal->amount) : lang('proposals:na')); ?>
        <!-- Proposal status/answer -->
        <?php echo __('proposals:' . (!empty($proposal->status) ? strtolower($proposal->status) : 'noanswer'), array(format_date($proposal->last_status_change))); ?>
        <!-- View Proposal -->
        <?php echo anchor('proposal/'.$proposal->unique_id, lang('proposals:view')); ?>
        <!-- Proposal comments -->
        <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/proposal/'.$proposal->id, 'Comments ('.$proposal->total_comments.')'); ?>

	<?php endforeach ?>



<?php endif; // count $proposals ?>
