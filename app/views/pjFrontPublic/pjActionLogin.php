<div class="fdLoader"></div>
<?php
$index = $controller->_get->toString('index');
// Theme 11's reference UI shows one header bar spanning the full width,
// above BOTH the menu and cart columns — themes 1-10 keep the header
// nested inside the menu column only, as it always was.
$fdTheme11 = (string) @$tpl['option_arr']['o_theme'] === 'theme11';
?>
<br />
<?php if ($fdTheme11): ?>
	<?php include_once dirname(__FILE__) . '/elements/header.php';?>
<?php endif; ?>
<div class="row">
	<div id="fdMain_<?php echo $index; ?>" class="col-md-8 col-sm-8 col-xs-12 pjFdPanelLeft">

		<div class="panel panel-default">
			<?php if (!$fdTheme11): ?>
				<?php include_once dirname(__FILE__) . '/elements/header.php';?>
			<?php endif; ?>
			<div class="panel-body  pjFdPanelBody">
				<form id="fdLoginForm_<?php echo $index;?>" action="" method="post" class="form-horizontal" data-toggle="validator">
					<input type="hidden" name="login_client" value="1"/>
					<div class="alert alert-warning alert-dismissible pjFdAlert" role="alert" style="display:none;">
						<button type="button" class="close" data-pj-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<i class="fa fa-info-circle"></i> <span id="fdLoginMessage_<?php echo $index;?>"></span>
					</div>

					<div class="form-group">
						<label for="" class="col-md-2 col-sm-4 control-label"><?php __('front_email'); ?></label>

						<div class="col-md-10 col-sm-8">
							<input type="email" class="form-control" name="login_email" data-required="<?php __('front_email_address_required');?>" data-email="<?php __('front_email_not_valid');?>"/>

							<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
						</div>
					</div><!-- /.form-group -->

					<div class="form-group">
						<label for="" class="col-md-2 col-sm-4 control-label"><?php __('front_password'); ?></label>

						<div class="col-md-10 col-sm-8">
							<input type="password" name="login_password" class="form-control" data-required="<?php __('front_password_required');?>">
							<div class="help-block with-errors"><ul class="list-unstyled"></ul></div>
						</div>
					</div><!-- /.form-group -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" class="btn btn-default text-uppercase fdButtonLogin"><?php __('front_button_login');?></button>
							<a href="#" class="btn btn-link text-capitalize fdForogtPassword pjFdBtnLink"><?php __('front_forgot_password');?></a>
							<?php
							if ($tpl['cart_box']['cart'] !== false && count($tpl['cart_box']['cart']) > 0)
							{ 
								?>
								<a href="#" class="btn btn-link fdContinue pjFdBtnLink"><strong><?php __('front_new_client');?></strong></a>
								<?php
							} 
							?>
						</div><!-- /.col-sm-offset-2 col-sm-10 -->
					</div><!-- /.form-group -->
				</form><!-- /.form-horizontal -->
			</div><!-- /.panel-body pjFdPanelBody -->
			
		</div><!-- /.panel panel-default -->
	</div><!-- /.col-md-8 col-sm-8 col-xs-12 pjFdPanelLeft -->
	<div id="fdCart_<?php echo $index; ?>" class="col-md-4 col-sm-4 col-xs-12 pjFdPanelRight">
		<?php include_once dirname(__FILE__) . '/elements/cart.php';?>
	</div><!-- /.col-md-4 col-sm-4 col-xs-12 pjFdPanelRight -->
</div><!-- /.row -->