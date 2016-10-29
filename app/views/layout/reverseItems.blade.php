
<link rel="stylesheet" href="{{$public_path}}lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css">
<link rel="stylesheet" href="{{$public_path}}lib/jquery.gritter/css/jquery.gritter.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/Uniform.js/2.1.2/themes/default/css/uniform.default.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">

<style type="text/css">
	label {
		font-size: 12px !important;
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
    						<div class="alert alert-success">إذن إرجاع اصناف</div>
				        	<div class="messages"></div>
				        	{{Form::open(["action" => "addItemsToStores","id"=>"addItemsToStores" ,"class"=>"form-horizontal"])}}
					        	<div class="row">
						        	<div class="col-xs-12">
						                <div class="form-group">
						                	{{Form::label('invoice_number', 'رقم الفاتورة',["class"=>"control-label col-xs-4"])}}
						                    <div class="col-xs-8">
						                    	{{Form::text("invoice_number","",["id"=>"invoice_number" , "placeholder"=>"رقم الفاتورة" , "class"=>"form-control invoice_number"])}}
						                    </div>
						                </div>
						            </div>

						            {{-- <div class="col-xs-12" style="margin-bottom:12px;">
						            	<button class="btn btn-danger" type="button" id="add_new_items">حذف الإذن بالكامل</button>
						            </div> --}}

						            <div class="col-xs-12">
						            	<div class="table-responsive tableHolder">
						            		<table class="table table-bordered itemsTable sortableTable responsive-table tablesorter tablesorter-default">
						            			<thead>
						            				<tr>
						            					<th>كود الصنف</th>
						            					<th>إسم الصنف</th>
						            					<th>نوع الصنف</th>
						            					<th>الكمية</th>
						            					<th>الكمية المراد إرجاعها للمخزن</th>
						            					<th>تعديل</th>
						            				</tr>
						            			</thead>
						            			<tbody class="drawer"></tbody>
					            			</table>
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
				            	
		            		</div>
	            	{{Form::close()}}
	            </div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
</div>
<script type="text/javascript">
	$(function(){
		var current_parent_id = "";
		$(".date").datepicker({
		    language : 'ar',
		    todayBtn : "linked",
		    format : 'yyyy/mm/dd',
		    autoClose : true
		});
		var plus14days = new Date();
		plus14days.setDate(plus14days.getDate());
		$(".date").datepicker("setDate", plus14days);

		$(".invoice_number").select2({
			width:"100%",
	        dir:"rtl",
	        placeholder : 'ضع كود صنف يديوياً او بإستخدام جهاز قارئ البار كود',
	        minimumInputLength: 1,
	        id: function(bond){ return bond.id},
	        ajax: {
	        url: 'getItemSoldData',
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
		});
	});

	function getChildrenData(parent_id){
		current_parent_id = parent_id;
		$.ajax({
			url : "getChildrenItemData",
			dataType : "json",
			type : "get",
			data : {
				keyword : parent_id,
			},
			success : function (data){
				var tableDrawer = "";

				$.each(data,function(k,v){
					tableDrawer += "<tr>";
					tableDrawer += '<td>';
					tableDrawer += '<input id="item_id_'+v.s_id+'" disabled="disabled"  name="item_id" type="hidden" value="'+v.s_id+'">';
					tableDrawer += '<input id="item_code_'+v.s_id+'" disabled="disabled" placeholder="كود الصنف" class="form-control" name="item_code" type="text" value="'+v.store_items_item_name+'">';
					tableDrawer += '</td>';
					tableDrawer += '<td>';
					tableDrawer += '<input id="item_name_'+v.s_id+'" disabled="disabled" placeholder="إسم الصنف" class="form-control" name="item_name" type="text" value="'+v.item_definer_item_name+'">';
					tableDrawer += '</td>';
					tableDrawer += '<td>';
					tableDrawer += '<input id="item_type_'+v.s_id+'" disabled="disabled"  placeholder="النوع" class="form-control" name="item_type" type="text" value="'+v.item_type_name+'">';
					tableDrawer += '</td>';
					tableDrawer += '<td>';
					tableDrawer += '<input id="item_quantity_'+v.s_id+'" disabled="disabled" placeholder="الكمية الحالية" class="form-control" name="item_quantity" type="text" value="'+v.net_quantity+'">';
					tableDrawer += '</td>';
					tableDrawer += '<td>';
					tableDrawer += '<input id="item_quantity_deleted_'+v.s_id+'" name="item_quantity_deleted" placeholder="الكمية المراد حذفها" class="form-control" type="text" value="">';
					tableDrawer += '</td>';
					tableDrawer += "<td><button type='button' class='btn btn-success btn-sm' onclick='saveFN("+v.s_id+")'>حفظ</button></td>"
					tableDrawer += "</tr>";
				})
				$(".drawer").html(tableDrawer);

			}
		})
	}

	function repoFormatResultItems(repo) {
    	var markup = '<div class="row-fluid">' +
	    '<div class="span10">' +
	    '<div class="row-fluid">' +
	       '<div class="span6">' + repo.invoice_number + '</div>' +
	    '</div>';

	    markup += '</div></div>';
	    return markup;
	}

	function repoFormatSelectionItems(repo) {

		// $("#provider_name").val(repo.provider_name);
		// $("#invoice_date").val(repo.invoice_date);
		getChildrenData(repo.invoice_number);
	    return repo.invoice_number;
	}
	
	function saveFN(invoice_parent){
		if (confirm('هل انت متأكد من تعديل الكميات الحالية ؟')){
			$.ajax({
				url : "saveDeletedItemsSold",
				dataType : 'json',
				type : 'post',
				data : {
					item_code : $("#item_code_"+invoice_parent+"").val(),
					invoice_parent : $("#invoice_number").val(),
					item_id : $("#item_id_"+invoice_parent+"").val(),
					item_quantity : $("#item_quantity_"+invoice_parent+"").val(),
					item_quantity_deleted : $("#item_quantity_deleted_"+invoice_parent+"").val(),
					delete_reason : $("#delete_reason_"+invoice_parent+"").val()
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
						getChildrenData(current_parent_id)
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
</script>