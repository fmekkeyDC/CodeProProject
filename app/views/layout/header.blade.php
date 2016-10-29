<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<!--IE Compatibility modes-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--Mobile first-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>{{$system_name}}</title>
	
	<meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
	<meta name="author" content="CodePro Systems">
	
	<meta name="msapplication-TileColor" content="#5bc0de" />
	<meta name="msapplication-TileImage" content="{{$public_path}}img/metis-tile.png" />
	
	{{HTML::Style($public_path."lib/bootstrap/css/bootstrap.rtl.css")}}
	{{HTML::Style($public_path."css/font-awesome.min.css")}}
	{{HTML::Style($public_path."css/main.rtl.css")}}
	{{HTML::Style($public_path."lib/metismenu/metisMenu.css")}}
	{{HTML::Style($public_path."lib/animate.css/animate.css")}}
	{{HTML::Style($public_path."lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css")}}
	{{HTML::Style($public_path."lib/jquery.gritter/css/jquery.gritter.css")}}
	{{HTML::Style($public_path."css/uniform.default.min.css")}}
	{{HTML::Style($public_path."css/jasny-bootstrap.min.css")}}
    {{HTML::Style($public_path."lib/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css")}}
    {{HTML::Style($public_path."lib/jquery.gritter/css/jquery.gritter.css")}}
   	{{HTML::Style($public_path."css/datepicker3.min.css")}}
    {{HTML::Style($public_path."css/bootstrap-colorpicker.min.css")}}
    {{HTML::Style($public_path."css/bootstrap-datetimepicker.min.css")}}
    {{HTML::Style($public_path."css/select2.css")}}
    {{HTML::Style($public_path."css/jquery.dataTables.min.css")}}
    

	<style media="screen">
		body {
			direction: rtl;
		}

		select , input {
			font-size: 12px !important;
		}

		.datepicker{
		    right: auto
		}

		textarea{
			height: 50px !important;
			max-height: 50px !important;
		}

	</style>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
	<script>
		less = {
			env: "development",
			relativeUrls: false,
			rootpath: "{{$public_path}}"
		};
	</script>
	{{HTML::Style($public_path."css/style-switcher.css")}}
	<link rel="stylesheet/less" type="text/css" href="{{$public_path}}less/theme.less">
	{{HTML::Script($public_path."js/less.js")}}
  </head>
  <body class="">
  <div class="bg-dark dk" id="wrap">