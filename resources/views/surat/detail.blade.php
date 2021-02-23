@extends('layouts.baseView')

@section('csrf-token')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('CSS_link')
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/plugins/iCheck/all.css')}}">
@endsection

@section('style')
  <style type="text/css">
    tr td{
      padding: 10px;
    }
    .col-md-6{
      padding: 13px;
    }
    .box-primary{
      width: 80%;
      margin: auto;
    }
    .box-body{
      padding: 10px;
      font-size: 15px;
    }
    .notFound{
      font-size: 12px;
      color: red;
    }
    .btn-primary{
      float: right;
    }
    .default_file{
      width: 30%;
      height: 30%;
    }

    @media screen and (max-width: 700px){
      .default_file{
        width: 20%;
        height: 20%;
      } 
    }
  </style>
@endsection

@section('page_header')Surat {{($tipe == "surat masuk"? "Masuk" : "Keluar")}} @endsection

@section('breadcrumb')
  @if($tipe == 'surat masuk')
    @if(Auth::user()->role->name == "operator")
    	<li><a href="{{route('operator.surat-masuk.index')}}"><i class="ion ion-android-archive"></i> Surat Masuk</a></li>
    @else
      <li><a href="{{route('manajer.surat-masuk.index')}}"><i class="ion ion-android-archive"></i> Surat Masuk</a></li>
    @endif
  	<li class="active">Detail Surat Masuk</li>
  @else
    @if(Auth::user()->role->name == "operator")
      <li><a href="{{route('operator.surat-keluar.index')}}"><i class="ion ion ion-share"></i> Surat Keluar</a></li>
    @else
      <li><a href="{{route('manajer.surat-keluar.index')}}"><i class="ion ion ion-share"></i> Surat Keluar</a></li>
    @endif
      <li class="active">Detail Surat Keluar</li>
  @endif
@endsection

