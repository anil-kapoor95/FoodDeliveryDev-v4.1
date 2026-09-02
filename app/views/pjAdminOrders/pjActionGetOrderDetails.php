<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
	foreach ($tpl['arr']['product_arr'] as $k => $v)
	{
		$extra = array();
		foreach ($v['extra_arr'] as $e)
		{
			$extra[] = stripslashes(sprintf("%u x %s", $e['cnt'], $e['name']));
		}
		if(!empty($v['size']))
		{
			$product = stripslashes(sprintf("%u x %s (%s)", $v['cnt'], $v['name'], $v['size']));
		}else{
			$product = stripslashes(sprintf("%u x %s", $v['cnt'], $v['name']));
		}
		?>
		<div class="row">
			<div class="col-xs-12"><?php echo $product;?></div>
			<?php if (count($extra) > 0) { ?>
				<div class="col-xs-12"><?php __('lblOrderExtras');?>: <?php echo implode('; ', $extra);?></div>
			<?php } ?>
		</div>
		<?php 
		if ($k < count($tpl['arr']['product_arr']) - 1) { 
			?>
			<div class="hr-line-dashed"></div>
			<?php 
		}
	}
}else{
    ?>
    <div class="alert alert-warning">
   		<?php __('lblOrderNotFound')?>
    </div>
    <?php    
}
?>