<?php
if(isset($tpl['arr']) && !empty($tpl['arr']))
{
	$category_id = $controller->_get->toInt('category_id');
	foreach($tpl['arr'] as $product)
	{
		// Same local "no image" fallback categories.php already uses — not
		// the old hosted placeholder service, which no longer resolves and
		// left every photo-less product showing a broken image icon.
		$image_path = PJ_INSTALL_URL . PJ_IMG_PATH . 'frontend/no_image.png';
		if(!empty($product['image']))
		{
			$image_path = PJ_INSTALL_URL . $product['image'];
		}
		?>
		<div class="panel panel-default pjFdProduct">
			<form style="overflow: hidden;" action="" method="post">
				<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
				<div class="panel-heading pjFdProductHead" id="headingInner<?php echo $category_id?><?php echo $product['id']?>">
					<h2 class="panel-title">
						<a data-pj-toggle="collapse" data-pj-parent="#accordionInner<?php echo $category_id;?>" href="#collapseInner<?php echo $category_id;?><?php echo $product['id']?>" aria-expanded="<?php echo $product['is_featured'] == '1' ? 'true' : 'false';?>" aria-controls="collapseInner<?php echo $category_id;?><?php echo $product['id']?>">
							<!-- Card-grid themes (theme11) show this thumbnail up front; hidden by default
							     in FoodDelivery.css so themes 1-10 render exactly as before. -->
							<div class="pjFdProductMedia">
								<img src="<?php echo $image_path;?>" alt="" class="pjFdProductThumb" />
								<?php if ($product['is_featured'] == '1'): ?>
								<span class="pjFdBadgeBestSeller"><?php __('front_best_seller'); ?></span>
								<?php endif; ?>
								<!-- Decorative favourite toggle — local UI state only, nothing is
								     persisted or sent to the server. Stops the click from bubbling
								     to the card so tapping the heart doesn't also open the product. -->
								<!-- <span class="pjFdFavorite" onclick="event.preventDefault(); event.stopPropagation(); this.classList.toggle('pjFdFavoriteOn');" title="<?php __('front_favorite'); ?>">
									<i class="fa fa-heart"></i>
								</span> -->
							</div>
							<div class="row">
								<div class="col-md-9 col-sm-9 col-xs-8 text-capitalize pjFdProductName"><?php echo pjSanitize::clean($product['name']);?></div><!-- /.col-md-10 col-sm-10 col-xs-10 -->

								<div class="col-md-3 col-sm-3 col-xs-4 text-right pjFdProductPrice">
								<?php
								if($product['set_different_sizes'] == 'F' || count($product['price_arr']) == 0)
								{
								    echo pjCurrency::formatPrice($product['price']);
								}
								?>
								</div><!-- /.col-md-2 col-sm-2 col-xs-2 -->
							</div>
							<!-- Card-grid themes (theme11) show name + description + price + a quick-add
							     button in the always-visible card body; hidden by default so themes
							     1-10 keep using the .row above unchanged. Clicks bubble up to this
							     same <a> (no JS needed) so the "+" opens the same order/extras panel
							     the rest of the card opens — it's a fast way in, not a bypass of size
							     or extras selection. -->
							<div class="pjFdProductCardInfo">
								<div class="pjFdProductCardName text-capitalize"><?php echo pjSanitize::clean($product['name']);?></div>
								<?php if (!empty($product['description'])): ?>
								<div class="pjFdProductCardDesc"><?php echo pjSanitize::clean($product['description']);?></div>
								<?php endif; ?>
								<div class="pjFdProductCardFooter">
									<span class="pjFdProductCardPrice">
									<?php
									if($product['set_different_sizes'] == 'F' || count($product['price_arr']) == 0)
									{
									    echo pjCurrency::formatPrice($product['price']);
									}
									else
									{
									    __('front_from_price');
									}
									?>
									</span>
									<span class="pjFdQuickAdd"><i class="fa fa-info"></i></span>
								</div>
							</div>
						</a>
					</h2><!-- /.panel-title -->
				</div><!-- /#headingInnerOne.panel-heading -->
				<div class="panel-collapse collapse<?php echo $product['is_featured'] == '1' ? ' in' : null;?>" id="collapseInner<?php echo $category_id;?><?php echo $product['id']?>" role="tabpanel" aria-labelledby="headingInner<?php echo $category_id;?><?php echo $product['id']?>">
					<div class="panel-body pjFdProductBody">
						<div class="row pjFdProductContent">
							<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-8 pjFdProductBodyMedia">
									<img src="<?php echo $image_path;?>" alt="Responsive image" class="img-responsive" />
								</div><!-- /.col-lg-4 col-md-4 col-sm-4 col-xs-8 -->

								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 pjFdProductBodyText">
									<p><?php echo nl2br(pjSanitize::clean($product['description']));?></p>
								</div><!-- /.col-lg-8 col-md-8 col-sm-8 col-xs-12 -->
							</div><!-- /.col-lg-10 col-md-10 col-sm-12 col-xs-12 -->

							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 pjFdColCustom">
								<?php
								if($product['set_different_sizes'] == 'T' && count($product['price_arr']) > 0)
								{
									?>
									<select id="fdSelectSize_<?php echo $product['id'];?>" name="price_id" class="form-control" data-id="<?php echo $product['id'];?>">
										<?php
										foreach($product['price_arr'] as $price)
										{
										    ?><option value="<?php echo $price['id']?>"><?php echo $price['price_name']?>: <?php echo pjCurrency::formatPrice($price['price']);?></option><?php
										}
										?>
									</select>
									<?php
								}
								?>
								<br/>
								<button class="btn btn-default btn-block text-uppercase pjFdBtnOrder fdProductOrder" role="button" data-id="<?php echo $product['id'];?>"><?php __('front_order');?></button>
							</div><!-- /.col-lg-2 col-md-2 col-sm-3 col-xs-4 -->
						</div><!-- /.row -->

						<br />
						<?php
						if(!empty($product['extra_arr']))
						{
							?>
							<div class="row">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table pjFdProductMeta">
									<?php
									foreach($product['extra_arr'] as $extra)
									{
										?>
										<tr>
											<td class="col-lg-7 col-md-6 col-sm-5 col-xs-4 text-capitalize">
												<?php echo pjSanitize::clean($extra['name']); ?>
											</td>

											<td class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
												<span><?php echo pjCurrency::formatPrice($extra['price']);?></span>
											</td><!-- /.col-lg-2 col-md-2 col-sm-2 col-xs-2 -->

											<td class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">x</td>

											<td class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
												<div class="input-group pjFdCounter">
													<span class="input-group-btn">
														<button class="btn btn-default fdOperator" type="button" data-index="<?php echo $category_id?>-<?php echo $product['id']?>-<?php echo $extra['id'];?>" data-sign="-">-</button>
													</span>
													<input id="fdQty_<?php echo $category_id?>-<?php echo $product['id']?>-<?php echo $extra['id'];?>" name="extra_id[<?php echo $extra['id'];?>]" class="fdQtyInput form-control align-center" value="0"/>
													<span class="input-group-btn">
														<button class="btn btn-default fdOperator" type="button" data-index="<?php echo $category_id?>-<?php echo $product['id']?>-<?php echo $extra['id'];?>" data-sign="+">+</button>
													</span>
												</div><!-- /.input-group pjFdCounter -->
											</td>
										</tr>
										<?php
									}
									?>
								</table><!-- /.table -->
							</div><!-- /.row -->
							<?php
						}
						?>
					</div><!-- /.panel-body -->
				</div><!-- /#collapseInnerOne.panel-collapse collapse -->
			</form>
		</div><!-- /.panel panel-default -->
		<?php
	}
}
?>
