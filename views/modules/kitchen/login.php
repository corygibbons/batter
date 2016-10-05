<div class="login">
fghvbjnkml,
	<?php echo Business::getLogo(false, false, 2);?>
	<p>sfsdf<?php echo __('kitchen:client_welcome') ?> <?php echo $client->first_name . " ". $client->last_name  . " - ". $client->company?></p>
	<h3><?php echo __('kitchen:pleaselogin') ?></h3>

	<?php echo form_open(Settings::get('kitchen_route')."/login/".$client->unique_id, 'id="login-form"');?>
		<div class="row">
		<label for="email"><?php echo lang('clients:passphrase') ?>:</label>
		<?php echo form_input(array(
			'name'	=> 'passphrase',
			'id'	=> 'passphrase',
			'type'	=> 'password',
			'class'	=> 'txt',
			'value' => set_value('passphrase'),
		));?>
		</div>

		<?php if ( $this->session->flashdata('error') ): ?>
			<p class="error"><?php echo $this->session->flashdata('error'); ?></p>
		<?php endif ?>

		<div>
			<input type="submit" class="hidden-submit button" value="<?php echo lang('login:login') ?>" />
		</div>
	<?php echo form_close(); ?>

</div>