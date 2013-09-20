
<?php if (empty($fee)): ?>
	
    <!-- Please wait, your order is being processed and you will be redirected to the :1 website. -->
	<h2><?php echo __('transactions:orderbeingprocessed', array($gateway));?></h2>

    <!-- If you are not automatically redirected to :1 within 5 seconds... -->
    <?php echo __('transactions:ifyouarenotredirected', array($gateway));?>

<?php else: ?>

    <!-- As :1 imposes a transactional fee, we have added a :2% surcharge. -->
    <?php echo __('transactions:fee_applied', array($gateway, $fee));?></p>

<?php endif ?>
	

<?php echo $form; ?>
