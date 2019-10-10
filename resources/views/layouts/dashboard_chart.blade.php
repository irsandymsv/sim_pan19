<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Overview Surat Masuk dan Keluar Bulan Ini</h3>

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
            <p class="text-center">
              <strong>{{$bulan}}</strong>
            </p>

            <div class="chart">
              <!-- Chart Canvas -->
              <canvas id="areaChart" style="height: 180px;"></canvas>
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <p class="text-center">
              <strong>Total Surat Bulan Ini</strong>
            </p>

            <div class="chart">
              <!-- Chart Canvas -->
              <canvas id="barChart" style="height: 180px;"></canvas>
            </div>
            
            <div style="text-align: center;">
            	<h4>TOTAL : <span id="total_surat">0</span> Surat</h4>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  </div>