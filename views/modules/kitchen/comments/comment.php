<div class="comment <?php echo ($comment->user_id != null ? get_user_full_name_by_id($comment->user_id) : 'client'); ?>">
    <p><span class="orange"><?php echo $comment->user_name; ?></span> <?php echo __('kitchen:saidon', array(format_date($comment->created), format_time($comment->created))) ?> <?php if ($comment->being_viewed_by_owner): ?><a class="comment_edit_link" href="<?php echo site_url(Settings::get('kitchen_route')."/".$client->unique_id."/edit_comment/".$comment->id. "/" .$item_type.'/'.$item_id);?>"><?php echo __('global:edit');?></a> <a class="comment_delete_link js-confirm-delete-comment" href="<?php echo site_url(Settings::get('kitchen_route')."/".$client->unique_id."/delete_comment/".$comment->id. "/" .$item_type.'/'.$item_id);?>"><?php echo __('global:delete');?></a><?php endif;?></p>
    <p><?php echo str_replace(array("\n\n", "\n"), array('</p><p>', '<br>'), $comment->comment); ?></p>

    <?php // Files ?>
    <?php include('files.php'); ?>
</div>