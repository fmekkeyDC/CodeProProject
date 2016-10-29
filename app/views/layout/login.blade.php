<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{{$system_name}}</title>
    
    <meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
    <meta name="author" content="">
    
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="{{$public_path}}img/metis-tile.png" />
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{$public_path}}lib/bootstrap/css/bootstrap.rtl.css">
    
    <!-- Font Awesome -->
    {{HTML::Style($public_path."css/font-awesome.min.css")}}
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="{{$public_path}}css/main.rtl.css">
    
    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="{{$public_path}}lib/metismenu/metisMenu.css">
    
    <!-- animate.css stylesheet -->
    <link rel="stylesheet" href="{{$public_path}}lib/animate.css/animate.css">

    <style media="screen">
        body {
            direction: rtl;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login">
      <div class="form-signin">
    <div class="text-center">
{{-- {{Hash::make('123456789')}} --}}
        <img src="{{$public_path}}img/codepro.jpg" width="148" alt="CodePro systems">
    </div>
    <hr>
    <div class="tab-content">
        <div class="messages"></div>
        <div id="login" class="tab-pane active">
            <form action="{{URL::to('loginToSystem')}}" id="loginToSystem" url="{{URL::to('loginToSystem')}}">
                <p class="text-muted text-center">
                    أدخل اسم المستخدم وكلمة المرور
                </p>
                <input type="text" id="username" placeholder="اسم المستخدم" class="form-control top">
                <input type="password" id="password" placeholder="كلمة المرور" class="form-control bottom">
                <div class="checkbox">
		  {{-- <label>
		    <input type="checkbox"> Remember Me
		  </label> --}}
		</div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">تسجيل الدخول</button>
            </form>
        </div>
        <div id="forgot" class="tab-pane">
            <form action="index.html">
                <p class="text-muted text-center">Enter your valid e-mail</p>
                <input type="email" placeholder="mail@domain.com" class="form-control">
                <br>
                <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
            </form>
        </div>
        <div id="signup" class="tab-pane">
            <form>
                <input type="text" placeholder="username" class="form-control top">
                <input type="email" placeholder="mail@domain.com" class="form-control middle">
                <input type="password" placeholder="password" class="form-control middle">
                <input type="password" placeholder="re-password" class="form-control bottom">
                <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
            </form>
        </div>
    </div>
    <hr>
    {{-- <div class="text-center">
        <ul class="list-inline">
            <li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
            <li><a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a></li>
            <li><a class="text-muted" href="#signup" data-toggle="tab">Signup</a></li>
        </ul>
    </div> --}}

    <div class="text-center">جميع الحقوق محفوظة CodePro Systems {{date("Y")}}</div>
  </div>


    <!--jQuery -->
    <script src="{{$public_path}}lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="{{$public_path}}lib/bootstrap/js/bootstrap.js"></script>


    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });

                $("#loginToSystem").on("submit",function(){
                    $.ajax({
                        url : 'loginToSystem',
                        dataType : 'json',
                        type : 'post',
                        cashe : false,
                        data : {
                            username : $("#username").val(),
                            userpassword : $("#password").val(),
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
                                window.location.href = '{{URL::to('/')}}'
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
        })(jQuery);
    </script>
</body>

</html>
