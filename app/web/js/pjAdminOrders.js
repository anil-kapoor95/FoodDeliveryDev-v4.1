var jQuery_1_8_2 = jQuery_1_8_2 || $.noConflict();
(function ($, undefined) {
	$(function () {
		"use strict";
		var validator,
			$frmCreateOrder = $('#frmCreateOrder'),
			$frmUpdateOrder = $('#frmUpdateOrder'),
			$dialogReminderEmail = $("#dialogReminderEmail"),
			$dialogConfirm = $("#dialogConfirm"),
			dialog = ($.fn.dialog !== undefined),
			datepicker = ($.fn.datepicker !== undefined),
			datagrid = ($.fn.datagrid !== undefined),
			validate = ($.fn.validate !== undefined),
			chosen = ($.fn.chosen !== undefined),
			spinner = ($.fn.spinner !== undefined),
			tabs = ($.fn.tabs !== undefined),
			autocomplete = ($.fn.autocomplete !== undefined),
			datetimeOptions = null,
			$tabs = $("#tabs"),
			tOpt = {
				select: function (event, ui) {
					$(":input[name='tab_id']").val(ui.panel.id);
				}
			};
	
		if ($tabs.length > 0 && tabs) {
			$tabs.tabs(tOpt);
		}
		if (chosen) {
			$('#client_id').chosen();
		}
		if ($('#dateTimePickerOptions').length) {
        	var currentDate = new Date();
        	var $optionsEle = $('#dateTimePickerOptions');
        	
	        moment.updateLocale('en', {
				week: { dow: parseInt($optionsEle.data('wstart'), 10) },
				months : $optionsEle.data('months').split("_"),
		        weekdaysMin : $optionsEle.data('days').split("_")
			});
	        datetimeOptions = {
					format: $optionsEle.data('format'),
					locale: moment.locale('en'),
					allowInputToggle: true,
					ignoreReadonly: true
				};
	        datetimeOptions.minDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());
	        $('#d_dt').datetimepicker(datetimeOptions);
	        $('#p_dt').datetimepicker(datetimeOptions);
	        $('#d_dt').on('dp.hide', function (e) {
	        	validateDeliveryTime();
	        	calPrice(1);
			});
        	$('#p_dt').on('dp.hide', function (e) {
        		validatePickupTime();
        		calPrice(1);
			});
        }
		
		if ($frmCreateOrder.length > 0 || $frmUpdateOrder.length > 0) 
		{
			$.validator.addMethod('pickupTime',
			    function (value, element) {
					if($(element).attr('data-wt') == 'open')
					{
						return true;
					}else{
						return false;
					}
			    }
			);
			$.validator.addMethod('deliveryTime',
			    function (value, element) {
					if($(element).attr('data-wt') == 'open')
					{
						return true;
					}else{
						return false;
					}
			    }
			);
				
			$frmCreateOrder.validate({
				rules: {
					"p_dt":{
						pickupTime: true
					},
					"d_dt":{
						deliveryTime: true
					},
					"c_email": {
						remote: "index.php?controller=pjAdminOrders&action=pjActionCheckClientEmail"
					}
				},
				messages:{
					"p_dt":{
						pickupTime: myLabel.restaurant_closed
					},
					"d_dt":{
						deliveryTime: myLabel.restaurant_closed
					},
					"c_email": {
						remote: myLabel.email_exists
					}
				},
				ignore: "",
				invalidHandler: function(form, validator) {

			        var $ele = $(validator.errorList[0].element);
			        var $closest = $ele.closest('.tab-pane');
			        var id = $closest.attr('id');
			        $('.nav a[href="#' + id + '"]').tab('show');
			    },
				submitHandler: function(form){
					var valid = true;
					var $ele = null;
					$('#fdOrderList').find("tbody.main-body > tr.fdLine").each(function() {
						var index = $(this).attr('data-index'),
							$product = $('#fdProduct_' + index),
							$price = $('#fdPrice_' + index);
						if($product.val() == '')
						{
							$product.parent().addClass('has-error');
							valid = false;
							$ele = $product;
						}else{
							$product.parent().removeClass('has-error');
						}
						if($price.val() == '')
						{
							$price.parent().addClass('has-error');
							valid = false;
							$ele = $product;
						}else{
							$price.parent().removeClass('has-error');
						}
					});
					if(valid == true)
					{
						form.submit();
					}else{
						var $closest = $ele.closest('.tab-pane');
				        var id = $closest.attr('id');
				        $('.nav a[href="#' + id + '"]').tab('show');
					}
				}
			});
			$frmUpdateOrder.validate({
				rules: {
					"p_dt":{
						pickupTime: true
					},
					"d_dt":{
						deliveryTime: true
					},
					"c_email": {
						remote: "index.php?controller=pjAdminOrders&action=pjActionCheckClientEmail"
					}
				},
				messages:{
					"p_dt":{
						pickupTime: myLabel.restaurant_closed
					},
					"d_dt":{
						deliveryTime: myLabel.restaurant_closed
					},
					"c_email": {
						remote: myLabel.email_exists
					}
				},
				ignore: "",
				invalidHandler: function(form, validator) {

			        var $firstEle = $(validator.errorList[0].element);
			        var $closest = $firstEle.closest('.tab-pane');
			        var id = $closest.attr('id');
			        $('.nav a[href="#' + id + '"]').tab('show');
			    },
				submitHandler: function(form){
					var valid = true;
					var $ele = null;
					$('#fdOrderList').find("tbody.main-body > tr.fdLine").each(function() {
						var index = $(this).attr('data-index'),
							$product = $('#fdProduct_' + index),
							$price = $('#fdPrice_' + index);
						
						if($product.val() == '')
						{
							$product.parent().addClass('has-error');
							valid = false;
							$ele = $product;
						}else{
							$product.parent().removeClass('has-error');
						}
						if($price.val() == '')
						{
							$price.parent().addClass('has-error');
							valid = false;
							$ele = $product;
						}else{
							$price.parent().removeClass('has-error');
						}
					});
					if(valid == true)
					{
						form.submit();
					}else{
						var $closest = $ele.closest('.tab-pane');
				        var id = $closest.attr('id');
				        $('.nav a[href="#' + id + '"]').tab('show');
					}
				}
			});
			
			bindTouchSpin();
			if($frmUpdateOrder.length > 0)
			{
				if($('#fdOrderList').find("tbody.main-body > tr").length > 0)
				{
					calPrice(0);
					$('#fdOrderList').show();
				}
			}
		}
		function bindTouchSpin()
		{
			if($("#fdOrderList").length > 0)
			{
				$('#fdOrderList').find(".pj-field-count").TouchSpin({
					verticalbuttons: true,
		            buttondown_class: 'btn btn-white',
		            buttonup_class: 'btn btn-white',
		            min: 1,
		            max: 4294967295
		        });
			}
		}
		function validatePickupTime()
		{
			var $frm = $frmCreateOrder;
			if($frmUpdateOrder.length > 0)
			{
				$frm = $frmUpdateOrder;
			}
			$.ajax({
				type: 'POST',
				async: false, 
				url: "index.php?controller=pjAdminOrders&action=pjActionCheckPickup",
				data: {
					type: function(){ return $frm.find("input[name='type']").is(":checked") ? 'delivery' : 'pickup'; },
					p_location_id: function(){ return $frm.find("select[name='p_location_id']").val(); },
					p_dt: function(){ return $frm.find("input[name='p_dt']").val(); }
				},
				success: function(data){
					if(data == 'false')
					{
						$frm.find("input[name='p_dt']").attr('data-wt', 'closed').valid();
					}else{
						$frm.find("input[name='p_dt']").attr('data-wt', 'open').valid();
					}
				}
			});
		}
		function validateDeliveryTime()
		{
			var $frm = $frmCreateOrder;
			if($frmUpdateOrder.length > 0)
			{
				$frm = $frmUpdateOrder;
			}
			$.ajax({
				type: 'POST',
				async: false, 
				url: "index.php?controller=pjAdminOrders&action=pjActionCheckDelivery",
				data: {
					type: function(){ return $frm.find("input[name='type']").is(":checked") ? 'delivery' : 'pickup'; },
					d_location_id: function(){ return $frm.find("select[name='d_location_id']").val(); },
					d_dt: function(){ return $frm.find("input[name='d_dt']").val(); }
				},
				success: function(data){
					if(data == 'false')
					{
						$frm.find("input[name='d_dt']").attr('data-wt', 'closed').valid();
					}else{
						$frm.find("input[name='d_dt']").attr('data-wt', 'open').valid();
					}
				}
			});
		}
		function formatType(val, obj) {			
			if(val == 'pickup')
			{
				return '<div class="badge badge-default btn-xs no-margin"><span class="p-w-xs">' + myLabel.pickup + '</span></div>';
			}else{
				return '<div class="badge badge-primary btn-xs no-margin"><span class="p-w-xs">' + myLabel.delivery + '</span></div>';
			}
		}
		function formatStatus(val, obj) {			
			return obj.status_formated;
		}
		function formatOrderId(str, obj) {
			return '<a href="index.php?controller=pjAdminOrders&action=pjActionUpdate&id='+obj.id+'">'+str+'</a>';
		}
		if ($("#grid").length > 0 && datagrid) {
			var $grid = $("#grid").datagrid({
				buttons: [{type: "edit", url: "index.php?controller=pjAdminOrders&action=pjActionUpdate&id={:id}"},
				          {type: "delete", url: "index.php?controller=pjAdminOrders&action=pjActionDeleteOrder&id={:id}"}
						 ],
				columns: [
				          {text: myLabel.order_id, type: "text", sortable: true, renderer: formatOrderId},
				          {text: myLabel.name, type: "text", sortable: false},
				          {text: myLabel.date_time, type: "text", sortable: false, editable: false},
				          {text: myLabel.total, type: "text", sortable: false, editable: false},
				          {text: myLabel.type, type: "text", sortable: false, editable: false,  renderer: formatType},
				          {text: myLabel.status, type: "text", sortable: true, editable: false, renderer: formatStatus, applyClass: "btn btn-xs no-margin bg"},
				          {text: myLabel.is_completed, type: "toggle", sortable: true, editable: true, 
				        	  editableRenderer: function () {
				        		  return 0;
				        	  },
				        	  saveUrl: "index.php?controller=pjAdminOrders&action=pjActionSaveOrder&id={:id}",
				        	  positiveLabel: myLabel.yes, positiveValue: "1", negativeLabel: myLabel.no, negativeValue: "0", 
				        	  cellClass: "text-center"}],
				dataUrl: "index.php?controller=pjAdminOrders&action=pjActionGetOrder" + pjGrid.queryString,
				dataType: "json",
				fields: ['uuid', 'client_name', 'datetime', 'total', 'type', 'status', 'is_completed'],
				paginator: {
					actions: [
					   {text: myLabel.delete_selected, url: "index.php?controller=pjAdminOrders&action=pjActionDeleteOrderBulk", render: true, confirmation: myLabel.delete_confirmation},
					   {text: myLabel.exported, url: "index.php?controller=pjAdminOrders&action=pjActionExportOrder", ajax: false}
					],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminOrders&action=pjActionSaveOrder&id={:id}",
				select: {
					field: "id",
					name: "record[]",
					cellClass: 'cell-width-2'
				}
			});
		}
		
		if ($("#grid_new_orders").length > 0 && datagrid) {
			var $grid_new_orders = $("#grid_new_orders").datagrid({
				buttons: [{type: "eye", url: "index.php?controller=pjAdminOrders&action=pjActionGetOrderDetails&id={:id}"}],
				columns: [
				          {text: myLabel.order_id, type: "text", sortable: true, renderer: formatOrderId},
				          {text: myLabel.name, type: "text", sortable: false},
				          {text: myLabel.date_time, type: "text", sortable: false, editable: false},
				          {text: myLabel.total, type: "text", sortable: false, editable: false},
				          {text: myLabel.type, type: "text", sortable: false, editable: false,  renderer: formatType},
				          {text: myLabel.status, type: "select", sortable: true, editable: true, options: [
				  				                                                                                     {label: myLabel.pending, value: "pending"}, 
				  				                                                                                     {label: myLabel.confirmed, value: "confirmed"},
				  				                                                                                     {label: myLabel.cancelled, value: "cancelled"},
				  				                                                                                     {label: myLabel.prepared, value: "prepared"},
				  				                                                                                     {label: myLabel.out_for_delivery, value: "out_for_delivery"},
				  				                                                                                     {label: myLabel.delivered, value: "delivered"},
				  				                                                                                     {label: myLabel.ready_to_pickup, value: "ready_to_pickup"},
				  				                                                                                     {label: myLabel.picked_up, value: "picked_up"}
				  				                                                                                     ], applyClass: "btn btn-xs no-margin bg"},
				          {text: myLabel.is_completed, type: "toggle", sortable: true, editable: true, 
				        	  editableRenderer: function () {
				        		  return 0;
				        	  },
				        	  saveUrl: "index.php?controller=pjAdminOrders&action=pjActionSaveNewOrder&id={:id}",
				        	  positiveLabel: myLabel.yes, positiveValue: "1", negativeLabel: myLabel.no, negativeValue: "0", 
				        	  cellClass: "text-center"}],
				dataUrl: "index.php?controller=pjAdminOrders&action=pjActionGetNewOrder" + pjGrid.queryString,
				dataType: "json",
				fields: ['uuid', 'client_name', 'datetime', 'total', 'type', 'status', 'is_completed'],
				paginator: {
					actions: [],
					gotoPage: true,
					paginate: true,
					total: true,
					rowCount: true
				},
				saveUrl: "index.php?controller=pjAdminOrders&action=pjActionSaveNewOrder&id={:id}",
				select: false
			});
			
			$("#grid_new_orders").on("click", ".pj-table-icon-eye", function (e) {
				if (e && e.preventDefault) {
					e.preventDefault();
				}
				var $href = $(this).attr('href'),
					$newOrderContentWrapper = $('#newOrderContentWrapper');				
				$newOrderContentWrapper.html("");
				$.get($href).done(function (data) {
					$newOrderContentWrapper.html(data);
					$('#newOrderDetailsModal').modal('show');
				});
				return false;
			});
		}
				
		$(document).on("focusin", ".datepick", function (e) {
			var $this = $(this);
			$this.datepicker({
				firstDay: $this.attr("rel"),
				dateFormat: $this.attr("rev"),
				onSelect: function (dateText, inst) {
					
				}
			});
		}).on("submit", ".frm-filter", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid.datagrid("option", "content"),
				cache = $grid.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val(),
				type: $this.find("select[name='type']").val()
			});
			$grid.datagrid("option", "cache", cache);
			$grid.datagrid("load", "index.php?controller=pjAdminOrders&action=pjActionGetOrder", "created", "DESC", content.page, content.rowCount);
			return false;
		}).on("submit", ".frm-filter-new-orders", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				content = $grid_new_orders.datagrid("option", "content"),
				cache = $grid_new_orders.datagrid("option", "cache");
			$.extend(cache, {
				q: $this.find("input[name='q']").val(),
				type: $this.find("select[name='type']").val()
			});
			$grid_new_orders.datagrid("option", "cache", cache);
			$grid_new_orders.datagrid("load", "index.php?controller=pjAdminOrders&action=pjActionGetNewOrder", content.column, content.direction, content.page, content.rowCount);
			return false;
		}).on("change", "#payment_method", function (e) {
			switch ($("option:selected", this).val()) {
				case 'creditcard':
					$(".boxCC").show();
					break;
				default:
					$(".boxCC").hide();
			}
		}).on("change", "#voucher_code", function (e) {
			calPrice(1);
		}).on("click", "#btnAddProduct", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var index = Math.ceil(Math.random() * 999999),
				$clone = $("#boxProductClone").find("tbody").html();
			$clone = $clone.replace(/\{INDEX\}/g, 'new_' + index);
			$('#fdOrderList').find("tbody.main-body").append($clone);
			bindTouchSpin();
			$('#fdOrderList').show();
		}).on("click", ".pj-remove-product", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).closest(".fdLine").remove();
			if($('#fdOrderList').find("tbody.main-body > tr").length == 0)
			{
				$('#fdOrderList').hide();
			}else{
				calPrice(1);
			}
			return false;
		}).on("click", ".pj-add-extra", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			var index = $this.attr('data-index');
			var $productEle = $('#fdProduct_' + index);
			var product_id = $productEle.val();
			var $extra_table = $this.parent().siblings(".pj-extra-table");
			if(product_id != '')
			{
				$.get("index.php?controller=pjAdminOrders&action=pjActionGetExtras", {
					product_id: product_id,
					index: $this.attr("data-index")
				}).done(function (data) {
					$(data).appendTo($extra_table.find("tbody"));
					$extra_table.find(".pj-field-count").TouchSpin({
						verticalbuttons: true,
			            buttondown_class: 'btn btn-white',
			            buttonup_class: 'btn btn-white',
			            min: 1,
			            max: 4294967295
			        });
				});
			}
			return false;
		}).on("click", ".pj-remove-extra", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$(this).parent().parent().remove();
			calPrice(1);
			return false;
		}).on("change", ".fdProduct", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this),
				index = $this.attr("data-index"),
				option = $('option:selected', this).attr('data-extra');
			$this.valid();
			$('.fdExtraBusiness_'+index).hide();
			$.get("index.php?controller=pjAdminOrders&action=pjActionGetPrices", {
				product_id: $this.val(),
				index: index
			}).done(function (data) {
				$("#fdPriceTD_" + index).html(data);
				$('#fdExtraTable_' + index).find("tbody").html("");
				if($this.val() != '')
				{
					$('.business-' + index).show();
				}else{
					$('.business-' + index).hide();
				}
				if(option == '0')
				{
					$('.fdExtraNA_' + index).show();
				}else{
					$('.fdExtraButton_' + index).show();
				}
				calPrice(1);
			});
			return false;
		}).on("change", "#client_id", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $pjFdEditClient = $('#pjFdEditClient');
			if($(this).val() != '')
			{
				var href = $pjFdEditClient.attr('data-href');
				href = href.replace("{ID}", $(this).val());
				$pjFdEditClient.attr('href', href);
				$pjFdEditClient.css('display', 'inline-block');
				$.get("index.php?controller=pjAdminOrders&action=pjActionGetClient&id=" + $(this).val()).done(function (data) {
					if($('#c_title').length > 0)
					{
						$('#c_title').removeClass('required');
						$('#c_title').val(data.c_title).valid();
					}
					if($('#c_email').length > 0)
					{
						$('#c_email').removeClass('required');
						/*$('#c_email').val(data.email).valid();*/
						$('#c_email').val("").valid();
					}
					if($('#c_password').length > 0)
					{
						$('#c_password').removeClass('required');
						$('#c_password').val(data.password).valid();
					}
					if($('#c_name').length > 0)
					{
						$('#c_name').removeClass('required');
						$('#c_name').val(data.name).valid();
					}
					if($('#c_phone').length > 0)
					{
						$('#c_phone').removeClass('required');
						$('#c_phone').val(data.phone).valid();
					}
					if($('#c_company').length > 0)
					{
						$('#c_company').removeClass('required');
						$('#c_company').val(data.c_company).valid();
					}
					if($('#c_address_2').length > 0)
					{
						$('#c_address_2').removeClass('required');
						$('#c_address_2').val(data.c_address_2).valid();
					}
					if($('#c_address_1').length > 0)
					{
						$('#c_address_1').removeClass('required');
						$('#c_address_1').val(data.c_address_1).valid();
					}
					if($('#c_city').length > 0)
					{
						$('#c_city').removeClass('required');
						$('#c_city').val(data.c_city).valid();
					}
					if($('#c_state').length > 0)
					{
						$('#c_state').removeClass('required');
						$('#c_state').val(data.c_state).valid();
					}
					if($('#c_zip').length > 0)
					{
						$('#c_zip').removeClass('required');
						$('#c_zip').val(data.c_zip).valid();
					}
					if($('#c_country').length > 0)
					{
						$('#c_country').removeClass('required');
						$('#c_country').val(data.c_country).trigger("liszt:updated").valid();
					}
					if( ($('#d_address_1').length > 0 && $('#d_address_1').val() != '') ||
						($('#d_address_2').length > 0 && $('#d_address_2').val() != '') ||
						($('#d_city').length > 0 && $('#d_city').val() != '') ||
						($('#d_state').length > 0 && $('#d_state').val() != '') ||
						($('#d_zip').length > 0 && $('#d_zip').val() != '') ||
						($('#d_country_id').length > 0 && $('#d_country_id').val() != ''))
					{
						
					}else{
						if($('#d_address_1').length > 0)
						{
							$('#d_address_1').val(data.c_address_1).valid();
						}
						if($('#d_address_2').length > 0)
						{
							$('#d_address_2').val(data.c_address_2).valid();
						}
						if($('#d_city').length > 0)
						{
							$('#d_city').val(data.c_city).valid();
						}
						if($('#d_state').length > 0)
						{
							$('#d_state').val(data.c_state).valid();
						}
						if($('#d_zip').length > 0)
						{
							$('#d_zip').val(data.c_zip).valid();
						}
						if($('#d_country_id').length > 0)
						{
							$('#d_country_id').val(data.c_country).trigger("liszt:updated").valid();
						}
					}
				});
			}else{
				$pjFdEditClient.css('display', 'none');
				if($('#c_title').length > 0)
				{
					if($('#c_title').hasClass('fdRequired'))
					{
						$('#c_title').addClass('required');
					}
					$('#c_title').val("").valid();
				}
				if($('#c_email').length > 0)
				{
					if($('#c_email').hasClass('fdRequired'))
					{
						$('#c_email').addClass('required');
					}
					$('#c_email').val("").valid();
				}
				if($('#c_password').length > 0)
				{
					if($('#c_password').hasClass('fdRequired'))
					{
						$('#c_password').addClass('required');
					}
					$('#c_password').val("").valid();
				}
				if($('#c_name').length > 0)
				{
					if($('#c_name').hasClass('fdRequired'))
					{
						$('#c_name').addClass('required');
					}
					$('#c_name').val("").valid();
				}
				if($('#c_phone').length > 0)
				{
					if($('#c_phone').hasClass('fdRequired'))
					{
						$('#c_phone').addClass('required');
					}
					$('#c_phone').val("").valid();
				}
				if($('#c_company').length > 0)
				{
					if($('#c_company').hasClass('fdRequired'))
					{
						$('#c_company').addClass('required');
					}
					$('#c_company').val("").valid();
				}
				if($('#d_address_1').length > 0)
				{
					if($('#d_address_1').hasClass('fdRequired'))
					{
						$('#d_address_1').addClass('required');
					}
					$('#d_address_1').val("").valid();
				}
				if($('#d_address_2').length > 0)
				{
					if($('#d_address_2').hasClass('fdRequired'))
					{
						$('#d_address_2').addClass('required');
					}
					$('#d_address_2').val("").valid();
				}
				if($('#d_city').length > 0)
				{
					if($('#d_city').hasClass('fdRequired'))
					{
						$('#d_city').addClass('required');
					}
					$('#d_city').val("").valid();
				}
				if($('#d_state').length > 0)
				{
					if($('#d_state').hasClass('fdRequired'))
					{
						$('#d_state').addClass('required');
					}
					$('#d_state').val("").valid();
				}
				if($('#d_zip').length > 0)
				{
					if($('#d_zip').hasClass('fdRequired'))
					{
						$('#d_zip').addClass('required');
					}
					$('#d_zip').val("").valid();
				}
				if($('#d_country_id').length > 0)
				{
					if($('#d_country_id').hasClass('fdRequired'))
					{
						$('#d_country_id').addClass('required');
					}
					$('#d_country_id').val("").trigger("liszt:updated").valid();
				}
			}
		}).on("change", ".fdSize", function (e) {
			calPrice(1);
		}).on("change", ".fdExtra", function (e) {
			calPrice(1);		
		}).on("change", ".pj-field-count", function (e) {
			calPrice(1);
		}).on("change", "#filter_type", function (e) {
			$('.frm-filter').submit();
		}).on("change", "#new_order_filter_type", function (e) {
			$('.frm-filter-new-orders').submit();
		}).on("click", ".pjFdOpenClientTab", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			$("#tabs").tabs("option", "active", 1);
		}).on("change", "#d_location_id", function (e) {
			$('#btnCalc').trigger('click');
		}).on("change", ".onoffswitch-order .onoffswitch-checkbox", function (e) {
			if ($(this).prop('checked')) {
                $('.order-delivery').show();
                $('.order-delivery').find('.fdRequired').addClass('required');
                $('.order-pickup').hide();
                $('.order-pickup').find('.fdRequired').removeClass('required');
            }else {
                $('.order-delivery').hide();
                $('.order-delivery').find('.fdRequired').removeClass('required');
                $('.order-pickup').show();
                $('.order-pickup').find('.fdRequired').addClass('required');
            }
		}).on("change", ".onoffswitch-client .onoffswitch-checkbox", function (e) {
			if ($(this).prop('checked')) {
                $('.current-client-area').hide();
                $('.current-client-area').find('.fdRequired').removeClass('required');
                $('.new-client-area').show();
                $('.new-client-area').find('.fdRequired').addClass('required');
            }else {
                $('.current-client-area').show();
                $('.current-client-area').find('.fdRequired').addClass('required');
                $('.new-client-area').hide();
                $('.new-client-area').find('.fdRequired').removeClass('required');
                $('#c_email').val("").valid();
            }
		}).on("change", "#status", function (e) {
			var $pjFdPriceWrapper = $('#pjFdPriceWrapper');
			var value = $("#status option:selected").val();
			var text = $("#status option:selected").text();
			var bg_class = 'bg-' + value;
			$pjFdPriceWrapper.find('.panel-heading')
				.removeClass("bg-pending")
				.removeClass("bg-cancelled")
				.removeClass("bg-confirmed")				
				.removeClass("bg-prepared")
				.removeClass("bg-out_for_delivery")
				.removeClass("bg-delivered")
				.removeClass("bg-ready_to_pickup")
				.removeClass("bg-picked_up")				
				.addClass(bg_class);
			$pjFdPriceWrapper.find('.status-text').html(text);
		}).on("click", "#btnEmail", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var booking_id = $(this).attr('data-id');
			var document_id = 0;
			var $emailContentWrapper = $('#emailContentWrapper');
			
			$('#btnSendEmailConfirm').attr('data-booking_id', booking_id);
			
			$emailContentWrapper.html("");
			$.get("index.php?controller=pjAdminOrders&action=pjActionReminderEmail", {
				"id": booking_id
			}).done(function (data) {
				$emailContentWrapper.html(data);
				if(data.indexOf("pjResendAlert") == -1)
				{
					myTinyMceInit.call(null, 'textarea#mceEditor', 'mceEditor');
					validator = $emailContentWrapper.find("form").validate({
						
					});
					$('#btnSendEmailConfirm').show();
				}else{
					$('#btnSendEmailConfirm').hide();
				}	
				$('#reminderEmailModal').modal('show');
			});
			return false;
		}).on("click", "#btnSendEmailConfirm", function (e) {
			if (e && e.preventDefault) {
				e.preventDefault();
			}
			var $this = $(this);
			var $emailContentWrapper = $('#emailContentWrapper');
			if (validator.form()) {
				$('#mceEditor').html( tinymce.get('mceEditor').getContent() );
				$(this).attr("disabled", true);
				var l = Ladda.create(this);
			 	l.start();
				$.post("index.php?controller=pjAdminOrders&action=pjActionReminderEmail", $emailContentWrapper.find("form").serialize()).done(function (data) {
					if (data.status == "OK") {
						$('#reminderEmailModal').modal('hide');
					} else {
						$('#reminderEmailModal').modal('hide');
					}
					$this.attr("disabled", false);
					l.stop();
				});
			}
			return false;
		});
		
		function myTinyMceInit(pSelector, pValue) {
			tinymce.init({
				relative_urls : false,
				remove_script_host : false,
				convert_urls : true,
				browser_spellcheck : true,
			    contextmenu: false,
			    selector: pSelector,
			    theme: "modern",
			    height: 300,
			    plugins: [
			         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
			         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			         "save table contextmenu directionality emoticons template paste textcolor"
			    ],
			    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
			    image_advtab: true,
			    menubar: "file edit insert view table tools",
			    setup: function (editor) {
			    	editor.on('change', function (e) {
			    		editor.editorManager.triggerSave();
			    	});
			    }
			});
			if (tinymce.editors.length) {							
				tinymce.execCommand('mceAddEditor', true, pValue);
			}
		}
		$("#reminderEmailModal").on("hidden.bs.modal", function () {
        	if (tinymce.editors.length > 0) 
			{
		        tinymce.execCommand('mceRemoveEditor',true, "mceEditor");
		    }
        });
		function getTotal()
		{
			var $frm = null;
			if($frmCreateOrder.length > 0)
			{
				$frm = $frmCreateOrder;
			}
			if($frmUpdateOrder.length > 0)
			{
				$frm = $frmUpdateOrder;
			}
			if($('#fdOrderList').find("tbody.main-body > tr").length > 0)
			{
				$('.ibox-content').addClass('sk-loading');
				$.post("index.php?controller=pjAdminOrders&action=pjActionGetTotal", $frm.serialize()).done(function (data) {
					if(data.price != 'NULL')
					{
						$("#price").val(data.price).valid();
						$("#price_packing").val(data.price_packing);
						$("#price_delivery").val(data.price_delivery);
						$("#discount").val(data.discount);
						$("#subtotal").val(data.subtotal);
						$("#tax").val(data.tax);
						$("#total").val(data.total);
						
						$("#price_format").html(data.price_format);
						$("#packing_format").html(data.packing_format);
						$("#delivery_format").html(data.delivery_format);
						$("#discount_format").html(data.discount_format);
						$("#subtotal_format").html(data.subtotal_format);
						$("#tax_format").html(data.tax_format);
						$("#total_format").html(data.total_format);
					}
					$('.ibox-content').removeClass('sk-loading');
				});
			}
		}
		function calPrice(get_total)
		{	
			var prices = {};
			$('#fdOrderList').find("tbody.main-body > tr").each(function() {
				var total = 0,
					total_format = '',
					index = $(this).attr('data-index'),
					product = $('#fdProduct_' + index).val(),
					price_element = $('#fdPrice_' + index),
					product_qty = parseInt($('#fdProductQty_' + index).val(), 10),
					price = 0;
				
				var element_type = price_element.attr('data-type');
				if(element_type == 'input')
				{
					price = parseFloat(price_element.val());
				}else{
					var attr = $('option:selected', price_element).attr('data-price');
					if (typeof attr !== typeof undefined && attr !== false) {
						price = parseFloat(attr, 10);
					}
				}
				if(price > 0 && product_qty > 0)
				{
					total += parseFloat(price) * product_qty;
					$('.fdExtra_' + index).each(function() {
						var extra_index = $(this).attr('data-index'),
							extra = $(this).val(),
							extra_qty = parseInt($('#fdExtraQty_' + extra_index).val(), 10);
						if(extra != '' && extra_qty > 0)
						{
							var extra_price = 0;
							var extra_attr = $('option:selected', this).attr('data-price');
							if (typeof extra_attr !== typeof undefined && extra_attr !== false) {
								extra_price = parseFloat(extra_attr, 10);
							}
							if(extra_price > 0)
							{
								total += extra_price * extra_qty;
							}
						}
					});
				}
				prices[index] = total;
			});
			$.post("index.php?controller=pjAdminOrders&action=pjActionFormatPrice", {prices: prices}).done(function (data) {
				if(data.status == 'OK')
				{
					for (var o in data.prices) {
						if(data.prices.hasOwnProperty(o))
						{
							$('#fdTotalPrice_' + o).html(data.prices[o]);
						}
					}
					if(get_total == 1)
					{
						getTotal();
					}
				}
			});
		}
		
		$(document).ready(function() {
			if($('#grid_new_orders').length > 0)
			{
				ion.sound({
				    sounds: [
				        {name: "Alarm_Beep"}
				    ],
				    path: "app/web/upload/sounds/",
				    preload: true,
				    multiplay: true,
				    volume: 1
				});
				$.get("index.php?controller=pjAdminOrders&action=pjActionCheckNewOrder").done(function (data) {
					if(data.code == 100)
					{
						ion.sound.play("Alarm_Beep");
					}
				});				
				var refreshId = setInterval(function(){
					$.get("index.php?controller=pjAdminOrders&action=pjActionCheckNewOrder").done(function (data) {
						if(data.code == 100)
						{						
							ion.sound.play("Alarm_Beep");
							var $this = $(this),
								content = $grid_new_orders.datagrid("option", "content"),
								cache = $grid_new_orders.datagrid("option", "cache");
							$.extend(cache, {
								q: "",
								type: ""
							});
							$grid_new_orders.datagrid("option", "cache", cache);
							$grid_new_orders.datagrid("load", "index.php?controller=pjAdminOrders&action=pjActionGetNewOrder", "created", "ASC", content.page, content.rowCount);
						}
					});
		        }, 15000);
			}
		});
	});
})(jQuery_1_8_2);