<li class="treeview" id="surat_masuk">
  <a href="#"><i class="ion ion-android-archive"></i> <span>Arsip Surat Masuk</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('operator.surat-masuk.create')}}">Tambah Surat Masuk</a></li>
    <li><a href="{{route('operator.surat-masuk.index')}}">Daftar Surat Masuk</a></li>
    <li><a href="{{route('operator.surat-masuk.kelengkapan', "Lemari")}}">Tanpa Lemari</a></li>
    <li><a href="{{route('operator.surat-masuk.kelengkapan', "File")}}">Tanpa File</a></li>
  </ul>
</li>

<li class="treeview" id="surat_keluar">
  <a href="#"><i class="ion ion-share"></i> <span>Arsip Surat Keluar</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('operator.surat-keluar.create')}}">Tambah Surat Keluar</a></li>
    <li><a href="{{route('operator.surat-keluar.index')}}">Daftar Surat Keluar</a></li>
    <li><a href="{{route('operator.surat-keluar.kelengkapan', "Revisi")}}">Butuh Revisi</a></li>
    <li><a href="{{route('operator.surat-keluar.kelengkapan', "Lemari")}}">Tanpa Lemari</a></li>
    <li><a href="{{route('operator.surat-keluar.kelengkapan', "File")}}">Tanpa File</a></li>
  </ul>
</li>