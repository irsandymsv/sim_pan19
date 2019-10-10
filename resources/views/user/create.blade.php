@extends('layouts.create_edit')

@section('CSS_link')
	<link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
@endsection

@section('page_header')User @endsection

@section('breadcrumb')
	<li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> User</a></li>
	<li class="active">Tambah User</li>
@endsection

@section('create_edit_title') Tambah Data User @endsection

@section('create_edit_route') {{route('admin.user.store')}} @endsection

@section('create_edit_form')
	<div class="form-group">
    	<label for="name">Nama</label>
    	<input type="text" name="name" class="form-control" id="name" placeholder="nama" value="{{ old('name') }}">
      	@error('name')
          	<span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	@enderror
    </div>

    <div class="form-group">
    	<label for="email">Email</label>
    	<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
      	@error('email')
          	<span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	  @enderror
    </div>

    <div class="form-group">
    	<label for="password">Password</label>
    	<input type="password" name="password" class="form-control" id="password" placeholder="Password">
      	@error('password')
          	<span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	@enderror
    </div>

    <div class="form-group">
    	<label for="password_confirmation">Konfirmasi Password</label>
    	<input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password">
    </div>

    <div class="form-group">
    	<label for="gender">Jenis Kelamin</label>
      	<div class="radio">
          	<label>
          		<input type="radio" name="gender" id="gender" value="Laki-laki" {{(old('gender')=="Laki-laki" ? 'checked' : '')}}> Laki-laki	
          	</label>
        </div>

        <div class="radio">
          	<label>
          		<input type="radio" name="gender" id="gender2" value="perempuan" {{(old('gender')=="Perempuan" ? 'checked' : '')}}> Perempuan	
          	</label>
        </div>
      
      	@error('gender')
          	<span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	@enderror
    </div>

    <div class="form-group">
    	<label for="role_id">Role</label>
    	<select class="form-control" name="role_id" id="role_id">
          	<option value="">-- Pilih Role --</option>
          	@foreach($roles as $role)
          	<option {{(old('role_id')==$role->id ? 'selected' : '')}} value="{{$role->id}}">{{$role->name}}</option>
          	@endforeach
      	</select>

    	@error('role_id')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	@enderror
    </div>

    {{-- <div class="form-group">
      <label for="divisi_id">Divisi</label>
      <select class="form-control" name="divisi_id" id="divisi_id">
            <option value="">-- Pilih Divisi --</option>
            @foreach($divisi as $item)
            <option {{(old('divisi_id')==$item->id ? 'selected' : '')}} value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>

      @error('divisi_id')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
      @enderror
    </div> --}}

    <div class="form-group">
    	<label for="phone_number">Nomor Telepon</label>
    	<input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Nomor Telepon" value="{{ old('phone_number') }}">

    	@error('phone_number')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
    	@enderror
    </div>
@endsection
