@extends('layouts.create_edit')

@section('CSS_link')
	<link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
@endsection

@section('style')
  <style type="text/css">
    #datautama, #data_opsional, #moreOption{
      padding: 5px;
    }

    #files{
      margin-top: 10px;
      width: 90%;
    }

    #data_opsional{
      /*background-color: lightgrey;*/
      padding: 0px;
    }
  </style>
@endsection

@section('page_header') Surat {{($tipe == "surat masuk"? "Masuk" : "Keluar")}} @endsection

@section('breadcrumb')
  @if($tipe == 'surat masuk')
  	<li><a href="{{route('operator.surat-masuk.index')}}"><i class="ion ion-android-archive"></i> Surat Masuk</a></li>
  	<li class="active">Tambah Surat Masuk</li>
  @else
    <li><a href="{{route('operator.surat-keluar.index')}}"><i class="ion ion ion-share"></i> Surat Keluar</a></li>
    <li class="active">Tambah Surat Keluar</li>
  @endif
@endsection

@section('create_edit_title') Tambah Data Surat {{($tipe == "surat masuk"? "Masuk" : "Keluar")}}  @endsection

@section('create_edit_route') 
  @if($tipe == "surat masuk")
    {{route('operator.surat-masuk.store')}} 
  @else
    {{route('operator.surat-keluar.store')}} 
  @endif
@endsection

@section('create_edit_form')
  <div class="row" id="data_utama">
    <div class="col-md-6">
      <div class="form-group">
        <label for="nomor_surat">Nomor Surat</label>
        <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" placeholder="Nomor Surat" value="{{ old('nomor_surat') }}">
          @error('nomor_surat')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="perihal">Perihal</label>
        <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Perihal" value="{{ old('perihal') }}">
          @error('perihal')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="kategori_id">Kategori</label>
        <select class="form-control" name="kategori_id" id="kategori_id">
              <option value="">-- Pilih Kategori --</option>
              @foreach($kategori as $val)
              <option {{(old('kategori_id')==$val->id ? 'selected' : '')}} value="{{$val->id}}">{{$val->name}}</option>
              @endforeach
          </select>

        @error('kategori_id')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      @if($tipe == "surat masuk")
        <div class="form-group">
          <label for="pengirim">Pengirim</label>
          <input type="text" name="pengirim" class="form-control" id="pengirim" placeholder="Pengirim" value="{{old('pengirim')}}">
            @error('pengirim')
                <span class="invalid-feedback" role="alert" style="color: red;">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
        </div>
      @endif
    </div>

    <div class="col-md-6">

      <div class="form-group">
        <label for="tujuan">Tujuan {{($tipe == "surat masuk" ? "(Individu)" : "(Instansi)")}}</label>
        <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Tujuan" value="{{ old('tujuan') }}">

        @error('tujuan')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      @if($tipe == "surat masuk")
        <div class="form-group">
          <label for="tanggal_diterima">Tanggal Diterima</label>
          <input type="date" name="tanggal_diterima" class="form-control" id="tanggal_diterima" value="{{ old('tanggal_diterima') }}">

          @error('tanggal_diterima')
                <span class="invalid-feedback" role="alert" style="color: red;">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
        </div>
      @endif

      <div class="form-group">
        <label for="tanggal_surat">Tanggal Surat</label>
        <input type="date" name="tanggal_surat" class="form-control" id="tanggal_surat" value="{{ old('tanggal_surat') }}" >

        @error('tanggal_surat')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="jumlah_lampiran">Jumlah Lampiran</label>
        <input type="number" min="0" name="jumlah_lampiran" class="form-control" id="jumlah_lampiran" value="{{ old('jumlah_lampiran') }}">

        @error('jumlah_lampiran')
              <span class="invalid-feedback" role="alert" style="color: red;">
                  <strong>{{ $message }}</strong>
              </span>
        @enderror
      </div>
    </div>
  </div>

  <hr>
  <div id="data_opsional">
    <h4>Data Opsional</h4>
  </div>
  
  <div class="row" id="moreOption" >

    <div class="col-md-6">
      <h4><strong>File Surat</strong></h4>
      <div id="files">
        <div class="form-group">
          <label for="file_surat">Upload File</label>
          <div class="input-group input-group-sm">
            <input type="file" name="file_surat[]" multiple="" class="form-control" value="{{ old('file_surat') }}">
            <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-flat" id="add_file">Add</button>
            </span>
          </div>

          @error('file_surat')
                <span class="invalid-feedback" role="alert" style="color: red;">
                    <strong>{{ $message }}</strong>
                </span>
          @enderror
        </div>  
      </div>
    </div>

    <div class="col-md-6">
      <h4><strong>Penyimpanan Arsip</strong></h4>
      <div class="form-inline">
        <div class="form-group">
          <label for="lemari_id">Lemari Penyimpanan</label>
          <select class="form-control" name="lemari_id" id="lemari_id">
                <option value="">-- Pilih Lemari --</option>
                @foreach($lemari as $item)
                <option {{(old('lemari_id')==$item->id ? 'selected' : '')}} value="{{$item->id}}">{{$item->nomor}}</option>
                @endforeach
            </select>

          @error('lemari_id')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        &ensp;
        <div class="form-group">
          <label for="baris_lemari">Baris ke</label>
          <select name="baris_lemari" class="form-control" id="baris_lemari">
            
          </select>
          {{-- <input type="number" class="form-control" min="1" name="baris_lemari" id="baris_lemari"> --}}

          @error('baris_lemari')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
    </div>
    

    {{-- <div class="form-group" name="new_file">
      <label for="file_surat">Upload File</label>
      <input type="file" name="file_surat[]" multiple="" class="form-control" id="1" value="{{ old('file_surat') }}">
      <button name="del_file" type="button" class="btn btn-danger">Delete</button>

      @error('file_surat')
            <span class="invalid-feedback" role="alert" style="color: red;">
                <strong>{{ $message }}</strong>
            </span>
      @enderror
    </div> --}}

  </div>
