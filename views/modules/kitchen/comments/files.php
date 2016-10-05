<?php if (count($comment->files)): ?>
    <div id="files">
        <p><?php echo __('kitchen:attachment') ?>:</p>
        <ul class="list-of-files">
            <?php foreach ($comment->files as $file): ?>
                <?php $ext = explode('.', $file->orig_filename); end($ext); $ext = current($ext); ?>

                <?php if($ext == 'png' OR $ext == 'jpg' OR $ext == 'gif'): ?>
                    <div class="image-preview">
                        <p><img src="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id.'/download/'.$comment->id.'/'.$file->id);?>" style="max-width:50%" /></p>
                    </div>
                <?php endif ?>

                <?php $bg = asset::get_src($ext.'.png', 'img'); ?>
                <?php $style = empty($bg) ? '' : 'style="background: url('.$bg.') 1px 0px no-repeat;"'; ?>

                <li><a class="file-to-download" <?php echo $style;?> href="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id.'/download/'.$comment->id.'/'.$file->id);?>"><?php echo $file->orig_filename;?></a></li>

            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>