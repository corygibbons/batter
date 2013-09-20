<h1><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br><?php echo $client->company; ?></h1>
    

<!-- Commenter user name -->
<?php echo $comment->user_name; ?>
<!-- Said on -->
<?php echo __('kitchen:saidon', array(format_date($comment->created), format_time($comment->created))) ?>
<!-- Delete comment link -->
<a href="<?php echo site_url(Settings::get('kitchen_route') . "/" . $client->unique_id . "/delete_comment/" . $comment->id); ?>"><?php echo __('global:delete'); ?></a>

<!-- Comment body text -->
<?php echo str_replace(array("\n\n", "\n"), array('</p><p>', '<br>'), $comment->comment); ?>



<?php if (count($comment->files)): ?>

    <!-- Attachment heading -->
    <?php echo __('kitchen:attachment') ?>:

    <?php foreach ($comment->files as $file): ?>

        <?php
        $ext = explode('.', $file->orig_filename);
        end($ext);
        $ext = current($ext);
        ?>

        <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
        <?php $style = empty($bg) ? '' : 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>

        <a href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download/' . $comment->id . '/' . $file->id); ?>"><?php echo $file->orig_filename; ?></a>

    <?php endforeach; ?>

<?php endif ?>





<h3>Edit comment</h3>

<?php echo form_open_multipart(Settings::get('kitchen_route') . "/" . $client->unique_id . "/edit_comment/" . $comment->id . "/" .$item_type.'/'.$item_id, 'id="comment-form"'); ?>

    <label for="comment"><?php echo __('kitchen:comment') ?>:</label>
    <?php
    echo form_textarea(array(
        'name' => 'comment',
        'id' => 'comment',
        'rows' => 10,
        'cols' => 80,
        'class' => 'txt',
        'value' => set_value('comment', $comment->comment),
    ));
    ?>

    <label for="file"><?php echo __('kitchen:file') ?>:</label>
    <?php echo form_upload('files[]'); ?>

    <input type="submit" class="hidden-submit button" value="<?php echo __('kitchen:edit_comment') ?>" />

<?php echo form_close(); ?>
