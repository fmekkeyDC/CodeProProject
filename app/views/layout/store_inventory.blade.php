<style type="text/css">


	@media print {
		
		table , table th , table td , label , table tr td{
			font-size: 10px !important;
			font-weight: lighter !important;
		}

		button,input[type=submit]{
			display: none !important;
		}

		body{
			direction: rtl;
			padding: 2%;
			font-size: 11px;
			font-weight: lighter;
		}

		input,select,textarea , .select2-container{
			border: 0px !important;
			font-size: 10px !important;
		}

		.invoiceheader{
			display: block !important;
			color: black !important;
			border: 0px !important;
			font-size: 22px !important;
		}

		.noPrint{
			display: none !important;
		}

		.page-break{
			page-break-before: always; 
		}

		.pagination{
			display: none !important;
		}

	   thead {display: table-header-group;}
		@page {size: a4;}
		@page {size: portrait;}
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
				            <h5> التقارير</h5>
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
				            <div class="reportHolder col-xs-12">
				            	<h5 class="alert alert-info">عدد الأصناف {{$getReportQueryLength}} <button type="button" class="btn btn-default pull-right" onclick="printDiv('.reportHolder');">طباعة</button> <div style="clear: both;"></div></h5>

				            	{{--*/ $per_page = 15 /*--}}
				            	{{--*/ $pages = ceil($getReportQueryLength / $per_page)  /*--}}
				            	
				            	<table class="table table-bordered datatable">
				            		<thead>
					            		<tr>
					            			<th>كود الصنف</th>
					            			<th>إسم الصنف</th>
					            			<th>الكمية الحالية</th>
					            			<th>الرصيد الحرج للصنف</th>
					            			<th>تجاوز حد الطلب</th>
					            		</tr>
				            		</thead>
				            		<tbody>
					            		@foreach($getReportQuery as $reportData)
					            			<tr>
					            				<td>{{$reportData->item_code}}</td>
					            				<td>{{$reportData->item_name}}</td>
					            				<td>{{$reportData->net_quantity}}</td>
					            				<td>{{$reportData->re_request_point}}</td>
					            				<td>
					            					@if ($reportData->re_request_point > $reportData->net_quantity)
					            						<i class="text-danger fa fa-exclamation"></i> <span class="text-danger">هذا الصنف تجاوز حد الطلب</span>
					            					@else
					            						<i class="text-success fa fa-check"></i> <span class="text-success"> رصيد كافي </span>
					            					@endif
					            				</td>
					            			</tr>
					            		@endforeach
				            		</tbody>
				            	</table>
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
		$(".datatable").dataTable({
			"language": {
                "url": "public/layout/js/Arabic.json"
            }
		});
	})
	function printDiv(container) {
		$(container).print({    
	        globalStyles: true,
            mediaPrint: true,
            stylesheet: null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: null,
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 750,
            title: 'CodePro Systems , Mahalla Elkoupra 7 abdelhamed salem st',
            doctype: '<!doctype html>'
	  });
	}
</script>
