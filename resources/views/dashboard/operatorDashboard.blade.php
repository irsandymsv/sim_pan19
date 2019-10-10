@extends('layouts.baseView')

@section('page_header')Dashboard @endsection

@section('breadcrumb')
	<li class="active"><a href="{{route('operator.dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-teal">
				<div class="inner">
					<h3>{{$suratMasuk_count}}</h3>
					<p>Surat Masuk</p>
				</div>
				<div class="icon">
					<i class="ion ion-android-archive"></i>
				</div>
				<a href="{{route('operator.surat-masuk.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-orange">
				<div class="inner">
					<h3>{{$suratKeluar_count}}</h3>
					<p>Surat Keluar</p>
				</div>
				<div class="icon">
					<i class="ion ion-share"></i>
				</div>
				<a href="{{route('operator.surat-keluar.index')}}" class="small-box-footer">
					More 
					<i class="fa fa-arrow-circle-right"></i>
				</a>
			</div>
		</div>
	</div>
	
    @include('layouts.dashboard_chart')

    <div class="row">
    	<div class="col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Kelengkapan Data Surat</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
	                <table class="table no-margin" style="font-size: 16px;">
	                	<tbody>
	                		<tr style="background-color: lightgrey;">
	                			<td>
	                				<b>Surat Masuk</b>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td>
	                				<a href="{{route('operator.surat-masuk.kelengkapan', "Lemari")}}"><span class="label label-primary">{{$sm_noLemari}}</span> Surat belum dilengkapi data lemari</a>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td>
	                				<a href="{{route('operator.surat-masuk.kelengkapan', "File")}}"><span class="label label-success">{{$sm_noFile}}</span> Surat belum dilengkapi file surat</a>
	                			</td>
	                		</tr>

	                		<tr style="background-color: lightgrey;">
	                			<td>
	                				<b>Surat Keluar</b>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td>
	                				<a href="{{route('operator.surat-keluar.kelengkapan', "Revisi")}}"><span class="label label-danger">{{$sk_revisi}}</span> Surat membutuhkan revisi</a>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td>
	                				<a href="{{route('operator.surat-keluar.kelengkapan', "Lemari")}}"><span class="label label-primary">{{$sk_noLemari}}</span> Surat belum dilengkapi data lemari</a>
	                			</td>
	                		</tr>

	                		<tr>
	                			<td>
	                				<a href="{{route('operator.surat-keluar.kelengkapan', "File")}}"><span class="label label-success">{{$sk_noFile}}</span> Surat belum dilengkapi file surat</a>
	                			</td>
	                		</tr>
	                	</tbody>
	                </table>
	            </div>
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Surat Terbaru</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
	            <div class="table-responsive">
	                <table class="table no-margin">
	                	<thead>
	                		<th>No Surat</th>
	                		<th>Jenis</th>
	                		<th>Status</th>
	                	</thead>
	                	<tbody>
	                		@foreach($surat_baru as $item)
	                			<tr>
	                				<td>
	                					@if(get_class($item) == "App\SuratMasuk")
	                						<a href="{{route('operator.surat-masuk.show', $item->id)}}">{{$item->nomor_surat}}</a>
	                					@else
	                						<a href="{{route('operator.surat-keluar.show', $item->id)}}">{{$item->nomor_surat}}</a>
	                					@endif
	                					
	                				</td>
	                				<td>
	                					@if(get_class($item) == "App\SuratMasuk")
	                						Surat Masuk
	                					@else
	                						Surat Keluar
	                					@endif
	                				</td>
	                				<td>{{$item->status}}</td>
	                			</tr>
	                		@endforeach
	                	</tbody>
	                </table>
	            </div>
            </div>
            <!-- ./box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
@endsection

@section('script_src')
	<!-- ChartJS -->
	<script src="{{asset('/AdminLTE/bower_components/chart.js/Chart.js')}}"></script>
@endsection

