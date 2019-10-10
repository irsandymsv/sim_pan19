@extends('layouts.create_edit')

@section('CSS_link')
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
@endsection

@section('page_header')Lemari Arsip @endsection

@section('breadcrumb')
  <li><a href="{{route('admin.lemari.index')}}"><i class="ion ion-ios-albums"></i> Lemari Arsip</a></li>
  <li class="active">Ubah Lemari Arsip</li>
@endsection

@section('create_edit_title') Ubah Data Lemari Arsip @endsection

@section('create_edit_route') {{route('admin.lemari.update', $lemari->id)}} @endsection

@section('put_method') @method('PUT') @endsection

@section('create_edit_form')
  <div class="form-group">
      <label for="nomor">Nomor Lemari</label>
      <input type="text" name="nomor" class="form-control" id="nomor" placeholder="Nomor Lemari" value="{{ $lemari->nomor }}">
        @error('nomor')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
      @enderror
    </div>

    <div class="form-group">
      <label for="lokasi">Lokasi Lemari</label>
      <textarea class="form-control" name="lokasi" placeholder="Lokasi Lemari" id="lokasi">{{ $lemari->lokasi }}</textarea>
        @error('lokasi')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
      @enderror
    </div>

    <div class="form-group">
      <label for="jml_baris">Jumlah Baris Lemari</label>
      <input type="number" name="jml_baris" class="form-control" id="jml_baris" placeholder="Jumlah Baris" value="{{ $lemari->jml_baris }}">
        @error('jml_baris')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
      @enderror
    </div>
@endsection
