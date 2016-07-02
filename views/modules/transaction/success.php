<h2><?php echo __('transactions:paymentreceived');?></h2>

<p><?php echo __('transactions:thankyouforyourpayment');?><br />
<br />
<?php echo __('transactions:ifyouhavefilesyouwillgetanemail');?><br />
<br />
<?php echo __('transactions:ifyoudonotreceiveemail', array(mailto(Business::getNotifyEmail()))); ?><br />
<br />
<?php echo __('global:thanks');?><br />
<?php echo Business::getAdminName(); ?>