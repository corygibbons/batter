<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>

        <?php $frontend_css = function_exists('frontend_css') ? frontend_css() : Settings::get('frontend_css'); ?>
        <?php $frontend_js = function_exists('frontend_js') ? frontend_js() : Settings::get('frontend_js'); ?>

        <title><?php echo __('kitchen:kitchen_name') ?> | <?php echo Business::getBrandName(); ?></title>

        <!--favicon-->
        <link rel="shortcut icon" href=""/>

        <!--metatags-->
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <link rel="mask-icon" href="<?php echo asset::get_src('mask-icon.svg', 'img'); ?>" color="rgb(232,163,75)">

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo Asset::get_src("redactor/redactor.css", 'js'); ?>"/>
        <?php echo asset::css('kitchen_style.css', array('media' => 'all')); ?>
        <?php echo (asset::get_src('frontend.css', 'css') == "") ? "" : asset::css('frontend.css', array('media' => 'all'), null, false); ?>

        <link href='//fonts.googleapis.com/css?family=Cabin:400,700&subset=latin&v2' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Copse&subset=latin&v2' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

        <?php echo asset::js('jquery-1.11.0.min.js'); ?>
        <?php
        /*
         * If the current environment is "development", then the dev version of jQuery Migrate will be loaded,
         * which will generate console warnings about everything that needs updating.
         */
        ?>
        <?php echo asset::js('jquery-migrate-1.2.1' . (!IS_DEBUGGING ? '.min' : '') . '.js'); ?>
        <script>document.write('<script src="<?php echo asset::get_src('redactor/redactor.min.js', 'js');?>">\x3C/script>')</script>
        <script>
            var redactor_options = {
                minHeight: 150,
                imageUpload: '<?php echo site_url("ajax/image_upload"); ?>',
                fileUpload: '<?php echo site_url("ajax/file_upload"); ?>',
            };
        </script>

        <?php if (!empty($frontend_css)): ?>
            <link rel="stylesheet" href="<?php echo site_url("frontend_css/" . crc32($frontend_css) . '.css'); ?>"/>
        <?php endif; ?>

    </head>

    <body class="kitchen <?php echo is_admin() ? 'admin' : 'not-admin'; ?>">

        <div id="buttonBar">

            <div id="buttonHolders">
                <?php if (!isset($is_login) or !$is_login): ?>
                    <?php echo str_ireplace('http://', '//', Business::getLogo(false, false, 2)); ?>
                <?php endif; ?>


                <?php if (logged_in()): ?>
                    <?php echo anchor('admin/', __('global:backtoadmin'), 'class="button"'); ?>
                <?php endif; ?>
                <?php if ($this->session->userdata('client_passphrase') != ''): ?>
                    <?php echo !logged_in() ? anchor(Settings::get('kitchen_route') . '/logout/' . $this->uri->segment(2), __('global:logout'), 'class="button"') : ''; ?>
                <?php endif; ?>
                <?php echo anchor(Settings::get('kitchen_route') . '/' . $this->uri->segment(2), __('global:dashboard'), 'class="button ' . ($this->uri->segment(3) == '' ? 'active' : '') . '"'); ?>
                <?php if ($client->support_user_id > 0): ?>
                    <?php echo anchor(Settings::get('kitchen_route') . '/' . $this->uri->segment(2) . '/tickets', __('tickets:support_tickets'), 'class="button ' . ($this->uri->segment(3) == 'tickets' ? 'active' : '') . '"'); ?>
                    <?php if ($client->can_create_support_tickets): ?>
                        <?php echo anchor(Settings::get('kitchen_route') . '/' . $this->uri->segment(2) . '/new_ticket', __('tickets:submit_new'), 'class="button ' . ($this->uri->segment(3) == 'new_ticket' ? 'active' : '') . '"'); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <span class="button-bar-text "><?php echo __('kitchen:kitchen_name') ?></span>
            </div>
            <!-- /buttonHolders -->

        </div>
        <!-- /buttonBar -->

        <div id="wrapper">

            <?php echo $template['body']; ?>

            <div id="footer">

            </div>
            <!-- /footer -->
        </div>
        <!-- /wrapper -->
        <script src="<?php echo Asset::get_src("kitchen.js", "js"); ?>"></script>
        <?php if (!empty($frontend_js)): ?>
            <script src="<?php echo site_url("frontend_js/" . crc32($frontend_js) . '.js'); ?>"></script>
        <?php endif; ?>
    </body>
</html>