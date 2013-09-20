<!DOCTYPE html>

<html>

<head>

    <title><?php echo Settings::get('site_name'); ?></title>

    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />

    <!-- CSS -->
    <?php echo asset::css('request.css', array('media' => 'all')); ?>

    <?php if (Settings::get('frontend_css')): ?>
    	<style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>
            <!-- Grab Google CDN's jQuery and jQuery UI, with a protocol relative URL; fall back to local if necessary -->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.js"></script>
            <script>window.jQuery || document.write('<script src="<?php echo asset::get_src('jquery.min.js', 'js');?>">\x3C/script>')</script>
     <?php if (isset($custom_head)): ?>
            <?php echo $custom_head;?>
            <?php endif;?>
</head>

<body class="simple-invoice transaction <?php echo is_admin() ? 'admin' : 'not-admin';?>" <?php echo (isset($autosubmit) and $autosubmit) ? 'onLoad="var forms = document.getElementsByTagName(\'FORM\'); for (var i=0; i<forms.length; i++) forms[i].submit();"' : ''; ?>>





<?php echo logo(false, false);?>





<?php echo $template['body']; ?>





</body>
</html>