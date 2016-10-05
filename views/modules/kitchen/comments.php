<div class="content">

    <h1><?php echo $client->first_name;?> <?php echo $client->last_name;?><br><?php echo $client->company;?></h1>

        <?php switch($item_type):
            case 'invoice': ?>

                <?php
                switch ($invoice->type) {
                    case 'ESTIMATE':
                      $number_wording = "estimates:estimatenumber";
                      break;
                    case "CREDIT_NOTE":
                      $number_wording = "credit_notes:credit_note_number";
                      break;
                    default:
                      $number_wording = "invoices:invoicenumber";
                      break;
                }

                $number_wording = __($number_wording, array($invoice->invoice_number));
                ?>

                <h2><?php echo $number_wording ?></h2>

            <?php
                break;
            case 'project': ?>

                <h2><?php echo __('projects:project') ?>: <?php echo $project->name; ?></h2>

            <?php
                break;
            case 'task': ?>

                <h2><?php echo $task->project->name; ?>:<br /><?php echo $task->name; ?></h2>

            <?php
                break;
            case 'proposal': ?>

                <h2><?php echo __('proposals:proposal') ?>: <?php echo $proposal->title; ?></h2>

            <?php
                break;
            endswitch; ?>


    <?php if ( count($comments) ): ?>
        <?php foreach ($comments as $comment): ?>

            <?php // Comment ?>
            <?php include('comments/comment.php'); ?>

        <?php endforeach ?>
    <?php else: ?>

        <p><?php echo __('kitchen:nocomments') ?></p>

    <?php endif ?>

    <?php // Leave a comment ?>
    <?php include('comments/form.php'); ?>

</div>

<script>
    $('textarea').redactor(redactor_options);
</script>

