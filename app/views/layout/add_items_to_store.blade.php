

<style type="text/css">
	label {
		font-size: 12px !important;
	}

	table tr {
		cursor: pointer;
	}

	.selectedRow {
		background-color: #337ab7 !important; 
		color: whitesmoke;
	}

	@media print {
		
		table , table th , table td , label , table tr td{
			font-size: 10px !important;
			font-weight: lighter !important;
		}

		button,input[type=submit]{
			display: none !important;
		}

		body{
			direction: rtl;
			padding: 2%;
			font-size: 11px;
			font-weight: lighter;
		}

		input,select,textarea , .select2-container{
			border: 0px !important;
			font-size: 10px !important;
		}

		.invoiceheader{
			display: block !important;
			color: black !important;
			border: 0px !important;
			font-size: 22px !important;
		}

		@page {size: landscape}
	}
</style>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter" style="height: 2000px">
			<div class="row">
				<div class="col-xs-12">
				    <div class="box dark">
				        <header>
				            <div class="icons"><i class="fa fa-edit"></i></div>
				            <h5>إدارة المخازن</h5>
				            <!-- .toolbar -->
				            <div class="toolbar">
				              <nav style="padding: 8px;">
				                  <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
				                      <i class="fa fa-minus"></i>
				                  </a>
				                  <a href="javascript:;" class="btn btn-default btn-xs full-box">
				                      <i class="fa fa-expand"></i>
				                  </a>
				                  {{-- <a href="javascript:;" class="btn btn-danger btn-xs close-box">
				                      <i class="fa fa-times"></i>
				                  </a> --}}
				              </nav>
				            </div>            <!-- /.toolbar -->
				        </header>
				        <div id="div-1" class="body collapse in" aria-expanded="true">
    						<div class="alert alert-success">
    							<span class="pull-left"> إذن إضافة اصناف </span>
    							<button class="btn btn-default btn-sm pull-right" style="margin-right: 5px;" onclick="printDiv('#addItemsToStores')">طباعة الفاتورة</button>
    							<button class="btn btn-primary btn-sm  pull-right printBarCodes">طباعة باركود للفاتورة</button>
    							<div style="clear:both;"></div>
    						</div>
				        	<div class="messages"></div>
				        	<div class="printLayout">
				        	{{Form::open(["action" => "addItemsToStores","id"=>"addItemsToStores" ,"class"=>"form-horizontal"])}}
					        	<div class="alert alert-info invoiceheader">
					        	 إذن إضافة أصناف <span class="pull-right"> Myzoo Clinc </span></div>
					        	<div style="clear:both;"></div>
					        	<hr>
					        	<div class="row">
						        	<div class="col-xs-12">
						                <div class="form-group">
						                	{{Form::label('id', 'رقم الإذن',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("id",$getNextItemsOnStoresID,["id"=>"id" , "name"=>"id" , "placeholder"=>"رقم الإذن" , "class"=>"form-control"])}}
						                    </div>
						                </div>
						                <div class="form-group datePickerBlock">
						                	{{Form::label('invoice_date', 'تاريخ الإذن',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("invoice_date","",["id"=>"invoice_date" , "name"=>"invoice_date" , "placeholder"=>"تاريخ الإذن" , "class"=>"form-control date"])}}
						                    </div>
						                </div>

						                <div class="form-group">
						                	{{Form::label('provider_name', 'المورد',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("provider_name","",["id"=>"provider_name", "placeholder"=>"المورد" , "class"=>"form-control"])}}
						                    </div>
						                </div>
						            </div>

						            <div class="col-xs-12" style="margin-bottom:12px;">
						            	<button class="btn btn-warning" type="button" id="add_new_items">اضافة صنف للإذن</button>
						            </div>

						            <div class="col-xs-12">
						            	<div class="table-responsive tableHolder">
						            		<table class="itemsTable table table-bordered sortableTable responsive-table tablesorter tablesorter-default">
						            			<thead>
						            				<tr>
						            					<th class="col-xs-2">كود الصنف</th>
						            					<th class="col-xs-2">إسم الصنف</th>
						            					<th class="col-xs-2">نوع الصنف</th>
						            					<th class="col-xs-2">العدد</th>
						            					<th class="col-xs-2">سعر الشراء للوحدة</th>
						            					<th class="col-xs-2">الإجمالي</th>
						            				</tr>
						            			</thead>
						            			<tbody class="tbodysellTable">
						            				
						            			</tbody>
					            			</table>
				            			</div>
				              		</div>
				              		<div class="col-xs-12">
					            		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_total_price', 'إجمالي الفاتورة',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_total_price","",["id"=>"items_total_price" , "name"=>"items_total_price" , "placeholder"=>"إجمالي الفاتورة" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>

				                		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_discount', 'قيمة الخصم',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_discount",0,["id"=>"items_discount" , "name"=>"items_discount" , "placeholder"=>"قيمة الخصم" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>
				                		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('payment_method', 'طريقة الدفع',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	نقداً
							                    	{{Form::radio("payment_method",1,true,["id"=>"payment_method" , "placeholder"=>"قيمة الخصم" , "class"=>"uniform"])}} &nbsp;
							                    	أجل
							                    	{{Form::radio("payment_method",2,false,["id"=>"payment_method", "placeholder"=>"قيمة الخصم" , "class"=>"uniform"])}}
							                    </div>
					                    	</div>
				                		</div>
					            	</div>
					            	<div class="col-xs-12">
				                		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_net_total', 'صافي الفاتورة',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_net_total","",["id"=>"items_net_total" , "name"=>"items_net_total" , "placeholder"=>"صافي الفاتورة" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>
						            	<div class="col-xs-8">
						            		<div class="form-group">
							                	{{Form::label('invoice_notice', 'ملاحظات',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::textarea("invoice_notice","",["class" => "form-control" , "id" => "invoice_notice"])}}
							                    </div>
					                    	</div>
				                		</div>
				              	</div>
				              	<div class="row">
				              		<div class="col-xs-12">
				              			<div class="form-group">
						                    <div class="col-xs-12">
						                    	{{Form::submit('حفظ ',["class"=>"btn btn-success btn-block"])}}
						                    </div>
						                </div>
				              		</div>
				              	</div>
	            				{{Form::close()}}
				              	</div>
				              	<hr>
				              	<div class="row">
				              		<div style="clear:both"></div>
					              	<div class="col-xs-12">
					              		<h4 class="alert alert-info">
					              			الفواتير المضافة للمخزن
					              		</h4>
					            		<table class="table table-bordered sellInvoicedTable">
					            			<thead>
					            				<tr>
					            					<th>رقم الفاتورة</th>
					            					<th>تاريخ الفاتورة</th>
					            					<th>المورد</th>
					            				</tr>
					            			</thead>
					            			<tbody></tbody>
					            			<tfoot>
					            				<tr>
					            					<th>رقم الفاتورة</th>
					            					<th>تاريخ الفاتورة</th>
					            					<th>المورد</th>
					            				</tr>
					            			</tfoot>
					            		</table>
					            	</div>
				            	</div>
		            		</div>
	            </div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
</div>


<script type="text/javascript">
    var total_invocie = 0;
	$(function(){
		
		$(".printBarCodes").hide();
		$("#add_new_items").on("click",function(){
			if ($(".item_code:last").val() != ""){
				var tableAppender = "";
				tableAppender += '<tr>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_code" name="item_code[]" placeholder="كود الصنف" class="form-control item_code" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<select id="item_name" name="item_name[]" class="form-control item_name"><option value="0">فضلاً ضع كود الصنف أولاً</option></select>';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<select id="item_type" name="item_type[]" class="form-control item_type"><option value="0">فضلاً ضع كود الصنف أولاً</option></select>';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_quantity" name="item_quantity[]" placeholder="العدد" class="form-control item_quantity" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_price" name="item_price[]" placeholder="سعر الشراء" class="form-control item_price" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_total_price" name="item_total_price[]" placeholder="إجمالي سعر الشراء" class="form-control item_total_price" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '</tr>';
				tableAppender += "<tr>";
				$('.tbodysellTable').append(tableAppender);
				$("input[type=text]").on("keypress",function(){
		            if (event.keyCode == 13){
		                $("#add_new_items").click();
		                return false;
		            }
		        });

		        var elements = ["Ctrl+s"];

                $.each(elements, function(i, e) {
                   var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
                   
                    $("input[type=text]").bind('keydown', elements[i], function assets() {
                        if (elements[i] == "Ctrl+s"){
                            $("#addItemsToStores").trigger("submit");
                        }
                        return false;
                   });
                });
                
				$(".item_quantity:last").on("keyup",function(){
					window.setTimeout(function(){
						$.each($(".item_total_price"),function(k,value){
							total_invocie += parseFloat($(value).val())
						});
						$("#items_total_price").val(total_invocie);
						$("#items_discount").keyup();
						total_invocie = 0;
					}, 500)


				});

				$(".item_quantity").on("keyup",function(){
						$(".item_total_price").removeClass("selected")
						var payment_value = $($(document.activeElement).closest("tr").find("td")["prevObject"]["0"]).find("td:eq(4) input")[0]["value"]
						var quantityValue = $($(document.activeElement).closest("tr").find("td")["prevObject"]["0"]).find("td:eq(3) input")[0]["value"];
						var items_total = $($(document.activeElement).closest("tr").find("td")["prevObject"]["0"]).find("td:eq(5) input")[0];
						$(items_total).addClass("selected")
						$(".selected").val(parseFloat(payment_value * quantityValue))
						$(".selected").click()
				});

				$('.select2-container-active:last').addClass('select2-container-active');
				item_code_finder();
			}else{
				alert("فضلاً قم بتعبئة بيانات الحقل الحالي أولاً")
			}
		});

	   $(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy/mm/dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		item_code_finder();

		// $("#items_discount").on("keyup",function(){
		// 	$("#items_net_total").val(parseFloat($("#items_total_price").val() - $(this).val()));
		// });

		$("#items_discount").on("keyup",function(){
			if ($(this).val().indexOf("%") != -1){
				var percentageValue = parseFloat($(this).val().split("%")[0] / 100);
				$("#items_net_total").val(parseFloat(parseFloat($("#items_total_price").val()) - parseFloat($("#items_total_price").val() * percentageValue)));
			}else{
				$("#items_net_total").val(parseFloat($("#items_total_price").val() - $(this).val()));
			}
		});
		dataTableDrawer();
		

		$("#addItemsToStores").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addItemsToStores",
				dataType : 'json',
				type : 'post',
				contentType: false,
    			processData: false,
				data : formElementsData,
				beforeSend : function(){
				$(".messages").show();
				$(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messages").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						getNextItemsOnStoresID();
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
						dataTableDrawer();
					}
				},
				complete : function(){
					console.log("request completed");
				},
				error : function (error) {
					console.error(error);
				}
			});

			return false;
		});

		$("#add_new_items").click();
	});

	function item_code_finder(){
		$(".item_code:last").select2({
			width:"100%",
	        dir:"rtl",
	        placeholder : 'ضع كود صنف يديوياً او بإستخدام جهاز قارئ البار كود',
	        minimumInputLength: 2,
	        id: function(bond){ return bond.id},
	        ajax: {
	        url: 'getItemDataByCode',
	        dataType: 'json',
	        quietMillis: 250,
	        data: function (term, page) {
	            return {
	                q: term,
	            };
	        },
	        results: function (data, page) { 
	            return { results: data.items };
	        },
	        cache: false
	        },
	        initSelection: function(element, callback) {
	            return element;
	        },
	        formatResult: repoFormatResultItems,
	        formatSelection: repoFormatSelectionItems,
	        dropdownCssClass: "bigdrop",
	        escapeMarkup: function (m) { return m; }		
		}).on("select2-selecting", function(e) {
          setTimeout(function(){$(".item_quantity:last")[0].focus();},0)
        }).select2("open")
	}

	function repoFormatResultItems(repo) {
    	var markup = '<div class="row-fluid">' +
	    '<div class="span10">' +
	    '<div class="row-fluid">' +
	       '<div class="span6">' + repo.item_code + " " + repo.item_name +'</div>' +
	       
	    '</div>';

	    markup += '</div></div>';

	    return markup;
	}

	function repoFormatSelectionItems(repo) {
		$(".item_price:last").val(repo.paid_price);
		$('.item_type:last')
		.html($("<option></option>")
		.attr("value",repo.item_type_id)
		.attr("selected","selected")
		.text(repo.item_type_name)); 

		$('.item_name:last')
		.html($("<option></option>")
		.attr("value",repo.item_code)
		.attr("selected","selected")
		.text(repo.item_name));
		
		// window.setTimeout(function(){
		// 	$.each($(".item_total_price"),function(k,value){
		// 		total_invocie += parseFloat($(value).val())
		// 	})
		// 	$("#items_total_price").val(total_invocie);
		// 	$("#items_discount").keyup();
		// 	$(".item_quantity:last").keyup();
		// }, 500)

		total_invocie = 0;
	
		$("body").click();
	    return repo.item_code;
	}
	function getNextItemsOnStoresID(){
		return {{HomeController::getNextItemsOnStoresID('store_items')}}
	}


	function getInvoiceData(invoiceID){

		$.ajax({
			url : "getStoreItemsDataTable",
			dataType : 'json',
			type : 'get',
			data : {
				invoiceID : invoiceID,
			},
			beforeSend : function(){
			$(".messages").show();
			$(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
			},
			success : function(data){
				if (data.errorsFounder == 1){
					var str = '';
					$.each(data.messages,function(key,value){
						str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
					});

					$(".messages").html("<div class='alert alert-danger'>"+str+"</div>");

				}else{
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#id").val(data.parent.invoice_number);
					$("#invoice_date").val(data.parent.invoice_date);
					$("#provider_name").val(data.parent.provider_name);
					$("#invoice_notice").val(data.parent.invoice_notice);
					$("#items_net_total").val(data.parent.items_net_total);
					$("#items_discount").val(data.parent.items_discount);
					$("#items_total_price").val(data.parent.items_total_price);
					$("#addons").val(data.parent.addons);
					$(".printBarCodes").fadeIn(500).attr("onclick","printBarCodes()");
					$("#id,#invoice_date,#provider_name,#invoice_notice,#items_net_total,#items_discount,#items_total_price,#addons").attr("disabled","disabled");
					$(".messages").hide();

					var tableAppender = "";

					$.each(data.children,function(k,v){
						tableAppender += '<tr>';
						tableAppender += '<td>';
						tableAppender += '<input id="item_code" name="item_code[]" placeholder="كود الصنف" class="form-control item_code" type="text" value="'+v.item_code+'">';
						tableAppender += '</td>';
						tableAppender += '<td>';
						tableAppender += '<select id="item_name" name="item_name[]" class="form-control item_name"><option value="0">'+v.item_name+'</option></select>';
						tableAppender += '</td>';
						tableAppender += '<td>';
						tableAppender += '<select id="item_type" name="item_type[]" class="form-control item_type"><option value="0">'+v.item_type_name+'</option></select>';
						tableAppender += '</td>';
						tableAppender += '<td>';
						tableAppender += '<input id="item_quantity" name="item_quantity[]" placeholder="العدد" class="form-control item_quantity" type="text" value="'+v.item_quantity+'">';
						tableAppender += '</td>';
						tableAppender += '<td>';
						tableAppender += '<input id="item_price" name="item_price[]" placeholder="سعر الشراء" class="form-control item_price" type="text" value="'+v.item_price+'">';
						tableAppender += '</td>';
						tableAppender += '<td>';
						tableAppender += '<input id="item_total_price" name="item_total_price[]" placeholder="إجمالي سعر الشراء" class="form-control item_total_price" type="text" value="'+v.item_total_price+'">';
						tableAppender += '</td>';
						tableAppender += '</tr>';
						tableAppender += "<tr>";
					});

					$('.tbodysellTable').html(tableAppender);
					$("#id,#invoice_date,#client_name,#invoice_notice,#items_net_total,#items_discount,.item_name,.item_code,.item_type,.item_quantity,.item_price,.item_total_price,.item_total_net").attr("readonly","readonly");

				}
			},
			complete : function(){
				console.log("request completed");
			},
			error : function (error) {
				console.error(error);
			}
		});
	}

	function dataTableDrawer(){
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getStoreInvoiceItemsData",
			// "aaSorting": [[ 4, "desc" ]],
		});

	  	 $('.sellInvoicedTable tbody').on('click', 'tr', function () {
	  	 	var iPos = sellInvoicedTabletbody.fnGetPosition( this );
	        var aData = sellInvoicedTabletbody.fnGetData( iPos );
	        var iId = aData[0];
	        $(".sellInvoicedTable tbody tr").removeClass("selectedRow");
	        $(this).addClass("selectedRow");
	        getInvoiceData(iId);
	    });
	}

	function printDiv(container) {
		$(container).print({    
	        globalStyles: true,
            mediaPrint: true,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: 'CodePro Systems , Mahalla Elkoupra 7 abdelhamed salem st',
            doctype: '<!doctype html>'
	  });
	}

	function printBarCodes() {
		var item_code = $("input[name='item_code[]']").map(function() { return this.value; }).get().join(',');
		var item_quantity = $("input[name='item_quantity[]']").map(function() { return this.value; }).get().join(',');
	 	 ajaxBrowsing('{{URL::to("printBarCodesFromStoresInvoice")}}?items_name='+item_code+'&items_quantity='+item_quantity+'');
	}
</script>