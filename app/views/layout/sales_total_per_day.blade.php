<style type="text/css">

	table.dataTable {
	    width: 100%;
	    margin: 0 0 !important; 
	    clear: both;
	    border-collapse: collapse !important; 
	    border-spacing: 0;
	    font-size: 12px;
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

		.page-break{
			page-break-before: always; 
		}

		@page {size: portrait;}
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
				            <h5> التقارير</h5>
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
				        		<div class="alert alert-success">تقرير تفاصيل البيع <button type="button" class="btn btn-default pull-right" onclick="printDiv('.reportHolder');">طباعة</button>
			        			<div style="clear:both;"></div>

				        		</div>
			        			<div style="clear:both;"></div>
					        	{{Form::open(["action" => "showSalesDetailDailyReport","id"=>"showSalesDetailDailyReport" ,"class"=>"form-horizontal"])}}
					                <div class="col-xs-6">
						                <div class="form-group">
						                	{{Form::label('date_From', 'تاريخ البداية',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("date_From","",["id"=>"date_From" , "placeholder"=>"التاريخ" , "class"=>"form-control date"])}}
						                    </div>
						                </div>
					                </div>

					                <div class="col-xs-6">
						                <div class="form-group">
						                	{{Form::label('date_to', 'تاريخ النهاية',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("date_to","",["id"=>"date_to" , "placeholder"=>"التاريخ" , "class"=>"form-control date"])}}
						                    </div>
						                </div>
					                </div>

				                    <div class="col-xs-12">
					                	<div class="form-group">
					                    	{{Form::submit('عرض التقرير',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}
				            </div>
				            <div class="reportHolder"></div>
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
		$("#showSalesDetailDailyReport").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "showSalesDetailDailyReport",
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
						var reportDrawer = "";
						var totalPaymentPrice = 0;
						var totalPaymentPrice = 0;
						var totalPaymentPrice = 0;
						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-warning'>تقرير بالأصناف المباعة <span class='fa fa-toggle-on pull-right collapse-invoice' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped invoice'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>كود الصنف</th>";
						reportDrawer += "<th>إسم الصنف</th>";
						reportDrawer += "<th>الكمية المباعة</th>";
						// reportDrawer += "<th>سعر شراء الوحدة</th>";
						reportDrawer += "<th>سعر بيع الوحدة</th>";
						// reportDrawer += "<th>إجمالي سعر شراء الوحدات</th>";
						reportDrawer += "<th>إجمالي سعر بيع الوحدات</th>";
						// reportDrawer += "<th>الربح</th>";
						reportDrawer += "</tr>";
						$.each(data.total_items_payment,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.item_code +"</td>";
							reportDrawer += "<td>"+ v.item_name +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.total_sold_quantity).toFixed(2) +"</td>";
							// reportDrawer += "<td>"+ parseFloat(v.item_paid_price).toFixed(2) +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.item_sell_price).toFixed(2) +"</td>";
							// reportDrawer += "<td>"+ parseFloat(v.total_paid).toFixed(2) +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.total_sold).toFixed(2) +"</td>";
							// reportDrawer += "<td>"+ parseFloat(v.total_revenu).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "</div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.total_payment_details,function(k,v){
							reportDrawer += "<tr>";
							// reportDrawer += "<td>إجمالي سعرء الشراء</td>";
							// reportDrawer += "<td>"+ parseFloat(v.total_paid).toFixed(2) +"</td>";
							// reportDrawer += "<td>إجمالي سعر البيع</td>";
							reportDrawer += "<td>إجمالي البيع</td>";
							reportDrawer += "<td>"+ parseFloat(v.total_sold).toFixed(2) +"</td>";
							// reportDrawer += "<td>"+ parseFloat(v.total_revenu).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";


						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>خدمات <span class='fa fa-toggle-on pull-right collapse-service' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered service'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>إسم الخدمة</th>";
						reportDrawer += "<th>تاريخ الخدمة</th>";
						reportDrawer += "<th>إسم العميل</th>";
						reportDrawer += "<th>كود العميل</th>";
						reportDrawer += "<th>إجمالي المبلغ المحصل</th>";
						reportDrawer += "</tr>";
						$.each(data.getShowerServices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>خدمة شاور</td>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.price).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getShavingServices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ (v.service_type == 1 ? 'حلاقة' : 'تقليم اظافر') +"</td>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.price).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getCheckServices,function(k,v){
							var type ='';
							if (v.check_type == 1){ 
								type = 'كشف' 
							}else if(v.check_type == 2){ 
								type = 'إعادة كشف' 
							} else if (v.check_type == 3){
							 type = 'إستشارة'
							}
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ type  +"</td>";
							reportDrawer += "<td>"+ v.check_date +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.price).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getHostingPreEndServices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>خدمة إستضافة بمبلغ تحت الحساب</td>";
							reportDrawer += "<td>"+ v.start_date +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ v.user_pay_before_end_date +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getHostingEndServices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>خدمة استضافة منتهية</td>";
							reportDrawer += "<td>"+ v.end_date +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ v.total_remainig +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getOtherServicesServices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>خدمات اخري</td>";
							reportDrawer += "<td>"+ v.check_date + " - " + v.service_name +"</td>";
							reportDrawer += "<td>"+ v.client_name +"</td>";
							reportDrawer += "<td>"+ v.id +"</td>";
							reportDrawer += "<td>"+ parseFloat(v.price).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.totalServicesRevenu,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة الخدمات</td>";
							reportDrawer += "<td>"+ parseFloat(v.totalServicesRevenu).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>إيرادات اخري <span class='fa fa-toggle-on pull-right collapse-other-revenu' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered revenu'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>التاريخ</th>";
						reportDrawer += "<th>نوع الإيراد</th>";
						reportDrawer += "<th>المبلغ</th>";
						reportDrawer += "</tr>";
						$.each(data.getRevenu,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>"+ v.expenses_name +"</td>";
							reportDrawer += "<td>"+ v.expenses_value +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.totalRevenuValue,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة الإيرادات الأخري</td>";
							reportDrawer += "<td>"+ v.totalRevenuValue +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>مصروفات <span class='fa fa-toggle-on pull-right collapse-expenses' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered expenses'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>التاريخ</th>";
						reportDrawer += "<th>الطبيعة</th>";
						reportDrawer += "<th>نوع المصروف</th>";
						reportDrawer += "<th>المبلغ</th>";
						reportDrawer += "</tr>";
						$.each(data.getExpenses,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>مصروفات</td>";
							reportDrawer += "<td>"+ v.expenses_name +"</td>";
							reportDrawer += "<td>"+ v.expenses_value +"</td>";
							reportDrawer += "</tr>";
						});

						$.each(data.getUsable,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>مستخدم</td>";
							reportDrawer += "<td>"+ v.expenses_name +"</td>";
							reportDrawer += "<td>"+ v.expenses_value +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.TotalExpensesValue,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة المصروفات</td>";
							reportDrawer += "<td>"+ parseFloat(v.totalExpenses).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>الصادر <span class='fa fa-toggle-on pull-right collapse-export' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered export'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>التاريخ</th>";
						reportDrawer += "<th>الطبيعة</th>";
						reportDrawer += "<th>نوع المصروف</th>";
						reportDrawer += "<th>المبلغ</th>";
						reportDrawer += "</tr>";
						$.each(data.getExport,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>صادر</td>";
							reportDrawer += "<td>"+ v.expenses_name +"</td>";
							reportDrawer += "<td>"+ v.expenses_value +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";
						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.exportValue,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة الصادر</td>";
							reportDrawer += "<td>"+ parseFloat(v.exportValue).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>مصروفات شهرية <span class='fa fa-toggle-on pull-right collapse-MonthlyCosts' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered MonthlyCosts'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>التاريخ</th>";
						reportDrawer += "<th>الطبيعة</th>";
						reportDrawer += "<th>نوع المصروف</th>";
						reportDrawer += "<th>المبلغ</th>";
						reportDrawer += "</tr>";
						$.each(data.getMonthlyCosts,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.date +"</td>";
							reportDrawer += "<td>مصروفات شهرية</td>";
							reportDrawer += "<td>"+ v.expenses_name +"</td>";
							reportDrawer += "<td>"+ v.expenses_value +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";
						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.monthlyCosts,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة المصروفات الشهرية</td>";
							reportDrawer += "<td>"+ parseFloat(v.monthlyCosts).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-info'>فواتير مرتجعة <span class='fa fa-toggle-on pull-right collapse-reverse' style='cursor:pointer;'></span></h6>";
						reportDrawer += "<table class='dataTable table table-bordered reverse'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>رقم الفاتورة</th>";
						reportDrawer += "<th>تاريخ الفاتورة</th>";
						reportDrawer += "<th>إجمالي المبلغ المخصوم</th>";
						reportDrawer += "</tr>";
						$.each(data.getReversingInvoices,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ v.invoice_number +"</td>";
							reportDrawer += "<td>"+ v.invoice_date +"</td>";
							reportDrawer += "<td>"+ v.items_net_total +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "</div> <div class='page-break'></div>";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<table class='dataTable table table-bordered table-striped'>";
						$.each(data.reversing_invoiceValue,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>إجمالي قيمة المرتجع</td>";
							reportDrawer += "<td>"+ parseFloat(v.reversing_invoiceValue).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});

						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						reportDrawer += "<div class='col-xs-12 '>";
						reportDrawer += "<h6 class='alert alert-warning'>صافي الإيراد خلال الفترة</h6>";
						reportDrawer += "<table class='dataTable table table-bordered'>";
						reportDrawer += "<tr>";
						reportDrawer += "<th>من الفترة</th>";
						reportDrawer += "<th>إلي الفترة</th>";
						reportDrawer += "<th>بيع الفواتير</th>";
						reportDrawer += "<th>مبالغ اضافية علي الفواتير</th>";
						reportDrawer += "<th>صافي إيراد الخدمات</th>";
						reportDrawer += "<th>صافي إيراد الإيرادات الأخري</th>";
						reportDrawer += "<th>يخصم منه المصروفات</th>";
						reportDrawer += "<th>يخصم منه مصروفات صادرة من النقدية</th>";
						reportDrawer += "<th>يخصم منه مصروفات شهرية</th>";
						reportDrawer += "<th>يخصم منه فواتير مرتجعة</th>";
						reportDrawer += "<th>يخصم منه قيمة الخصومات علي المبيعات</th>";
						reportDrawer += "<th>المبلغ</th>";
						reportDrawer += "</tr>";
						$.each(data.getStoreItemsData,function(k,v){
							reportDrawer += "<tr>";
							reportDrawer += "<td>"+ $("#date_From").val() +"</td>";
							reportDrawer += "<td>"+ $("#date_to").val() +"</td>";
							$.each(data.total_payment_details,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.total_revenu).toFixed(2) +"</td>";
							});
							
							$.each(data.addons,function(k,v){
								reportDrawer += "<td>"+ v.addons +"</td>";
							});

							$.each(data.totalServicesRevenu,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.totalServicesRevenu).toFixed(2) +"</td>";
							});


							$.each(data.totalRevenuValue,function(k,v){
								reportDrawer += "<td>"+ v.totalRevenuValue +"</td>";
							});


							$.each(data.TotalExpensesValue,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.totalExpenses).toFixed(2) +"</td>";
							});

							$.each(data.exportValue,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.exportValue).toFixed(2) +"</td>";
							});

							$.each(data.monthlyCosts,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.monthlyCosts).toFixed(2) +"</td>";
							});

							$.each(data.reversing_invoiceValue,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.reversing_invoiceValue).toFixed(2) +"</td>";
							});

							$.each(data.getDiscounts,function(k,v){
								reportDrawer += "<td>"+ parseFloat(v.getDiscounts).toFixed(2) +"</td>";
							});
							
							reportDrawer += "<td>"+ parseFloat(v.totalRevnue).toFixed(2) +"</td>";
							reportDrawer += "</tr>";
						});
						reportDrawer += "</table>";
						reportDrawer += "<hr /> </div> ";

						// reportDrawer += "<div class='col-xs-12 '>";
						// reportDrawer += "<h6 class='alert alert-warning'>صافي الإيراد بإجمالي فواتير الشراء خلال المدة </h6>";
						// reportDrawer += "<table class='dataTable table table-bordered'>";
						// reportDrawer += "<tr>";
						// reportDrawer += "<th>من الفترة</th>";
						// reportDrawer += "<th>إلي الفترة</th>";
						// reportDrawer += "<th>المبلغ</th>";
						// reportDrawer += "</tr>";
						// $.each(data.getStoreItemsDataWithPayment,function(k,v){
						// 	reportDrawer += "<tr>";
						// 	reportDrawer += "<td>"+ $("#date_From").val() +"</td>";
						// 	reportDrawer += "<td>"+ $("#date_to").val() +"</td>";
						// 	reportDrawer += "<td>"+ v.totalRevnue.toFixed(2) +"</td>";
						// 	reportDrawer += "</tr>";
						// });
						// reportDrawer += "</table>";
						// reportDrawer += "<hr /> </div> ";

						// reportDrawer += "<div class='col-xs-12 '>";
						// reportDrawer += "<h6 class='alert alert-info'>فواتير مباعة</h6>";
						// reportDrawer += "<table class='dataTable table table-bordered'>";
						// reportDrawer += "<tr>";
						// reportDrawer += "<th>رقم الفاتورة</th>";
						// reportDrawer += "<th>تاريخ الفاتورة</th>";
						// reportDrawer += "<th>خصومات</th>";
						// reportDrawer += "<th>إضافات</th>";
						// reportDrawer += "<th>إجمالي المبلغ المحصل</th>";
						// reportDrawer += "</tr>";
						// $.each(data.getSoldInvoices,function(k,v){
						// 	reportDrawer += "<tr>";
						// 	reportDrawer += "<td>"+ v.invoice_number +"</td>";
						// 	reportDrawer += "<td>"+ v.invoice_date +"</td>";
						// 	reportDrawer += "<td>"+ v.items_discount +"</td>";
						// 	reportDrawer += "<td>"+ v.addons +"</td>";
						// 	reportDrawer += "<td>"+ v.items_net_total +"</td>";
						// 	reportDrawer += "</tr>";
						// });
						// reportDrawer += "</table>";
						// reportDrawer += " <hr /> </div><div class='page-break'></div>";

						// reportDrawer += "<div class='col-xs-12 '>";
						// reportDrawer += "<h6 class='alert alert-info'>بضاعة مشتراه</h6>";
						// reportDrawer += "<table class='dataTable table table-bordered'>";
						// reportDrawer += "<tr>";
						// reportDrawer += "<th>رقم الفاتورة</th>";
						// reportDrawer += "<th>تاريخ الفاتورة</th>";
						// reportDrawer += "<th>خصومات</th>";
						// reportDrawer += "<th>إجمالي المبلغ المدفوع</th>";
						// reportDrawer += "</tr>";
						// $.each(data.getStoreItems,function(k,v){
						// 	reportDrawer += "<tr>";
						// 	reportDrawer += "<td>"+ v.invoice_number +"</td>";
						// 	reportDrawer += "<td>"+ v.invoice_date +"</td>";
						// 	reportDrawer += "<td>"+ v.items_discount +"</td>";
						// 	reportDrawer += "<td>"+ v.items_net_total +"</td>";
						// 	reportDrawer += "</tr>";
						// });
						// reportDrawer += "</table>";
						// reportDrawer += " <hr /> </div><div class='page-break'></div>";

						$(".reportHolder").html(reportDrawer);
						$(".reverse,.invoice,.service,.revenu,.expenses,.export,.MonthlyCosts").hide();
						$(".collapse-reverse").on("click",function(){
							$(".reverse").toggle();
						});
						$(".collapse-invoice").on("click",function(){
							$(".invoice").toggle();
						});
						$(".collapse-service").on("click",function(){
							$(".service").toggle();
						});
						$(".collapse-revenu").on("click",function(){
							$(".revenu").toggle();
						});
						$(".collapse-other-revenu").on("click",function(){
							$(".revenu").toggle();
						});
						
						$(".collapse-expenses").on("click",function(){
							$(".expenses").toggle();
						});
						$(".collapse-export").on("click",function(){
							$(".export").toggle();
						});
						$(".collapse-MonthlyCosts").on("click",function(){
							$(".MonthlyCosts").toggle();
						});
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> تم عرض التقرير بنجاح </div>")
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

		$(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy-mm-dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		$(".dataTable").dataTable();
	});


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
</script>
