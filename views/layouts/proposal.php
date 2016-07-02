<?php $can_edit = (logged_in() && can("edit", $proposal['client_id'], "proposals", $proposal['id'])); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>

        <?php $frontend_css = function_exists('frontend_css') ? frontend_css() : Settings::get('frontend_css'); ?>
        <?php $frontend_js = function_exists('frontend_js') ? frontend_js() : Settings::get('frontend_js'); ?>

        <title><?php echo __('global:proposal'); ?> | <?php echo Business::getBrandName(); ?></title>
        <!--favicon-->
        <link rel="shortcut icon" href=""/>
        <!--metatags-->
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <link rel="mask-icon" href="<?php echo asset::get_src('mask-icon.svg', 'img'); ?>" color="rgb(232,163,75)">

        <!-- CSS -->
        <?php echo asset::css('proposal_style.css', array('media' => 'all')); ?>
        <?php echo (asset::get_src('frontend.css', 'css') == "") ? "" : asset::css('frontend.css', array('media' => 'all')); ?>

        <?php if (!$pdf_mode): ?>
            <?php echo asset::css('facebox.css', array('media' => 'all')); ?>
            <?php echo asset::css('pancake_bar_style.css', array('media' => 'all')); ?>
            <link rel="stylesheet" href="<?php echo Asset::get_src("redactor/redactor.css", 'js'); ?>"/>
        <?php endif; ?>

        <?php if (Settings::get('use_utf8_font') and $pdf_mode): ?>
            <style>.pdf, .pdf * {
                    font-family: "dejavu sans" !important;
                }</style>
        <?php endif; ?>

        <?php if (!empty($frontend_css)): ?>
            <link rel="stylesheet" href="<?php echo site_url("frontend_css/" . crc32($frontend_css) . '.css'); ?>"/>
        <?php endif; ?>

        <?php if (!$pdf_mode): ?>
            <script>
                proposalAutosave = <?php echo (Settings::get('autosave_proposals') == 1) ? 'true' : 'false';?>;
                proposalGetProcessedEstimate = '<?php echo site_url('get_processed_estimate');?>';
                proposalGetEstimates = '<?php echo site_url('ajax/get_estimates/'.$proposal['client_id'].'/'.'{UNIQID}');?>';
                proposalGetPremadeSections = '<?php echo site_url('ajax/get_premade_sections/');?>';
                faceboxURL = '<?php echo str_replace('facebox.js', '', asset::get_src('facebox/facebox.js', 'js'));?>';
                faceboxLoadingImageURL = '<?php echo asset::get_src('facebox/loading.gif', 'js');?>';
                faceboxCloseLabelURL = '<?php echo asset::get_src('facebox/closelabel.png', 'js');?>';
                proposalSavePremadeSectionUrl = '<?php echo site_url('ajax/save_premade_section');?>';
                proposalSaveUrl = '<?php echo site_url('ajax/save_proposal/'.$proposal['unique_id']);?>';
                proposalStatusUrl = '<?php echo site_url('ajax/set_proposal/'.$proposal['unique_id']);?>/';
            </script>

        <?php echo asset::js('jquery-1.11.0.min.js'); ?>
        <?php
        /*
         * If the current environment is "development", then the dev version of jQuery Migrate will be loaded,
         * which will generate console warnings about everything that needs updating.
         */
        ?>
        <?php echo asset::js('jquery-migrate-1.2.1' . (!IS_DEBUGGING ? '.min' : '') . '.js'); ?>

            <!-- Loading fonts from Google Fonts to provide some nice text -->
            <link href='//fonts.googleapis.com/css?family=Paytone+One&v1' rel='stylesheet' type='text/css'>
            <link href='//fonts.googleapis.com/css?family=Muli&v1' rel='stylesheet' type='text/css'>

        <?php if ($can_edit) : ?>
            <script src="<?php echo asset::get_src('jquery-ui-1.10.4.sortable.min.js', 'js'); ?>"></script>
            <script type="text/javascript" src="<?php echo asset::get_src('facebox/facebox.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo asset::get_src('redactor/redactor.min.js'); ?>"></script>
            <script>
                var redactor_options = {
                    minHeight: 150,
                    imageUpload: '<?php echo site_url("ajax/image_upload"); ?>',
                    fileUpload: '<?php echo site_url("ajax/file_upload"); ?>'
                };
            </script>
        <?php endif; ?>
        <?php endif; ?>
    </head>

    <body class="proposal <?php echo $can_edit ? 'admin' : 'not-admin'; ?> <?php echo $pdf_mode ? 'pdf' : 'not-pdf'; ?>" data-empty-title="<?php echo __('proposals:emptysection'); ?>" data-empty-subtitle="<?php echo __('proposals:emptysubtitle'); ?>" data-empty-contents="<?php echo __('proposals:emptycontents'); ?>">
        <?php if (!$pdf_mode): ?>
            <div id="buttonBar" data-status="<?php echo $proposal['status']; ?>">

                <div id="buttonHolders">
                    <?php if ($can_edit): ?>
                        <?php echo anchor('admin/proposals', __("global:admin") . ' &rarr;', 'class="button"'); ?>
                        <?php echo anchor(Settings::get('kitchen_route') . '/' . $proposal['client']['unique_id'], __("global:client_area") . ' &rarr;', 'class="button"'); ?>
                        <?php echo anchor('proposal/' . $proposal['unique_id'] . '/pdf', __('global:downloadpdf'), 'target="_blank"'); ?>
                        <?php echo anchor('admin/proposals/send/' . $proposal['unique_id'], __('global:send_to_client'), 'class="button"'); ?>
                        <?php echo anchor('admin', ($proposal['is_viewable'] ? __('global:viewable') : __('global:not_viewable')), 'class="toggle_is_viewable ' . ($proposal['is_viewable'] ? 'viewable' : 'not-viewable') . ' button" data-not-viewable="' . __('global:not_viewable') . '" data-viewable="' . __('global:viewable') . '"'); ?>
                        <?php echo anchor('admin/proposals/all', __('proposals:save'), 'class="saveProposal button" data-saving="' . __('proposals:saving') . '" data-saved="' . __('proposals:saved') . '" data-save="' . __('proposals:save') . '"'); ?>
                        <?php echo anchor('admin', __('global:mark_as_unanswered'), 'class="unanswer button"'); ?>
                        <?php echo anchor('admin', __('global:mark_as_accepted'), 'class="admin accept button"'); ?>
                        <?php echo anchor('admin', __('global:mark_as_rejected'), 'class="admin reject button"'); ?>
                    <?php else: ?>
                        <?php echo anchor(Settings::get('kitchen_route') . '/' . $proposal['client']['unique_id'], __("global:client_area") . ' &rarr;', 'class="button"'); ?>
                        <?php echo anchor('proposal/' . $proposal['unique_id'] . '/pdf', __('global:downloadpdf'), 'target="_blank"'); ?>
                        <?php echo anchor('admin', __('global:reject_proposal'), 'class="client reject button"'); ?>
                        <?php echo anchor('admin', __('global:accept_proposal'), 'class="client accept button"'); ?>
                    <?php endif; ?>
                    <?php echo anchor('admin', __('global:proposal_rejected'), 'class="rejected button"'); ?>
                    <?php echo anchor('admin', __('global:proposal_accepted'), 'class="accepted button"'); ?>
                </div>
                <!-- /buttonHolders -->

            </div><!-- /buttonBar -->
        <?php if (!$pdf_mode): ?>
            <script>
                $('#buttonBar').each(function () {
                    var status = $(this).data('status');

                    $('.proposal.admin .client.accept, .proposal.admin .client.reject, .proposal.not-admin .admin.accept, .proposal.not-admin .admin.reject, .proposal.not-admin .unanswer.button').hide();

                    if (status == 'ACCEPTED') {
                        $('.accept, .reject, .rejected').hide();
                    } else {
                        if (status == 'REJECTED') {
                            $('.accept, .reject, .accepted').hide();
                        } else {
                            $('.unanswer.button, .rejected, .accepted').hide();
                        }
                    }
                });
            </script>
        <?php endif; ?>
        <?php endif; ?>
        <div class="sidebar">
            <?php echo Business::getLogo(false, false); ?>
            <h2><?php echo lang('proposal:outline') ?></h2>
            <ul>
                <?php foreach ($proposal['pages'] as $key => $page) : ?>
                    <li class="page page-<?php echo $key; ?>" data-key="<?php echo $key; ?>">
                        <span class="pageCount"><?php echo __("proposals:pagexofcount", array($key, '<span class="pageTotal">' . count($proposal['pages']) . '</span>')); ?></span>
                        <ul>
                            <?php foreach ($page['sections'] as $section) : ?>
                                <li class="section section-<?php echo $section['key']; ?>" data-key="<?php echo $section['key']; ?>">
                                    <span><?php echo empty($section['title']) ? __('proposals:emptysection') : $section['title']; ?></span>
                                    <ul>
                                        <?php if (isset($section['sections'])) : ?>
                                            <?php foreach ($section['sections'] as $subsection) : ?>
                                                <li class="section subsection section-<?php echo $subsection['key']; ?>" data-key="<?php echo $subsection['key']; ?>"></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="wrapper">
            <div class="editing-container">
                <div class="editing"><a href="" class="confirm"> Accept</a> <a href="" class="cancel"> Discard </a>
                </div>
            </div>
            <div id="header" class="cover-page">
                <div id="envelope">
                    <table border="0" cellspacing="5" cellpadding="5" width="100%">
                        <tr>
                            <td style="width: 50%;text-align: left;">
                                <p>
                                    <span class="clientCompany editable"><?php echo $proposal['client']['company']; ?></span>
                                    <br/>
                                    <span class="clientName editable"><?php echo $proposal['client']['name']; ?></span>
                                    <br/>
                                    <span class="clientAddress editable"><?php echo stristr($proposal['client']['address'], '<br') !== false ? $proposal['client']['address'] : nl2br($proposal['client']['address']); ?></span>
                                </p>
                            </td>
                            <td class="logo-brand-details">
                                <p><?php echo Business::getLogo(false, false, null); ?>
                                    <br/><?php echo Business::getHtmlEscapedMailingAddress(); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /envelope -->

                <div id="clientInfo">
                    <div id="proposalTitleHolder">
                        <table border="0" cellspacing="5" cellpadding="5" width="100%">
                            <tr>
                                <td class="title">
                                    <span class="proposalId"><?php echo $proposal['id']; ?></span>

                                    <h2 class="proposalTitle editable"><?php echo $proposal['title']; ?></h2>

                                    <p class="clientId"><?php echo $proposal['client']['id']; ?>

                                    <h2><?php echo __('proposals:for'); ?>
                                        <br/><span class="clientCompany editable"><?php echo $proposal['client']['company']; ?></span><br/>
                                        <small><?php echo format_date($proposal['created']); ?></small>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <!-- /proposalTitleHolder -->
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