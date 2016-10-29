<div id="content">
	<div class="outer">
		<div class="inner bg-light lter" style="min-height: 1000px">
			<div class="row">
				<div class="col-xs-12">
				    <div class="box dark">
				        <header>
				            <div class="users_appss"><i class="fa fa-edit"></i></div>
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
				        		<div class="alert alert-success">تعريف مستخدم جديد</div>
					        	{{Form::open(["action" => "addNewUser","id"=>"addNewUser" ,"class"=>"form-horizontal"])}}
					                <div class="form-group">
					                	{{Form::label('username', 'إسم المستخدم',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::text("username","",["id"=>"username" , "name"=>"username" , "placeholder"=>"إسم المستخدم" , "class"=>"form-control"])}}
					                    </div>
					                </div>
					                <div class="form-group">
					                	{{Form::label('userpassword', 'كلمة المرور',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::password("userpassword",["id"=>"userpassword" , "name"=>"userpassword" , "placeholder"=>"كلمة المرور" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('userpassword', 'تأكيد كلمة المرور',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::password("confuserpassword",["id"=>"confuserpassword" , "name"=>"confuserpassword" , "placeholder"=>"تأكيد كلمة المرور" , "class"=>"form-control validate[required,equals[confuserpassword]]"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('users_apps', 'صلاحيات المستخدم',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select("users_apps",$usersAppsRight,'',["id"=>"users_apps" , "name"=>"users_apps" , "placeholder"=>"صلاحيات المستخدم" , "multiple" => "multiple" , "style"=>"width:100%;", "autocomplete" => "off"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                	{{Form::label('users_rights', 'يسمح له بــ',["class"=>"control-label col-xs-2"])}}
					                    <div class="col-xs-10">
					                    	{{Form::select('users_rights', $listOfOptions,'', ["id"=>"users_rights" , "name"=>"users_rights" , "class"=>"form-control"])}}
					                    </div>
					                </div>

					                <div class="form-group">
					                    <div class="col-xs-12">
					                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					                    </div>
					                </div>
					            {{Form::close()}}
				            </div>
				            <div class="col-xs-12">
				        		<div class="alert alert-info">التطبيقات الحالية</div>
				            	<div class="tableHolder table-responsive col-xs-12">
				            		<table class="table table-bordered responsive-table">
				            			<thead>
				            				<tr>
				            					<th class="col-xs-2">إسم المستخدم</th>
				            					<th class="col-xs-2">التطبيقات</th>
				            					<th class="col-xs-2">يسمح له بـ</th>
				            					<th class="col-xs-2">تعديل</th>
				            					<th class="col-xs-2">حذف</th>
				            				</tr>
				            			</thead>
				            			<tbody>
				            				
				            			</tbody>
				            		</table>
				            	</div>
				            </div>
				            <div style="clear: both;">
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
		reDrawTable();
        $("#users_apps").select2();
		$(".messages").hide();
		$("#addNewUser").on("submit",function(e){
			var username = $("#username").val();
			var userpassword = $("#userpassword").val();
			var users_apps = $("#users_apps").val();
			var users_rights = $("#users_rights").val();
			var confuserpassword = $("#confuserpassword").val();
			$.ajax({
				url : 'addNewUser',
				dataType : 'json',
				type : 'post',
				cashe : false,
				data : {
					username : username,
					userpassword : userpassword,
					users_apps : users_apps,
					users_rights : users_rights,
					confuserpassword : confuserpassword
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
			url : 'getUsersTable',
			dataType : 'json',
			type : 'get',
			cashe : false,
			success : function(data){
				var userRightStatus = "";
				var tableContent = '<table class="table table-bordered">';
				tableContent += '<thead>';
				tableContent += '<tr>';
				tableContent += '<th class="col-xs-2">إسم المستخدم</th>';
				tableContent += '<th class="col-xs-2">التطبيقات</th>';
				tableContent += '<th class="col-xs-2">يسمح له بـ</th>';
	            tableContent += '<th class="col-xs-2">كلمة المرور الجديدة</th>';
				tableContent += '<th class="col-xs-2">تعديل</th>';
				tableContent += '<th class="col-xs-2">حذف</th>';
				tableContent += '</tr>';
				tableContent += '</thead>';
				tableContent += '<tbody>';
				$.each(data,function(key,value){
					switch (value.users_rights) {
						case 1:
							userRightStatus = "الإطلاع"
							break;
						case 2 :
							userRightStatus = "الإضافة"
							break;
						case 3:
							userRightStatus = "التعديل"
							break;
						case 4:
							userRightStatus = "الحذف"
							break;
						default:
							userRightStatus = "لم يتم تحديد صلاحيات إستخدام لهذا المستخدم"
							break;
					}
					tableContent += "<tr>";
					tableContent += "<td id='td_name_"+value.id+"'>"+value.username+"</td>";
					tableContent += "<td id='td_apps_"+value.id+"'>"+value.users_apps+"</td>";
					tableContent += "<td id='td_rights_"+value.id+"'>"+userRightStatus+"</td>";
					tableContent += "<td id='td_password_"+value.id+"'></td>";
					tableContent += "<td id='EditBtnData_"+value.id+"'><button id='Editbtn' class='btn btn-warning' onclick='updateFN("+value.id+")'>تعديل</button></td>";
					tableContent += "<td id='DeleteBtn_"+value.id+"'><button id='Deletebtn' class ='btn btn-danger' onclick='deleteFN("+value.id+")'>حذف</button></td>";
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
				url : 'deleteUsers',
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
					reDrawTable();
				},
				error : function (error) {
					console.error(error);
				}
			});
		}
	}
	var username = "",userpassword="",app_type="",sort="";

	function updateFN(id){
		$(".messages").hide();

		username = $.trim($("#td_name_"+id+"").text());
		userpassword = $.trim($("#td_apps_"+id+"").text());
		app_type = $.trim($("#td_rights_"+id+"").text());
		sort = $.trim($("#td_sort_"+id+"").text());

		$("#td_name_"+id+"").html("<input type='text' name='username' id='username_"+id+"' class='form-control' value='"+username+"'>");
		$("#td_apps_"+id+"").html('<select id="users_apps'+id+'" name="users_apps'+id+'" placeholder="صلاحيات المستخدم" multiple="multiple" autocomplete="off" style="width:100%;">'+$("#users_apps").html() + "</select>");
		$("#td_rights_"+id+"").html('<select id="users_rights" name="users_rights" class="form-control">'+$("#users_rights").html()+'</select>');

		$("#td_password_"+id+"").html('<input id="newPassword'+id+'" name="newPassword" placeholder="إتركها فارغة في حالة عدم التغيير" class="form-control" type="password" value="" >');

		$("#EditBtnData_"+id+"").html(
			"<button type='button' name='Editbtn' id='Editbtn' class='btn btn-warning' onclick='returnBTN("+id+")'>عودة</button>"
		);
		$("#DeleteBtn_"+id+"").html(
			'<button id="saveBTN_'+id+'" class="btn btn-success" onclick="saveFN('+id+')" type="button">حفظ</button>'
		);

		$("#users_apps"+id+"").select2();
	}

	function returnBTN (id) {
		reDrawTable();
	}

	function saveFN(id){
		var username = $.trim($("#username_"+id+"").val());
		var newPassword = $.trim($("#newPassword"+id+"").val());
		var userpassword = [] ;

		$("#users_apps"+id+" :selected").map(function(i, el) {
		    userpassword.push($(el).val());
		});
		var app_type = $.trim($("#td_rights_"+id+" select").val());

		$.ajax({
			url : 'updateUsers',
			dataType : 'json',
			type : 'post',
			cashe : false,
			data : {
				id : id,
				username : username,
				userpassword : userpassword,
				newPassword : newPassword,
				app_type : app_type,
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
						reDrawTable();
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
