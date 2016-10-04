<div class="client-details">
    <h1 class="client-name"><?php echo client_name($client); ?></h1>
    <div class="account-totals">
        <p class="unpaid-balance"><?php echo __('kitchen:unpaid_balance', array(Currency::format($client->unpaid_total))) ?></p>
        <p class="total-to-date"><?php echo __('kitchen:total_paid_to_date', array(Currency::format($client->paid_total)))?></p>
        <?php if ($this->clients_m->get_has_had_credit($client->id)): ?>
            <p class="credit-balance"><?php echo __('global:credit_balance'); ?>: <?php echo Currency::format($this->clients_m->get_balance($client->id)); ?></p>
        <?php endif; ?>
    </div>
</div>