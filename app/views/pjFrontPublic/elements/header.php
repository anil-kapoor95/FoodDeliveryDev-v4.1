<?php
$show_locale = false;
if($controller->session->getData($controller->defaultLangMenu) == 'show' && isset($tpl['locale_arr']) && count($tpl['locale_arr']) > 1)
{
	$show_locale = true;
} 
?>
<div class="panel-heading pjFdPanelHead">
	<div class="row">
		<div class="<?php echo $show_locale == true ? 'col-lg-6 col-md-6 col-sm-6 col-xs-12' : 'col-lg-8 col-md-8 col-sm-8 col-xs-8'?>">
			<a href="#" class="btn btn-default pjFdBtnHome fdBtnHome" title="<?php echo __('front_menu');?>">
				<i class="fa fa-cutlery fa-3"></i>
			</a>
			
			&nbsp;&nbsp;
			<?php
			$action = $controller->_get->toString('action');
			$menu_label = __('front_menu', true);
			switch ($action) {
				case 'pjActionMain':
					$menu_label = __('front_menu', true);
					break;
				case 'pjActionLogin':
					$menu_label = __('front_login_to_account', true, false);
					break;
				case 'pjActionTypes':
					$menu_label = __('front_order_details', true, false);
					break;
				case 'pjActionVouchers':
					$menu_label = __('front_order_total', true, false);
					break;
				case 'pjActionCheckout':
					$menu_label = __('front_payment', true, false);
					break;
				case 'pjActionPreview':
					$menu_label = __('front_confirm_order', true, false);
					break;
			}
			$menu_items = __('front_menu_titles', true);
			?>	
			<div class="btn-group pjFdNav">
				<button type="button" class="btn btn-default dropdown-toggle text-capitalize pjFdBtnNav" data-pj-toggle="dropdown" aria-expanded="false"><?php echo $menu_label;?> <span class="caret"></span></button>
				<ul class="dropdown-menu text-uppercase" role="menu">
					<li><a href="#" data-load="loadMain" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionMain')) ? ' pjFdBtnActive' : (in_array($action, array('pjActionLogin', 'pjActionForgot', 'pjActionTypes', 'pjActionVouchers', 'pjActionCheckout', 'pjActionPreview')) ? ' pjFdBtnPassed' : ' disabled') ; ?>"><?php echo $menu_items[1];?></a></li>
					<li><a href="#" data-load="loadLogin" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionLogin')) ? ' pjFdBtnActive' : (in_array($action, array('pjActionForgot', 'pjActionTypes', 'pjActionVouchers', 'pjActionCheckout', 'pjActionPreview')) ? ' pjFdBtnPassed' : ' disabled'); ?>"><?php echo $menu_items[2];?></a></li>
					<li><a href="#" data-load="loadTypes" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionTypes')) ? ' pjFdBtnActive' : (in_array($action, array('pjActionVouchers', 'pjActionCheckout', 'pjActionPreview')) ? ' pjFdBtnPassed' : ' disabled'); ?>"><?php echo $menu_items[3];?></a></li>
					<li><a href="#" data-load="loadVouchers" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionVouchers')) ? ' pjFdBtnActive' : (in_array($action, array('pjActionCheckout', 'pjActionPreview')) ? ' pjFdBtnPassed' : ' disabled'); ?>"><?php echo $menu_items[4];?></a></li>
					<li><a href="#" data-load="loadCheckout" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionCheckout')) ? ' pjFdBtnActive' : (in_array($action, array('pjActionPreview')) ? ' pjFdBtnPassed' : ' disabled'); ?>"><?php echo $menu_items[5];?></a></li>
					<li><a href="#" data-load="loadPreview" class="btn btn-link pjFdBtnMenu pjFdBtn<?php echo in_array($action, array('pjActionPreview')) ? ' pjFdBtnActive' : ' disabled'; ?>"><?php echo $menu_items[6];?></a></li>
				</ul>
			</div><!-- /.btn-group pjFdNav -->
			<?php if ((string) @$tpl['option_arr']['o_theme'] === 'theme11'): ?>
			<script type="text/javascript">
			/* Theme 11's numbered-circle step tracker needs the step number split out
			   from the "step N - label" text (see theme11.css .pjFdStepNum/.pjFdStepLabel)
			   without touching the shared label strings other themes still show in full.
			   Runs on load and on every step navigation (a MutationObserver, since this
			   header can be re-rendered by the app's own step-navigation JS at any time).
			   This whole <script> re-executes every time header.php is re-injected (every
			   step change, including "Start Over" back to the menu) — jQuery's .html()
			   re-runs embedded <script> tags — but #pjWrapperFoodDelivery_theme11 itself
			   is the app's outer, never-replaced wrapper. Without stashing the observer on
			   that persistent element and disconnecting the previous one first, every
			   navigation piled another live observer onto the same target; a few steps in,
			   a single class/DOM change (e.g. expanding a category) fired every accumulated
			   observer at once, and their own DOM writes re-triggered each other, freezing
			   the page. Keeping exactly one observer (replacing it, not stacking) fixes that. */
			(function () {
				function splitOne(el) {
					if (el.getAttribute('data-pj-step-split')) { return; }
					var m = /^\s*step\s+(\d+)\s*-\s*(.+)$/i.exec(el.textContent || '');
					if (!m) { return; }
					el.setAttribute('data-pj-step-split', '1');
					el.innerHTML = '<span class="pjFdStepNum">' + m[1] + '</span><span class="pjFdStepLabel">' + m[2] + '</span>';
				}
				function run() {
					var items = document.querySelectorAll('#pjWrapperFoodDelivery_theme11 .pjFdNav .pjFdBtn');
					for (var i = 0; i < items.length; i++) { splitOne(items[i]); }
				}
				run();
				var target = document.getElementById('pjWrapperFoodDelivery_theme11');
				if (target && window.MutationObserver) {
					if (target._pjFdStepObserver) { target._pjFdStepObserver.disconnect(); }
					target._pjFdStepObserver = new MutationObserver(run);
					target._pjFdStepObserver.observe(target, { childList: true, subtree: true });
				}
			})();
			</script>
			<script type="text/javascript">
			/* Expanded product card: the description moves up beside the extras
			   list when it's short enough to fit in the space left below them,
			   instead of always getting its own full-width row underneath (see
			   theme11.css .pjFdDescFitsBeside). "Fits" depends on the real
			   rendered height of both the description and the leftover space —
			   which varies per product's text length and per screen width — so
			   it's measured here rather than guessed from a fixed line count.
			   No-extras-at-all is handled in pure CSS (theme11.css) and doesn't
			   need this script at all.
			   Re-measures on load, on window resize (the side-by-side layout
			   only exists from tablet width up), and whenever a card is
			   expanded/collapsed (MutationObserver, same reasoning as the step
			   tracker above — disconnected while this script makes its own
			   class changes, so it doesn't re-trigger itself, AND stashed on
			   the persistent wrapper — same reasoning as the step tracker's
			   observer above — instead of a script-local variable, since this
			   whole <script> re-runs on every step change: a plain local
			   variable is recreated fresh each time and can't see the previous
			   run's observer to disconnect it, so every navigation was leaving
			   yet another live observer running on top of the old ones. The
			   window resize listener is stashed the same way so it doesn't
			   pile up duplicates either). */
			(function () {
				var FIT_CLASS = 'pjFdDescFitsBeside';
				var target = document.getElementById('pjWrapperFoodDelivery_theme11');

				function measure(card) {
					var media = card.querySelector('.pjFdProductMedia');
					var topinfo = card.querySelector('.pjFdProductHead .row');
					var extrasRow = card.querySelector('.pjFdProductBody > .row:has(.pjFdProductMeta)');
					var descP = card.querySelector('.pjFdProductBodyText p');
					card.classList.remove(FIT_CLASS);
					if (!media || !topinfo || !extrasRow || !descP) {
						// No extras (theme11.css already places the description
						// beside the photo unconditionally in that case) or no
						// description to place at all — nothing to measure.
						return;
					}
					// Below tablet width the grid drops to one column (see
					// theme11.css), so there's no "beside" spot to fit into.
					if (window.innerWidth < 768) { return; }

					var mediaHeight = media.getBoundingClientRect().height;
					var usedHeight = topinfo.getBoundingClientRect().height
						+ extrasRow.getBoundingClientRect().height
						+ 20; // the two 10px row-gaps this stack already spends (theme11.css row-gap)
					var available = mediaHeight - usedHeight;
					var descHeight = descP.getBoundingClientRect().height;
					if (descHeight > 0 && descHeight <= available) {
						card.classList.add(FIT_CLASS);
					}
				}
				function run() {
					if (target && target._pjFdDescObserver) { target._pjFdDescObserver.disconnect(); }
					var cards = document.querySelectorAll('#pjWrapperFoodDelivery_theme11 .pjFdProduct:has(.panel-collapse.in)');
					for (var i = 0; i < cards.length; i++) { measure(cards[i]); }
					if (target && window.MutationObserver) {
						target._pjFdDescObserver = new MutationObserver(run);
						target._pjFdDescObserver.observe(target, { childList: true, subtree: true, attributes: true, attributeFilter: ['class'] });
					}
				}
				run();
				if (target) {
					if (target._pjFdDescResizeHandler) { window.removeEventListener('resize', target._pjFdDescResizeHandler); }
					target._pjFdDescResizeHandler = run;
					window.addEventListener('resize', target._pjFdDescResizeHandler);
				}
			})();
			</script>
			<?php endif; ?>

		</div><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-12 -->
		<div class="pjFdHeaderRight<?php echo $show_locale == true ? ' col-lg-6 col-md-6 col-sm-6 col-xs-12' : ' col-lg-4 col-md-4 col-sm-4 col-xs-4'?>">
			<?php
			if($controller->isFrontLogged())
			{ 
				?>
				<a class="btn btn-default pull-right pjFdBtnAcc fdBtnLogout" href="#" role="button" title="<?php __('front_logout', false, false);?>"><i class="fa fa-sign-out"></i></a>
				<?php
			} 
			?>
			<a class="btn btn-default pull-right pjFdBtnAcc fdBtnAccount" href="#" role="button" title="<?php __('front_login_to_account', false, false);?>"><i class="fa fa-<?php echo $controller->isFrontLogged() ? 'user' : 'lock';?>"></i></a>
			
			<?php
			if($show_locale == true)
			{ 
				$locale_id = $controller->pjActionGetLocale();
				$selected_lang = '';
				foreach ($tpl['locale_arr'] as $locale)
				{
					if($locale_id == $locale['id'])
					{
						$selected_lang = pjSanitize::html($locale['name']);
					}
				}
				?>
				<div class="btn-group pull-right pjFdLanguage" role="group" aria-label="">
					<button type="button" class="btn btn-default dropdown-toggle pjFdBtnNav" data-pj-toggle="dropdown" aria-expanded="false">
						<?php echo $selected_lang;?>
						<span class="caret"></span>
					</button>
					
					<ul class="dropdown-menu text-capitalize" role="menu">
						<?php
						foreach ($tpl['locale_arr'] as $locale)
						{
							?><li><a href="#" class="fdSelectorLocale<?php echo $locale_id == $locale['id'] ? ' pjFdBtnActive' : NULL; ?>" data-id="<?php echo $locale['id']; ?>" title="<?php echo pjSanitize::html($locale['name']); ?>"><?php echo pjSanitize::html($locale['name']); ?></a></li><?php
						} 
						?>
					</ul>
				</div>
				<?php
			} 
			?>
		</div><!-- /.col-lg-6 col-md-6 col-sm-6 col-xs-12 -->
	</div><!-- /.row -->
</div><!-- /.panel-heading pjFdPanelHead -->