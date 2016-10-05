<?php if (!empty($activity['post']->orig_filename)): ?>
    <div class="files">
        <p><?php echo __('tickets:attachment') ?>:</p>
        <?php $ext = explode('.', $activity['post']->orig_filename);
          end($ext);
          $ext = current($ext); ?>
        <?php if ($ext == 'png' OR $ext == 'jpg' OR $ext == 'gif'): ?>
            <div class="image-preview">
                <p><img src="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download_ticket_file/' . $activity['post']->real_filename); ?>" style="max-width:50%" /></p>
            </div>
        <?php endif; ?>
        <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
        <?php $style = empty($bg) ? '' : 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>
        <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download_ticket_file/' . $activity['post']->real_filename); ?>"><?php echo $activity['post']->orig_filename; ?></a>
    </div>
<?php endif; ?>