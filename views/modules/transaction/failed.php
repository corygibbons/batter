<h2><?php echo __('transactions:paymentfailed');?></h2>
<?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <p><?php echo "Please contact ".Business::getAdminName()." at ".Business::getNotifyEmail()." for assistance."; ?></p>
<?php else: ?>
    <p><?php echo __('transactions:extrapaymentfailed', array(Business::getAdminName(), Business::getNotifyEmail()));?></p>
<?php endif ;?>
<a href="<?php echo site_url($unique_id);?>">Back to Invoice</a>