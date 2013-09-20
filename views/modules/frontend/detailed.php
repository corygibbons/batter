<?php if (isset($invoice['id'])): ?>




    <!-- Invoice item headers if you need them -->
    <?php echo __('global:description'); // Description ?>
    <?php echo __('invoices:timequantity'); // Time/Quantity?>
    <?php echo __('invoices:ratewithcurrency', array($invoice['currency_code'] ? $invoice['currency_code'] : Currency::code())); // Rate ?>
    <?php echo __('invoices:taxable'); // Taxable ?>
    <?php echo __('items:type'); // Type ?>
    <?php echo __('invoices:total'); // Total ?>



    <?php if ( ! empty($invoice['items'])): $class = ''; ?>
                
        <?php foreach( $invoice['items'] as $item ): ?>

            <!-- Item name -->
            <?php echo escape($item['name']); ?>
            <!-- Item quantity -->
            <?php echo $item['qty']; ?>
            <!-- Item rate -->
            <?php echo Currency::format($item['rate'], $invoice['currency_code']); ?>
            <!-- Taxable -->
            <?php echo $item['tax_id'] ? __('global:Y') : __('global:N'); ?>
            <!-- Item type -->
            <?php echo invoice_item_type($item); ?>
            <!-- Item total -->
            <?php echo Currency::format($item['total'], $invoice['currency_code']); ?>



            <?php if ($item['description']): ?>
                <?php echo nl2br(escape($item['description'])); ?>
            <?php endif; ?>



            <?php $class = ($class == '' ? 'alt' : ''); ?>
                
        <?php endforeach; ?>


    <?php endif; ?>



                                    
    <?php if ( ! empty($invoice['notes'])): ?>

        <h3><?php echo __('global:notes');?>:</h3>
        <?php echo auto_typography(escape($invoice['notes']));?>

    <?php endif; ?>










    <!-- Tax section -->
    <?php if ($invoice['has_tax_reg']): ?>
        <h3><?php echo __('settings:taxes') ?></h3>

        <?php foreach ($invoice['taxes'] as $id => $total ):
            $tax = Settings::tax($id); if (empty($tax['reg'])) continue; ?>

            <?php echo $tax['name'] ?>
            <?php echo $tax['reg'] ?>

        <?php endforeach; ?>

    <?php endif; ?>










    <?php if (!$is_estimate): // If is not estimate ?>

        <?php $has_gateway = (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0); ?>

        <?php if (count($invoice['partial_payments']) > 1) : ?>


            <h3><?php echo __('partial:partialpayments');?></h3>

            <?php foreach ($invoice['partial_payments'] as $part) : ?>

                <?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?>
                <?php if ($part['due_date'] != 0) : ?>
                    <?php echo __('partial:dueondate', array('<span class="dueon">'.format_date($part['due_date']).'</span>'));?>
                <?php endif; ?>

                <?php echo (empty($part['notes'])) ? '' : '- '.$part['notes']; ?>
                                    


                <?php if (!$part['is_paid']) : ?>

                    <?php if ($pdf_mode) : ?>
                        <?php if ($has_gateway): ?>
                            <?php echo " &raquo; ".__('partial:topaynowgoto', array('<a href="'.$part['payment_url'].'">'.$part['payment_url'].'</a>'));?>
                        <?php endif ?>
                    <?php else: ?>

                        <?php if ($has_gateway): ?>
                            <?php echo " &raquo; ".anchor($part['payment_url'], __('partial:proceedtopayment'), 'class="simple-button"'); ?>
                        <?php endif ?>

                    <?php endif; ?>

                <?php else: ?>
                    
                    <?php echo " &raquo; ".__('partial:partpaidthanks');?>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    <?php endif; // If is not estimate ?>










    <!-- Files for download section -->

    <?php if (!($is_estimate)): // If is not estimate ?>

        <?php if ($files): // If there are files ?>

            <h3><?php echo __('invoices:filestodownload'); ?></h3>

                <?php if ( ! $is_paid): // Invoice not paid ?>
                    <?php echo __('invoices:fileswillbeavailableafterpay');?>
                <?php endif; ?>


                <?php foreach ($files as $file): ?>

                    <?php $ext = explode('.', $file['orig_filename']); end($ext); $ext = current($ext); ?>
                    <?php $bg = $pdf_mode ? '' : asset::get_src($ext.'.png', 'img'); ?>
                    <?php $style = empty($bg) ? '' : 'style="background: url('.$bg.') 1px 0px no-repeat;"'; ?>
                    
                    <?php if ($is_paid): ?>
                        <a class="file-to-download" <?php echo $style;?> href="<?php echo site_url('files/download/'.$invoice['unique_id'].'/'.$file['id']);?>"><?php echo $file['orig_filename'];?></a>
                    <?php else: ?>
                         <?php echo $file['orig_filename']; ?>
                    <?php endif; ?>

                <?php endforeach; ?>


        <?php endif; ?>

    <?php endif; ?>










    <!-- Invoice totals -->
    <?php echo __('invoices:subtotal');?>
    <?php echo Currency::format($invoice['sub_total'], $invoice['currency_code']); ?>

    <?php foreach( $invoice['taxes'] as $id => $total ): ?>
        <?php $tax = Settings::tax($id); ?>

        <?php echo $tax['name'].' ('.$tax['value'].'%):'; ?>
        <?php echo Currency::format($total, $invoice['currency_code']); ?>

    <?php endforeach; ?>


    <?php echo __('invoices:totaltax');?>
    <?php echo Currency::format($invoice['tax_total'], $invoice['currency_code']); ?>



    <?php echo __('invoices:total');?>
    <?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?>


    <?php if ($invoice['paid_amount']): ?>
                    
        <?php echo __('invoice:paid_amount');?>:
        <?php echo Currency::format($invoice['paid_amount'], $invoice['currency_code']); ?>

        <?php echo __('Due');?>:
        <?php echo Currency::format($invoice['unpaid_amount'], $invoice['currency_code']); ?>

    <?php endif; ?>


    <?php echo __('invoices:due'); ?>:
    <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?>




<?php endif;?>
