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
				        	<div class="col-xs-4">
				        		<div class="alert alert-success">تعريف تطبيق جديد</div>
					        	{{Form::open(["action" => "addNewApplication","id"=>"addNewApplication" ,"class"=>"form-horizontal"])}}
					                <div class="form-group">
					                	{{Form::label('app_name', 'إسم التطبيق',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("app_name","",["id"=>"app_name" , "name"=>"app_name" , "placeholder"=>"إسم التطبيق" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('app_route', 'مسار التوجيه',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("app_route","",["id"=>"app_route" , "name"=>"app_route" , "placeholder"=>"مسار التوجيه" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('icon', 'صورة مصغرة',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("icon","",["id"=>"icon" , "name"=>"icon" , "placeholder"=>"صورة مصغرة" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('app_active', 'حالة التطبيق',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select('app_active', $listOfOptions,'', ["id"=>"app_active" , "name"=>"app_active" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('app_active', 'الإرتباط',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10 parents">
					                    	{{Form::select('parent', $appsParents,'', ["id"=>"parent" , "name"=>"parent" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                
					                <div class="form-group">
					                	{{Form::label('sort', 'الترتيب',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("sort",0,["id"=>"sort" , "name"=>"sort" , "placeholder"=>"الترتيب" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}
				            </div>
				            <div class="col-xs-8">
				        		<div class="alert alert-info">التطبيقات الحالية</div>
				            	<div class="table-responsive tableHolder">
				            		<table class="table table-bordered sortableTable responsive-table tablesorter tablesorter-default">
				            			<thead>
				            				<tr>
				            					<th>اسم التطبيق</th>
				            					<th>التوجيه</th>
				            					<th>الإرتباط</th>
				            					<th>الترتيب</th>
				            					<th>تعديل</th>
				            					<th>حذف</th>
				            				</tr>
				            			</thead>
				            			<tbody>
				            				@foreach($getAppsParents as $parents)
					            				<tr id='tr_{{$parents->id}}'>
					            					<td id="td_name_{{$parents->id}}">{{$parents->app_name}}</td>
					            					<td id="td_route_{{$parents->id}}">{{$parents->app_route}}</td>
					            					<td id="td_type_{{$parents->id}}">
					            						@if ($parents->parent == 0)
					            							تطبيق رئيسي
					            						@else
					            							تطبيق فرعي
					            						@endif
					            					</td>
					            					<td id="td_sort_{{$parents->id}}">{{$parents->sort}}</td>
					            					<td id="td_btn_{{$parents->id}}">
					            						{{Form::button("تعديل",["id"=>"Editbtn","class"=>"btn btn-sm btn-warning" , "onclick" => "updateFN('".$parents->id."')"])}}
					            						{{Form::button("حفظ",["id"=>"saveBTN_".$parents->id."","class"=>"btn btn-success hidden","onclick"=>"saveFN('".$parents->id."')"])}}
					            					</td>
					            					<td>
					            						{{Form::button("حذف",["id"=>"Deletebtn","class"=>"btn btn-sm btn-danger","onclick"=>"deleteFN('".$parents->id."')"])}}
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
        $(".tablesorter").dataTable(
        	 {"oLanguage": {
			      "sSearch": "البحث عن تطبيقات : ",
			      "sInfo": "إجمالي التطبيقات _TOTAL_ تطبيق ويعرض الأن (_START_ من _END_)",
			      "sLengthMenu": "عرض _MENU_ تطبيق بالصفحة الواحدة",
			      "sZeroRecords": "لاتوجد تطبيقات حالياً",
			      "oPaginate": {
		        		"sNext": "التالي",
		        		"sPrevious": "السابق"
		      		}
		   		}
			}
        );
		$(".messages").hide();
		$("#addNewApplication").on("submit",function(e){
			var app_name = $("#app_name").val();
			var app_route = $("#app_route").val();
			var icon = $("#icon").val();
			var app_active = $("#app_active").val();
			var parent = $("#parent").val();
			var sort = $("#sort").val();
			$.ajax({
				url : 'addNewApplication',
				dataType : 'json',
				type : 'post',
				cashe : false,
				data : {
					app_name : app_name,
					app_route : app_route,
					icon : icon,
					app_active : app_active,
					parent : parent,
					sort : sort
				},
				beforeSend : function(){
					$(".messages").show();
					$(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str ='';
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messages").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
					}

					reDrawTable();
				},
				complete : function(){

				},
				error : function (error) {
					console.error(error);
				}
			});

			e.preventDefault();
		});
	});

	function reDrawTable () {
		$.ajax({
			url : 'getAppsTable',
			dataType : 'json',
			type : 'get',
			cashe : false,
			success : function(data){
				var tableContent = '<table class="table table-bordered sortableTable responsive-table tablesorter tablesorter-default">';
				tableContent += '<thead>';
				tableContent += '<tr>';
				tableContent += '<th>اسم التطبيق</th>';
				tableContent += '<th>التوجيه</th>';
				tableContent += '<th>الإرتباط</th>';
				tableContent += '<th>الترتيب</th>';
				tableContent += '<th>تعديل</th>';
				tableContent += '<th>حذف</th>';
				tableContent += '</tr>';
				tableContent += '</thead>';
				tableContent += '<tbody>';
				$.each(data,function(key,value){
					tableContent += "<tr>";
					tableContent += "<td>"+value.app_name+"</td>";
					tableContent += "<td>"+value.app_route+"</td>";
					tableContent += "<td>";
					if (value.parent == 0) {
						tableContent += "تطبيق رئيسي";
					}else{
						tableContent += 'تطبيق فرعي';
					}
					tableContent += "</td>";
					tableContent += "<td>"+value.sort+"</td>";
					tableContent += "<td><button id='Editbtn' class='btn btn-warning'>تعديل</button></td>";
					tableContent += "<td><button id='Deletebtn' class ='btn btn-danger'>حذف</button></td>";
					tableContent += "</tr>";
				});
				tableContent += '</tbody>';
				tableContent += '</table>';
				$(".tableHolder").html(tableContent);
			},
			complete : function(){

			},
			error : function (error) {
				console.error(error);
			}
		});
	}

	function deleteFN(id){
		$(".messages").hide();
		if (confirm("هل انت متأكد من حذف بيانات التطبيق ؟ ")){
			$.ajax({
				url : 'deleteApp',
				dataType : 'json',
				type : 'delete',
				cashe : false,
				data : {
					id : id
				},
				beforeSend : function(){
					$(".messages").show();
					$(".messages").html("<div class='alert alert-info'>جاري معالجة الطلب <img src='public/layout/img/gears.gif' style='width: 53px;'></div>")
				},
				success : function(data){
					if (data.errorsFounder == 1){
						var str = "";
						$.each(data.messages,function(key,value){
							str += "<p> <i class='fa fa-times'></i> "+value+"</p>";
						});

						$(".messages").html("<div class='alert alert-danger'>"+str+"</div>");

					}else{
						$(".messages").html("<div class='alert alert-success'> <i class='fa fa-check'></i> "+data.messages+"</div>")
						window.location.reload();
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
	var app_name = "",app_route="",app_type="",sort="";
	function updateFN(id){
		$(".messages").hide();

		app_name = $.trim($("#td_name_"+id+"").text());
		app_route = $.trim($("#td_route_"+id+"").text());
		app_type = $.trim($("#td_type_"+id+"").text());
		sort = $.trim($("#td_sort_"+id+"").text());

		$("#td_name_"+id+"").html("<input type='text' name='app_name' id='app_name_"+id+"' class='form-control' value='"+app_name+"'>");
		$("#td_route_"+id+"").html("<input type='text' name='app_route' id='app_route_"+id+"' class='form-control' value='"+app_route+"'>");
		$("#td_type_"+id+"").html($(".parents").html());
		$("#td_sort_"+id+"").html("<input type='text' name='sort' id='sort_"+id+"' class='form-control' value='"+sort+"'>");
		$("#td_btn_"+id+"").html(
			"<button type='button' name='Editbtn' id='Editbtn' class='btn btn-sm btn-warning' onclick='returnBTN("+id+")'>عودة</button>" + 
			'<button id="saveBTN_'+id+'" class="btn btn-sm btn-success" onclick="saveFN('+id+')" type="button">حفظ</button>'
		);
	}

	function returnBTN (id) {
		$("#td_name_"+id+"").html(app_name);
		$("#td_route_"+id+"").html(app_route);
		$("#td_type_"+id+"").html(app_type);
		$("#td_sort_"+id+"").html(sort);
		$("#td_btn_"+id+"").html("<button type='button' name='Editbtn' id='Editbtn' class='btn btn-sm btn-warning' onclick='updateFN("+id+")'>تعديل</button>");
		$("#saveBTN_"+id+"").hide();
	}

	function saveFN(id){
		var app_name = $.trim($("#app_name_"+id+"").val());
		var app_route = $.trim($("#app_route_"+id+"").val());
		var app_type = $.trim($("#td_type_"+id+" select").val());
		var sort = $.trim($("#sort_"+id+"").val());
		$.ajax({
			url : 'updateApp',
			dataType : 'json',
			type : 'post',
			cashe : false,
			data : {
				id : id,
				app_name : app_name,
				app_route : app_route,
				app_type : app_type,
				sort : sort
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
					window.location.reload();
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
