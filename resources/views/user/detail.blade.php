@extends('layouts.profile')

@section('page_header'){{$link}} @endsection

@section('breadcrumb')
	@if($link == "Profile")
		<li class="active"><a href="{{route('profile')}}"><i class="fa fa-user"></i> Profile</a></li>
	@else
		<li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> User</a></li>
		<li class="active">Detail User</li>
	@endif
	
@endsection

@section('profile_buttons')
	@if($link == "Profile")
		<a href="{{route('profile.edit')}}" type="button" id="editBtn" class="btn btn-primary btn-block"><b>Edit</b></a>
		<a href="{{route('profile.resetPassword')}}" type="button" class="btn btn-warning btn-block">Ubah Password</a>
	@else
		<div class="form-group">
			<a href="{{route('admin.user.edit', $user->id)}}" type="button" id="editBtn" class="btn btn-primary btn-block"><b>Edit</b></a>	
		</div>

		<div class="form-group">
			<a href="{{route('admin.user.resetPassword', $user->id)}}" type="button" class="btn btn-warning btn-block">Ubah Password</a>	
		</div>
		
		@if(Auth::id() != $user->id)
			<div class="form-group">
				<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-deleteUser">
					Hapus user
	            </button>
			</div>
		@endif
	@endif

	@if(session("selfDelete_error"))
		<div class="alert alert-danger alert-dismissible">
		    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
		    {{session("selfDelete_error")}}
	  	</div>
	@endif

	<div class="modal modal-danger fade" id="modal-deleteUser">
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
            <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
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

@section('profile_title')
	Profile
@endsection

@section('profile_body')
	<div class="col-md-6">
		<div class="detailUser">
			<strong>Nama</strong>
            <h4 class="text-muted">
            	{{$user->name}}
            </h4>
            {{-- <hr> --}}
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div>

		<div class="detailUser">
			<strong>Email</strong>
            <h4 class="text-muted">
            	{{$user->email}}
            </h4>
            {{-- <hr> --}}
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div>

		<div class="detailUser">
			<strong>Nomor Telepon</strong>
            <h4 class="text-muted">
            	{{$user->phone_number}}
            </h4>
            {{-- <hr>	 --}}
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div>


	</div>

	<div class="col-md-6">
		<div class="detailUser">
			<strong>Jenis Kelamin</strong>
            <h4 class="text-muted">
            	{{$user->gender}}
            </h4>
            {{-- <hr> --}}
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div>

		{{-- <div class="detailUser">
			<strong>Divisi</strong>
            <h4 class="text-muted">
            	{{$user->divisi->name}}
            </h4>
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div> --}}

		<div class="detailUser">
			<strong>Alamat</strong>
            <h4 class="text-muted">
            	@if($user->alamat == "")
            		-
            	@else
            		{{$user->alamat}}
            	@endif
            </h4>
            {{-- <hr> --}}
            <div style="height: 1px; background-color: black; margin-bottom: 15px;"></div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$("#resetPass").fadeOut(3500);
		$("#updateProfile").fadeOut(3500);
	</script>
@endsection