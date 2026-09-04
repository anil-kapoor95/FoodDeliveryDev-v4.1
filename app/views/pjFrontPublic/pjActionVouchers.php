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
			<div class="panel-body pjFdPanelBody">
				<?php
				if($tpl['status'] == 'OK')
				{
					$price = 0;
					$discount = 0;
					$discount_print = NULL;
					$subtotal = 0.00;
					$tax = 0.00;
					$total = 0.00;
					$delivery = 0.00;
					$packing = 0.00;
					
					// Theme 11's reference UI opens this page with an "ORDER SUMMARY" list of
					// the actual cart items (name, qty x unit price, line total) above the
					// Price/Packing fee/... breakdown — themes 1-10 never showed this, so it's
					// built up here (gated behind $fdTheme11) alongside the existing price loop
					// rather than looping the cart a second time.
					$fdSummaryItemsHtml = '';
					$cart_price = 0;
					foreach ($tpl['cart_box']['cart'] as $hash => $item)
					{
						foreach ($tpl['cart_box']['product_arr'] as $product)
						{
							if ($product['id'] == $item['product_id'])
							{
								$product_price = 0;
								$product_price = $item['price'] * $item['cnt'];
								$packing += $product['packing_fee'] * $item['cnt'];
								$cart_price += $product_price;
								$fdItemExtraTotal = 0;
								foreach ($item['extra_arr'] as $extra_id => $extra)
								{
									$cart_price += $extra['price'] * $extra['qty'];
									$fdItemExtraTotal += $extra['price'] * $extra['qty'];
								}
								if ($fdTheme11)
								{
									ob_start();
									?>
									<div class="pjFdSummaryItem">
										<div class="pjFdSummaryItemInfo">
											<strong class="text-capitalize"><?php echo stripslashes($product['name']); ?></strong>
											<span class="pjFdSummaryItemQty"><?php echo (int) $item['cnt']; ?> &times; <?php echo pjCurrency::formatPrice($item['price']); ?></span>
										</div>
										<div class="pjFdSummaryItemPrice"><?php echo pjCurrency::formatPrice($product_price + $fdItemExtraTotal); ?></div>
									</div>
									<?php
									$fdSummaryItemsHtml .= ob_get_clean();
								}
							}
						}
					}
					$controller->_set('price', $cart_price);
					if ($fdTheme11 && $fdSummaryItemsHtml !== '')
					{
						?>
						<h2 class="text-muted text-center">Order Summary</h2>
						<br />
						<?php echo $fdSummaryItemsHtml; ?>
						<div class="pjFdSummaryDivider"></div>
						<?php
					}

					if($controller->_is('price'))
					{
						$price = $controller->_get('price');
						?>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<strong><?php __('front_price'); ?></strong>
							</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
							<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($controller->_get('price')); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
						</div><!-- /.form-group -->
		
						<br />
						<br />
						<?php
					}
					# Packing fee
					$controller->_set('packing', $packing);
					?>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<strong><?php __('front_packing_fee'); ?></strong>
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
						<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($controller->_get('packing')); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
					</div><!-- /.form-group -->
		
					<br />
					<br />
					<?php
					if($controller->_get('type') == 'delivery')
					{
						$delivery = $controller->_get("delivery");
						?>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<strong><?php __('front_delivery_fee'); ?></strong>
							</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
							<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($controller->_get('delivery')); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
						</div><!-- /.form-group -->
		
						<br />
						<br />
						<?php
					}
					// Theme 11's reference UI moves this promo-code block down to sit below
					// the Total row instead of here, between Delivery fee and Discount —
					// themes 1-10 keep it exactly where it always rendered. The markup itself
					// (ids/classes fdVoucherCode_/fdVoucherMessage_/fdButtonApply) is untouched
					// either way, since pjFoodDelivery.js's voucher-apply handler depends on
					// this exact nesting (".parent().parent().show()" off the message div) —
					// only *when* it's echoed changes, captured here and replayed further down.
					ob_start();
					?>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<strong><?php __('front_promo_code'); ?></strong>
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->

						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="input-group pjFdGroupVaucher">
								<input type="text" id="fdVoucherCode_<?php echo $index; ?>" name="voucher_code" value="<?php echo $controller->_is('voucher_code') ? $controller->_get('voucher_code') : NULL;?>" class="form-control"/>
								<span class="input-group-btn">
									<button class="btn btn-default text-uppercase fdButtonApply" type="button"><?php __('front_button_apply');?></button>
								</span>
							</div><!-- /input-group pjFdGroupVaucher -->
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
					</div><!-- /.form-group -->

					<div class="form-group" style="display: none;">
						<br />
						<br />
						<div class="col-md-6 col-sm-6 col-xs-12">
							&nbsp;
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->

						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="alert alert-warning" role="alert" id="fdVoucherMessage_<?php echo $index;?>"></div>
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
					</div><!-- /.form-group -->
					<?php
					$fdPromoBlock = ob_get_clean();
					if (!$fdTheme11)
					{
						echo $fdPromoBlock;
						?>
						<br />
						<br />
						<?php
					}
					if ($fdTheme11)
					{
						?>
						<div class="pjFdSummaryDivider"></div>
						<?php
					}
					$discount_print = NULL;
					if ($controller->_is('voucher_code'))
					{
						$voucher_discount = $controller->_get('voucher_discount');
						switch ($controller->_get('voucher_type'))
						{
							case 'percent':
								$discount_print = $voucher_discount . "%";
								$discount = (($price + $packing) * $voucher_discount) / 100;
								break;
							case 'amount':
							    $discount_print = pjCurrency::formatPrice($voucher_discount);
								$discount = $voucher_discount;
								break;
						}
					}
					if ($discount > $price + $packing)
					{
						$discount = $price + $packing;
					}
					$subtotal = $price + $delivery + $packing - $discount;
					
					$controller->_set('discount', $discount);
					$controller->_set('price', $price);
					$controller->_set('subtotal', $subtotal);
					if($controller->_get('voucher_type') == 'amount')
					{
					    $discount_print = pjCurrency::formatPrice($discount);
					}
					if(!is_null($discount_print))
					{
						?>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<strong><?php __('front_discount'); ?></strong>
							</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
							<div class="col-md-6 col-sm-6 col-xs-12"><?php echo $discount_print; ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
						</div><!-- /.form-group -->
		
						<br />
						<br />
						<?php
					}
					if($controller->_is('subtotal'))
					{
						?>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<strong><?php __('front_subtotal'); ?></strong>
							</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
							<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($controller->_get('subtotal')); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
						</div><!-- /.form-group -->
		
						<br />
						<br />
						<?php
					}
					if(!empty($tpl['option_arr']['o_tax_payment']))
					{
						if ($tpl['option_arr']['o_add_tax'] == '1' && $controller->_get('type') == 'delivery')
						{
							$tax = (($subtotal - $delivery) * $tpl['option_arr']['o_tax_payment']) / 100;
						} else {
							$tax = ($subtotal * $tpl['option_arr']['o_tax_payment']) / 100;
						}
						$controller->_set('tax', $tax);
						?>
						<div class="form-group">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<strong><?php __('front_tax'); ?></strong>
							</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
																
							<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($tax); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
						</div><!-- /.form-group -->
		
						<br />
						<br />
						<?php
					}
					$total = $subtotal + $tax;
					$controller->_set('total', $total);
					if ($fdTheme11)
					{
						?>
						<div class="pjFdSummaryDivider"></div>
						<?php
					}
					?>
					<div class="form-group<?php echo $fdTheme11 ? ' pjFdSummaryTotal' : NULL; ?>">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<strong><?php __('front_total'); ?></strong>
						</div><!-- /.col-md-6 col-sm-6 col-xs-6 -->

						<div class="col-md-6 col-sm-6 col-xs-12"><?php echo pjCurrency::formatPrice($total); ?></div><!-- /.col-md-6 col-sm-6 col-xs-6 -->
					</div><!-- /.form-group -->

					<br />
					<br />
					<?php if ($fdTheme11): ?>
						<div class="pjFdSummaryDivider"></div>
						<h2 class="text-muted text-center">Have a promo code?</h2>
						<br />
						<div class="pjFdPromoTheme11"><?php echo $fdPromoBlock; ?></div>
						<br />
					<?php endif; ?>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
							<a href="#" class="btn btn-default text-uppercase fdButtonBackTypes"><?php __('front_button_back');?></a>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<a href="#" class="btn btn-default text-uppercase fdButtonPayment<?php echo ($tpl['cart_box']['cart'] !== false && count($tpl['cart_box']['cart'])) > 0 ? null : ' fdButtonDisabled';?>"><?php __('front_button_continue');?></a>
						</div><!-- /.col-sm-8 col-sm-offset-4 -->
					</div><!-- /.row -->
					<?php
				}else{
					?>
					<div>
						<?php
						$front_messages = __('front_messages', true, false);
						$system_msg = str_replace("[STAG]", "<a href='#' class='fdStartOver'>", $front_messages[13]);
						$system_msg = str_replace("[ETAG]", "</a>", $system_msg); 
						echo $system_msg; 
						?>
					</div>
					<?php
				}					 
				?>
			</div><!-- /.panel-body pjFdPanelBody -->
			
		</div><!-- /.panel panel-default -->
	</div><!-- /.col-md-8 col-sm-8 col-xs-12 pjFdPanelLeft -->
	<div id="fdCart_<?php echo $index; ?>" class="col-md-4 col-sm-4 col-xs-12 pjFdPanelRight">
		<?php include_once dirname(__FILE__) . '/elements/cart.php';?>
	</div><!-- /.col-md-4 col-sm-4 col-xs-12 pjFdPanelRight -->
</div><!-- /.row -->