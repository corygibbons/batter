<?php if (isset($invoice['id'])): ?>

    <?php
    $has_only_flat_rate_items = true;
    foreach ($invoice['items'] as $item) {
        if (in_array($item['type'], array("fixed_discount", "percentage_discount"))) {
            continue;
        } else {
            if ($item['type'] !== "flat_rate" && $item['type'] !== "expense") {
                $has_only_flat_rate_items = false;
            }
        }
    }

    $rowspan = 4;

    if ($invoice['paid_amount']) {
        $rowspan++;
    }

    $has_taxes = false;
    foreach ($invoice['taxes'] as $id => $total) {
        if ($id > 0) {
            $has_taxes = true;
            $rowspan++;
        }
    }

    if ($has_taxes and count($invoice['taxes']) > 1) {
        $rowspan++;
    }

    $rowspan += count($invoice['discounts']);
    if (count($invoice['discounts']) > 0) {
        $rowspan++;
    }

    foreach ($invoice['discounts'] as $discount) {
        $rowspan++;
    }

    $colspan = $invoice['has_discount'] ? 5 : 4;

    if ($has_only_flat_rate_items) {
        $colspan--;
    }

    if (!Settings::get("hide_tax_column") or $has_taxes) {
        $colspan++;
    }

    ?>

    <div class="invoice--contents">

        <?php // Line items ?>
        <?php include('detailed/items.php'); ?>

        <?php // Financial summary ?>
        <?php include('detailed/totals.php'); ?>

        <?php // Invoice notes ?>
        <?php include('detailed/notes.php'); ?>

        <?php // Files for download ?>
        <?php include('detailed/files.php'); ?>

        <?php // Payments ?>
        <?php include('detailed/payments.php'); ?>

    </div>





        <?php // Tax reg numbers ?>
        <?php //include('partials/detailed-taxes.php'); ?>

<?php endif; ?>