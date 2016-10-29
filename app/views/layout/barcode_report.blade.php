<div id="content">
	<div class="outer">
		<div class="inner bg-light lter" style="min-height: 1000px">
			<div class="row">
				<div class="col-xs-12">
				    <div class="box dark">
				        <header>
				            <div class="icons"><i class="fa fa-edit"></i></div>
				            <h5>مدير التطبيقات</h5>
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
				        		<div class="alert alert-success">تقرير طباعة بار كود الأصناف</div>
					        	{{Form::open(["action" => "getItemsBarCodes","id"=>"getItemsBarCodes" ,"class"=>"form-horizontal" , "target"=>"_blank"])}}
					        		<div class="col-xs-6">
						                <div class="form-group">
						                	{{Form::label('item_name', 'اسم الصنف',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("item_name","",["id"=>"item_name" , "name"=>"item_name" , "placeholder"=>"اسم الصنف" , "class"=>"form-control item_code_select_items"])}}
						                    </div>
						                </div>	
					                </div>
					                <div class="col-xs-4">
					                	<div class="form-group">
						                	{{Form::label('quantity', 'العدد',["class"=>"control-label col-xs-2"])}}
						                    <div class="col-xs-10">
						                    	{{Form::text("quantity","",["id"=>"quantity", "placeholder"=>"العدد" , "class"=>"form-control quantity"])}}
						                    </div>
						                </div>
					                </div>

					                <div class="col-xs-2">
					                	<div class="form-group">
						                	<button class="btn btn-primary btn-block" type="button" onclick="insertNewLine()">إضافة</button>
						                </div>
					                </div>

					                {{-- <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div> --}}
					            {{Form::close()}}
				            </div>
				        	{{Form::open(["action" => "printBarCodes","id"=>"printBarCodes" ,"class"=>"form-horizontal" , "target"=>"_blank"])}}

					            <div class="col-xs-12 reportArea">
					            	@foreach($getBarCodesData as $barcode)
					            		<table class="table table-bordered">
											<tr>
												<th class="col-xs-3">معرف الصنف</th>
												<th class="col-xs-3">كود الصنف</th>
												<th class="col-xs-3">اسم الصنف</th>
												<th class="col-xs-3">عدد</th>
												<th class="col-xs-1">حذف</th>
											</tr>
											<tr>
												<td>{{$barcode->id}}</td>
												<td>{{$barcode->item_code}}</td>
												<td>{{$barcode->item_name}}</td>
												<td><input type="number" name="count[]" class="form-control count" id="count" value="{{$barcode->quantity}}"></td>
												<td style="display:none;"><input type="hidden" name="item_code[]" class="form-control item_code" id="item_code" value="{{$barcode->item_code}}"></td>
												<td><button class="btn btn-danger btn-sm" type="button" onclick='$(this).closest("table").remove();'>حذف</button></td>
											</tr>
										</table>
					            	@endforeach
					            </div>
					            <div style="clear: both;"></div>

					            <div class="col-xs-12">
			                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					            </div>
			            		<div style="clear: both;"></div>
				            {{Form::close()}}

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
	var item_id = "" , item_code = "", item_name = "";
	$(function(){
		// $("#getItemsBarCodes").on("submit",function(){
		// 	var formElementsData = new FormData(this);
		// 	$.ajax({
		// 		url : "getItemsBarCodes",
		// 		dataType : 'json',
		// 		type : 'post',
		// 		contentType: false,
  //   			processData: false,
		// 		data : formElementsData,
		// 		beforeSend : function(){
		// 		$(".messages").show();
		// 		$(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
		// 		},
		// 		success : function(data){
		// 			if (data.errorsFounder == 1){
		// 				var str = '';
		// 				$.each(data.messages,function(key,value){
		// 					str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
		// 				});

		// 				$(".messages").html("<div class='alert alert-danger'>"+str+"</div>");

		// 			}else{
		// 				$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+" <h2 class='text-center'>كود العميل : "+data.ServiceCode+"</h2> </div>")
		// 			}
		// 		},
		// 		complete : function(){
		// 			console.log("request completed");
		// 		},
		// 		error : function (error) {
		// 			console.error(error);
		// 		}
		// 	});
		// 	return false;
		// });

		$(".item_code_select_items").select2({
			width:"100%",
	        dir:"rtl",
	        placeholder : 'ضع كود صنف يديوياً او بإستخدام جهاز قارئ البار كود',
	        minimumInputLength: 1,
	        id: function(bond){ return bond.id},
	        ajax: {
	        url: 'getItemDataByBarCode',
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
		}).on("select2-close", function () {
		    setTimeout(function() {
		        $('.select2-container-active').removeClass('select2-container-active');
		        $(':focus').blur();
		    }, 1);
		}).select2("open");
	});


	function repoFormatResultItems(repo) {
    	var markup = '<div class="row-fluid">' +
	    '<div class="span10">' +
	    '<div class="row-fluid">' +
	       '<div class="span6">' + repo.item_name + " " + repo.item_code +'</div>' +
	    '</div>';

	    markup += '</div></div>';
	    return markup;
	}

	function repoFormatSelectionItems(repo) {
		item_id = repo.id;
		item_code = repo.item_code; 
		item_name = repo.item_name;
		setTimeout(function(){
				$(".quantity").get(0).focus()
			},500)
	    return repo.item_code;
	}

	function printBarCodes(id) {
		return window.location.href = "print_barcodes?id="+id;
	}

	function insertNewLine(){
		var table_Drawer = '<table class="table table-bordered">';
		table_Drawer += '<tr>';
		table_Drawer += '<th class="col-xs-3">معرف الصنف</th>';
		table_Drawer += '<th class="col-xs-3">كود الصنف</th>';
		table_Drawer += '<th class="col-xs-3">اسم الصنف</th>';
		table_Drawer += '<th class="col-xs-2">عدد</th>';
		table_Drawer += '<th class="col-xs-1">حذف</th>';
		table_Drawer += '</tr>';
		table_Drawer += '<tr>';
		table_Drawer += '<td>'+item_id+'</td>';
		table_Drawer += '<td>'+item_code+'</td>';
		table_Drawer += '<td>'+item_name+'</td>';
		// table_Drawer += '<td><button class="btn btn-success" onclick=printBarCodes("'+repo.item_code+'") type="button">طباعة</button></td>';
		table_Drawer += '<td><input type="number" name="count[]" class="form-control count" id="count" value="'+$(".quantity").val()+'"></td>';
		table_Drawer += '<td style="display:none;"><input type="hidden" name="item_code[]" class="form-control item_code" id="item_code" value="'+item_code+'"></td>';
		table_Drawer += '<td><button class="btn btn-danger btn-sm removeTable" type="button">حذف</button></td>';
		table_Drawer += '</tr>';
		table_Drawer += '</table>';


		if ($(".table:contains('"+item_code+"')").length == 0){
			$(".reportArea").append(table_Drawer);
		}else{
			alert("لا يمكن اضافة هذا الصنف لأنه مضاف من قبل")
			setTimeout(function(){
				$(".table:contains('"+item_code+"')").find("td:eq(3)").find("input").get(0).focus()
			},500)
		}
		$(".item_code_select_items").select2("open");

		$(".removeTable").on("click",function(){
			$(this).closest("table").remove(); 
		});
	}
</script>

