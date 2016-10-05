<div class="comment-form">
    <h3><?php echo __('kitchen:add_a_comment'); ?></h3>
    <?php echo form_open_multipart(Settings::get('kitchen_route')."/".$client->unique_id."/comments/".$item_type.'/'.$item_id, 'id="comment-form"');?>
        <div>
            <?php echo form_textarea(array(
                'name'  => 'comment',
                'id'    => 'comment',
                'rows'  => 10,
                'cols'  => 80,
                'class' => 'txt',
                'value' => set_value('comment'),
            ));?>
        </div>
        <div class="add-file">
            <label for="file"><?php echo __('kitchen:file') ?>:</label>
            <?php echo form_upload('files[]'); ?>
        </div>
        <div>
            <input type="submit" class="hidden-submit button" value="<?php echo __('kitchen:submitcomment') ?>" />
            <!-- <input type="submit" class="hidden-submit button" value="<?php echo lang('login:login') ?>" /> -->
        </div>
    <?php echo form_close();?>
</div><?php // .comment-form ?>