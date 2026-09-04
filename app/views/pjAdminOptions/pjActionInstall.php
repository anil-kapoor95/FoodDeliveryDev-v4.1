<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoInstallTitle') ?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoInstallDesc') ?></p>
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="" method="get" class="form-horizontal">
                    <?php if (count($tpl['menu_locale_arr']) > 1) : ?>
                        <div class="m-b-lg">
                            <h2 class="no-margins"><?php __('lblInstallConfig');?></h2>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="col-lg-3 col-md-4 control-label"><?php __('lblInstallConfigLocale');?></label>

                                    <div class="col-lg-5 col-md-8">
                                        <select name="install_locale" id="install_locale" class="form-control">
                                            <option value="">-- <?php __('plugin_base_choose'); ?> --</option>
                                            <?php
                                            foreach ($tpl['menu_locale_arr'] as $locale)
                                            {
                                                ?><option value="<?php echo $locale['id']; ?>"><?php echo pjSanitize::html($locale['name']); ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 col-md-4 control-label"><?php __('lblInstallConfigHide');?></label>

                                    <div class="col-lg-5 col-md-8">
                                        <div class="clearfix">
                                            <div class="switch onoffswitch-data pull-left">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" class="onoffswitch-checkbox" id="install_hide" name="install_hide">
                                                    <label class="onoffswitch-label" for="install_hide">
                                                        <span class="onoffswitch-inner" data-on="<?php __('plugin_base_yesno_ARRAY_T', false, true); ?>" data-off="<?php __('plugin_base_yesno_ARRAY_F', false, true); ?>"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                    <?php endif; ?>

                    <div class="m-b-lg">
                        <h2 class="no-margins"><?php __('infoInstallCodeTitle');?></h2>
                    </div>

                    <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('lblInstallJs1_body') ?></p>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label class="col-lg-3 col-md-4 control-label"><?php __('lblInstallJs1_1');?></label>

                                <div class="col-lg-9 col-md-8">
                                    <textarea class="form-control textarea_install" id="install_code" rows="8">&lt;link href="<?php echo PJ_INSTALL_URL.PJ_FRAMEWORK_LIBS_PATH . 'pj/css/'; ?>pj.bootstrap.min.css" type="text/css" rel="stylesheet" /&gt;
&lt;link href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFrontEnd&action=pjActionLoadCss" type="text/css" rel="stylesheet" /&gt;
&lt;script type="text/javascript" src="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFrontEnd&action=pjActionLoad"&gt;&lt;/script&gt;</textarea>
                                </div>
                            </div>
                        </div>

                        <div style="display:none" id="hidden_code">&lt;link href="<?php echo PJ_INSTALL_URL.PJ_FRAMEWORK_LIBS_PATH . 'pj/css/'; ?>pj.bootstrap.min.css" type="text/css" rel="stylesheet" /&gt;
&lt;link href="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFrontEnd&action=pjActionLoadCss" type="text/css" rel="stylesheet" /&gt;
&lt;script type="text/javascript" src="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFrontEnd&action=pjActionLoadJS"&gt;&lt;/script&gt;</div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<?php if ((string) @$tpl['option_arr']['o_theme'] === 'theme11'): ?>
<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                $error_code = $controller->_get->toString('err');
                if ($error_code === 'AO08')
                {
                    $titles = __('error_titles', true);
                    $bodies = __('error_bodies', true);
                    ?>
                    <div class="alert alert-success">
                        <i class="fa fa-check m-r-xs"></i>
                        <strong><?php echo @$titles[$error_code]; ?></strong>
                        <?php echo @$bodies[$error_code]; ?>
                    </div>
                    <?php
                }
                ?>

                <div class="m-b-lg">
                    <h2 class="no-margins"><?php __('infoTheme11ColorsTitle'); ?></h2>
                </div>

                <p class="alert alert-info alert-with-icon m-t-xs"><i class="fa fa-info-circle"></i> <?php __('infoTheme11ColorsDesc'); ?></p>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;action=pjActionUpdate" method="post" class="form-horizontal" id="frmTheme11Colors">
                    <input type="hidden" name="options_update" value="1" />
                    <input type="hidden" name="csrf_token" value="<?php echo pjAppController::getCsrfToken(); ?>" />
                    <input type="hidden" name="next_action" value="pjActionInstall" />

                    <?php
                    $theme11_color_groups = array(
                        'lblTheme11ColorGroupHeader' => array(
                            'o_theme11_color_header_bg'   => array('lblTheme11ColorHeaderBg', '#ffffff'),
                            'o_theme11_color_header_text' => array('lblTheme11ColorHeaderText', '#1a1a1a'),
                        ),
                        'lblTheme11ColorGroupButtons' => array(
                            'o_theme11_color_primary'      => array('lblTheme11ColorPrimary', '#ee4d3d'),
                            'o_theme11_color_primary_text' => array('lblTheme11ColorPrimaryText', '#ffffff'),
                            'o_theme11_color_success'      => array('lblTheme11ColorSuccess', '#22c55e'),
                            'o_theme11_color_link'         => array('lblTheme11ColorLink', '#2f6fed'),
                        ),
                        'lblTheme11ColorGroupPage' => array(
                            'o_theme11_color_body_bg' => array('lblTheme11ColorBodyBg', '#f6f6f8'),
                            'o_theme11_color_card_bg' => array('lblTheme11ColorCardBg', '#ffffff'),
                            'o_theme11_color_text'    => array('lblTheme11ColorText', '#1f2328'),
                            'o_theme11_color_muted'   => array('lblTheme11ColorMuted', '#767c86'),
                            'o_theme11_color_border'  => array('lblTheme11ColorBorder', '#ececee'),
                        ),
                    );
                    foreach ($theme11_color_groups as $group_label_key => $fields_arr)
                    {
                        ?>
                        <h4 class="m-t-md"><?php __($group_label_key); ?></h4>
                        <div class="hr-line-dashed"></div>
                        <?php
                        foreach ($fields_arr as $key => $meta)
                        {
                            $value = !empty($tpl['option_arr'][$key]) ? $tpl['option_arr'][$key] : $meta[1];
                            ?>
                            <div class="form-group">
                                <label class="col-sm-3 col-md-2 control-label"><?php echo __($meta[0], true, false); ?></label>
                                <div class="col-sm-5 col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon" style="padding:2px 4px;">
                                            <input type="color" name="value-color-<?php echo $key; ?>" value="<?php echo pjSanitize::html($value); ?>" style="width:34px;height:32px;padding:1px;border:0;vertical-align:middle;" oninput="this.parentElement.nextElementSibling.value=this.value;">
                                        </span>
                                        <input type="text" class="form-control" value="<?php echo pjSanitize::html($value); ?>" onchange="this.previousElementSibling.firstElementChild.value=this.value;" oninput="if(/^#[0-9a-fA-F]{6}$/.test(this.value)){this.previousElementSibling.firstElementChild.value=this.value;}">
                                    </div>
                                </div>
                            </div><!-- /.form-group -->
                            <?php
                        }
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary"><?php __('btnTheme11ColorsSave'); ?></button>
                        </div>
                    </div><!-- /.form-group -->
                </form>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>
<?php endif; ?>