@extends('layouts.indexLayout')

@section('csrf-token')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page_header')Divisi @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('admin.divisi.index')}}"><i class="fa fa-sitemap"></i> Divisi</a></li>
@endsection

@section('data_title') Data Divisi @endsection

@section('data_create_btn')
	<button class="btn btn-info" data-toggle="modal" data-target="#modal-create" style="float: right;"><i class="fa fa-plus"></i> Tambah Divisi</button>
@endsection

@section('dataTable_content')
	<thead>
        <tr>
          <th>Id</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($divisi as $item)
    		<tr id="{{$item->id}}">
    			<td>{{$item->id}}</td>
    			<td>{{$item->name}}</td>
    			<td>
    				<button name="btnEdit" id="{{$item->id}}" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-edit">Edit</button>
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
            <p>Apakah anda yakin ingin menghapus Divisi ini? {{-- &hellip; --}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
            {{-- <form method="POST" action="#">
				@csrf
				@method("DELETE") --}}
				<button type="button" id="hapusBtn" data-dismiss="modal" class="btn btn-outline">Hapus Divisi</button>
			{{-- </form> --}}
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
	<!-- /.modal -->
@endsection

@section('create_modal')
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-create">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-purple">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Tambah Divisi Baru</h4>
	      </div>
	      <form method="POST" action="{{route('admin.divisi.store')}}">
	          @csrf
		      <div class="modal-body" style="padding: 30px;">
		        <label for="name">Nama Divisi</label>
            	<input type="text" name="name" class="form-control" id="name" placeholder="nama" value="{{ old('name') }}">
              	@if($errors->create->has('name'))
                  	<span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $errors->create->first('name') }}</strong>
                    </span>
            	@endif
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
		        <button type="submit" class="btn btn-success">Tambahkan</button>
		      </div>
		  </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection

@section('edit_modal')
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-primary"> 
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Ubah Divisi <span id="nama_divisi"></span></h4>
	      </div>
	      <form method="POST" id="edit_form" action="#">
	          @csrf
	          @method("PUT")
		      <div class="modal-body" style="padding: 30px;">
		        <label for="name">Nama Divisi</label>
            	<input type="text" name="name" id="edit_input" class="form-control" id="name" placeholder="nama" value="" autofocus="autofocus">
              	@if($errors->edit->has('name'))
                  	<span class="invalid-feedback" role="alert" style="color: red;">
                        <strong>{{ $errors->edit->first('name') }}</strong>
                    </span>
            	@endif
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
		        <button type="submit" class="btn btn-success">Ubah</button>
		      </div>
		  </form>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endsection

@section('script')
	@if($errors->create->has('name'))
		<script type="text/javascript">
			$('#modal-create').modal('show');
		</script>
	@endif

	@if($errors->edit->has('name'))
		<script type="text/javascript">
			var id_divisi = {{session('id_divisi')}}
			var nama = $("tr#"+id_divisi+" td:nth-child(2)").text();

			$('#modal-edit').modal('show');
			$('#edit_form').attr('action', '/162410101094/myWebsite/public/admin/divisi/'+id_divisi);
			$('#nama_divisi').text(nama);
			console.log('id = '+id_divisi);
		</script>
	@endif

	<script type="text/javascript">
		$(function () {
			$('#table1').DataTable({
				order: []
			})
		})

		$("button[name='btnEdit']").click(function(event) {
			var name = $(this).parent("td").prev().text();
			var id = $(this).attr('id');
			// console.log('name= '+name+"| id= "+id);

			$("#edit_input").val(name);
			$('#edit_form').attr('action', '/162410101094/myWebsite/public/admin/divisi/'+id);
			$('#nama_divisi').text(name);
		});

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
					url: '/162410101094/myWebsite/public/admin/divisi/'+id,
					type: 'POST',
					data: {_method: 'DELETE'},
				})
				.done(function(hasil) {
					console.log(hasil);
					$("tr#"+id).hide();
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