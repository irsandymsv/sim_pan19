<li class="treeview" id="user">
  <a href="#"><i class="fa fa-users"></i> <span>user</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('admin.user.create')}}">Tambah User</a></li>
    <li><a href="{{route('admin.user.index')}}">Daftar user</a></li>
  </ul>
</li>

<li id="kategori">
  <a href="{{route('admin.kategori.index')}}"><i class="fa fa-tags"></i> 
    <span>Kategori</span>
  </a>
</li>

{{-- <li id="divisi">
  <a href="{{route('admin.divisi.index')}}"><i class="fa fa-sitemap"></i> 
    <span>Divisi</span>
  </a>
</li> --}}

<li class="treeview" id="user">
  <a href="#"><i class="ion ion-ios-albums"></i> <span>Lemari Arsip</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('admin.lemari.create')}}">Tambah Lemari Arsip</a></li>
    <li><a href="{{route('admin.lemari.index')}}">Daftar Lemari Arsip</a></li>
  </ul>
</li>