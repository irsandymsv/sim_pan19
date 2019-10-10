@extends('layouts.profile')

@section('page_header'){{$link}} @endsection

@section('breadcrumb')
	@if($link == "Profile")
		<li><a href="{{route('profile')}}"><i class="fa fa-user"></i> Profile</a></li>
		<li class="active">Edit Profile</li>
	@else
		<li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> User</a></li>
		<li><a href="{{route('admin.user.show', $user->id)}}"> Detail User</a></li>
		<li class="active">Edit User</li>
	@endif
	
@endsection

@section('profile_buttons')
	<input type="file" name="avatar" id="avatar" accept="image/*">
	<br>
	<button type="submit" id="saveBtn" class="btn btn-success btn-block"><b>Simpan</b></button>
	@if($link == "Profile")
		<a href="{{route('profile')}}" type="button" id="batalBtn" class="btn btn-default btn-block"><b>Batal</b></a>
	@else
		<a href="{{route('admin.user.show', $user->id)}}" type="button" id="batalBtn" class="btn btn-default btn-block"><b>Batal</b></a>
	@endif
@endsection

@section('user_update_route')
	@if($link == "Profile")
		{{route('profile.update', $user->id)}}
	@else
		{{route('admin.user.update', $user->id)}}
	@endif
@endsection

@section('profile_title')
	Edit Profile
@endsection

@section('profile_body')
	<div class="col-md-6">
		<div class="form-group" name="editForm">
        	<label for="name">Nama</label>
        	<input type="text" name="name" class="form-control" id="name" value="{{$user->name}}">
          	@error('name')
	          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
	                <strong>{{ $message }}</strong>
	            </span>
            @enderror
        </div>

		<div class="form-group" name="editForm">
        	<label for="email">Email</label>
        	<input type="email" name="email" class="form-control" id="email" value="{{$user->email}}">
          	
          	@error('email')
	          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
	                <strong>{{ $message }}</strong>
	            </span>
            @enderror
        </div>

		<div class="form-group" name="editForm">
        	<label for="phone_number">Nomor Telepon</label>
        	<input type="text" name="phone_number" class="form-control" id="phone_number" value="{{$user->phone_number}}">

            @error('phone_number')
	          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
	                <strong>{{ $message }}</strong>
	            </span>
        	@enderror
        </div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group" name="editForm">
			<label for="gender">Jenis Kelamin</label>
			<div>
              	<label class="radio-inline">
              		<input type="radio" name="gender" id="gender" value="Laki-laki" {{($user->gender=='Laki-laki'? 'checked' : '')}}> Laki-laki	
              	</label>
            
              	<label class="radio-inline">
              		<input type="radio" name="gender" id="gender2" value="Perempuan" {{($user->gender=='Perempuan'? 'checked' : '')}}> Perempuan	
              	</label>
                
              	@error('gender')
		          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
		                <strong>{{ $message }}</strong>
		            </span>
        		@enderror
            </div>
		</div>

		{{-- <div class="form-group" name="editForm">
        	<label for="divisi_id">Divisi</label>
        	<select name="divisi_id" class="form-control">
    			<option value="">-- Pilih Divisi --</option>
    			@foreach($divisi as $item)
    				<option {{($user->divisi_id==$item->id? 'selected' : '')}} value="{{$item->id}}">{{$item->name}}</option>
    			@endforeach
    		</select>
    		@error('divisi_id')
          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    		@enderror
        </div> --}}

		<div class="form-group" name="editForm">
        	<label for="alamat">Alamat</label>
        	<textarea class="form-control" name="alamat" id="alamat">{{$user->alamat}} </textarea>

            @error('alamat')
	          	<span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
	                <strong>{{ $message }}</strong>
	            </span>
        	@enderror
        </div>

        @if($link != "Profile")
            <div class="form-group" name="editForm">
                <label for="Role">Role</label>
                <select name="role_id" class="form-control">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option {{($user->role_id==$role->id? 'selected' : '')}} value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                @error('role_id')
                <span class="invalid-feedback" id="name_error" role="alert" style="color: red;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        @endif
	</div>
@endsection