
<h1><?php echo $client->first_name;?> <?php echo $client->last_name;?><br><?php echo $client->company;?></h1>










<?php switch($item_type): 
	case 'invoice': ?>

	   <h2><?php echo ($invoice->type == 'ESTIMATE') ? __('global:estimate') : Settings::get('default_invoice_title') ?>: <?php echo $invoice->invoice_number; ?></h2>

	<?php break;
    case 'project': ?>

	   <h2><?php echo __('projects:project') ?>: <?php echo $project->name; ?></h2>

	<?php break;
    case 'task': ?>

    	<h2><?php echo __('tasks:task') ?>: <?php echo $task->name; ?></h2>

	<?php break;
	case 'proposal': ?>

	   <h2><?php echo __('proposals:proposal') ?>: <?php echo $proposal->title; ?></h2>
	
    <?php break;
endswitch; ?>










<?php if (count($comments)): ?>

    <?php foreach ($comments as $comment): ?>

        <!-- Commenter user name -->
        <?php echo $comment->user_name; ?>
        <!-- Said on -->
        <?php echo __('kitchen:saidon', array(format_date($comment->created), format_time($comment->created))) ?>

        <?php if ($comment->being_viewed_by_owner): ?>
            <!-- Edit comment link -->
            <a href="<?php echo site_url(Settings::get('kitchen_route')."/".$client->unique_id."/edit_comment/".$comment->id. "/" .$item_type.'/'.$item_id);?>"><?php echo __('global:edit');?></a>
            <!-- Delete comment link -->
            <a href="<?php echo site_url(Settings::get('kitchen_route')."/".$client->unique_id."/delete_comment/".$comment->id. "/" .$item_type.'/'.$item_id);?>" onclick="if (!confirm('Are you sure you want to delete this comment?')) {return false;}"><?php echo __('global:delete');?></a>
        <?php endif;?>

        <!-- Comment body text -->
        <?php echo str_replace(array("\n\n", "\n"), array('</p><p>', '<br>'), $comment->comment); ?>

        <?php if (count($comment->files)): ?>

            <!-- Attachments heading -->
            <?php echo __('kitchen:attachment'); ?>

        	<?php foreach ($comment->files as $file): ?>
		

                <?php $ext = explode('.', $file->orig_filename); end($ext); $ext = current($ext); ?>
        					
                <?php if($ext == 'png' OR $ext == 'jpg' OR $ext == 'gif'): ?>
                    <img src="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id.'/download/'.$comment->id.'/'.$file->id);?>" style="max-width:50%" />
                <?php endif ?>

                <?php $bg = asset::get_src($ext.'.png', 'img'); ?>
                <?php $style = empty($bg) ? '' : 'style="background: url('.$bg.') 1px 0px no-repeat;"'; ?>
        		
                <a href="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id.'/download/'.$comment->id.'/'.$file->id);?>"><?php echo $file->orig_filename;?></a>
        				
	       <?php endforeach; ?>

        <?php endif ?>

	<?php endforeach ?>

<?php else: ?>

	<?php echo __('kitchen:nocomments'); // No comments ?>

<?php endif ?>
	




<h3>Add a comment</h3>

<?php echo form_open_multipart(Settings::get('kitchen_route')."/".$client->unique_id."/comments/".$item_type.'/'.$item_id, 'id="comment-form"');?>

    <label for="comment"><?php echo __('kitchen:comment') ?>:</label>
    <?php echo form_textarea(array(
    	'name'	=> 'comment',
    	'id'	=> 'comment',
    	'rows' 	=> 10,
    	'cols' 	=> 80,
    	'class'	=> 'txt',
    	'value' => set_value('comment'),
    ));?>

    <label for="file"><?php echo __('kitchen:file') ?>:</label>
    <?php echo form_upload('files[]'); ?>

    <input type="submit" value="<?php echo __('kitchen:submitcomment') ?>" />

<?php echo form_close();?>
