@extends('layouts.indexLayout')

@section('csrf-token')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_header')Surat Masuk @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('operator.surat-masuk.index')}}"><i class="fa fa-tags"></i> Surat Masuk</a></li>
@endsection

@section('data_title') Data Surat Masuk @endsection

@section('data_create_btn')
	<a href="{{route('operator.surat-masuk.create')}}" class="btn btn-info" style="float: right;"><i class="fa fa-plus"></i> Tambah Surat Masuk</a>
@endsection

@section('dataTable_content')
	<thead>
        <tr>
          <th>Nomor</th>
          <th>Perihal</th>
          <th>Kategori</th>
          @if($tipe == "surat masuk")
            <th>Pengirim</th>
          @endif
          <th>Tujuan</th>
          @if($tipe == "surat masuk")
            <th>Tanggal Diterima</th>
          @else
            <th>Tanggal Surat</th>
          @endif
          <th>Status</th>
          <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($surat as $item)
    		<tr id="{{$item->id}}">
    			<td>{{$item->nomor_surat}}</td>
          <td>{{$item->perihal}}</td>
    			<td>{{$item->kategori->name}}</td>
    			<td>{{$item->pengirim}}</td>
          <td>{{$item->tujuan}}</td>
          @if($tipe == "surat masuk")
            <td>{{Carbon\Carbon::parse($item->tanggal_diterima)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
          @else
            <td>{{Carbon\Carbon::parse($item->tanggal_surat)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
          @endif
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