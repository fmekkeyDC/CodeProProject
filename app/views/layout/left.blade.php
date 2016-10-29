
<div id="left">

<div class="media user-media bg-dark dker">
<div class="user-media-toggleHover">
	<span class="fa fa-user"></span>
</div>
<div class="user-wrapper bg-dark">
	<a class="user-link" href="">
		<img class="media-object img-thumbnail user-img" alt="User Picture" src="{{$public_path}}img/logo46.jpg">
		<span class="label label-danger user-label"></span>
	</a>

	<div class="media-body">
		<h5 class="media-heading">مرحباً</h5>
		<ul class="list-unstyled user-info">
			<li><a href="">{{Auth::user()->username}}</a></li>
			<li>اخر تسجيل دخول : <br>
				<small><i class="fa fa-calendar"></i>&nbsp; {{date("Y-M-D H:I:S A")}}</small>
			</li>
		</ul>
	</div>
</div>
</div>
<!-- #menu -->
<ul id="menu" class="bg-blue dker">
  {{-- <li class="nav-divider"></li> --}}
  <li class="">
	<a href="{{URL::to('/')}}">
	  <i class="fa fa-dashboard"></i><span class="link-title">&nbsp;الرئيسية</span>
	</a>
  </li>
  @foreach($system_apps["parent"] as $apps)
	  <li class="" onclick="SetSession({{$apps->id}})" id="LIST_{{$apps->id}}">
		<a href="javascript:;">
		  <i class="{{$apps->icon}}"></i>
		  {{$apps->app_name}}
		  <span class="link-title"></span>
		  <span class="fa arrow"></span>
		</a>
		<ul class="collapse">
		@foreach($system_apps["children"] as $childs)
		  	@if($apps->id == $childs->parent)
	  			<li>
					<a href="#" onclick="ajaxBrowsing('{{URL::to($childs->app_route)}}')">
			  		<i class="{{$childs->icon}}"></i>
					   {{$childs->app_name}}
					 </a>
				</li>
		  @endif
	  	@endforeach
		</ul>
	  </li>
  @endforeach
</ul>
<!-- /#menu -->
</div>