@extends('layouts.indexLayout')

@section('csrf-token')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_header')Surat {{($tipe == "surat masuk"? "Masuk" : "Keluar")}} @endsection

@section('breadcrumb')
  @if($tipe == "surat masuk")
  	 <li><a href="{{route('operator.surat-masuk.index')}}"><i class="ion ion-android-archive"></i> Surat Masuk</a></li>
     <li class="active"> Surat Masuk Tanpa {{$data}}</li>
  @else
      <li class="active"><a href="{{route('operator.surat-keluar.index')}}"><i class="ion ion ion-share"></i> Surat Keluar</a></li>
    @if($data == "Revisi")
      <li class="active"> Surat Keluar Butuh Revisi</li>
    @else
      <li class="active"> Surat Keluar Tanpa {{$data}}</li>
    @endif
  @endif
@endsection

@section('data_title')
@if($data == "Revisi")
  Surat Keluar yang Butuh Revisi
@else
  Surat {{($tipe == "surat masuk"? "masuk" : "keluar")}} yang Belum Dilengkapi Data {{$data}}
@endif
@endsection

@section('data_create_btn')
  @if(Auth::user()->role->name == "operator")
    @if($tipe == "surat masuk")
  	 <a href="{{route('operator.surat-masuk.create')}}" class="btn btn-info" style="float: right;"><i class="fa fa-plus"></i> Tambah Surat Masuk</a>
    @else
      <a href="{{route('operator.surat-keluar.create')}}" class="btn btn-info" style="float: right;"><i class="fa fa-plus"></i> Tambah Surat Keluar</a>
    @endif
  @endif
@endsection

@section('dataTable_content')
	<thead>
        <tr>
          <th>Nomor</th>
          <th>Perihal</th>
          <th>Nomor Lemari</th>
          <th>File</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($surat as $item)
    		<tr id="{{$item->id}}">
    			<td>{{$item->nomor_surat}}</td>
          <td>{{$item->perihal}}</td>
          <td>
            @if(!is_null($item->lemari_id))
              {{$item->lemari->nomor}}
            @else
              -
            @endif
            
          </td>
          <td>
            @if(!is_null($item->file_surat))
              @foreach($item->file_surat as $file)
                @if($tipe == "surat masuk")
                  <li>
                    <a href="{{$file}}" target="_blank">{{substr(strstr($file, 'suratMasuk/'), 11)}}</a>
                  </li>
                @else
                  <li>
                    <a href="{{$file}}" target="_blank">{{substr(strstr($file, 'suratKeluar/'), 12)}}</a>
                  </li>
                @endif
              @endforeach
            @else
              -  
            @endif
          </td>
    			<td>{{($item->status==""? "-" : $item->status)}}</td>
          <td>
            @if($tipe == "surat masuk")
              <a href="{{route('operator.surat-masuk.show', $item->id)}}" title="Lihat detail" id="{{$item->id}}" class="btn btn-success btn-flat"><i class="fa fa-eye"></i></a>
              <a href="{{route('operator.surat-masuk.edit', $item->id)}}" title="Ubah" id="{{$item->id}}" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></a>
            @else
              <a href="{{route('operator.surat-keluar.show', $item->id)}}" title="Lihat detail" id="{{$item->id}}" class="btn btn-success btn-flat"><i class="fa fa-eye"></i></a>
              <a href="{{route('operator.surat-keluar.edit', $item->id)}}" title="Ubah" id="{{$item->id}}" class="btn btn-primary btn-flat"><i class="fa fa-edit"></i></a>
            @endif
    				<button name="btnDel" id="{{$item->id}}" title="Hapus" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash-o"></i></button>
    			</td>
    		</tr>
    	@endforeach
    </tbody>
@endsection

@section('delete_modal')
	<div class="modal modal-danger fade" id="modal-delete">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Konfirmasi Penghapusan</h4>
          </div>
          <div class="modal-body">
            <p>Apakah anda yakin ingin menghapus data surat ini? {{-- &hellip; --}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
            {{-- <form method="POST" action="#">
    				@csrf
    				@method("DELETE") --}}
				<button type="button" id="hapusBtn" data-dismiss="modal" class="btn btn-outline">Hapus</button>
			{{-- </form> --}}
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
	<!-- /.modal -->
@endsection

@section('success_modal')
	<div class="modal modal-success fade" id="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Sukses</h4>
          </div>
          <div class="modal-body">
            <p>Data Surat Berhasil dihapus {{-- &hellip; --}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Oke</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
	<!-- /.modal -->
@endsection

@section('script')
	<script type="text/javascript">

		$(function () {
			$('#table1').DataTable({
				order: []
			})
		})

		$("button[name='btnDel']").click(function() {
			var id = $(this).attr('id');
			// console.log("id= "+id);

			$('div.modal-footer').off().on('click', '#hapusBtn', function(event) {
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    }
				});

				$.ajax({
          @if($tipe == "surat masuk")
					 url: '/162410101094/myWebsite/public/operator/surat-masuk/'+id,
          @else
            url: '/162410101094/myWebsite/public/operator/surat-keluar/'+id,
          @endif
					type: 'POST',
					data: {_method: 'DELETE'},
				})
				.done(function(hasil) {
					console.log(hasil);
					$("tr#"+id).hide();
     //      $('#modal-success').find('p:first').text("Data lemari berhasil dihapus");
					// $('#modal-success').modal('show');
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			});
		});
		
	</script>
@endsection