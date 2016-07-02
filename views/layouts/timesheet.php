<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>

        <?php $frontend_css = function_exists('frontend_css') ? frontend_css() : Settings::get('frontend_css'); ?>
        <?php $frontend_js = function_exists('frontend_js') ? frontend_js() : Settings::get('frontend_js'); ?>

        <title><?php echo __('timesheet:forproject', array($project)); ?> | <?php echo Business::getBrandName(); ?></title>
        <!--favicon-->
        <link rel="shortcut icon" href=""/>
        <!--metatags-->
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <link rel="mask-icon" href="<?php echo asset::get_src('mask-icon.svg', 'img'); ?>" color="rgb(232,163,75)">

        <!-- CSS -->
        <?php echo asset::css('invoice_style.css', array('media' => 'all')); ?>
        <?php echo (asset::get_src('frontend.css', 'css') == "") ? "" : asset::css('frontend.css', array('media' => 'all'), null, false); ?>

        <?php if (Settings::get('use_utf8_font') and $pdf_mode): ?>
            <style>.pdf, .pdf * {
                    font-family: "dejavu sans" !important;
                }</style>
        <?php endif; ?>

        <?php if (!empty($frontend_css)): ?>
            <link rel="stylesheet" href="<?php echo site_url("frontend_css/" . crc32($frontend_css) . '.css'); ?>"/>
        <?php endif; ?>

    </head>

    <body class="timesheet <?php echo is_admin() ? 'admin' : 'not-admin'; ?> <?php echo ($pdf_mode) ? 'pdf_mode pdf' : 'not-pdf'; ?>">
        <?php if (!$pdf_mode): ?>
            <div id="buttonBar">

                <div id="buttonHolders">
                    <?php if (logged_in()): ?>
                        <?php echo anchor('admin', 'Go to Admin &rarr;', 'class="button"'); ?>
                    <?php endif; ?>
                    <div id="pdf">
                        <a href="<?php echo $timesheet_url_pdf; ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
                    </div>
                    <!-- /pdf -->
                </div>
                <!-- /buttonHolders -->

            </div><!-- /buttonBar -->
        <?php endif; ?>
        <div id="wrapper">

            <div id="header">

                <div id="clientInfo">
                    <div id="envelope2">
                        <table cellspacing="5" cellpadding="5">
                            <tr>
                                <td width="310px" style="vertical-align:top;"><h2><?php echo __('timesheet:for'); ?>
                                        <br/><?php echo $client['company']; ?></h2>

                                    <p><?php echo $client['company']; ?> - <?php echo $client['first_name'] . ' ' . $client['last_name']; ?>
                                        <br/>
                                        <?php echo nl2br($client['address']); ?></p>

                                    <p class="project-details">
                                        <span><strong><?php echo __('projects:project'); ?>:</strong> <?php echo $project; ?></span><br/>
                                        <?php if (isset($task)): ?>
                                            <span><strong><?php echo __('global:task'); ?>:</strong> <?php echo $task['name']; ?></span>
                                            <br/>
                                        <?php endif; ?>
                                        <span><strong><?php echo __('partial:dueon'); ?>: </strong><?php echo $project_due_date ? format_date($project_due_date) : '<em>n/a</em>'; ?></span><br/>
                                        <span><strong><?php echo __('timesheet:totalbillable'); ?>: </strong><?php echo $total_hours; ?></span>
                                    </p>

                                </td>
                                <td width="310px" style="text-align:right;vertical-align:top;">
                                    <?php echo Business::getLogo(false, false, 2); ?>
                                    <p><?php echo Business::getHtmlEscapedMailingAddress(); ?></p>
                                </td>
                            </tr>
                        </table>
                        <br/> <br/>
                    </div>
                </div>
                <!-- /clientInfo -->
            </div>
            <!-- /header -->
            <?php echo $template['body']; ?>
            <div id="footer">

            </div>
            <!-- /footer --><!-- /wrapper -->

        </div>
        <?php if (!empty($frontend_js)): ?>
            <script src="<?php echo site_url("frontend_js/" . crc32($frontend_js) . '.js'); ?>"></script>
        <?php endif; ?>
    </body>

</html>