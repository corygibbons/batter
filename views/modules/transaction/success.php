<!-- Payment Received! -->
<h2><?php echo __('transactions:paymentreceived');?></h2>


<!-- Thank you for your payment. You should be receiving a receipt via email shortly. -->
<?php echo __('transactions:thankyouforyourpayment');?>

<!-- If you have files awaiting delivery you will receive an email with a link to download them shortly. -->
<?php echo __('transactions:ifyouhavefilesyouwillgetanemail');?>

<!-- If you do not receive an email within an hour please contact _ -->
<?php echo __('transactions:ifyoudonotreceiveemail', array(mailto(Settings::get('notify_email')))); ?>

<!-- Thanks! -->
<?php echo __('global:thanks');?>


<?php echo Settings::get('admin_name'); ?>