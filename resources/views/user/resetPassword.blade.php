@extends('layouts.profile')

@section('page_header'){{$link}} @endsection

@section('breadcrumb')
	@if($link == "Profile")
		<li><a href="{{route('profile')}}"><i class="fa fa-user"></i> Profile</a></li>
		<li class="active">Ubah Password</li>
	@else
		<li><a href="{{route('admin.user.index')}}"><i class="fa fa-user"></i> User</a></li>
		<li><a href="{{route('admin.user.show', $user->id)}}"> Detail User</a></li>
		<li class="active">Ubah Password</li>
	@endif
	
@endsection

@section('profile_buttons')
	<button type="submit" id="saveBtn" class="btn btn-success btn-block"><b>Simpan</b></button>
	@if($link == "Profile")
		<a href="{{route('profile')}}" type="button" id="batalBtn" class="btn btn-default btn-block"><b>Batal</b></a>
	@else
		<a href="{{route('admin.user.show', $user->id)}}" type="button" id="batalBtn" class="btn btn-default btn-block"><b>Batal</b></a>
	@endif
@endsection


@section('user_update_route')
	@if($link == "Profile")
		{{route('profile.updatePassword', $user->id)}}
	@else
		{{route('admin.user.updatePassword', $user->id)}}
	@endif
@endsection

@section('profile_title')
	Ubah Password
@endsection

@section('profile_body')
	<div class="col-sm-12">
		<div class="form-group" name="editForm">
        	<label for="password">Password Baru</label>
        	<input type="password" name="password" class="form-control" id="password" >

            @error('password')
	          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
	                <strong>{{ $message }}</strong>
	            </span>
        	@enderror
        </div>

        <div class="form-group" name="editForm">
        	<label for="password_confirmation">Konfirmasi Password Baru</label>
        	<input type="password" name="password_confirmation" class="form-control" id="password_confirmation" >
        </div>
	</div>
	
@endsection