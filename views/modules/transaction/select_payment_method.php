
<h2><?php echo __('gateways:selectpaymentmethod');?></h2>

<?php foreach ($gateways as $gateway) : ?>
    <?php echo anchor($payment_url.'/'.$gateway['gateway'], $gateway['frontend_title'], 'class="simple-button"'); ?>
<?php endforeach; ?>