@section('script')
	<script type="text/javascript">
		$(function() {
			var jml_sm = @json($jml_sm);
			var jml_sm_length = jml_sm.length;
			var total_sm = 0;

			var jml_sk = @json($jml_sk);
			var jml_sk_length = jml_sk.length;
			var total_sk = 0;

			for (var i = 0; i < jml_sm_length; i++) {
				total_sm += jml_sm[i];
				total_sk += jml_sk[i];
			}

			//AREA CHART

			// Get context with jQuery - using jQuery's .get() method.
		    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
		    // This will get the first returned node in the jQuery collection.
		    var areaChart       = new Chart(areaChartCanvas)

		    var areaChartData = {
		      labels  : ['Minggu I', 'Minggu II', 'Minggu III', 'Minggu IV'],
		      datasets: [
		        {
		          label               : 'Surat Masuk',
		          fillColor           : '#5bd1d7',
		          strokeColor         : '#1794A5',
		          pointColor          : '#1794A5',
		          pointHighlightStroke: '#EEEEEE',
		          data                : jml_sm
		        },
		        {
		          label               : 'Surat Keluar',
		          fillColor           : '#FF9933',
		          strokeColor         : '#FD7013',
		          pointColor          : '#FD7013',
		          pointHighlightStroke: '#EEEEEE',
		          data                : jml_sk
		        }
		      ]
		    }

		    var areaChartOptions = {
		      //Boolean - If we should show the scale at all
		      showScale               : true,
		      //Boolean - Whether grid lines are shown across the chart
		      scaleShowGridLines      : true,
		      //String - Colour of the grid lines
		      scaleGridLineColor      : 'rgba(0,0,0,.05)',
		      //Number - Width of the grid lines
		      scaleGridLineWidth      : 1,
		      //Boolean - Whether to show horizontal lines (except X axis)
		      scaleShowHorizontalLines: true,
		      //Boolean - Whether to show vertical lines (except Y axis)
		      scaleShowVerticalLines  : true,
		      //Boolean - Whether the line is curved between points
		      bezierCurve             : true,
		      //Number - Tension of the bezier curve between points
		      bezierCurveTension      : 0.3,
		      //Boolean - Whether to show a dot for each point
		      pointDot                : true,
		      //Number - Radius of each point dot in pixels
		      pointDotRadius          : 4,
		      //Number - Pixel width of point dot stroke
		      pointDotStrokeWidth     : 1,
		      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
		      pointHitDetectionRadius : 20,
		      //Boolean - Whether to show a stroke for datasets
		      datasetStroke           : true,
		      //Number - Pixel width of dataset stroke
		      datasetStrokeWidth      : 2,
		      //Boolean - Whether to fill the dataset with a color
		      datasetFill             : true,
		      //String - A legend template
		      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
		      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
		      maintainAspectRatio     : true,
		      //Boolean - whether to make the chart responsive to window resizing
		      responsive              : true
		    }

		    //Create the line chart
		    areaChart.Line(areaChartData, areaChartOptions);


		    //BAR CHART

		    var barChartCanvas = $('#barChart').get(0).getContext('2d')
		    var barChart = new Chart(barChartCanvas)
		    var barChartData = {
		    	labels  : ['{{$bulan}}'],
			    datasets: [
			        {
			          label               : 'Surat Masuk',
			          fillColor           : '#5bd1d7',
			          strokeColor         : '#5bd1d7',
			          data                : [total_sm]
			        },
			        {
			          label               : 'Surat Keluar',
			          fillColor           : '#FF9933',
			          strokeColor         : '#FF9933',
			          data                : [total_sk]
			        }
			    ]
		    }
		    // barChartData.datasets[1].fillColor   = '#00a65a'
		    // barChartData.datasets[1].strokeColor = '#00a65a'
		    // barChartData.datasets[1].pointColor  = '#00a65a'
		    var barChartOptions                  = {
		      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
		      scaleBeginAtZero        : true,
		      //Boolean - Whether grid lines are shown across the chart
		      scaleShowGridLines      : true,
		      //String - Colour of the grid lines
		      scaleGridLineColor      : 'rgba(0,0,0,.05)',
		      //Number - Width of the grid lines
		      scaleGridLineWidth      : 1,
		      //Boolean - Whether to show horizontal lines (except X axis)
		      scaleShowHorizontalLines: true,
		      //Boolean - Whether to show vertical lines (except Y axis)
		      scaleShowVerticalLines  : true,
		      //Boolean - If there is a stroke on each bar
		      barShowStroke           : true,
		      //Number - Pixel width of the bar stroke
		      barStrokeWidth          : 2,
		      //Number - Spacing between each of the X value sets
		      barValueSpacing         : 5,
		      //Number - Spacing between data sets within X values
		      barDatasetSpacing       : 1,
		      //String - A legend template
		      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
		      //Boolean - whether to make the chart responsive
		      responsive              : true,
		      maintainAspectRatio     : true
		    }

		    barChartOptions.datasetFill = false
		    barChart.Bar(barChartData, barChartOptions)

		    $("#total_surat").text(total_sm + total_sk);

		});
	</script>
@endsection