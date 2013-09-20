
<!-- Payment Details -->
<h2><?php echo __('gateways:payment_details'); ?></h2>


<form method="post" action="" id="payment-form" class="client_fields">




    <?php if (isset($errors)) :?>

        <?php foreach ($errors as $error) : ?>
            <?php echo $error; ?>
        <?php endforeach; ?>

    <?php endif;?>




    <?php foreach ($client_fields as $key => $field) : ?>

        <label for="<?php echo $key;?>"><?php echo $field['label'];?></label>
        <?php if ($field['type'] == 'text') : ?>

            <input type="text" autocomplete="off" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key;?>]"<?php endif;?> id="<?php echo $key;?>" />

        <?php elseif ($field['type'] == 'select') : ?>

            <select <?php if ($use_field_names): ?>name="client_fields[<?php echo $key;?>]"<?php endif;?> id="<?php echo $key;?>">
                <?php foreach($field['options'] as $option_value => $option_label) : ?>
                    <option value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>
                <?php endforeach; ?>
            </select>

        <?php elseif ($field['type'] == 'mmyyyy'): ?>

            <select id="<?php echo $key;?>_m" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key;?>][m]"<?php endif;?>>
                <?php for ($i = 1; $i <= 12; $i++) :?>
                    <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT) ?></option>
                <?php endfor;?>
            </select>
            
            <select id="<?php echo $key;?>_y" <?php if ($use_field_names): ?>name="client_fields[<?php echo $key;?>][y]"<?php endif;?>>
                <?php for ($i = (date('Y')); $i <= (date('Y') + 10); $i++) :?>
                    <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                <?php endfor;?>
            </select>

        <?php endif; ?>

    <?php endforeach; ?>




    <button type="submit" class="submit-button"><?php echo __('partial:proceedtopayment');?></button>




</form>