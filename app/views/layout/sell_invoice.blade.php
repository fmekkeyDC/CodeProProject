

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

		.noPrint{
			display: none !important;
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
				            <h5>إدارة الفواتير</h5>
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
    						<div class="alert alert-success">فاتورة بيع
    							<button class="btn btn-default pull-right" onclick="printDiv('#addSellInvoice')">طباعة</button>
    							<div style="clear:both;"></div>
            					<a data-toggle="modal" data-original-title="تحذير" style="display: none;" data-placement="bottom" class="btn btn-default btn-sm warningModal" href="#warningModal">
									<i class="fa fa-question"></i>
								</a>
    						</div>
				        	<div class="messages"></div>


				        	{{Form::open(["action" => "addSellInvoice","id"=>"addSellInvoice" ,"class"=>"form-horizontal"])}}
					        	<div class="alert alert-info invoiceheader">
					        	 فاتورة بيع <span class="pull-right"> Myzoo Clinc </span></div>
					        	<div style="clear:both;"></div>
					        	<hr>

					        	<div class="col-xs-12">
						        	<ol class="breadcrumb">
									  <li class="active">إضافة خدمة للفاتورة </li>
									  <li><a href="#" onclick="getServicesForm(1)" id="service_1" data-table="check" data-toggle="modal" data-target="#myModal" data-href="{{URL::to('Check')}}">كشف و إستشارة </a></li>
									  <li><a href="#" onclick="getServicesForm(2)" id="service_2" data-table="shower" data-toggle="modal" data-target="#myModal" data-href="{{URL::to('shower')}}">شاور</a></li>
									  <li><a href="#" onclick="getServicesForm(3)" id="service_3" data-table="shaving" data-toggle="modal" data-target="#myModal" data-href="{{URL::to('shaving')}}">حلاقة</a></li>
									  <li><a href="#" onclick="getServicesForm(4)" id="service_4" data-table="other_services" data-toggle="modal" data-target="#myModal" data-href="{{URL::to('other_services')}}">خدمات اخري</a></li>
									</ol>
								</div>

					        	<div class="row">

				        			@if (Auth::user()->users_rights == 4)
							        	<div class="col-xs-12">
					        				<button type="button" class="btn btn-danger deleteInvoice"  style="margin-bottom: 20px; display: none;">حذف الفاتورة</button>
					        			</div>
				        			@endif

						        	<div class="col-xs-12">
						        		<div class="col-xs-6">
							                <div class="form-group">
							                	{{Form::label('id', 'رقم الفاتورة',["class"=>"control-label col-xs-2"])}}
							                    <div class="col-xs-4">
							                    	{{Form::text("id",$getNextItemsOnStoresID,["id"=>"id" , "placeholder"=>"رقم الفاتورة" , "class"=>"form-control"])}}
							                    </div>

							                    {{Form::label('lastInvoiceNumber', 'الفاتورة السابقة',["class"=>"control-label col-xs-2"])}}
							                    <div class="col-xs-4">
							                    	{{Form::text("lastInvoiceNumber","",["id"=>"lastInvoiceNumber" , "placeholder"=>"الفاتورة السابقة" , "class"=>"form-control"])}}
							                    </div>

							                </div>

							                <div class="form-group">
							                	{{Form::label('invoice_date', 'تاريخ الفاتورة',["class"=>"control-label col-xs-2"])}}
							                    <div class="col-xs-4">
							                    	{{Form::text("invoice_date","",["id"=>"invoice_date"  , "placeholder"=>"تاريخ الفاتورة" , "class"=>"form-control date"])}}
							                    </div>
							                    <div class="col-xs-3">
						                    		{{Form::button("تعديل تاريخ الفاتورة",["class" => "btn btn-primary" , "id"=>"edit_invoice_date" , "style"=>"display:none;"])}}
							                	</div>
							                	<div class="col-xs-3">
									            	<button class="btn btn-warning" type="button" id="add_new_items">اضافة اصناف</button>
									            </div>
							                </div>
						                </div>
						        		<div class="col-xs-6">
							                <div class="form-group">
							                	{{Form::label('client_name', 'إسم العميل',["class"=>"control-label col-xs-2"])}}
							                    <div class="col-xs-10">
							                    	{{Form::text("client_name","",["id"=>"client_name" , "placeholder"=>"إسم العميل" , "class"=>"form-control"])}}
							                    </div>
							                </div>
						                </div>

						                {{-- <div class="form-group">
						                	{{Form::label('payment_method', 'سعر البيع',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	قطاعي
						                    	{{Form::radio("payment_method",1,true,["id"=>"payment_method" , "title"=>"إسم العميل" ])}}
						                    	جملة
						                    	{{Form::radio("payment_method",2,false,["id"=>"payment_method" , "title"=>"إسم العميل" ])}}
						                    </div>
						                </div> --}}
						            </div>

						            

						            <div class="col-xs-12">
						            	<div class="table-responsive tableHolder">
						            		<table class="table table-bordered sortableTable sellTable responsive-table tablesorter tablesorter-default">
						            			<thead>
						            				<tr>
						            					<th class="col-xs-2">كود الصنف</th>
						            					<th class="col-xs-3">إسم الصنف</th>
						            					<th class="col-xs-2">نوع الصنف</th>
						            					<th class="col-xs-1">الكمية</th>
						            					<th class="col-xs-1">ثمن الوحدة</th>
						            					<th class="col-xs-1">المجموع</th>
						            					<th class="col-xs-2 noPrint">الكمية الحالية</th>
						            				</tr>
						            			</thead>
						            			<tbody class="tbodysellTable">
						            			</tbody>
					            			</table>
				            			</div>
				              		</div>
				              		<div class="col-xs-12 services"></div>
					            	<div style="clear:both"></div>
				              		<div class="col-xs-12">
					            		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_total_price', 'إجمالي الفاتورة',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_total_price","",["id"=>"items_total_price" , "placeholder"=>"إجمالي الفاتورة" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>

				                		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_discount', 'قيمة الخصم',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_discount","",["id"=>"items_discount", "placeholder"=>"قيمة الخصم" , "class"=>"form-control"])}}
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
							                    	{{Form::radio("payment_method",2,false,["id"=>"payment_method" , "placeholder"=>"قيمة الخصم" , "class"=>"uniform"])}}
							                    </div>
					                    	</div>
				                		</div>
					            	</div>
					            	<div class="col-xs-12">
					            		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('addons', 'إضافات',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("addons",0,["id"=>"addons"  , "placeholder"=>"إضافات" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>

				                		<div class="col-xs-4">
						            		<div class="form-group">
							                	{{Form::label('items_net_total', 'صافي الفاتورة',["class"=>"control-label col-xs-4"])}}
							                    <div class="col-xs-6">
							                    	{{Form::text("items_net_total",0,["id"=>"items_net_total" , "placeholder"=>"صافي الفاتورة" , "class"=>"form-control"])}}
							                    </div>
					                    	</div>
				                		</div>
					            	</div>
					            	<div class="col-xs-12">
					            		<div class="col-xs-4">
						            		<div class="form-group">
						            			{{Form::label('service_total_price', 'إجمالي الخدمات',["class"=>"control-label col-xs-4"])}}
						                   		<div class="col-xs-6">
						                    		{{Form::text("service_total_price",0,["id"=>"service_total_price" , "placeholder"=>"إجمالي الخدمات" , "class"=>"form-control"])}}
						                    	</div>
						            		</div>
					            		</div>
					            		<div class="col-xs-4">
						            		<div class="form-group">
						            			{{Form::label('total_invoice_with_service', 'إجمالي الفاتورة والخدمات',["class"=>"control-label col-xs-4"])}}
						                   		<div class="col-xs-6">
						                    		{{Form::text("total_invoice_with_service",0,["id"=>"total_invoice_with_service" , "placeholder"=>"إجمالي الخدمات" , "class"=>"form-control" , "style "=> "background-color: #ffc5c5;"])}}
						                    	</div>
						            		</div>
					            		</div>
					            	</div>
					            	<div class="col-xs-12">
					            		<div class="form-group">
						                	{{Form::label('invoice_notice', 'ملاحظات',["class"=>"control-label col-xs-4"])}}
						                    <div class="col-xs-6">
						                    	{{Form::textarea("invoice_notice","",["class" => "form-control"])}}
						                    </div>
				                    	</div>
			                		</div>
				              	</div>
				              	<div class="row">
				              		<div class="col-xs-12">
				              			<div class="form-group">
						                    <div class="col-xs-12">
						                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
						                    </div>
						                </div>
				              		</div>
				              	</div>
				              	<hr>
	            				{{Form::close()}}
				              	<div class="row">
				              		<div style="clear:both"></div>
					              	<div class="col-xs-12">
					              		<h4 class="alert alert-info">
					              			الفواتير المباعة 
					              		</h4>
					            		<table class="table table-bordered sellInvoicedTable">
					            			<thead>
					            				<tr>
					            					<th>رقم الفاتورة</th>
					            					<th>تاريخ الفاتورة</th>
					            					<th>صافي المبلغ</th>
					            					<th>العميل</th>
					            				</tr>
					            			</thead>
					            			<tbody></tbody>
					            			<tfoot>
					            				<tr>
					            					<th>رقم الفاتورة</th>
					            					<th>تاريخ الفاتورة</th>
					            					<th>صافي المبلغ</th>
					            					<th>العميل</th>
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="color: black;width: 90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body formHolder">
        <p>جاري تحميل الصفحة</p>
      </div>
      <div class="modal-footer FormFooter">
        <div id="javascriptFormHolder"></div>
      </div>
    </div>

  </div>
</div>

<div id="warningModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeWarningModal" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color: black;z-index: 999999999;">تنبيه</h4>
            </div>
            <div class="modal-body">
                <p style="color: black;">
                   يوجد خدمات معرفة لهذة الفاتورة
                </p>
                <button type="button" class="btn btn-danger" onclick="deleteAllServices();">حذف</button>
                <button type="button" class="btn btn-primary closeWarningModal" data-dismiss="modal">إستمرار</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default closeWarningModal" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<script type="text/javascript">

	var total_invocie = 0;
	var index = 0
	$(function(){
		$('input').on('focus',function(){
	        $(this).attr('autocomplete', 'off');
	    });

		checkForOldServices();
	    GetServicesItems();

	    $('#myModal').on('hidden.bs.modal', function () {
	   		$(".formHolder").empty();
        	$("#javascriptFormHolder").empty();
        	GetServicesItems();
		})

		$(".closeWarningModal").on("click",function(){
        	$(".item_code:last").select2("open");
		})

		$("#add_new_items").on("click",function(){
			index++;
			if ($(".item_code:last").val() != ""){
				var tableAppender = "";
				tableAppender += '<tr id="item_tr_'+index+'">';
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
				tableAppender += '<input id="item_quantity" name="item_quantity[]" placeholder="العدد" class="form-control item_quantity" type="text" value="" autocomplete="off">';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_price" name="item_price[]" placeholder="سعر الشراء" class="form-control item_price" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '<td>';
				tableAppender += '<input id="item_total_price" name="item_total_price[]" placeholder="إجمالي سعر الشراء" class="form-control item_total_price" type="text" value="">';
				tableAppender += '</td>';
				tableAppender += '<td class="noPrint">';
				tableAppender += '<input id="item_total_net" name="item_total_net[]" placeholder="صافي كمية الصنف بعد المحذوف والمباع" class="form-control item_total_net " type="text" disabled="disabled" style="display:inline; width:80%;"value=""> <span class="fa fa-times-circle text-danger" onclick="removeSelectedItem('+index+')"></span>';
				tableAppender += '</td>';
				tableAppender += '</tr>';
				tableAppender += "<tr>";
				$('.tbodysellTable').append(tableAppender);
				$(".item_quantity:last").on("keyup",function(){
					window.setTimeout(function(){
						$.each($(".item_total_price"),function(k,value){
							total_invocie += parseFloat($(value).val())
						});
						$("#items_total_price").val(parseFloat(total_invocie));
						$("#items_discount").keyup();
						$("#total_invoice_with_service").val(parseFloat(total_invocie) + parseFloat($("#service_total_price").val()));
						total_invocie = 0;
					}, 500)
				});

				$("input[type=text]").on("keypress",function(){
                    if (event.keyCode == 13){
                        $("#add_new_items").click();
					    event.preventDefault();

                        return false;
                    }
				});

				var elements = ["Ctrl+s"];

                $.each(elements, function(i, e) {
                   var newElement = ( /[\+]+/.test(elements[i]) ) ? elements[i].replace("+","_") : elements[i];
                   
                    $("input[type=text]").bind('keydown', elements[i], function assets() {
                        if (elements[i] == "Ctrl+s"){
                            $("#addSellInvoice").trigger("submit");
                        }
                        return false;
                   });
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

	   $("#add_new_items").click();
	   $(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy-mm-dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		item_code_finder();

		$("#items_discount").on("keyup",function(){
			var itemsTotalPrice = parseFloat($("#items_total_price").val()) + parseFloat($("#addons").val())
			var percentageValue = parseFloat($(this).val().split("%")[0] / 100);
			var itemsTotalPricePercentage = itemsTotalPrice - (itemsTotalPrice * percentageValue) 
			if ($(this).val().indexOf("%") != -1){
				$("#items_net_total").val(itemsTotalPricePercentage);
			}else{
				$("#items_net_total").val(itemsTotalPrice - $(this).val());
			}
			setTimeout(function(){
				$("#total_invoice_with_service").val(parseFloat($("#items_net_total").val()) + parseFloat(isNaN($("#service_total_price").val()) == false ?  $("#service_total_price").val() : 0))
			}, 100)
		});

		$("#addons").on("keyup",function(){
			var itemsTotalPrice = parseFloat($("#items_total_price").val()) + parseFloat($("#addons").val())
			var percentageValue = parseFloat($("#items_discount").val().split("%")[0] / 100);
			var itemsTotalPricePercentage = itemsTotalPrice - (itemsTotalPrice * percentageValue) 
			if ($("#items_discount").val().indexOf("%") != -1){
				$("#items_net_total").val(itemsTotalPricePercentage);
			}else{
				$("#items_net_total").val(itemsTotalPrice);

			}
			setTimeout(function(){
				$("#total_invoice_with_service").val(parseFloat($("#items_net_total").val()) + parseFloat(isNaN($("#service_total_price").val()) == false ?  $("#service_total_price").val() : 0))
			}, 100)
		});

		getLastInvoiceNumber();
		dataTableDrawerInvoice();

		$("#lastInvoiceNumber").on("keyup",function(){
			if ($(this).val() != ""){
				getInvoiceDataInvoice($(this).val())
			}
		})

		$("#addSellInvoice").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addSellInvoice",
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
						// getLastInvoiceNumber();
						// getNextItemsOnStoresID();
						// dataTableDrawerInvoice();
						ajaxBrowsing('{{Request::url("Request::url()")}}');
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
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
	});

	function item_code_finder(){
		$(".item_code:last").select2({
			width:"100%",
	        dir:"rtl",
	        placeholder : 'ضع كود صنف يديوياً او بإستخدام جهاز قارئ البار كود',
	        minimumInputLength: 1,
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
        }).select2("open");

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
		$(".item_price:last").val(repo.sell_dist_price);
		$(".item_total_net:last").val(repo.net_quantity);
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
		GetServicesItems();
		// $("body").click();
		//  $(this).closest('td').next('td').find('input').show();
	    return repo.item_code;
	}

	function getNextItemsOnStoresID(){
		return {{HomeController::getNextItemsOnStoresID('solditems')}}
	}

	function getInvoiceDataInvoice(invoiceID){

		$.ajax({
			url : "getInvoiceDataTable",
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
					$("#client_name").val(data.parent.client_name);
					$("#invoice_notice").val(data.parent.invoice_notice);
					$("#items_net_total").val(data.parent.items_net_total);
					$("#items_discount").val(data.parent.items_discount);
					$("#items_total_price").val(data.parent.items_total_price);
					$("#addons").val(data.parent.addons);
					$("#total_invoice_with_service").val(parseFloat($("#items_net_total").val()) + parseFloat($("#service_total_price").val()))
					$("#id,#invoice_date,#client_name,#invoice_notice,#items_net_total,#items_discount,#items_total_price,#addons").attr("readonly","true");
				
					$(".messages").hide();

					var tableAppender = "";
					$(".noPrint").hide();
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
						// tableAppender += '<td>';
						// tableAppender += '<input id="item_total_net" name="item_total_net[]" placeholder="صافي كمية الصنف بعد المحذوف والمباع" class="form-control item_total_net" type="text" disabled="disabled" value="'+v.net_quantity+'">';
						// tableAppender += '</td>';
						tableAppender += '</tr>';
						tableAppender += "<tr>";
					});

					$('.tbodysellTable').html(tableAppender);
					$("#id,#invoice_date,#client_name,#invoice_notice,#items_net_total,#items_discount,.item_name,.item_code,.item_type,.item_quantity,.item_price,.item_total_price,.item_total_net").attr("readonly","true");

					@if (Auth::user()->users_rights == 4)
						$("#invoice_date").removeAttr("disabled");
						$("#edit_invoice_date").fadeIn(500).attr("onclick","editInvoiceDate("+invoiceID+")");
						$(".deleteInvoice").fadeIn(500).attr("onclick","deletenvoiceDate("+invoiceID+")");
					@endif
					GetServicesItems();
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


	function dataTableDrawerInvoice(){
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getStoreItemsData",
			"aaSorting": [[ 1, "desc" ]],
		});

	  	 $('.sellInvoicedTable tbody').on('click', 'tr', function () {
	  	 	var iPos = sellInvoicedTabletbody.fnGetPosition( this );
	        var aData = sellInvoicedTabletbody.fnGetData( iPos );
	        var iId = aData[0];
	        $(".sellInvoicedTable tbody tr").removeClass("selectedRow");
	        $(this).addClass("selectedRow");
	        getInvoiceDataInvoice(iId);
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

	function removeSelectedItem(item){
		$("#item_tr_"+item+"").remove();
		$(".item_quantity").trigger("keyup");
	}
	

	function getLastInvoiceNumber(){
		$.ajax({
			url : "getLastInvoiceNumber",
			dataType : 'json',
			type : 'get',
			success : function(data){
				$("#lastInvoiceNumber").val(data.lastInvoiceNumber);
			},
			complete : function(){
				console.log("request completed");
			},
			error : function (error) {
				console.error(error);
			}
		});
	}

	function editInvoiceDate(iID){
		$.ajax({
			url : "editInvoiceDate",
			dataType : 'json',
			type : 'post',
			data : {
				invoice_id : iID,
				invoice_date : $("#invoice_date").val(),
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
					$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
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

	function deletenvoiceDate(iID){
		if (confirm("هل انت متأكد من حذف بيانات هذة الفاتورة ؟ ")){
			$.ajax({
				url : "deleteInvoiceDate",
				dataType : 'json',
				type : 'delete',
				data : {
					invoice_id : iID,
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
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
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
	}

	function getServicesForm(serviceID){
		$(".formHolder").empty()
    	$("#javascriptFormHolder").empty();
		setTimeout(function(){
			$.ajax({
				type : 'get',
	            dataType : 'html',
	            data : {
	            	invoice_id : $("#id").val(),
	            	from_invoice : "ok",
	            	service_name : $.trim($("#service_"+serviceID+"").text()),
	            	table_name : $("#service_"+serviceID+"").attr("data-table")
	            },
	            url : $("#service_"+serviceID+"").attr("data-href"),
	            success : function(data){
	            	$(".formHolder").html(data)
					$(".addNewItem").hide();
	            	
	            	$("#javascriptFormHolder").append(eval($(this).text()));
	            },
	            complete : function(){

	            },
	            error : function(error){
	            	alert("حدث خطأ اثناء تحميل الخدمة يرجي الإتصال بشركة كود برو")
	            }
			})
		}, 500)
	}

	function GetServicesItems () {
		$.ajax({
    		url : "getServicesWithInvoice",
    		dataType : "json",
    		type : "get",
    		data : {
    			invoice_id : $("#id").val()
    		},
    		success : function (data){
    			var dataDrawer = "<h4 class='alert alert-info'>الخدمات</h4>" 
    			dataDrawer += "<table class='table table-bordered'>";
    			dataDrawer += "<tr>"; 
    			dataDrawer += "<th>اسم الخدمة</th>"; 
    			dataDrawer += "<th>السعر</th>"; 
    			dataDrawer += "<th>حذف الخدمة</th>"; 
    			dataDrawer += "</tr>"; 
    			$.each(data.data,function(k,v){
    				dataDrawer += "<tr>";
    				dataDrawer += "<td>"+v.service_name+"</td>";
    				dataDrawer += "<td>"+v.price+"</td>";
    				dataDrawer += "<td><button type='button' class='btn btn-sm btn-danger' onclick=deleteServiceFromInvoice("+v.id+")>حذف</button></td>";
    				dataDrawer += "</tr>";
    			});
    			dataDrawer += "</table>";
    			
    			if (data.data.length > 0){
    				$(".services").html(dataDrawer);
    				$("#service_total_price").val(data.totalPrice);
    				$("#total_invoice_with_service").val(parseFloat(data.totalPrice) + parseFloat($("#items_net_total").val()));

    			}else{
    				$(".services").empty();
    				$("#service_total_price").val(0);
    				$("#total_invoice_with_service").val(parseFloat($("#items_net_total").val()) + parseFloat($("#service_total_price").val()));
    			}
    		}
    	});
	}

	function deleteServiceFromInvoice(linkID){
		if (confirm("هل انت اتأكد من حذف هذة الخدمة من الفاتورة الحالية ؟ ")){
			$.ajax({
				url : "deleteServiceFromInvoiceItem",
				dataType : "json",
				type : 'get',
				data : {
					link_id : linkID
				},
				success : function (data) {
					if (data.errorsFounder == 0){
						GetServicesItems();
					}else{
						alert(data.messages)
					}
				}
			});
		}
	}

	function checkForOldServices () {

		$.ajax({
    		url : "getServicesWithInvoice",
    		dataType : "json",
    		type : "get",
    		data : {
    			invoice_id : $("#id").val()
    		},
    		success : function (data){
    			if (data.data.length > 0){
					$(".warningModal").trigger("click");
					$(".item_code:last").select2("close");
    			}else{
    				$(".services").empty();
    			}
    		}
    	});
	}

	function deleteAllServices () {
		$(".closeWarningModal").trigger("click");
		$("#total_invoice_with_service").val(0);
		$("#service_total_price").val(0);
		$(".item_code:last").select2("open");
		$.ajax({
				url : "deleteAllServiceFromInvoiceItem",
				dataType : "json",
				type : 'get',
				data : {
					invoice_id : $("#id").val()
				},
				success : function (data) {
					if (data.errorsFounder == 0){
						GetServicesItems();
					}else{
						alert(data.messages)
					}
				}
			});
	}
</script>

