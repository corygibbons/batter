<?php if (!empty($invoice['notes']) and $invoice['notes'] != "<p><br></p>"): ?>
    <div class="invoice--notes">
        <div class="notes">
            <h3><?php echo __('global:notes'); ?>:</h3>
            <?php echo escape($invoice['notes']); ?>
        </div>
    </div>
<?php endif; ?>