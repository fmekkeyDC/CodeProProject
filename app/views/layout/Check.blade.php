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
				            <h5> كشف و استشاره </h5>
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
				        	<div class="messagesCheck"></div>
				        	<div class="col-xs-12">
				        		<div class="alert alert-success">استمارة كشف و استشاره 
			        				<button class="btn btn-success addNewItem" onclick="addNewItem()">اضف بيانات خدمة كشف جديد</button>
				        		</div>
					        	{{Form::open(["action" => "addNewCheck","id"=>"addNewCheck" ,"class"=>"form-horizontal"])}}
					        	
					                 <div class="form-group">
					                	{{Form::label('check_type', 'نوع الاستماره',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("check_type",1,true,["id"=>"check_type"  , "placeholder"=>"كشف","class"=>"check_type"])}}
					                    	كشف &nbsp;

					                    	{{Form::radio("check_type",2,false,["id"=>"check_type"  , "placeholder"=>"اعادة كشف","class"=>"check_type"])}}
					                    	اعادة كشف &nbsp;

					                    	{{Form::radio("check_type",3,false,["id"=>"check_type"  , "placeholder"=>"ماستشاره","class"=>"check_type"])}}
					                    	استشاره &nbsp;
					                    	
					                    </div>
					                </div>

					        		<div class="form-group">
					                	{{Form::label('check_date', 'التاريخ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("check_date","",["id"=>"check_date"  , "placeholder"=>"التاريخ" , "class"=>"form-control date"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('price', 'سعر الخدمة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("price","",["id"=>"price"  , "placeholder"=>"سعر الخدمة" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('client_name', 'اسم العميل',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("client_name","بدون",["id"=>"client_name"  , "placeholder"=>"اسم العميل" , "class"=>"form-control"])}}
					                    	{{Form::hidden("service_invice_id",Input::get("invoice_id", 0),["id"=>"service_invice_id"])}}
					                    	{{Form::hidden("from_invoice",Input::get("from_invoice", 0),["id"=>"from_invoice"])}}
					                    	{{Form::hidden("service_name",Input::get("service_name", 0),["id"=>"service_name"])}}
					                    	{{Form::hidden("table_name",Input::get("table_name", 0),["id"=>"table_name"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('client_mobile', 'رقم التليفون',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("client_mobile","بدون",["id"=>"client_mobile"  , "placeholder"=>"رقم التليفون" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                  <div class="form-group">
					                	{{Form::label('animal_type', 'نوع الحيوان',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("animal_type","",["id"=>"animal_type"  , "placeholder"=>"نوع الحيوان" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                 <div class="form-group">
					                	{{Form::label('gender', 'الجنس',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::radio("gender",1,true,["id"=>"gender"  , "placeholder"=>"ذكر","class"=>"gender"])}}
					                    	ذكر &nbsp;
					                    	{{Form::radio("gender",2,false,["id"=>"gender"  , "placeholder"=>"انثي","class"=>"gender"])}}
					                    	انثي &nbsp;
					                    	
					                    </div>
					                </div>
					                 


					                 <div class="form-group">
					                	{{Form::label('notice', 'التشخيص',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::textarea("notice","",["id"=>"notice"  , "placeholder"=>"التشخيص" , "class"=>"form-control"])}}
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
				              			بيانات خدمات الكشف والإستشارة 
				              		</h4>
				            		<table class="table table-bordered sellInvoicedTableCheck">
				            			<thead>
				            				<tr>
				            					<th>كود العميل</th>
				            					<th>اسم العميل</th>
				            					<th>رقم التليفون</th>
				            					<th>اسم الحيوان والفصيلة</th>
				            					<th>التاريخ</th>
				            					<th>السعر</th>
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
				            					<th>السعر</th></tr>
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
		$("#addNewCheck").on("submit",function(){
			var formElementsData = new FormData(this);
			$.ajax({
				url : "addNewCheck",
				dataType : 'json',
				type : 'post',
				contentType: false,
    			processData: false,
				data : formElementsData,
				beforeSend : function(){
				$(".messagesCheck").show();
				$(".messagesCheck").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = '';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messagesCheck").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						dataTableDrawer();
						$(".messagesCheck").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
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
			url : "getCheckingByID",
			dataType : 'json',
			type : 'get',
			data : {
				invoiceID : invoiceID,
			},
			beforeSend : function(){
			$(".messagesCheck").show();
			$(".messagesCheck").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
			},
			success : function(data){
				if (data.errorsFounder == 1){
					var str = '';
					$.each(data.messages,function(key,value){
						str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
					});

					$(".messagesCheck").html("<div class='alert alert-danger'>"+str+"</div>");

				}else{
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$(".exitAnimal").fadeIn(500);
					$("#addNewHostingServices").fadeIn(500);
					$(".invoice_previewer").hide();

					$("#check_date").val(data.check_date);
					
					$.each($("input[name=check_type]"),function(k,v){
						if ($(v).val() == data.check_type){
							$(v).prop("checked",true)
						}
					});

					$("#client_name").val(data.client_name);
					$("#client_mobile").val(data.client_mobile);
					$("#animal_type").val(data.animal_type);
					$("#price").val(data.price).attr("disabled","disabled");
					$.each($("input[name=gender]"),function(k,v){
						if ($(v).val() == data.gender){
							$(v).prop("checked",true)
						}
					});
					$("#notice").val(data.notice);
					$("#addNewCheck").append('<input type="hidden" name="updated" id="updated" value="'+data.id+'">')
				}
			},
			complete : function(){
				$(".messagesCheck").hide();
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

	function dataTableDrawer(){
		var sellInvoicedTableChecktbody = $(".sellInvoicedTableCheck").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getCheckServices",
			"aaSorting": [[ 4, "desc" ]],
		});

	  	 $('.sellInvoicedTableCheck tbody').on('click', 'tr', function () {
	  	 	var iPos = sellInvoicedTableChecktbody.fnGetPosition( this );
	        var aData = sellInvoicedTableChecktbody.fnGetData( iPos );
	        var iId = aData[0];
	        $(".sellInvoicedTableCheck tbody tr").removeClass("selectedRow");
	        $(this).addClass("selectedRow");
	        getInvoiceData(iId);
	    });
	}

</script>