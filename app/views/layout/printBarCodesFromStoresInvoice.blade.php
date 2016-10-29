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
				            </div>
				        	{{Form::open(["action" => "printBarCodes","id"=>"printBarCodes" ,"class"=>"form-horizontal" , "target"=>"_blank"])}}
					            <div class="col-xs-12 reportArea"></div>
					            <div class="col-xs-12">
			                    	{{Form::submit('حفظ',["class"=>"btn btn-success btn-block"])}}
					            </div>
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

	$(function(){
		var item_code = '{{Input::get("items_name")}}';
		var items_quantity = '{{Input::get("items_quantity")}}';

		item_code = item_code.split(",");
		items_quantity = items_quantity.split(",");

		for(var index=0 ; index<item_code.length ; index++){
			var table_Drawer = '<table class="table table-bordered">';
			table_Drawer += '<tr>';
			table_Drawer += '<th class="col-xs-6">كود الصنف</th>';
			table_Drawer += '<th class="col-xs-6">عدد</th>';
			table_Drawer += '</tr>';
			table_Drawer += '<tr>';
			table_Drawer += '<td>'+item_code[index]+'</td>';
			table_Drawer += '<td><input type="number" name="count[]" class="form-control count" value="'+items_quantity[index]+'" id="count"></td>';
			table_Drawer += '<td style="display:none;"><input type="hidden" name="item_code[]" class="form-control item_code" id="item_code" value="'+item_code[index]+'"></td>';
			table_Drawer += '</tr>';
			table_Drawer += '</table>';
			$(".reportArea").append(table_Drawer);
		}
	});
		
</script>

