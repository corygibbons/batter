<h2><?php echo __('gateways:payment_details'); ?></h2>
<form method="post" action="<?php echo $post_url; ?>" id="payment-form" class="client_fields">
    <div class="errors">
        <?php if (isset($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php foreach ($client_fields as $key => $field) : ?>
        <?php if ($field['type'] == 'hidden') : ?>
            <input type="hidden" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>]"<?php endif; ?> id="<?php echo $key; ?>" value="<?php echo $field['value']; ?>" />
        <?php else: ?>
            <div class="row">
                <label for="<?php echo $key; ?>"><?php echo $field['label']; ?></label>
                <?php if ($field['type'] == 'text') : ?>
                    <input type="text" autocomplete="off" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>]"<?php endif; ?> id="<?php echo $key; ?>" />
                <?php elseif ($field['type'] == 'select') : ?>
                    <select <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>]"<?php endif; ?> id="<?php echo $key; ?>">
                        <?php foreach ($field['options'] as $option_value => $option_label) : ?>
                            <option value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif ($field['type'] == 'mmyyyy'): ?>
                    <select id="<?php echo $key; ?>_m" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>][m]"<?php endif; ?>>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT) ?></option>
                        <?php endfor; ?>
                    </select>
                    <select id="<?php echo $key; ?>_y" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>][y]"<?php endif; ?>>
                        <?php for ($i = (date('Y')); $i <= (date('Y') + 10); $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                <?php elseif ($field['type'] == 'select'): ?>
                    <select id="<?php echo $key; ?>_m" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key; ?>]"<?php endif; ?>>
                        <?php foreach ($field['options'] as $value => $title): ?>
                            <option value="<?php echo $value; ?>"><?php echo $title; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="row">
        <button type="submit" class="submit-button"><?php echo __('partial:proceedtopayment'); ?></button>
    </div>
</form>