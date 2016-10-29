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
				        	<div class="messagesShower"></div>
				        	<div class="col-xs-12">
				        		<div class="alert alert-success">
			        				استمارة شاور
			        				<button class="btn btn-success addNewItem" onclick="addNewItem()">اضف بيانات استمارة شاور جديدة</button>

				        		</div>
					        	{{Form::open(["action" => "addNewShowerService","id"=>"addNewShowerService" ,"class"=>"form-horizontal"])}}
									<div class="form-group">
					                	{{Form::label('service_type', 'نوع الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("service_type",1,true,["id"=>"service_type", "placeholder"=>"ذكر"])}}
					                    	شاور &nbsp;
					                    	{{Form::radio("service_type",2,false,["id"=>"service_type", "placeholder"=>"انثي"])}}
					                    	دراي شاور &nbsp;
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
					                    	{{Form::select ("animal_type",$listOfServices,"",["id"=>"animal_type", "placeholder"=>"نوع الحيوان" , "class"=>"form-control" ])}} 
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
					              			بيانات خدمات الشاور 
					              		</h4>
					            		<table class="table table-bordered sellInvoicedTableShower">
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
					            					<th>التاريخ</th>
					            					<th>سعر الخدمة</th>
					            					<th>اسم الحيوان والفصيلة</th>
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

		$("#animal_type").on("change",function(){
			$.ajax({
				url : "getServicePrices",
				dataType : 'json',
				type : 'get',
				async : false,
				data : {
					id : $("#animal_type").val()
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messagesShower").html("<div class='alert alert-danger'>"+str+"</div>");

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

		dataTableDrawer();

		$("input[name=service_type]").on("click",function(){
			if ($(this).val() == 2){
				$("#service_price").val(10).attr("disabled","disabled");
			}else{
				$("#service_price").val(servicePrice).removeAttr("disabled");
			}
		});

		$("#addNewShowerService").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewShowerService",
				dataType : 'json',
				type : 'post',
				contentType: false,
    			processData: false,
				data : formElementsData,
				beforeSend : function(){
				$(".messagesShower").show();
				$(".messagesShower").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messagesShower").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						dataTableDrawer();
						$(".messagesShower").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
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
			url : "getShowerByID",
			dataType : 'json',
			type : 'get',
			data : {
				invoiceID : invoiceID,
			},
			beforeSend : function(){
			$(".messagesShower").show();
			$(".messagesShower").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
			},
			success : function(data){
				if (data.errorsFounder == 1){
					var str = '';
					$.each(data.messages,function(key,value){
						str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
					});

					$(".messagesShower").html("<div class='alert alert-danger'>"+str+"</div>");

				}else{
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$(".exitAnimal").fadeIn(500);
					$("#addNewShowerService").fadeIn(500);
					$(".invoice_previewer").hide();
					$("#date").val(data.date);
					$("#client_name").val(data.client_name);
					$("#client_mobile").val(data.client_mobile);
					$("#animal_type").val(data.animal_type);
					$(".gender").val(data.gender);
					$("#notice").val(data.notice);
					$("#service_price").val(data.price).attr("readonly","true");
					$("#animal_type").trigger("change");

					$("#discount_price").val(parseFloat(servicePrice - data.price)).attr("disabled","disabled");
					
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
					$("#addNewShowerService").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')
				}
			},
			complete : function(){
				$(".messagesShower").hide();
			},
			error : function (error) {
				console.error(error);
			}
		});
	}

	function addNewItem(){
		// $("#updated").remove();
		// $("input:not(input[type=radio],input[type=submit],.date) ,select,textarea").val("");
		// $("#addNewShowerService").fadeIn(500);
		// $(".invoice_previewer").hide()

		ajaxBrowsing('{{Request::url()}}');
	}

	function dataTableDrawer(){
		var sellInvoicedTableShowertbody = $(".sellInvoicedTableShower").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getShowerServices",
			"aaSorting": [[ 4, "desc" ]],
		});

	  	 $('.sellInvoicedTableShower tbody').on('click', 'tr', function () {
	  	 	var iPos = sellInvoicedTableShowertbody.fnGetPosition( this );
	        var aData = sellInvoicedTableShowertbody.fnGetData( iPos );
	        var iId = aData[0];
	        $(".sellInvoicedTableShower tbody tr").removeClass("selectedRow");
	        $(this).addClass("selectedRow");
	        getInvoiceData(iId);
	    });
	}
</script>