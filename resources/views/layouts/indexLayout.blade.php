@extends('layouts.baseView')

@section('CSS_link')
<!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endsection

@section('content')
	<section class="content">
    	<div class="row">
	      	<div class="col-xs-12">
	      		<div class="box">
	      			<div class="box-header">
		              <h3 class="box-title">@yield('data_title')</h3>
		              @yield('data_create_btn')
		            </div>
		            <div class="box-body">
		            	<div class="table-responsive">
		            		<table id="table1" class="table table-bordered table-striped">
			            		@yield('dataTable_content')
				            </table>
		            	</div>
		            </div>
	      		</div>
	      	</div>

	      	@yield('delete_modal')
	      	@yield('create_modal')
	      	@yield('edit_modal')
	      	@yield('success_modal')
    	</div>
  </section>
@endsection

@section('script_src')
	
	<script src="{{asset('/AdminLTE/bower_components/moment/moment.min.js')}}"></script>
	
	<!-- DataTables -->
	<script src="{{asset('/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  	<script src="{{asset('/AdminLTE/bower_components/datatables.net/datetime-moment.js')}}"></script>

@endsection
