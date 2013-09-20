<?php echo logo(false, false, 2);?>

<?php echo __('kitchen:client_welcome') ?>

<?php echo $client->first_name . " ". $client->last_name  . " - ". $client->company?>

<h3><?php echo __('kitchen:pleaselogin') ?></h3>


<?php echo form_open(Settings::get('kitchen_route')."/login/".$client->unique_id, 'id="login-form"');?>

    <label for="email"><?php echo lang('clients:passphrase') ?>:</label>
    <?php echo form_input(array(
    	'name'	=> 'passphrase',
    	'id'	=> 'passphrase',
    	'type'	=> 'password',
    	'class'	=> 'txt',
    	'value' => set_value('passphrase'),
    ));?>

				
    <?php if ($this->session->flashdata('error')): ?>
    	<?php echo $this->session->flashdata('error'); ?>
    <?php endif ?>
				
    <input type="submit" class="hidden-submit button" value="<?php echo lang('login:login') ?>" />

<?php echo form_close();?>
