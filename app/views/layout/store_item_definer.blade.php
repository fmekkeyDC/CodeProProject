
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
    						<div class="alert alert-success">كارت الصنف </div>
    						<button class="btn btn-success addNewRecord" onclick="ajaxBrowsing('{{Request::url()}}')" style="display: none;"> تعريف صنف جديد </button>
				        	<br>
				        	<div class="messages"></div>
				        	{{Form::open(["action" => "addNewItemCard","id"=>"addNewItemCard" ,"class"=>"form-horizontal"])}}
					        	<div class="col-xs-6">
					                <div class="form-group">
					                	{{Form::label('item_type_id', 'نوع الصنف',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select("item_type_id",$listOfItemsTypes,"",["id"=>"item_type_id", "placeholder"=>"نوع الصنف" , "class"=>"form-control item_type_id"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('item_name', 'إسم الصنف',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("item_name","",["id"=>"item_name" , "placeholder"=>"إسم الصنف" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('item_code', 'كود الصنف',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("item_code","",["id"=>"item_code"  , "placeholder"=>"كود الصنف" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('paid_price', 'سعر الشراء',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("paid_price","",["id"=>"paid_price"  , "placeholder"=>"سعر الشراء" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('sell_dist_price', 'سعر البيع قطاعي',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("sell_dist_price","",["id"=>"sell_dist_price"  , "placeholder"=>"سعر البيع قطاعي" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('wholesale_price', 'سعر البيع جملة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("wholesale_price","",["id"=>"wholesale_price"  , "placeholder"=>"سعر البيع جملة" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('item_description', 'وصف الصنف',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::textarea("item_description","",["id"=>"item_description"  , "placeholder"=>"وصف الصنف" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					            </div>
					            <div class="col-xs-6">
					                <div class="form-group">
					                	{{Form::label('started_quantity', 'الرصيد الإفتتاحي',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("started_quantity","",["id"=>"started_quantity"  , "placeholder"=>"الرصيد الإفتتاحي" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('item_profitability', 'ربحية الصنف',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("item_profitability","",["id"=>"item_profitability"  , "placeholder"=>"ربحية الصنف" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('re_request_point', 'حد إعادة الطلب',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("re_request_point","",["id"=>"re_request_point"  , "placeholder"=>"حد إعادة الطلب" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('non_storeable_item', 'صنف غير مخزني',["class"=>"control-label col-xs-4"])}}
					                    <div class="col-xs-2">
					                    	{{Form::checkbox("non_storeable_item",0,false,["id"=>"non_storeable_item" , "class"=>"form-control"])}}
					                	</div>
					                	{{Form::label('none_active_item', 'صنف غير نشط',["class"=>"control-label col-xs-4"])}}
					                    <div class="col-xs-2">
					                    	{{Form::checkbox("none_active_item",1,false,["id"=>"none_active_item" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="form-group">
					                        <label class="control-label col-xs-4">صورة الصنف</label>
					                        <div class="col-xs-8">
					                            <div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
													<div>
													  <span class="btn btn-default btn-file"><span class="fileinput-new">إختر الصورة</span><span class="fileinput-exists">تغيير</span><input type="file" name="item_picture" id="item_picture"></span>
													  <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">إلغاء</a>
													</div>
										      	</div>

				                        	</div>
					            		</div>
				            		</div>
			           			</div>
				                <div class="form-group">
				                    <div class="col-xs-12">
				                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
				                    </div>
				                </div>
			            	{{Form::close()}}

			              		<div style="clear:both"></div>
				              	<div class="col-xs-12">
				              		<h4 class="alert alert-info">
				              			الأصناف المعرفة حالياً
				              		</h4>
				            		<table class="table table-bordered sellInvoicedTable">
				            			<thead>
				            				<tr>
				            					<th>كود الصنف</th>
				            					<th>اسم الصنف</th>
				            					<th>مجموعة الحيوان</th>
				            				</tr>
				            			</thead>
				            			<tbody></tbody>
				            			<tfoot>
				            				<tr>
				            					<th>كود الصنف</th>
				            					<th>مجموعة الحيوان</th>
				            					<th>مجموعة الحيوان</th>
				            				</tr>
				            			</tfoot>
				            		</table>
				            	</div>
			            	<div style="clear:both"></div>
		            </div>
	            </div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div style="clear:both"></div>

<script type="text/javascript">
	var isUpdated = 0;
	$(function(){
		nextItemID();

		$("#item_type_id").on("change",function(){
			if(isUpdated == 0){
				nextItemID();
			}
		});

		$("#paid_price , #sell_dist_price").on("focus",function(){
			$("#wholesale_price").val($("#sell_dist_price").val());
			$("#item_profitability").val(parseFloat( $("#sell_dist_price").val() - $("#paid_price").val() ));
		});

		$("#paid_price , #sell_dist_price").on("keyup",function(){
			$("#wholesale_price").val($("#sell_dist_price ").val());
			$("#item_profitability").val(parseFloat( $("#sell_dist_price").val() - $("#paid_price").val() ));
		})

		dataTableDrawer();

		$("#addNewItemCard").on("submit",function(){

			var formElementsData = new FormData(this);

			$.ajax({
				url : "addNewItemCard",
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
						ajaxBrowsing('{{Request::url()}}');
						nextItemID();
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

		$(".addNewRecord").on("click",function(){
			$("#oldItemID").remove();
			$(this).fadeOut();
		});

		$(".item_type_id").select2();
	});

	function nextItemID(){
		$.ajax({
			url : "next_item_id",
			dataType : 'json',
			type : 'get',
			beforeSend : function(){
			// $(".messages").show();
			// $(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
			},
			success : function(data){
				$("#item_code").val("00"+ $("#item_type_id").find(":selected").val()  +data)
			},
			complete : function(){
				console.log("request completed");
				// $(".messages").empty();
				// $(".messages").hide();
			},
			error : function (error) {
				console.error(error);
			}
		});

	}

	function getInvoiceData(invoiceID){

		$.ajax({
			url : "getStoreItemDataTableInfo",
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
					isUpdated = 1;
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$("#addNewItemCard").append("<input type='hidden' name='oldItemID' id='oldItemID' value='"+data.parent.item_code+"'>");
					$("#item_name").val(data.parent.item_name);
					$("#item_type_id").val(data.parent.item_type_id).change();
					$("#item_code").val(data.parent.item_code);
					$("#paid_price").val(data.parent.paid_price);
					$("#wholesale_price").val(data.parent.wholesale_price);
					$("#sell_dist_price").val(data.parent.sell_dist_price);
					$("#started_quantity").val(data.parent.started_quantity).attr("readonly","true");
					$("#item_profitability").val(data.parent.item_profitability);
					$("#re_request_point").val(data.parent.re_request_point);
					$("#item_description").val(data.parent.item_description);
					$(".addNewRecord").fadeIn(500);
					if (data.parent.non_storeable_item == 1){
						$("#non_storeable_item").prop('checked', true);
					}
					if (data.parent.non_storeable_item == 1){
						$("#none_active_item").prop('checked', true);
					}
					$(".messages").hide();
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

	function dataTableDrawer() {
		var sellInvoicedTabletbody = $(".sellInvoicedTable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            },
            "bProcessing": true,
			"bServerSide": true,
			"bDestroy": true,
			"sAjaxSource": "getStoresItemsDataTable",
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