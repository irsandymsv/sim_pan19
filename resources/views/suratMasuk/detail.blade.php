@extends('layouts.baseView')

@section('CSS_link')
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
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
  </style>
@endsection

@section('page_header')Surat Masuk @endsection

@section('breadcrumb')
	<li><a href="{{route('operator.surat-masuk.index')}}"><i class="fa fa-users"></i> Surat Masuk</a></li>
	<li class="active">Detail Surat Masuk</li>
@endsection

@section('content')
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h2 class="box-title">Detail Surat Masuk</h2>
          <a href="{{route('operator.surat-masuk.edit', $surat->id)}}" class="btn btn-primary">Ubah  <i class="fa fa-edit"></i></a>
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

                <tr>
                  <td><strong>Tanggal Diterima</strong></td>
                  <td>: {{Carbon\Carbon::parse($surat->tanggal_diterima)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
                </tr>

                <tr>
                  <td><strong>Kategori</strong></td>
                  <td>: {{$surat->kategori->name}}</td>
                </tr>

                <tr>
                  <td><strong>Pengirim</strong></td>
                  <td>: {{$surat->pengirim}}</td>
                </tr>

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
                  <td>: {{$surat->status}}</td>
                </tr>
              </table>
            </div>

            <div class="col-md-6">
              <div id="lemari_arsip">
                <h4><strong>Penyimpanan Arsip</strong></h4>
                @if(is_null($surat->lemari_id))
                  <i class="notFound">Data lemari belum ditambahkan. <a href="{{route('operator.surat-masuk.edit', $surat->id)}}">Tambahkan</a></i>
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

              <div id="file_surat">
                <h4><strong>File Surat</strong></h4>
                <div id="file">
                  @if(empty($surat->file_surat))
                    <i class="notFound">File surat belum ditambahkan. <a href="{{route('operator.surat-masuk.edit', $surat->id)}}">Tambahkan</a></i>
                  @else
                    <div class="row">
                      @php $no=0; @endphp
                      @foreach($surat->file_surat as $key => $val)
                        <div class="col-md-4" style="text-align: center;">
                          <a href="{{$val}}" target="_blank" title="{{strstr($val, '/')}}">
                            <img src="{{asset('storage/default_file.jpg')}}" class="default_file"><br>
                            <span>file {{$no+=1}}</span>
                          </a>
                        </div>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
@endsection

@section('script')
  <script type="text/javascript">
    
  </script>
@endsection