@section('content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary" style="width: 90%;">
        <div class="box-header with-border">
          <h2 class="box-title">Detail Surat {{($tipe == "surat masuk"? "Masuk" : "Keluar")}}</h2>
          @if(Auth::user()->role->name == "operator")
            @if($tipe == "surat masuk")
              <a href="{{route('operator.surat-masuk.edit', $surat->id)}}" class="btn btn-primary">Ubah  <i class="fa fa-edit"></i></a>
            @else
              <a href="{{route('operator.surat-keluar.edit', $surat->id)}}" class="btn btn-primary">Ubah  <i class="fa fa-edit"></i></a>
            @endif
          @endif
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <h4><strong>Data Surat</strong></h4>
              <table id="tbl_1" class="table table-striped">
                <tr>
                  <td><strong>Nomor Surat</strong></td>
                  <td>: {{$surat->nomor_surat}}</td>
                </tr>

                <tr>
                  <td><strong>Perihal</strong></td>
                  <td>: {{$surat->perihal}}</td>
                </tr>

                <tr>
                  <td><strong>Tanggal Surat</strong></td>
                  <td>: {{Carbon\Carbon::parse($surat->tanggal_surat)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
                </tr>

                @if($tipe == "surat masuk")
                  <tr>
                    <td><strong>Tanggal Diterima</strong></td>
                    <td>: {{Carbon\Carbon::parse($surat->tanggal_diterima)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
                  </tr>
                @endif

                <tr>
                  <td><strong>Kategori</strong></td>
                  <td>: {{$surat->kategori->name}}</td>
                </tr>

                @if($tipe == 'surat masuk')
                  <tr>
                    <td><strong>Pengirim</strong></td>
                    <td>: {{$surat->pengirim}}</td>
                  </tr>
                @endif

                <tr>
                  <td><strong>Tujuan</strong></td>
                  <td>: {{$surat->tujuan}}</td>
                </tr>

                <tr>
                  <td><strong>Jumlah Lampiran</strong></td>
                  <td>: {{$surat->jumlah_lampiran}}</td>
                </tr>

                <tr>
                  <td><strong>Status</strong></td>
                  <td>: {{($surat->status == ""? "-" : $surat->status)}}</td>
                </tr>
              </table>
            </div>

            <div class="col-md-6">
              <div id="lemari_arsip">
                <h4><strong>Penyimpanan Arsip</strong></h4>
                @if(is_null($surat->lemari_id))
                  <i class="notFound">Data lemari belum ditambahkan. 
                    @if(Auth::user()->role->name == "operator")
                      @if($tipe == "surat masuk")
                        <a href="{{route('operator.surat-masuk.edit', $surat->id)}}">Tambahkan</a>
                      @else
                        <a href="{{route('operator.surat-keluar.edit', $surat->id)}}">Tambahkan</a>
                      @endif
                    @endif
                  </i>
                @else
                  <table class="table table-bordered table-hover">
                    <tr>
                      <td><strong>Nomor Lemari</strong></td>
                      <td>{{$surat->lemari->nomor}}</td>
                      <td><strong>Baris</strong></td>
                      <td>{{$surat->baris_lemari}}</td>
                    </tr>

                    <tr>
                      <td><strong>Lokasi</strong></td>
                      <td colspan="3">{{$surat->lemari->lokasi}}</td>
                    </tr>
                  </table>
                @endif
              </div>
              <br>

              <div id="file_surat">
                <h4><strong>File Surat</strong></h4>
                <div id="file">
                  @if(is_null($surat->file_surat))
                    <i class="notFound">File surat belum ditambahkan. 
                      @if(Auth::user()->role->name == "operator")
                        @if($tipe == "surat masuk")
                          <a href="{{route('operator.surat-masuk.edit', $surat->id)}}">Tambahkan</a>
                        @else
                          <a href="{{route('operator.surat-keluar.edit', $surat->id)}}">Tambahkan</a>
                        @endif
                      @endif
                    </i>
                  @else
                    <div class="row">
                      @php $no=0; @endphp
                      @foreach($surat->file_surat as $key => $val)
                        <div class="col-xs-4" style="text-align: center;">
                          @if($tipe == "surat masuk")
                          <a href="{{$val}}" target="_blank" title="{{substr(strstr($val, 'suratMasuk/'), 11)}}">
                          @else
                          <a href="{{$val}}" target="_blank" title="{{substr(strstr($val, 'suratKeluar/'), 12)}}">
                          @endif
                            <img src="{{asset('default_file.jpg')}}" class="default_file"><br>
                            <span>file {{$no+=1}}</span>
                          </a>
                        </div>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
              <br>

              @if(Auth::user()->role->name == "manajer"  && $tipe == "surat keluar")
                <div id="confirm-form">
                  <h4><strong>Persetujuan Surat</strong></h4>
                  @if($surat->status == "Disetujui")
                    <button id="bnt_ubahSetuju" class="btn btn-warning">Ubah Persetujuan</button>
                    <button id="bnt_batalUbah" class="btn btn-default" style="display: none;">Batal</button>
                  @endif
                  <form action="{{route('manajer.surat-keluar.updateStatus', $surat->id)}}" method="POST" id="status_form" style="{{($surat->status == "Disetujui"? "display:none;" : "")}}">
                    @csrf
                    @method('PUT')
                    <div class="from-group">
                      <label for="status">Pilih Persetujuan</label><br>
                      <label style="cursor: pointer;">
                        <input type="radio" name="status" class="square-green" id="status_setujui" value="Disetujui" {{($surat->status=="Disetujui")? "checked" : ""}}> Setujui
                      </label> &ensp;
                      <label style="cursor: pointer;">
                        <input type="radio" name="status" class="square-red" id="status_revisi" value="Revisi" {{($surat->status=="Revisi")? "checked" : ""}}> Revisi
                      </label>

                      @error('status')
                            <span class="invalid-feedback" role="alert" style="color: red;">
                                <strong>{{ $message }}</strong>
                            </span>
                      @enderror
                    </div>

                    <div class="from-group" id="revisi_form" style="display: none;">
                      <label for="catatan_revisi">Catatan revisi</label>
                      <textarea name="catatan_revisi" class="form-control" id="catatan_revisi" placeholder="Catatan untuk revisi (opsional) ">{{$surat->catatan_revisi}}</textarea>
                    </div>

                    <div class="form-group" id="submit_btn" style="display: none;">
                      <button type="submit" class="btn btn-primary" >Simpan</button>
                    </div>
                  </form>
                </div>
              @endif

              @if(Auth::user()->role->name == "operator" && $surat->status=="Revisi")
                <div id="revisi_note">
                  <h4><strong> Catatan Revisi </strong></h4>
                  <p>
                    "{{$surat->catatan_revisi}}"
                  </p>
                </div>
              @endif

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
@endsection

@section('script_src')
    <!-- iCheck 1.0.1 -->
  <script src="{{asset('/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {

      $('input[type="radio"].square-green').iCheck({
        radioClass   : 'iradio_square-green'
      })

      $('input[type="radio"].square-red').iCheck({
        radioClass   : 'iradio_square-red'
      })

      $('input[type="radio"]').on("ifClicked", function(event) {
        $(this).iCheck('toggle');
        $("#submit_btn").show();
        var id = $(this).attr('id');

        if (id == "status_setujui") {
          console.log('stj');
          $("#revisi_form").hide();
          $('#catatan_revisi').text("");
        } else {
          console.log('rvs');
          $("#revisi_form").show();
        }
      });

      @if($surat->status == "Revisi")
        if($('input#status_revisi').attr('checked') != "undefined") {
          $("#revisi_form").show();
          $("#submit_btn").show();
        }
      @endif

      $("#bnt_ubahSetuju").click(function(event) {
        $("#status_form").show();
        $("#bnt_batalUbah").show();        
        $(this).hide();
      });

      $("#bnt_batalUbah").click(function(event) {
        $("#status_form").hide();
        $("#bnt_ubahSetuju").show();        
        $(this).hide();
      });

      //AJAX Update status Surat Masuk (manajer)
      @if($tipe == "surat masuk" && Auth::user()->role->name == "manajer" && $surat->status == "Belum dilihat" )
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          url: "{{route('surat-masuk.updateStatus')}}",
          type: 'POST',
          data: {
                  id: '{{$surat->id}}',
                  _method: 'PUT'
                },
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
      @endif


    })

  </script>
@endsection
