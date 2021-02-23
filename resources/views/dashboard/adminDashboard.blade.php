@extends('layouts.baseView')

@section('page_header')Dashboard @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
@endsection

@section('content')
	
	{{-- <div class="callout callout-info bg-light-blue" style="margin-bottom: 0!important;">
	    <h4> Selamat Datang {{$user->name}}</h4>
	    
	 </div>
	<br> --}}

	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>{{$jml_user}}</h3>
					<p>Users</p>
				</div>
				<div class="icon">
					<i class="ion ion-ios-people"></i>
				</div>
				<a href="{{route('admin.user.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>{{$jml_kategori}}</h3>
					<p>Kategori</p>
				</div>
				<div class="icon">
					<i class="ion ion-ios-pricetags"></i>
				</div>
				<a href="{{route('admin.kategori.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		{{-- <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>{{$jml_divisi}}</h3>
					<p>Divisi</p>
				</div>
				<div class="icon">
					<i class="fa fa-sitemap"></i>
				</div>
				<a href="{{route('admin.divisi.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div> --}}

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-light-blue">
				<div class="inner">
					<h3>{{$jml_lemari}}</h3>
					<p>Lemari Arsip</p>
				</div>
				<div class="icon">
					<i class="ion ion-ios-albums"></i>
				</div>
				<a href="{{route('admin.lemari.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<!-- USERS LIST -->
          	<div class="box box-danger">
	            <div class="box-header with-border">
	              <h3 class="box-title">User Terbaru</h3>

	              <div class="box-tools pull-right">
	                {{-- <span class="label label-danger">8 New Members</span> --}}
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
	                </button>
	              </div>
	            </div>
            	<!-- /.box-header -->
	            <div class="box-body no-padding">
	              <ul class="users-list clearfix">
	              	@foreach($new_users as $item)
	              		<li>
		                  <img src="{{ is_null(Auth::user()->avatar) ? asset('user/default_user.png') : asset('storage/'.Auth::user()->avatar) }}" alt="User Image">
		                  <a class="users-list-name" href="{{ route('admin.user.show', $item->id) }}">{{$item->name}}</a>
		                  <span class="users-list-date">{{Carbon\Carbon::parse($item->created_at)->locale('id_ID')->isoFormat('D MMM ')}}</span>
		                </li>
	              	@endforeach
	              </ul>
	              <!-- /.users-list -->
	            </div>
            	<!-- /.box-body -->
	            <div class="box-footer text-center">
	              <a href="{{route('admin.user.index')}}" class="uppercase">View All Users</a>
	            </div>
            	<!-- /.box-footer -->
          	</div>
          	<!--/.box -->
		</div>

		<div class="col-md-6">
			<div class="box box-default">
	            <div class="box-header with-border">
	              <h3 class="box-title">Jumlah User Berdasar Role</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	              </div>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="row">
	                <div class="col-md-8">
	                  <div class="chart-responsive">
	                    <canvas id="pieChart" height="150"></canvas>
	                  </div>
	                  <!-- ./chart-responsive -->
	                </div>
	                <!-- /.col -->
	                <div class="col-md-4">
	                  <ul class="chart-legend clearfix">
	                    <li><i class="fa fa-circle-o text-red"></i> Admin</li>
	                    <li><i class="fa fa-circle-o text-green"></i> Operator</li>
	                    <li><i class="fa fa-circle-o text-aqua"></i> Manajer</li>
	                  </ul>
	                </div>
	                <!-- /.col -->
	              </div>
	              <!-- /.row -->
	            </div>
	            <!-- /.box-body -->
	            {{-- <div class="box-footer no-padding">
	              <ul class="nav nav-pills nav-stacked">
	                <li><a href="#">United States of America
	                  <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
	                <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a>
	                </li>
	                <li><a href="#">China
	                  <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
	              </ul>
	            </div> --}}
	            <!-- /.footer -->
	        </div>
		</div>
	</div>
@endsection

@section('script_src')
	<!-- ChartJS -->
	<script src="{{asset('/AdminLTE/bower_components/chart.js/Chart.js')}}"></script>
@endsection

@section('script')
	<script type="text/javascript">
		var user_role = @json($jml_user_role);
		var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
	    var pieChart       = new Chart(pieChartCanvas)
	    var PieData        = [
	      {
	        value    : user_role['admin'],
	        color    : '#F71735',
	        highlight: '#f7223e',
	        label    : 'Admin'
	      },
	      {
	        value    : user_role['operator'],
	        color    : '#00a65a',
	        highlight: '#00cc70',
	        label    : 'Operator'
	      },
	      {
	        value    : user_role['manajer'],
	        color    : '#00c0ef',
	        highlight: '#00ccff',
	        label    : 'Manajer'
	      },
	      
	    ]
	    var pieOptions     = {
	      //Boolean - Whether we should show a stroke on each segment
	      segmentShowStroke    : true,
	      //String - The colour of each segment stroke
	      segmentStrokeColor   : '#fff',
	      //Number - The width of each segment stroke
	      segmentStrokeWidth   : 2,
	      //Number - The percentage of the chart that we cut out of the middle
	      percentageInnerCutout: 50, // This is 0 for Pie charts
	      //Number - Amount of animation steps
	      animationSteps       : 100,
	      //String - Animation easing effect
	      animationEasing      : 'easeOutBounce',
	      //Boolean - Whether we animate the rotation of the Doughnut
	      animateRotate        : true,
	      //Boolean - Whether we animate scaling the Doughnut from the centre
	      animateScale         : false,
	      //Boolean - whether to make the chart responsive to window resizing
	      responsive           : true,
	      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	      maintainAspectRatio  : true,
	      //String - A legend template
	      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
	    }
	    //Create pie or douhnut chart
	    // You can switch between pie and douhnut using the method below.
	    pieChart.Doughnut(PieData, pieOptions)
	</script>
@endsection