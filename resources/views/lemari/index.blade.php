@extends('layouts.indexLayout')

@section('csrf-token')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_header')Lemari Arsip @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('admin.lemari.index')}}"><i class="ion ion-ios-albums"></i> Lemari Arsip</a></li>
@endsection

@section('data_title') Data Lemari Arsip @endsection

@section('data_create_btn')
	<a href="{{route('admin.lemari.create')}}" class="btn btn-info" style="float: right;"><i class="fa fa-plus"></i> Tambah Lemari</a>
	{{-- <button class="btn btn-info" data-toggle="modal" data-target="#modal-create" style="float: right;"><i class="fa fa-plus"></i> Tambah Lemari</button> --}}
@endsection

@section('dataTable_content')
	<thead>
        <tr>
          <th>Id</th>
          <th>Nomor</th>
          <th>Lokasi</th>
          <th>Jumlah Baris</th>
          <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($lemari as $item)
    		<tr id="{{$item->id}}">
    			<td>{{$item->id}}</td>
    			<td>{{$item->nomor}}</td>
    			<td>{{$item->lokasi}}</td>
    			<td>{{$item->jml_baris}}</td>
    			<td>
    				<a href="{{route('admin.lemari.edit', $item->id)}}" name="btnEdit" id="{{$item->id}}" class="btn btn-primary btn-flat">Edit</a>
    				<button name="btnDel" id="{{$item->id}}" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete">Hapus</button>
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
            <p>Apakah anda yakin ingin menghapus data Lemari ini? {{-- &hellip; --}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
            {{-- <form method="POST" action="#">
				@csrf
				@method("DELETE") --}}
				<button type="button" id="hapusBtn" data-dismiss="modal" class="btn btn-outline">Hapus Lemari</button>
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
            <p>Data Lemari Berhasil dihapus {{-- &hellip; --}}</p>
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
					url: '/162410101094/myWebsite/public/admin/lemari/'+id,
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
			
			
			// $('div.modal-footer').find('form:first').attr('action', "/162410101094/myWebsite/public/admin/lemari/"+id);
		});
		
	</script>
@endsection