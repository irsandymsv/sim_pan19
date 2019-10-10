@extends('layouts.baseView')

@section('csrf-token')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('CSS_link')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/AdminLTE/bower_components/datatables.net/button-1.5.6/css/buttons.dataTables.min.css')}}">

  {{-- pdfmake --}}
  <script src='{{asset("/pdfmake/pdfmake.min.js")}}'></script>
  <script src='{{asset("/pdfmake/vfs_fonts.js")}}'></script>
@endsection

@section('page_header')Laporan @endsection

@section('breadcrumb')
    @if(Auth::user()->role->name == "manajer")
     <li class="active"><a href="{{route('manajer.laporan.index')}}"><i class="fa fa-bar-chart"></i> Laporan</a></li>
    @else
      {{-- <li class="active"><a href="{{route('operator.laporan.index')}}"><i class="fa bar-chart"></i> Laporan</a></li> --}}
    @endif
@endsection

@section('content')
  <section class="content">
      <div class="row">
          <div class="col-xs-12">

            <div class="box box-info">
              <div class="box-header">
                  <h3 class="box-title">Laporan Surat Masuk dan Keluar</h3>
                </div>
                <div class="box-body">
                  <div id="top-form" style="width: 50%;">
                    <div class="row" id="select_date">

                      <div class="col-md-4">
                        <label for="month">Pilih Bulan</label>
                        <select class="form-control" name="month" id="bulan">
                          <option value="">-- Pilih Bulan --</option>
                          <option value="1">Januari</option>
                          <option value="2">Februari</option>
                          <option value="3">Maret</option>
                          <option value="4">April</option>
                          <option value="5">Mei</option>
                          <option value="6">Juni</option>
                          <option value="7">Juli</option>
                          <option value="8">Agustus</option>
                          <option value="9">September</option>
                          <option value="10">Oktober</option>
                          <option value="11">November</option>
                          <option value="12">Desember</option>
                        </select>
                      </div>
                      
                      <div class="col-md-4">
                        <label for="tahun">Pilih Tahun</label>
                        <select class="form-control" name="year" id="tahun">
                          <option value="">-- Pilih Tahun --</option>
                          @foreach($tahun as $thn)
                            <option value="{{$thn}}">{{$thn}}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="col-md-4" id="btn_download" style="margin-top: 25px;">
                        {{-- <br> --}}
                      </div>
                    </div>
                  </div>
                  <br>

                  <div class="table-responsive">
                    <h4>Tabel Surat Masuk-Keluar</h4>
                    <table id="table_sm" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tipe Surat</th>
                          <th>Nomor Surat</th>
                          <th>Perihal</th>
                          <th>Kategori</th>
                          <th>Pengirim</th>
                          <th>Tujuan</th>
                          <th>Tanggal Diterima</th>
                          <th>Tanggal Surat</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_sm">
                        
                      </tbody>
                    </table>
                  </div>

                  <br>
                  {{-- <div class="table-responsive">
                    <h4>Tabel Surat Keluar</h4>
                    <table id="table_sk" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Nomor</th>
                          <th>Perihal</th>
                          <th>Kategori</th>
                          <th>Tujuan</th>
                          <th>Tanggal Surat</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div> --}}
                </div>
            </div>
          </div>
      </div>
  </section>
@endsection

@section('script_src')
  <!-- DataTables -->
  <script src="{{asset('/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('AdminLTE/bower_components/datatables.net/button-1.5.6/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('AdminLTE/bower_components/datatables.net/button-1.5.6/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('AdminLTE/bower_components/datatables.net/button-1.5.6/js/buttons.flash.min.js')}}"></script>
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {
      var table = $('#table_sm').DataTable({
        order: [],
        // dom: 'Bfrtip',
        // buttons: [
        //   {
        //     extend: 'pdf',
        //     text: "Download Laporan",
        //     filename: "laporan surat masuk keluar",
        //     title: "Rekap surat masuk dan keluar",
        //     messageTop: "ini adalah hasil rekap surat masuk dan keluar pada peruashaan anda"
        //   }
        // ]
      })

      // $('#table_sk').DataTable({
      //   order: []
      // })
      
      $("div.table-responsive").find('div.dt-buttons').hide();

      $("select[name='month'], select[name='year']").change(function(event) {
        // console.log('hai');
        var bulan = $("select[name='month']").children('option:selected').val();
        var tahun = $("select[name='year']").children('option:selected').val();
        var namaBulan = $("select[name='month']").children('option:selected').text();
        console.log('bulan = '+bulan);
        

        if (bulan != "" && tahun != "") {
          // console.log("coba lah");
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
            url: '{{route('laporan.getData')}}',
            type: 'POST',
            dataType: 'json',
            data: {
              'bulan': bulan,
              'tahun': tahun
            },
          })
          .done(function(hasil) {
            console.log("success");
            console.log(hasil);
            var rows = "";
            $.each(hasil["suratMasuk"], function(index, val) {
               rows +=  "<tr>"+
                          "<td>"+(index+1)+"</td>"+
                          "<td>Surat Masuk</td>"+
                          "<td>"+val.nomor_surat+"</td>"+
                          "<td>"+val.perihal+"</td>"+
                          "<td>"+val.kategori['name']+"</td>"+
                          "<td>"+val.pengirim+"</td>"+
                          "<td>"+val.tujuan+"</td>"+
                          "<td>"+val.tanggal_diterima+"</td>"+
                          "<td>"+val.tanggal_surat+"</td>"+
                          "<td>"+val.status+"</td>"+
                        "</tr>";
            });
            var number = hasil["suratMasuk"].length;

            $.each(hasil["suratKeluar"], function(index, val) {
             rows +=  "<tr>"+
                        "<td>"+(number+=1)+"</td>"+
                        "<td>Surat Keluar</td>"+
                        "<td>"+val.nomor_surat+"</td>"+
                        "<td>"+val.perihal+"</td>"+
                        "<td>"+val.kategori['name']+"</td>"+
                        "<td> - </td>"+
                        "<td>"+val.tujuan+"</td>"+
                        "<td> - </td>"+
                        "<td>"+val.tanggal_surat+"</td>"+
                        "<td>"+val.status+"</td>"+
                      "</tr>";
          });
            table.destroy();
            $("#tbody_sm").html(rows);
            table = $('#table_sm').DataTable({
              order: [],
              // dom: 'Bfrtip',
              buttons: [
                {
                  extend: 'pdf',
                  text: "Download Laporan",
                  filename: "Laporan surat masuk keluar "+namaBulan+" "+tahun,
                  title: "Rekap Surat Masuk dan Keluar "+namaBulan+" "+tahun,
                  messageTop: "Berikut adalah hasil rekap surat masuk dan keluar pada perusahaan anda selama bulan "+namaBulan+" "+tahun,
                  customize: function (doc) {
                    doc.content.splice(2,0,
                      {text:"Jumlah surat masuk = "+hasil["suratMasuk"].length, bold:true},
                      {text: "Jumlah surat keluar = "+hasil["suratKeluar"].length, bold:true, margin: [0,0,0,10]}
                    );
                  }
                }
              ]
            });

            $('#table_sm').DataTable().buttons().container().appendTo('div#btn_download');

          })
          .fail(function() {
            console.log("error");
          })

        } //endif
        
      });

    })
  </script>
@endsection
