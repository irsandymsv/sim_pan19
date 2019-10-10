@extends('layouts.indexLayout')

@section('page_header')User @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> User</a></li>
@endsection

@section('data_title') Data user @endsection

@section('data_create_btn')
	<a href="{{route('admin.user.create')}}" class="btn btn-info" style="float: right;"><i class="fa fa-plus"></i> Tambah User</a>
@endsection

@section('dataTable_content')
	<thead>
	    <tr>
	      <th>Id</th>
	      <th>nama</th>
	      <th>Email</th>
	      <th>Role</th>
	      <th>Tanggal Daftar</th>
	      <th>Aksi</th>
	    </tr>

	    <tr>
	      <th></th>
	      <th></th>
	      <th></th>
	      <th>Role</th>
	      <th></th>
	      <th></th>
	    </tr>
	</thead>
	<tbody>
		@foreach($users as $item)
			<tr>
				<td>{{$item->id}}</td>
				<td>{{$item->name}}</td>
				<td>{{$item->email}}</td>
				<td>{{$item->role->name}}</td>
				<td>{{\Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMMM Y')}}</td>
				<td>
					<a href="{{route('admin.user.show', $item->id)}}" class="btn btn-success btn-flat">Detail</a>
					<a href="{{route('admin.user.edit', $item->id)}}" class="btn btn-primary btn-flat">Edit</a>
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
            <p>Apakah anda yakin ingin menghapus User ini? {{-- &hellip; --}}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Batal</button>
            <form method="POST" action="#">
				@csrf
				@method("DELETE")
				<button type="submit" id="hapusBtn" class="btn btn-outline">Hapus User</button>
			</form>
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
			$.fn.dataTable.moment('D MMMM Y', 'id');
      		// $('#table1 thead tr').clone(true).appendTo( '#table1 thead' );

			$('#table1').DataTable({
				order: [],
				orderCellsTop: true,
		        initComplete: function () {
		          this.api().columns([3]).every( function () {
		              var column = this;
		              var select = $('<select><option value=""></option></select>')
		                  .appendTo( $("#table1 thead tr:eq(1) th").eq(column.index()).empty() )
		                  .on( 'change', function () {
		                      var val = $.fn.dataTable.util.escapeRegex(
		                          $(this).val()
		                      );

		                      column
		                          .search( val ? '^'+val+'$' : '', true, false )
		                          .draw();
		                  } );

		              column.data().unique().sort().each( function ( d, j ) {
		                  select.append( '<option value="'+d+'">'+d+'</option>' )
		              } );
		          } );
		        }
			});
		})
		
		$('button[name="btnDel"]').click(function() {
			var id = $(this).attr('id');
			// console.log("id= "+id);
			$('div.modal-footer').find('form:first').attr('action', "/162410101094/myWebsite/public/admin/user/"+id);
		});
		
	</script>
@endsection