@endsection

@section('script_src')
  <!-- bootstrap datepicker -->
  <script src="{{asset('/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {
      $('#datepicker1').datepicker({
        autoclose: true
      })

      $('#datepicker2').datepicker({
        autoclose: true
      })
    })

    var lemari = @json($lemari);
    var baris = 0;

    $('#lemari_id').change(function(event) {
      var id_lemari = $(this).children("option:selected").val();
      jQuery.each(lemari, function(index, val) {
        //iterate through array or object
        if (val.id == id_lemari) {
          baris = val.jml_baris;
          return false;
        }
      });

      var option = "";
      for (var i = 1; i <= baris; i++) {
        option += "<option value='"+i+"'>"+i+"</option>";
      }
      
      $('#baris_lemari').html(option);
    });

    var id_file = 0;
    $('#add_file').click(function(event) {
      // var more = $('div[name="new_file"]').html();
      var more = '<div class="form-group" name="new_file">'+
                    '<label for="file_surat">Upload File</label>'+
                    '<div class="input-group input-group-sm">'+
                      '<input type="file" name="file_surat[]" multiple="" class="form-control" id="1" value="{{ old('file_surat') }}">'+
                      '<span class="input-group-btn">'+
                        '<button type="button" name="del_file" class="btn btn-danger btn-flat" id="add_file">Delete</button>'+
                      '</span>'+
                    '</div>'+
                    '@error("file_surat")'+
                          '<span class="invalid-feedback" role="alert" style="color: red;">'+
                              '<strong>{{ $message }}</strong>'+
                          '</span>'+
                    '@enderror'+
                  '</div>';
      $('div#files').append(more);
    });

    $('body').on('click', '.btn-danger', function(event) {
      event.preventDefault();
      $(this).parents("div.form-group").remove();
    });
  </script>
@endsection
