<?php if ($invoice['type'] === "DETAILED") : ?>
    <?php if ($files): ?>
        <?php
        $requires_payment = get_instance()->dispatch_return('decide_invoice_requires_payment_before_file_download', array('invoice' => &$invoice), 'boolean');
        $requires_payment = is_array($requires_payment) ? true : $requires_payment;
        $requires_payment = $requires_payment ? !$is_paid : false; # If requires payment and is paid, then no payment is required.
        ?>
        <div class="invoice--files">

            <h2><?php echo __('invoices:filestodownload'); ?></h2>

            <?php if ($requires_payment): ?>
                <p><?php echo __('invoices:fileswillbeavailableafterpay'); ?></p>
            <?php endif; ?>

            <ul class="files-list">
                <?php foreach ($files as $file): ?>
                    <?php
                    $ext = explode('.', $file['orig_filename']);
                    end($ext);
                    $ext = current($ext);
                    ?>

                    <?php if (!$requires_payment): ?>
                        <li>
                            <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url('files/download/' . $invoice['unique_id'] . '/' . $file['id']); ?>"><?php echo $file['orig_filename']; ?></a>
                        </li>
                    <?php else: ?>
                        <li class="file-to-download" <?php echo $style; ?> ><?php echo $file['orig_filename']; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>


    <?php endif; ?>

            <?php if ($invoice['receipts']): ?>
                <div id="files" class="main-body-style">
                    <h2 class="main-header-style"><?php echo __('expenses:expense_receipts'); ?></h2>

                    <div class="files-holder">
                        <ul id="list-of-files">
                            <?php foreach ($invoice['receipts'] as $receipt): ?>
                                <?php
                                $ext = explode('.', $receipt);
                                end($ext);
                                $ext = current($ext);
                                ?>
                                <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
                                <?php $style = 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>
                                <li>
                                    <a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url('uploads/' . $receipt); ?>"><?php echo array_end(explode("/", $receipt)); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <!-- /list-of-files -->

                    </div>
                    <!-- /files-holder -->
                </div><!-- /files -->
            <?php endif; ?>
        <?php endif; ?>