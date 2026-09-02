<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-10">
                <h2><?php __('infoNewOrdersListTitle');?></h2>
            </div>
        </div><!-- /.row -->

        <p class="m-b-none"><i class="fa fa-info-circle"></i> <?php __('infoNewOrdersListDesc');?></p>
    </div><!-- /.col-md-12 -->
</div>
<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
    	<div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row m-b-md">
                    <form action="" method="get" class="form-horizontal frm-filter-new-orders">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="q" placeholder="<?php __('plugin_base_btn_search', false, true); ?>" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.col-md-3 -->
    
                        <div class="col-md-3 col-md-offset-3 text-right">
                        	<select name="type" id="new_order_filter_type" class="form-control">
                				<option value="">-- <?php __('lblAll'); ?> --</option>
                				<?php
                				foreach (__('types', true, false) as $k => $v)
                				{
                				    ?><option value="<?php echo $k; ?>"<?php echo $controller->_get->toString('type') == $k ? ' selected="selected"' : NULL;?>><?php echo stripslashes($v); ?></option><?php
                				}
                				foreach (__('order_statuses', true, false) as $k => $v)
                				{
                					?><option value="<?php echo $k; ?>"><?php echo stripslashes($v); ?></option><?php
                				}
                				?>
                			</select>
                        </div><!-- /.col-md-6 -->
                    </form>
                </div><!-- /.row -->

                <div id="grid_new_orders"></div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<div class="modal fade" id="newOrderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog modal-md" role="document">
	    <div class="modal-content">
		      <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title"><?php __('lblOrderedProducts');?></h4>
		      </div>
		      <div id="newOrderContentWrapper" class="modal-body"></div>
		      <div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal"><?php __('btnClose');?></button>
		      </div>
	    </div><!-- /.modal-content -->
  	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
var pjGrid = pjGrid || {};
pjGrid.queryString = "";
<?php
if ($controller->_get->toInt('client_id'))
{
    ?>pjGrid.queryString += "&client_id=<?php echo $controller->_get->toInt('client_id'); ?>";<?php
}
if ($controller->_get->toString('type'))
{
    ?>pjGrid.queryString += "&type=<?php echo $controller->_get->toString('type'); ?>";<?php
}
?>
var myLabel = myLabel || {};
myLabel.order_id = <?php x__encode('lblOrderID'); ?>;
myLabel.name = <?php x__encode('lblName'); ?>;
myLabel.phone = <?php x__encode('lblPhone'); ?>;
myLabel.date_time = <?php x__encode('lblDateTime'); ?>;
myLabel.total = <?php x__encode('lblTotal'); ?>;
myLabel.type = <?php x__encode('lblType'); ?>;
myLabel.pickup = <?php x__encode('lblPickup'); ?>;
myLabel.delivery = <?php x__encode('lblDelivery'); ?>;
myLabel.status = <?php x__encode('lblStatus'); ?>;
myLabel.exported = <?php x__encode('lblExport'); ?>;
myLabel.delete_selected = <?php x__encode('delete_selected'); ?>;
myLabel.delete_confirmation = <?php x__encode('delete_confirmation'); ?>;
myLabel.pending = <?php x__encode('order_statuses_ARRAY_pending'); ?>;
myLabel.confirmed = <?php x__encode('order_statuses_ARRAY_confirmed'); ?>;
myLabel.cancelled = <?php x__encode('order_statuses_ARRAY_cancelled'); ?>;
myLabel.prepared = <?php x__encode('order_statuses_ARRAY_prepared'); ?>;
myLabel.out_for_delivery = <?php x__encode('order_statuses_ARRAY_out_for_delivery'); ?>;
myLabel.delivered = <?php x__encode('order_statuses_ARRAY_delivered'); ?>;
myLabel.ready_to_pickup = <?php x__encode('order_statuses_ARRAY_ready_to_pickup'); ?>;
myLabel.picked_up = <?php x__encode('order_statuses_ARRAY_picked_up'); ?>;
myLabel.is_completed = <?php x__encode('lblOrderCompleted'); ?>;
myLabel.yes = <?php x__encode('_yesno_ARRAY_T'); ?>;
myLabel.no = <?php x__encode('_yesno_ARRAY_F'); ?>;
</script>