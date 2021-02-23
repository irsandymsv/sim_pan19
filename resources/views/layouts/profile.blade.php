@extends('layouts.baseView')

{{-- @section('page_header')User @endsection

@section('breadcrumb')
	<li><a href="{{route('user.index')}}"><i class="fa fa-user"></i> User</a></li>
	<li class="active">Detail User</li>
@endsection --}}

@section('content')
	<section class="content">
		<div class="row">
			<form method="POST" action="@yield('user_update_route')" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="col-md-3">
					<div class="box box-warning">
						<div class="box-body box-profile">
							@if($user->avatar == null)
								<img class="profile-user-img img-responsive img-circle" id="img_avatar" src="{{ asset('user/default_user.png') }}" alt="User profile picture" style="height: 120px; width: 120px; border-radius: 50%; object-fit: cover;">
							@else
								<img class="profile-user-img img-responsive img-circle" id="img_avatar" src="{{asset('storage/'.$user->avatar)}}" alt="User profile picture">
							@endif

			            	<h3 class="profile-username text-center">{{$user->name}}</h3>

			            	<p class="text-muted text-center">{{$user->role->name}}</p>

			            	<ul class="list-group list-group-unbordered">
				                {{-- <li class="list-group-item">
				                  <b>Followers</b> <a class="pull-right">1,322</a>
				                </li> --}}
			            	</ul>

			            	@yield('profile_buttons')
			            	
			            </div>
					</div>
				</div>

				<div class="col-md-9">
					<div class="box box-warning">
						<div class="box-header with-border">
			             	<h2 class="box-title">@yield('profile_title')</h2>
			            </div>
			            <div class="box-body">
			            	<div class="row" style="padding: 10px;">
			            		@yield('profile_body')
			            	</div>
			            	@if(session("resetPassword"))
		            			<div id="resetPass" class="alert alert-success alert-dismissible">
								    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								    <h4><i class="icon fa fa-check"></i> Success!</h4>
								    {{session("resetPassword")}}
							  	</div>
							  @elseif(session("updateProfile"))
							  	<div id="updateProfile" class="alert alert-success alert-dismissible">
								    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								    <h4><i class="icon fa fa-check"></i> Success!</h4>
								    {{session("updateProfile")}}
							  	</div>
		            		@endif
			            </div>
					</div>
				</div>
			</form>
		</div>
	</section>
@endsection

@section('script_src')
@endsection

@section('script')
	<script type="text/javascript">
		// if ($("#resetPass").length > 0) {
		// }
		

		// $("div[name='editForm']").hide();

		// var src_avatar = "";
		// $("#editBtn").click(function(event) {
		// 	$(".detailUser").hide();
		// 	$("div[name='editForm']").show();
		// 	$("#avatar").show();
		// 	$("#saveBtn").show();
		// 	$("#batalBtn").show();
		// 	$("#hapusBtn").hide();
		// 	src_avatar = $('#img_avatar').attr('src');
		// 	$(this).hide();

		// 	$("#batalBtn").click(function(event) {
		// 		$(".detailUser").show();
		// 		$("div[name='editForm']").hide();
		// 		$("#avatar").hide();
		// 		$("#saveBtn").hide();
		// 		$("#editBtn").show();
		// 		$("#hapusBtn").show();
		// 		$('#img_avatar').attr('src', src_avatar);
		// 		$("#avatar").val('');
		// 		$(this).hide();
		// 	});
		// });

		function readURL(input) {

	      if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function(e) {
	          $('#img_avatar').show();
	          $('#img_avatar').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	      }
	    }

	    $("#avatar").change(function() {
	      readURL(this);
	    });
	</script>
@endsection