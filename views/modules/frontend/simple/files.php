<?php if ( ! empty($files)): ?>
    <div id="files">

        <h3>Files for Download</h3>
        <?php if ( ! $is_paid): ?>
            <p>These files will be available for download once the invoice has been fully paid.</p>
        <?php endif; ?>

        <ol class="fileList">
        <?php foreach ($files as $file): ?>
        <?php if ($is_paid): ?>
            <li><?php echo anchor('files/download/'.$invoice['unique_id'].'/'.$file['id'], $file['orig_filename']); ?></li>
        <?php else: ?>
            <li><?php echo $file['orig_filename']; ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
        </ol>

    </div>
<?php endif; ?>