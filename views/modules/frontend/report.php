
<?php $i = 0; ?>


<?php foreach ($fields as $field => $title) : ?>
    
    <?php if ($field == 'taxes') : ?>

        <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>

            <?php echo str_ireplace('{tax}', $taxes[$tax_id], $title); ?>

        <?php endforeach; ?>

    <?php else: ?>

        <?php $i++; ?>

    <?php endif; ?>

<?php endforeach; ?>










<?php foreach ($fields as $field => $title) : ?>

    <?php if ($field == 'taxes') : ?>

        <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>

            Uncollected
            Collected
            Total

        <?php endforeach; ?>

    <?php else: ?>

        <?php echo $title; ?>

    <?php endif; ?>

<?php endforeach; ?>










<?php foreach ($records as $record) : ?>

    <?php foreach (array_keys($fields) as $field) : ?>

        <?php if ($field == 'taxes') : ?>

            <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                <?php echo Currency::format((isset($record['total_taxes'][$tax_id]) and isset($record[$field][$tax_id])) ? ($record['total_taxes'][$tax_id] - $record[$field][$tax_id]) : 0, Currency::code($record['currency_id'])); ?>
                <?php echo Currency::format(isset($record[$field][$tax_id]) ? $record[$field][$tax_id] : 0, Currency::code($record['currency_id'])); ?>
                <?php echo Currency::format(isset($record['total_taxes'][$tax_id]) ? $record['total_taxes'][$tax_id] : 0, Currency::code($record['currency_id'])); ?>
            <?php endforeach; ?>

        <?php else: ?>

            <?php switch ($field) {
                case 'due_date':
                echo format_date($record[$field]);
            break; case 'client':
                echo ($record[$field]);
            break; case 'invoice_number':
                echo '<a href="' . site_url('pdf/' . $record['unique_id']) . '">#' . ($record[$field]) . '</a>';
            break; default:
                    echo Currency::format($record[$field], Currency::code($record['currency_id']));
            break; } ?>

        <?php endif; ?>

    <?php endforeach; ?>

<?php endforeach; ?>    










<?php foreach (array_keys($fields) as $field) : ?>

    <?php if (isset($totals[$field])) : ?>

        <?php if ($field == 'taxes') : ?>

            <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                <?php echo Currency::format($totals[$field][$tax_id]['uncollected']); ?>
                <?php echo Currency::format($totals[$field][$tax_id]['collected']); ?>
                <?php echo Currency::format($totals[$field][$tax_id]['total']); ?>
            <?php endforeach; ?>

        <?php else: ?>

            <?php echo Currency::format($totals[$field]); ?>

        <?php endif; ?>

    <?php else: ?>

    <?php endif; ?>

<?php endforeach; ?>
