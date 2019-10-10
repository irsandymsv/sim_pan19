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

                      <div class="col-md-4" id="btn_download">
                        <br>
                        <button class="btn btn-primary" id="btn_cetak" style="display: none; margin-top: 5px;">cetak <i class="fa fa-print"></i></button>
                      </div>

                    </div>
                  </div>
                  <br>

                  <div class="table-responsive">
                    <h4>Tabel Surat Masuk</h4>
                    <table id="table_sm" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nomor Surat</th>
                          <th>Perihal</th>
                          <th>Kategori</th>
                          <th>Pengirim</th>
                          <th>Tujuan</th>
                          <th>Tanggal Diterima</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_sm">
                        
                      </tbody>
                    </table>
                  </div>

                  <br>
                  <div class="table-responsive">
                    <h4>Tabel Surat Keluar</h4>
                    <table id="table_sk" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nomor Surat</th>
                          <th>Perihal</th>
                          <th>Kategori</th>
                          <th>Tujuan</th>
                          <th>Tanggal Surat</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_sk">
                        
                      </tbody>
                    </table>
                  </div>
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
    var table_sm = $('#table_sm').DataTable({
      order: [],
    })

    var table_sk = $('#table_sk').DataTable({
      order: [],
    })


    $("div.table-responsive").find('div.dt-buttons').hide();

    $("select[name='month'], select[name='year']").change(function(event) {
      // console.log('hai');
      var bulan = $("select[name='month']").children('option:selected').val();
      var tahun = $("select[name='year']").children('option:selected').val();
      var namaBulan = $("select[name='month']").children('option:selected').text();
      console.log('bulan = '+bulan);
      

      if (bulan != "" && tahun != "") {
        $("#btn_cetak").show();
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
          var rows2 = "";
          $.each(hasil["suratMasuk"], function(index, val) {
             rows +=  "<tr>"+
                        "<td>"+(index+1)+"</td>"+
                        "<td>"+val.nomor_surat+"</td>"+
                        "<td>"+val.perihal+"</td>"+
                        "<td>"+val.kategori['name']+"</td>"+
                        "<td>"+val.pengirim+"</td>"+
                        "<td>"+val.tujuan+"</td>"+
                        "<td>"+val.tanggal_diterima+"</td>"+
                        "<td>"+val.status+"</td>"+
                      "</tr>";
          });

          $.each(hasil["suratKeluar"], function(index, val) {
             rows2 +=  "<tr>"+
                        "<td>"+(index+1)+"</td>"+
                        "<td>"+val.nomor_surat+"</td>"+
                        "<td>"+val.perihal+"</td>"+
                        "<td>"+val.kategori['name']+"</td>"+
                        "<td>"+val.tujuan+"</td>"+
                        "<td>"+val.tanggal_surat+"</td>"+
                        "<td>"+val.status+"</td>"+
                      "</tr>";
          });
          table_sm.destroy();
          $("#tbody_sm").html(rows);
          table_sm = $('#table_sm').DataTable({
            order: [],
          }) ;

          table_sk.destroy();
          $("#tbody_sk").html(rows2);
          table_sk = $("#table_sk").DataTable({
            order: [],
          });

          $("#btn_cetak").click(function(event) {
            var filePdf = {
              pageSize: 'A4',
              PageMargins: 5,
              content : [
                {
                  text: "Laporan Surat Masuk dan keluar "+namaBulan+" "+tahun, style: 'title'
                },
                {
                  text: "Berikut rekap surat masuk dan keluar pada perusahaan anda selama bulan "+namaBulan+" "+tahun
                },
                {
                  text: "Surat masuk", style: 'header'
                },
                {
                  text: "Jumlah Total = "+hasil['suratMasuk'].length, margin: [0, 0, 0, 5]
                },
                {
                  table: {
                    headerRows: 1,
                    widths: [ '*', 'auto', 100, '*' ],
                    body: [
                      [{text: 'No', style: 'tblHeader'}, {text: 'Nomor Surat', style: 'tblHeader'}, {text: 'Perihal', style: 'tblHeader'}, {text: 'Kategori', style: 'tblHeader'}, {text: 'Pengirim', style: 'tblHeader'}, {text: 'Tujuan', style: 'tblHeader'}, {text: 'Tanggal Diterima', style: 'tblHeader'}, {text: 'Status', style: 'tblHeader'} ]
                      $.each(hasil['suratMasuk'], function(index, val) {
                         [(index+1), val.nomor_surat, val.perihal, val.kategori['name'], val.pengirim, val.tujuan, val.tanggal_diterima, val.status]
                      });
                    ]
                  }
                }
              ],

              styles: {
                title: {
                  fontSize: 18,
                  bold: true,
                  alignment: 'center',
                  margin: [0, 0, 0, 10]
                },
                header: {
                  fontSize: 16,
                  bold: true,
                  margin: [0, 0, 0, 5]
                },
                tblHeader: {
                  fontSize: 14,
                  bold: true
                }
              }
            };

            pdfMake.createPdf(filePdf).downlaod("Laporan Surat "+namaBulan+" "+tahun+".pdf")
          });
          
        })
        .fail(function() {
          console.log("error");
        })

      } //endif
      
    });

  })
</script>
@endsection
