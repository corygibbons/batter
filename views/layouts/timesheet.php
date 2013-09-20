<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title><?php echo __('timesheet:forproject', array($project)); ?> | <?php echo Settings::get('site_name'); ?></title>
    <!--favicon-->
    <link rel="shortcut icon" href="" />
    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />

    <!-- CSS -->
    <?php echo asset::css('invoice.css', array('media' => 'all'), NULL, $pdf_mode); ?>

    <?php if (Settings::get('frontend_css')): ?>
        <style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>

</head>

<body class="timesheet <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php echo ($pdf_mode) ? 'pdf_mode' : '';?>">


<?php if( ! $pdf_mode): ?>

    <?php if (logged_in()): ?>
        <?php echo anchor('admin', 'Go to Admin &rarr;', 'class="button"'); ?>
    <?php endif; ?>

    <a href="<?php echo $timesheet_url_pdf; ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>

<?php endif; ?>





<!-- Client company name -->
<h2><?php echo __('timesheet:for');?><br /><?php echo $client['company'];?></h2>
<!-- Client first and last name -->
<?php echo $client['company'];?> - <?php echo $client['first_name'].' '.$client['last_name'];?>
<!-- Client address -->
<?php echo nl2br($client['address']);?></p></td>





<!-- Company name -->
<?php echo logo(false, false, 2);?>
<!-- Company mailing address -->
<?php echo nl2br(Settings::get('mailing_address')); ?>





<!-- Project -->
<?php echo __('projects:project');?>:
<?php echo $project;?>
<!-- Due -->
<?php echo __('partial:dueon');?>:
<?php echo $project_due_date ? format_date($project_due_date) : '<em>n/a</em>';?>
<!-- Total billable hours -->
<?php echo __('timesheet:totalbillable');?>:
<?php echo $total_hours;?>





<?php echo $template['body']; ?>





</body>
    
</html>