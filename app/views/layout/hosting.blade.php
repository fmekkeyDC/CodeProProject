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
				            <h5> استضافه</h5>
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
				        	<div class="messages"></div>
				        	<div class="col-xs-12">
				        		<div class="alert alert-success">
				        			<span class="pull-left">استمارة استضافه</span>
				        			<span class="pull-right">
				        				<button class="btn btn-success addNewItem" onclick="addNewItem();">اضف بيانات استضافة جديدة</button>
				        				<button class="btn btn-danger exitAnimal" style="display:none;">تسجيل خروج من خدمة الإستضافة</button>
				        			</span>
				        			<div style="clear:both;"></div>
				        		</div>


				        		<div class="alert alert-info clientIdDebit" style="display: none;">
			            			<h3>
			            				هذا العميل متبقي عليه مبلغ <span class="remainValue"></span> 
			            				<button class="btn btn-warning remainRequest pull-right">تحصيل المبلغ</button>
			            			</h3>
			            		</div>
				        			
					        	{{Form::open(["action" => "addNewHostingServices","id"=>"addNewHostingServices" ,"class"=>"form-horizontal"])}}

					        		<div class="form-group end_date">
					                	{{Form::label('end_date', 'تاريخ الخروج',["class"=>"control-label col-xs-2 "])}}
					                    <div class="col-xs-5">
					                    	{{Form::text("end_date","",["id"=>"end_date"  , "placeholder"=>"تاريخ الخروج" , "class"=>"form-control date "])}}
					                    </div>
					                    <div class="col-xs-5">
					                    	<button class="btn btn-primary exitAnimalBTN" type="button">تسجيل الخروج</button>
					                    </div>

					                </div>

					        		<div class="form-group">
						                	{{Form::label('start_date', 'تاريخ الاستضافة',["class"=>"control-label col-xs-2 "])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("start_date","",["id"=>"start_date"  , "placeholder"=>"تاريخ الاستضافه" , "class"=>"form-control date"])}}
						                    </div>
						                </div>
					                <div class="form-group">
					                	{{Form::label('client_name', 'اسم العميل',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("client_name","",["id"=>"client_name" , "placeholder"=>"اسم العميل" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('mobile_number', 'رقم التليفون',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("mobile_number","",["id"=>"mobile_number" , "placeholder"=>"رقم التليفون" , "class"=>"form-control"])}}
					                    </div>
					                </div>

				                  	<div class="form-group">
					                	{{Form::label('animal_type', 'نوع الحيوان',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select ("animal_type",$listOfServices,"",["id"=>"animal_type" , "placeholder"=>"نوع الحيوان" , "class"=>"form-control" ])}} 
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('animal_type', 'سعر الخدمة لليوم الواحد',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text ("per_day_price","",["id"=>"per_day_price" , "placeholder"=>"سعر الخدمة لليوم الواحد" , "class"=>"form-control" ])}} 
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('animal_type', 'مبلغ تحت الحساب',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text ("price_under_reciept","",["id"=>"price_under_reciept" , "placeholder"=>"مبلغ تحت الحساب" , "class"=>"form-control" ])}} 
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('animal_name', 'اسم الحيوان',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("animal_name","",["id"=>"animal_name" , "placeholder"=>"اسم الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('animal_color', 'لون الحيوان',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("animal_color","",["id"=>"animal_color" , "placeholder"=>"لون الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                 <div class="form-group">
					                	{{Form::label('gender', 'الجنس',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("gender","1",true,["id"=>"gender" , "placeholder"=>"ذكر"])}}
					                    	ذكر &nbsp;
					                    	{{Form::radio("gender","2",false,["id"=>"gender" , "placeholder"=>"انثي"])}}
					                    	انثي &nbsp;
					                    	
					                    </div>
					                </div>

					                 <div class="form-group">
					                	{{Form::label('notice', 'ملاحظات',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::textarea("notice","",["id"=>"notice" , "placeholder"=>"ملاحظات" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block saveDataFormBtn"])}}
					                    </div>
					                </div>
					            {{Form::close()}}

					            <div class="row">
				            	<div class="col-xs-6 invoice_previewer">
					        		<div class="form-group">
					                	{{Form::label('start_date_exit', 'تاريخ وصول الحيوان',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("start_date_exit","",["id"=>"start_date_exit"  , "placeholder"=>"تاريخ وصول الحيوان" , "class"=>"form-control date"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('end_date_exit', 'تاريخ المغادرة',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("end_date_exit","",["id"=>"end_date_exit"  , "placeholder"=>"تاريخ المغادرة" , "class"=>"form-control date"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('client_name_exit', 'اسم العميل',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("client_name_exit","",["id"=>"client_name_exit" , "placeholder"=>"اسم العميل" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('mobile_number_exit', 'رقم التليفون',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("mobile_number_exit","",["id"=>"mobile_number_exit" , "placeholder"=>"رقم التليفون" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                  <div class="form-group">
					                	{{Form::label('animal_type_exit', 'نوع الحيوان',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::select ("animal_type_exit",$listOfServices,"",["id"=>"animal_type_exit" , "placeholder"=>"نوع الحيوان" , "class"=>"form-control" ])}} 
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('animal_name_exit', 'اسم الحيوان',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("animal_name_exit","",["id"=>"animal_name_exit" , "placeholder"=>"اسم الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('animal_color_exit', 'لون الحيوان',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("animal_color_exit","",["id"=>"animal_color_exit" , "placeholder"=>"لون الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                 <div class="form-group">
					                	{{Form::label('gender_exit', 'الجنس',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::radio("gender_exit","1",true,["id"=>"gender_exit" , "placeholder"=>"ذكر"])}}
					                    	ذكر &nbsp;
					                    	{{Form::radio("gender_exit","2",false,["id"=>"gender_exit" , "placeholder"=>"انثي"])}}
					                    	انثي &nbsp;
					                    	
					                    </div>
					                </div>
				                </div>

				                <div class="col-xs-6 invoice_previewer">
				                	<div class="form-group">
					                	{{Form::label('totalDays', 'إجمالي المدة بالأيام',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("totalDays","",["id"=>"totalDays"  , "placeholder"=>"تاريخ وصول الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('months', 'عدد الشهور خلال المدة',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("months","",["id"=>"months"  , "placeholder"=>"تاريخ المغادرة" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('monthPrice', 'قيمة الشهور بعد الخصم',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("monthPrice","",["id"=>"monthPrice" , "placeholder"=>"اسم العميل" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('netWeeks', 'عدد الأسابيع خلال المدة',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("netWeeks","",["id"=>"netWeeks" , "placeholder"=>"رقم التليفون" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                 <div class="form-group">
					                	{{Form::label('weekPrice', 'قيمة الأسابيع بعد الخصم',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("weekPrice","",["id"=>"weekPrice" , "placeholder"=>"اسم الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('netDays', 'الأيام المتبقية',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("netDays","",["id"=>"netDays" , "placeholder"=>"لون الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('price_per_day', 'تكلفة اليوم الواحد',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("price_per_day","",["id"=>"price_per_day" , "placeholder"=>"تكلفة اليوم الواحد" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('NetPrice', 'قيمة الأيام المتبقية',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("NetPrice","",["id"=>"NetPrice" , "placeholder"=>"لون الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('orderBeforeDiscount', 'إجمالي المبلغ قبل الخصومات',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("orderBeforeDiscount","",["id"=>"orderBeforeDiscount" , "placeholder"=>"إجمالي المبلغ قبل الخصومات" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('orderTotalValue', 'إجمالي المبلغ بعد الخصومات',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("orderTotalValue","",["id"=>"orderTotalValue" , "placeholder"=>"إجمالي المبلغ قبل الخصومات" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('المبلغ المطلوب دفعة', 'المبلغ المطلوب دفعة',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("invoice_remaining","",["id"=>"invoice_remaining" , "placeholder"=>"المبلغ المبلغ المطلوب دفعة" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('old_payment', 'المبلغ المدفوع مسبقاً',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("old_payment","",["id"=>"old_payment" , "placeholder"=>"المبلغ المدفوع مسبقاً" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('total_invoice_pay', 'المبلغ المدفوع من قبل العميل',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("total_invoice_pay","",["id"=>"total_invoice_pay" , "placeholder"=>"المبلغ المدفوع من قبل العميل" , "class"=>"form-control"])}}
					                    </div>
					                </div>


					                <div class="form-group">
					                	{{Form::label('الباقي', 'الباقي',["class"=>"control-label col-xs-6"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("total_invoice_change","",["id"=>"total_invoice_change" , "placeholder"=>"الباقي" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="col-xs-12">
				                    	{{Form::button('تحصيل المبلغ المطلوب',["type"=>"button","class"=>"btn btn-success btn-block InsertPrice"])}}
					                </div>
				                </div>
				            </div>
				            </div>
				            <div class="row">
			              		<div style="clear:both"></div>
				              	<div class="col-xs-12">
				              		<h4 class="alert alert-info">
				              			بيانات خدمات الإستضافة 
				              		</h4>
				            		<table class="table table-bordered sellInvoicedTable">
				            			<thead>
				            				<tr>
				            					<th>كود العميل</th>
				            					<th>اسم العميل</th>
				            					<th>رقم التليفون</th>
				            					<th>اسم الحيوان والفصيلة</th>
				            					<th>تاريخ الدخول</th>
				            					<th>تاريخ الخروج</th>
				            				</tr>
				            			</thead>
				            			<tbody></tbody>
				            			<tfoot>
				            				<tr>
				            					<th>كود العميل</th>
				            					<th>اسم العميل</th>
				            					<th>رقم التليفون</th>
				            					<th>اسم الحيوان والفصيلة</th>
				            					<th>تاريخ الدخول</th>
				            					<th>تاريخ الخروج</th>
				            				</tr>
				            			</tfoot>
				            		</table>
				            	</div>
			            	</div>
				            <div style="clear: both;"></div>
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
	$(function(){
		$(".invoice_previewer").hide();
		$(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy-mm-dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		$(".end_date").hide();
		dataTableDrawer();
		
		$("#animal_type").on("change",function(){
			$.ajax({
				url : "getPriceForServices",
				dataType : 'json',
				type : 'get',
				data : {
					id : $("#animal_type").val()
				},
				success : function(data){
					$("#per_day_price").val(data.item_price).attr("disabled","disabled");
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

		$("#addNewHostingServices").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewHostingServices",
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
						dataTableDrawer();
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
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
		$.ajax({
			url : "getHostingByID",
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
					if (data.end_date == null){
						$(".exitAnimal").fadeIn(500);
						$("#addNewHostingServices").fadeIn(500);
						$(".invoice_previewer").hide();
						$("#start_date").val(data.start_date);
						$("#client_name").val(data.client_name);
						$("#mobile_number").val(data.mobile_number);
						$("#animal_type").val(data.animal_type);
						$("#animal_name").val(data.animal_name);
						$("#animal_color").val(data.animal_color);
						$("#per_day_price").val(data.price_per_day);
						$("#price_under_reciept").val(data.user_pay_before_end_date);

						$.each($("input[name=gender]"),function(k,v){
							if ($(v).val() == data.gender){
								$(v).prop("checked",true)
							}
						});
						$("#notice").val(data.notice);
					}else{
						$(".exitAnimal").fadeOut(500);
						$("#addNewHostingServices").hide();
						$(".invoice_previewer").fadeIn(500);
						$("#start_date_exit").val(data.start_date);
						$("#end_date_exit").val(data.end_date);
						$("#client_name_exit").val(data.client_name);
						$("#mobile_number_exit").val(data.mobile_number);
						$("#animal_type_exit").val(data.animal_type);
						$("#animal_name_exit").val(data.animal_name);
						$("#animal_color_exit").val(data.animal_color);
						$("#total_invoice_pay").val(data.total_invoice_pay);
						$("#invoice_remaining").val(parseFloat(data.orderTotalValue - data.user_pay_before_end_date));
						$("#total_invoice_change").val(data.total_invoice_change);
						$("#totalDays").val(data.totalDays);
						$("#months").val(data.months);
						$("#netDays").val(data.netDays);
						$("#netWeeks").val(data.netWeeks);
						$("#weekPrice").val(data.weekPrice);
						$("#monthPrice").val(data.monthPrice);
						$("#NetPrice").val(data.NetPrice);
						$("#orderBeforeDiscount").val(data.orderBeforeDiscount);
						$("#orderTotalValue").val(data.orderTotalValue);
						$("#old_payment").val(data.user_pay_before_end_date);
						$("#price_per_day").val(data.price_per_day);

						$.each($("input[name=gender_exit]"),function(k,v){
							if ($(v).val() == data.gender){
								$(v).prop("checked",true)
							}
						});

						if (data.total_invoice_pay == 0 || data.total_invoice_pay == null || data.total_invoice_pay < data.orderTotalValue){
							$(".InsertPrice").fadeIn(500).attr("onclick","paymentRecord('"+data.id+"')");

							$("#total_invoice_pay").on("keyup",function(){
								$("#total_invoice_change").val(parseFloat(data.orderTotalValue) - (parseFloat($("#total_invoice_pay").val()) +  + parseFloat(data.user_pay_before_end_date)))
							});
						}else{
							$(".InsertPrice").fadeOut(500);
						}


					}

					if (data.total_invoice_change > 0){
						console.log("ads")
						$(".clientIdDebit").fadeIn(500);
						$(".remainValue").html(data.total_invoice_change)
						$(".remainRequest").attr("onclick","setRemainPrice('"+data.id+"')")
					}else{
						$(".clientIdDebit").fadeOut(500);
						$(".remainValue").html("");
					}

					if (data.end_date != null){
						$(".exitAnimal").fadeOut(500).removeAttr("onclick");
						$(".end_date").hide();
					}else{
						$(".exitAnimal").fadeIn(500).attr("onclick","exitAnimalDate('"+data.id+"')");
						// $(".end_date").show();

					}
					$(".messages").hide();
					$("#addNewHostingServices").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')
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

	function addNewItem(){
		// $("#updated").remove();
		// $("input:not(input[type=radio],input[type=submit],.date) ,select,textarea").val("");
		// $("#addNewHostingServices").fadeIn(500);
		// $(".invoice_previewer").hide()
		ajaxBrowsing('{{Request::url()}}');
	}

	function exitAnimal(id){
		if (confirm('هل انت متأكد من تسجيل خروج هذا الحيوان من خدمة الإستضافة ؟ ')){
			$.ajax({
			url : "exitHosting",
			dataType : 'json',
			type : 'get',
			data : {
				invoiceID : id,
				exitDate : $("#end_date").val()
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
					$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
					getInvoiceData(id);
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

	function paymentRecord(id){
		if (confirm('هل انت متأكد من تحصيل المبلغ المدفوع؟ ')){
			$.ajax({
				url : "paymentRecord",
				dataType : 'json',
				type : 'post',
				data : {
					invoiceID : id,
					total_invoice_pay : $("#total_invoice_pay").val(),
					total_invoice_change : $("#total_invoice_change").val(),
					invoice_remaining : $("#invoice_remaining").val(),
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
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
						getInvoiceData(id);
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


	function setRemainPrice (id){
		if (confirm('هل انت متأكد من تحصيل المبلغ المتبقي ')){
			$.ajax({
				url : "setRemainPrice",
				dataType : 'json',
				type : 'post',
				data : {
					invoiceID : id,
					total_invoice_pay : $("#total_invoice_pay").val(),
					total_invoice_change : $("#total_invoice_change").val(),
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
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
						getInvoiceData(id);
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

	function dataTableDrawer() {
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getHostingServicesItems",
			"aaSorting": [[ 5, "desc" ]],
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

	function exitAnimalDate(id){
		$(".end_date").fadeIn(500);
		$(".exitAnimalBTN").attr("onclick","exitAnimal("+id+")")
	}
</script>