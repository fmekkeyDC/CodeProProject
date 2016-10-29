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
				            <h5> الخدمات </h5>
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
				        			<span class="pull-left">تعريف الخدمات</span>
				        			<span class="pull-right">
				        				<button class="btn btn-success" onclick="addNewItem()">اضف صنف جديد</button>
				        			</span>
				        			<div style="clear:both;"></div>
				        		</div>
					        	{{Form::open(["action" => "addNewService","id"=>"addNewService" ,"class"=>"form-horizontal"])}}
					                <div class="form-group">
					                	{{Form::label('app_name', 'نوع الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select("service_plan",[1 => "استضافة" , 2 => "كشف" , 3 => "استشارة"  , 4 => "شاور" , 5 => "تقليم اظافر"  , 6 => "حلاقة" , 7 => "دراي شاور"],"",["id"=>"service_plan" , "placeholder"=>"نوع الخدمة" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('service_name', 'اسم الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("service_name","",["id"=>"service_name" ,"placeholder"=>"اسم الخدمة" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('service_price', 'سعر الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("service_price","",["id"=>"service_price" ,"placeholder"=>"سعر الخدمه" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('service_type', 'نوع القيمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("service_type",1,true,["id"=>"service_type" ,"placeholder"=>"يوميا" ])}}
					                    	يوميا &nbsp;
					                    	{{Form::radio("service_type",2,false,["id"=>"service_type" ,"placeholder"=>"ثابت" ])}}
					                    	ثابت &nbsp;
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('weak_discount', 'نسبة خصم الاسبوع',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("weak_discount","",["id"=>"weak_discount" ,"placeholder"=>"نسبة خصم الاسبوع %" , "class"=>"form-control"])}} 
					                    </div>
					                    {{Form::label('month_discount', 'نسبة خصم الشهر ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-4">
					                    	{{Form::text("month_discount","",["id"=>"month_discount" ,"placeholder"=>"نسبة خصم الشهر %" , "class"=>"form-control"])}} 
					                    </div>
					                </div>

					                  <div class="form-group">
					                	
					                </div>


					                 <div class="form-group">
					                	{{Form::label('service_notice', 'ملاحظات',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::textarea("service_notice","",["id"=>"service_notice" ,"placeholder"=>"ملاحظات" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}
				            </div>
				            <div class="row">
			              		<div style="clear:both"></div>
				              	<div class="col-xs-12">
				              		<h4 class="alert alert-info">
				              			الخدمات المعرفة حالياً
				              		</h4>
				            		<table class="table table-bordered sellInvoicedTable">
				            			<thead>
				            				<tr>
				            					<th>كود الخدمة</th>
				            					<th>نوع الخدمة</th>
				            					<th>اسم الخدمة</th>
				            					<th>سعر الخدمة</th>
				            				</tr>
				            			</thead>
				            			<tbody></tbody>
				            			<tfoot>
				            				<tr>
				            					<th>كود الخدمة</th>
				            					<th>نوع الخدمة</th>
				            					<th>اسم الخدمة</th>
				            					<th>سعر الخدمة</th>
				            				</tr>
				            			</tfoot>
				            		</table>
				            	</div>
			            	</div>
		              		<div style="clear:both"></div>
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
		$("#addNewService").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewService",
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


		dataTableDrawer();
	});


	function getInvoiceData(invoiceID){

		$.ajax({
			url : "getServiceByID",
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
					$("#service_name").val(data.service_name);
					$("#service_price").val(data.service_price);
					$.each($("input[name=service_type]"),function(k,v){
						if ($(v).val() == data.service_type){
							$(v).prop("checked",true)
						}
					});
					$("#weak_discount").val(data.weak_discount);
					$("#month_discount").val(data.month_discount);
					$("#service_plan").val(data.service_plan);
					$("#service_notice").val(data.service_notice);
					$(".messages").hide();
					$("#addNewService").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')
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
		$("#updated").remove();
		$("input:not(input[type=radio]),select,textarea").val("");
	}

	function dataTableDrawer() {
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getServicesTypes",
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
</script>
