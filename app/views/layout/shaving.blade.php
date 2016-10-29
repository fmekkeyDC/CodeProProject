<style type="text/css">
	table tr {
		cursor: pointer;
	}

	.selectedRow {
		background-color: #337ab7 !important; 
		color: whitesmoke;
	}
</style>
<div id="content">
	<div class="outer">
		<div class="inner bg-light lter" style="min-height: 1000px">
			<div class="row">
				<div class="col-xs-12">
				    <div class="box dark">
				        <header>
				            <div class="icons"><i class="fa fa-edit"></i></div>
				            <h5> شاور</h5>
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
				        	<div class="messagesShaving"></div>
				        	<div class="col-xs-12">
				        		<div class="alert alert-success">استمارة حلاقة وتقليم اظافر
				        				<button class="btn btn-success addNewItem" onclick="addNewItem()">اضف بيانات حلاقة وتقليم جديدة</button>
				        		</div>
					        	{{Form::open(["action" => "addNewShavingService","id"=>"addNewShavingService" ,"class"=>"form-horizontal"])}}
									<div class="form-group">
					                	{{Form::label('service_type', 'نوع الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("service_type",1,true,["id"=>"service_type", "placeholder"=>"ذكر"])}}
					                    	حلاقة &nbsp;
					                    	{{Form::radio("service_type",2,false,["id"=>"service_type", "placeholder"=>"انثي"])}}
					                    	تقليم اظافر &nbsp;
					                    </div>
					                </div>

					        		<div class="form-group">
					                	{{Form::label('date', 'التاريخ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("date","",["id"=>"date"  , "placeholder"=>"التاريخ" , "class"=>"form-control date"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('client_name', 'اسم العميل',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("client_name","بدون",["id"=>"client_name", "placeholder"=>"اسم العميل" , "class"=>"form-control"])}}
					                    	{{Form::hidden("service_invice_id",Input::get("invoice_id", 0),["id"=>"service_invice_id"])}}
					                    	{{Form::hidden("from_invoice",Input::get("from_invoice", 0),["id"=>"from_invoice"])}}
					                    	{{Form::hidden("service_name",Input::get("service_name", 0),["id"=>"service_name"])}}
					                    	{{Form::hidden("table_name",Input::get("table_name", 0),["id"=>"table_name"])}}
					                    	
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('client_mobile', 'رقم التليفون',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("client_mobile","بدون",["id"=>"client_mobile", "placeholder"=>"رقم التليفون" , "class"=>"form-control"])}}
					                    </div>
					                </div>


					                <div class="form-group">
					                	{{Form::label('animal_type', 'نوع الحيوان',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select ("animal_type",$listOfServices,"",["id"=>"animal_type", "placeholder"=>"نوع الحيوان" , "class"=>"form-control type1" ])}} 
					                    	{{Form::select ("animal_type_2",$listOfServices_2,"",["id"=>"animal_type_2", "placeholder"=>"نوع الحيوان" , "class"=>"form-control type2" ])}} 
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('service_price', 'سعر الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("service_price","",["id"=>"service_price", "placeholder"=>"سعر الخدمة" , "class"=>"form-control"])}}
					                    </div>
				                    </div>

				                    <div class="form-group">
					                	{{Form::label('discount_price', 'قيمة الخصم',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("discount_price","",["id"=>"discount_price", "placeholder"=>"قيمة الخصم" , "class"=>"form-control"])}}
					                    </div>
					                </div>
						
					                 <div class="form-group">
					                	{{Form::label('gender', 'الجنس',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("gender",1,true,["id"=>"gender", "placeholder"=>"ذكر"])}}
					                    	ذكر &nbsp;
					                    	{{Form::radio("gender",2,false,["id"=>"gender", "placeholder"=>"انثي"])}}
					                    	انثي &nbsp;
					                    </div>
					                </div>
					                

					                 <div class="form-group">
					                	{{Form::label('notice', 'الملاحظات',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::textarea("notice","",["id"=>"notice", "placeholder"=>"الملاحظات" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}

					            <div class="row">
				              		<div style="clear:both"></div>
					              	<div class="col-xs-12">
					              		<h4 class="alert alert-info">
					              			بيانات خدمات الحلاقة وتقليم الأظافر 
					              		</h4>
					            		<table class="table table-bordered sellInvoicedTableShaving">
					            			<thead>
					            				<tr>
					            					<th>كود العميل</th>
					            					<th>اسم العميل</th>
					            					<th>رقم التليفون</th>
					            					<th>اسم الحيوان والفصيلة</th>
					            					<th>التاريخ</th>
					            					<th>سعر الخدمة</th>
					            				</tr>
					            			</thead>
					            			<tbody></tbody>
					            			<tfoot>
					            				<tr>
					            					<th>كود العميل</th>
					            					<th>اسم العميل</th>
					            					<th>رقم التليفون</th>
					            					<th>اسم الحيوان والفصيلة</th>
					            					<th>التاريخ</th>
					            					<th>سعر الخدمة</th>
				            					</tr>
					            			</tfoot>
					            		</table>
					            	</div>
				            	</div>
					            <div style= "clear: both;"></div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<!-- /.inner -->
		</div>
	</div>
	<!-- /.outer -->
</div>

<script type="text/javascript">
	var servicePrice = 0;
	$(".type2").hide().attr("disabled","disabled");
	$(function(){
		$(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy-mm-dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		dataTableDrawer();

		$("#animal_type").on("change",function(){
			$.ajax({
				url : "getServicePrices",
				dataType : 'json',
				type : 'get',
				data : {
					id : $("#animal_type").val()
				},
				async : false,
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messagesShaving").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						servicePrice = data.servicePrice; 
						if ($("input[name=service_type]:checked").val() == 1){
							$("#service_price").val(servicePrice).attr("disabled","disabled");
						}else{
							$("#service_price").val(10).attr("disabled","disabled");
						}
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

		$("#animal_type").trigger("change");


		
		$("input[name=service_type]").on("click",function(){
			if ($(this).val() == 2){
				$(".type1").hide().attr("disabled","disabled");
				$(".type2").show().removeAttr("disabled");
				$("#service_price").val(10).attr("disabled","disabled");
			}else{
				$(".type1").show().removeAttr("disabled");
				$(".type2").hide().attr("disabled","disabled");
				$("#service_price").val(servicePrice).removeAttr("disabled");
			}
		});

		$("#addNewShavingService").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewShavingService",
				dataType : 'json',
				type : 'post',
				contentType: false,
    			processData: false,
				data : formElementsData,
				beforeSend : function(){
				$(".messagesShaving").show();
				$(".messagesShaving").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messagesShaving").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						dataTableDrawer();
						// ajaxBrowsing('{{Request::url()}}');
						$(".messagesShaving").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
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

	function getInvoiceData(invoiceID){
		$("#animal_type").trigger("change");
		$.ajax({
			url : "getShavingByID",
			dataType : 'json',
			type : 'get',
			data : {
				invoiceID : invoiceID,
			},
			beforeSend : function(){
			$(".messagesShaving").show();
			$(".messagesShaving").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
			},
			success : function(data){
				servicePrice = data.price;
				if (data.errorsFounder == 1){
					var str = '';
					$.each(data.messages,function(key,value){
						str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
					});

					$(".messagesShaving").html("<div class='alert alert-danger'>"+str+"</div>");

				}else{
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$(".exitAnimal").fadeIn(500);
					$("#addNewShavingService").fadeIn(500);
					$(".invoice_previewer").hide();
					$("#date").val(data.date);
					$("#client_name").val(data.client_name);
					$("#client_mobile").val(data.client_mobile);
					if (data.service_type == 1) {
						$(".type1").fadeIn(500);
						$(".type2").fadeOut(500);
						$("#animal_type").val(data.animal_type);
					}else if (data.service_type == 2) {
						$(".type1").fadeOut(500);
						$(".type2").fadeIn(500);
						$("#animal_type_2").val(data.animal_type);
					}else{
						alert("خطأ في جلب بيانات نوع الحيوان")
					}
					$("#service_price").val(data.price).attr("disabled","disabled");
					$.each($("input[name=service_type]"),function(k,v){
						if ($(v).val() == data.service_type){
							$(v).prop("checked",true)
						}
					});

					$.each($("input[name=gender]"),function(k,v){
						if ($(v).val() == data.gender){
							$(v).prop("checked",true)
						}
					});
					$("#notice").val(data.notice);
					$("#discount_price").val(parseFloat(servicePrice - data.price)).attr("disabled","disabled");
					
					$("#addNewShavingService").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')
				}
			},
			complete : function(){
				$(".messagesShaving").hide();
			},
			error : function (error) {
				console.error(error);
			}
		});
	}

	function addNewItem(){
		// $("#updated").remove();
		// $("input:not(input[type=radio],input[type=submit],.date) ,select,textarea").val("");
		// $("#addNewShavingService").fadeIn(500);
		// $(".invoice_previewer").hide()
		ajaxBrowsing('{{Request::url()}}');
	}

	function dataTableDrawer(){
		var sellInvoicedTableShavingtbody = $(".sellInvoicedTableShaving").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getShavingServices",
			"aaSorting": [[ 4, "desc" ]],
		});

	  	 $('.sellInvoicedTableShaving tbody').on('click', 'tr', function () {
	  	 	var iPos = sellInvoicedTableShavingtbody.fnGetPosition( this );
	        var aData = sellInvoicedTableShavingtbody.fnGetData( iPos );
	        var iId = aData[0];
	        $(".sellInvoicedTableShaving tbody tr").removeClass("selectedRow");
	        $(this).addClass("selectedRow");
	        getInvoiceData(iId);
	    });
	}
</script>