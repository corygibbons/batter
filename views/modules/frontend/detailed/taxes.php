<?php if ($invoice['has_tax_reg']): ?>
        <h3><?php echo __('settings:tax_reg') ?>sdfsdf</h3>
        <ul id="taxes">
            <?php foreach ($invoice['taxes'] as $id => $total):
                $tax = Settings::tax($id);
                if (empty($tax['reg']))
                    continue;
                ?>
                <li class="<?php echo underscore($tax['name']) ?>">
                    <span class="name"><?php echo $tax['name'] ?>adasd:</span>
                    <span class="reg"><?php echo $tax['reg'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php $this->load->model("clients/clients_taxes_m"); ?>
    <?php $client_taxes = $this->clients_taxes_m->fetch($invoice['client_id']); ?>
    <?php if (count($client_taxes)): ?>
        <h3><?php echo __('clients:tax_numbers') ?></h3>
        <ul id="taxes">
            <?php foreach ($client_taxes as $tax_id => $tax_reg):
                $tax = Settings::tax($tax_id);
                if (empty($tax_reg))
                    continue;
                ?>
                <li class="<?php echo underscore($tax['name']) ?>">
                    <span class="name"><?php echo $tax['name'] ?>:</span>
                    <span class="reg"><?php echo $tax_reg ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php // END Taxes section ?>