<div id="content">

    <?php echo str_ireplace('http://', '//', Business::getLogo(false, false));?>

    <h2>Hi <?php echo $invoice['first_name'].' '.$invoice['last_name'];?></h2>

    <?php // Partial payments ?>
    <?php include('simple/partial-payments.php'); ?>

    <?php // Payment plan ?>
    <?php include('simple/payment-plan.php'); ?>

    <?php // Invoice description ?>
    <?php include('simple/description.php'); ?>

    <?php // Invoice notes ?>
    <?php include('simple/notes.php'); ?>

    <?php // Invoice files ?>
    <?php include('simple/files.php'); ?>

</div>