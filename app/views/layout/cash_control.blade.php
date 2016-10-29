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
				            <h5> الفواتير</h5>
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
				        	<div class="col-xs-8">
				        		<div class="alert alert-success">تسجيل النقدية
				        			<button class="btn btn-success pull-right" type="button" onclick="ajaxBrowsing('{{Request::url()}}')"> اضف جديد</button>
				        			<div style="clear:both;"></div>
				        		</div>
					        	{{Form::open(["action" => "addNewCash","id"=>"addNewCash" ,"class"=>"form-horizontal"])}}
					                
					        		<div class="form-group">
					                	{{Form::label('type', 'نوع العملية',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("type","1",true,["id"=>"type"])}}
					                    	مصروفات &nbsp;
					                    	{{Form::radio("type","2",false,["id"=>"type"])}}
					                    	ايرادات &nbsp;
					                    	{{Form::radio("type","3",false,["id"=>"type"])}}
					                    	صادر &nbsp;
					                    	{{Form::radio("type","4",false,["id"=>"type"])}}
					                    	مستخدم &nbsp;
					                    	{{Form::radio("type","5",false,["id"=>"type"])}}
					                    	مصروفات شهرية &nbsp;
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('date', 'التاريخ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("date","",["id"=>"date" , "placeholder"=>"التاريخ" , "class"=>"form-control date"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('expenses_value', 'المبلغ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("expenses_value","",["id"=>"expenses_value" ,  "placeholder"=>"المبلغ" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                  <div class="form-group">
					                	{{Form::label('expenses_name', 'نوع المصروف',["class"=>"control-label col-xs-2 type_name"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("expenses_name","",["id"=>"expenses_name" ,  "placeholder"=>"نوع المصروف" , "class"=>"form-control type_name"])}}
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
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}
				            </div>
				            <div class="col-xs-4">
				        		<div class="alert alert-info">معلومات الخزينة</div>
				            	<div class="table-responsive tableHolder">
				            		<table class="table table-bordered sortableTable responsive-table tablesorter tablesorter-default">
				            			<thead>
				            				<tr>
				            					<th> رصيد الخزينة</th>
				            				</tr>
				            			</thead>
				            			<tbody>
				            				<tr>
				            					<td>
				            						{{Form::text("CashBoxNow","",["id"=>"CashBoxNow" , "placeholder"=>"رصيد الخزينة " , "class"=>"form-control"])}}
				            					</td>
				            					
				            				</tr>
				            			</tbody>
				            		</table>
				            	</div>
				            </div>
				            <div class="row">
			              		<div style="clear:both"></div>
				              	<div class="col-xs-12">
				              		<h4 class="alert alert-info column_name">
				              			بيان بالمصروفات 
				              		</h4>
				            		<table class="table table-bordered sellInvoicedTable">
				            			<thead>
				            				<tr>
				            					<th>الكود</th>
				            					<th>التاريخ</th>
				            					<th class="type_name">نوع المصروف</th>
				            					<th>المبلغ</th>
				            				</tr>
				            			</thead>
				            			<tbody></tbody>
				            			<tfoot>
				            				<tr>
				            					<th>الكود</th>
				            					<th>التاريخ</th>
				            					<th class="type_name">نوع المصروف</th>
				            					<th>المبلغ</th>
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
		dataTableDrawer();
		$("#addNewCash").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewCash",
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
						dataTableDrawer();

					}else{
						dataTableDrawer();
						$(".date").trigger("change");
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" </div>")
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

		$("input[name=type]").on("click",function(){
			var type = $("input[name=type]:checked").val();
			var table_name = "إسم المصروف"
			var column_name = "بيان بالمصروفات";
			if(type == 2){
				table_name = "إسم الإيراد";
				column_name = "بيان بالإيرادات"
			}else if (type == 1){
				table_name = "إسم المصروف";
				column_name = "بيان بالمصروفات"
			}else if (type == 3){
				table_name = "إسم الصادر";
				column_name = "بيان بالصادرات"
			}else if (type == 4){
				table_name = "إسم المستخدم";
				column_name = "بيان بالإستخدامات"
			}else if (type == 5){
				table_name = "مصروفات شهرية";
				column_name = "بيان بالمصروفات شهرية"
			}


			$(".type_name").text(table_name);
			$(".column_name").html(column_name);
			$(".type_name").attr("placeholder",table_name);
			dataTableDrawer();
		});
		$(".date").on("change",function(){
			$.ajax({
				url : "getCurrentCashBoxService",
				dataType : 'json',
				type : 'get',
				data : {
					invoiceID : $(this).val(),
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

					}else{
						$("#CashBoxNow").val(data[0].totalRevnue)
						$("input:not('.date,#CashBoxNow,input[type=submit],input[type=radio]'),textarea").val("");
					}
				},
				complete : function(){
					console.log("request completed");
				},
				error : function (error) {
					console.error(error);
				}
			});
		}).trigger("change");
	});

	function dataTableDrawer() {
		var type = $("input[name=type]:checked").val();
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getExpenses?type="+type+"",
			"aaSorting": [[ 0, "desc" ]],
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

	function getInvoiceData(invoiceID){

		$.ajax({
			url : "getExpensesByID",
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
					$("#date").val(data.date);
					$("#expenses_name").val(data.expenses_name);
					$("#expenses_value").val(data.expenses_value);
					$("#notice").val(data.notice);
					$(".messages").hide();
					$("#addNewCash").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')

					$.each($("input[name=type]"),function(k,v){
						if ($(v).val() == data.gender){
							$(v).prop("checked",true)
						}
					});
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
</script>
