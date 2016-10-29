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
				        	<div class="col-xs-8">
				        		<div class="alert alert-success">تعريف انواع الأصناف</div>
					        	{{Form::open(["action" => "addNewItemGroups","id"=>"addNewItemGroups" ,"class"=>"form-horizontal"])}}
					                <div class="form-group">
					                	{{Form::label('item_type_name', 'إسم النوع',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("item_type_name","",["id"=>"item_type_name" , "name"=>"item_type_name" , "placeholder"=>"إسم النوع" , "class"=>"form-control"])}}
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
				        		<div class="alert alert-info">التطبيقات الحالية</div>
				            	<div class="table-responsive tableHolder">
				            		<table class="table table-bordered sortableTable responsive-table tablesorter tablesorter-default">
				            			<thead>
				            				<tr>
				            					<th>اسم النوع</th>
				            					<th>حفظ</th>
				            				</tr>
				            			</thead>
				            			<tbody>
				            			@foreach($getItemsGroups as $group)
				            				<tr>
				            					<td>
				            						{{Form::text("item_type_name",$group->item_type_name,["id"=>"item_type_name_edit_$group->id" , "name"=>"item_type_name" , "placeholder"=>"إسم النوع" , "class"=>"form-control"])}}

				            						{{Form::hidden("id",$group->id,["id"=>"id" , "name"=>"id" , "placeholder"=>"إسم النوع" , "class"=>"form-control"])}}
				            					</td>
				            					<td>
				            						{{Form::button("حفظ",["type"=>"button","id"=>"saveBTN_","class"=>"btn btn-success","onclick"=>"saveFN(".$group->id.")"])}}
				            					</td>
				            				</tr>
				            			@endforeach
				            			</tbody>
				            		</table>
				            	</div>
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
	$(function(){
		$("#addNewItemGroups").on("submit",function(){

			var formElementsData = new FormData(this);

			$.ajax({
				url : "addNewItemGroups",
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
	})

	function saveFN(id){
		$.ajax({
				url : "EditItemGroups",
				dataType : 'json',
				type : 'post',
				data : {
					id : id,
					item_type_name : $("#item_type_name_edit_"+id+"").val()
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
	}
</script>