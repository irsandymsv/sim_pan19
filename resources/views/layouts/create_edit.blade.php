@extends('layouts.baseView')

@section('CSS_link')
	<link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
@endsection

@section('content')
	<section class="content">
      <div class="row">
      	<div class="col-md-12">
      		<!-- general form elements -->
          <div class="box box-success" style="width: 90%; margin: auto;">
            <div class="box-header with-border">
              <h3 class="box-title">@yield('create_edit_title')</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="@yield('create_edit_route')" enctype="multipart/form-data">
            	@csrf
            	@yield('put_method')
	          	<div class="box-body">
	          		
	          		@yield('create_edit_form')

	        	  </div>
              <!-- /.box-body -->

	            <div class="box-footer" style="text-align: right;">
                @yield('back_btn') &ensp;
	            	<button type="submit" class="btn btn-primary">Submit</button>
	            </div>
            </form>
          </div>
      	</div>
	  </div>
	</section>
@endsection
