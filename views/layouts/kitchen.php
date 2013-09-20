<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

    <title><?php echo __('kitchen:kitchen_name') ?> | <?php echo Settings::get('site_name'); ?></title>

    <!--favicon-->
    <link rel="shortcut icon" href="" />

    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />

    <!-- CSS -->
    <?php echo asset::css('kitchen.css', array('media' => 'all')); ?>
    <?php echo asset::css('plugins/redactor.css', array('media' => 'all')); ?>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo asset::get_src('jquery.min.js', 'js');?>">\x3C/script>')</script>
    <script>document.write('<script src="<?php echo asset::get_src('redactor/redactor.min.js', 'js');?>">\x3C/script>')</script>
    
    <?php if (Settings::get('frontend_css')): ?>
        <style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>

</head>


<body class="kitchen <?php echo is_admin() ? 'admin' : 'not-admin';?>">
    
    

<?php if (logged_in()): ?>
    <?php echo anchor('admin/', __('global:backtoadmin') ); ?>
<?php endif; ?>

<?php if ($this->session->userdata('client_passphrase') != ''): ?>
    <?php if ($this->uri->segment(3) == ''): ?>
        <?php echo anchor(Settings::get('kitchen_route').'/'.$this->uri->segment(2), 'Dashboard', 'class="button active"'); ?>
    <?php endif; ?>
<?php endif; ?>


<?php if ($this->session->userdata('client_passphrase') != ''): ?>
    <?php echo anchor(Settings::get('kitchen_route').'/logout/'.$this->uri->segment(2), __('global:logout'), 'class="button"'); ?>
<?php endif; ?>

<?php if ($this->uri->segment(4) != ''): ?>
    <?php echo anchor(Settings::get('kitchen_route').'/'.$this->uri->segment(2), __('kitchen:backtodashboard'), 'class="button"'); ?>
<?php endif; ?>

<?php echo Settings::get('site_name'); ?> - <?php echo __('kitchen:kitchen_name') ?>

    

<?php echo $template['body']; ?>


</body>
</html>