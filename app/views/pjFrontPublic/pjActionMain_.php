<div class="fdLoader"></div>
<?php $index = $controller->_get->toString('index');?>
<br />
<div class="row">
	<div id="fdMain_<?php echo $index; ?>" class="col-md-8 col-sm-8 col-xs-12 pjFdPanelLeft">
		
		<div class="panel panel-default">
			<?php include_once dirname(__FILE__) . '/elements/header.php';?>
			<div class="panel-body pjFdPanelBody">
				<div class="panel-group" id="pjFdAccordion_<?php echo $index;?>" aria-multiselectable="true">
					<?php
					// Theme 11's reference UI keeps every category collapsed until the
					// customer opens one — themes 1-10 keep their original behaviour of
					// auto-expanding the first category, so this only changes theme11.
					$fdTheme11Collapsed = (string) @$tpl['option_arr']['o_theme'] === 'theme11';
					foreach($tpl['main']['category_arr'] as $k => $v)
					{
						if((int) $v['cnt_products'] > 0)
						{
							$fdCategoryOpen = !$fdTheme11Collapsed && $k==0;
							?>
							<div class="panel panel-default">
								<div class="panel-heading pjFdAccourdionOuterHead" role="tab" id="heading<?php echo $v['id']?>">
									<h1 class="panel-title text-uppercase">
										<a id="pjFdCategory_<?php echo $v['id'];?>" class="pjFdProductsType<?php echo $fdCategoryOpen ? null : ' collapsed';?>" data-cid="<?php echo $v['id'];?>" data-pj-toggle="collapse" data-pj-parent="#pjFdAccordion_<?php echo $index;?>" href="#collapse<?php echo $v['id']?>" aria-expanded="<?php echo $fdCategoryOpen ? 'true' : 'false';?>" aria-controls="collapse<?php echo $v['id']?>">
											<div class="row">
												<div class="col-md-9 col-sm-9 col-xs-8">
													<!-- Card-grid themes (theme11) show an icon + item-count subtitle here;
													     hidden by default in FoodDelivery.css so themes 1-10 are unaffected. -->
													<span class="pjFdCategoryIcon"><i class="fa fa-cutlery"></i></span>
													<span class="pjFdCategoryTitleWrap">
														<span class="pjFdCategoryName"><?php echo pjSanitize::clean($v['name']);?></span>
														<span class="pjFdCategoryCount"><?php echo (int) $v['cnt_products']; ?> <?php echo (int) $v['cnt_products'] == 1 ? __('front_item', true, false) : __('front_items', true, false); ?></span>
													</span>
												</div><!-- /.col-md-9 col-sm-9 col-xs-8 -->

												<div class="col-md-3 col-sm-3 col-xs-4 text-right">
													<span class="pjFdCategoryViewAll"><?php __('front_view_all'); ?></span>
													<i class="fa fa-minus"></i>
													<i class="fa fa-plus"></i>
												</div><!-- /.col-md-3 col-sm-3 col-xs-4 -->
											</div><!-- /.row -->
										</a>
									</h1><!-- /.panel-title -->
								</div><!-- /#headingOne.panel-heading -->
								
								
								<div class="panel-collapse collapse<?php echo $fdCategoryOpen ? ' in' : null;?>" id="collapse<?php echo $v['id']?>" data-id="<?php echo $v['id'];?>" role="tabpanel" aria-labelledby="heading<?php echo $v['id']?>">
									<div class="panel-body">
										<div class="panel-group pjFdProducts" id="accordionInner<?php echo $v['id']?>" data-fill="false" aria-multiselectable="true">
											
										</div>
									</div>
								</div>
								
							</div><!-- /.panel panel-default -->
							<?php
						}
					} 
					?>
				</div><!-- /#accordion.panel-group -->
			</div><!-- /.panel-body pjFdPanelBody -->
		</div><!-- /.panel panel-default -->
		
	</div>
	<div id="fdCart_<?php echo $index; ?>" class="col-md-4 col-sm-4 col-xs-12 pjFdPanelRight">
		<?php include_once dirname(__FILE__) . '/elements/cart.php';?>
	</div><!-- /.col-md-4 col-sm-4 col-xs-12 pjFdPanelRight -->
</div><!-- /.row -->