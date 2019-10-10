<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}">

  @yield('csrf-token')
  @yield('CSS_link')

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. -->
  <link rel="stylesheet" href="{{asset('/AdminLTE/dist/css/skins/skin-purple.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  @yield('style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{route('root')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SIM</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SIM</b>PAN</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages (WAS HERE): style can be found in dropdown.less-->

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              @if(count(Auth::user()->unreadNotifications) > 0)
                <span class="label label-success">{{count(Auth::user()->unreadNotifications)}}</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li class="header"> {{count(Auth::user()->unreadNotifications)}} notifikasi baru</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  @foreach(Auth::user()->unreadNotifications as $notif)
                    <li><!-- start notification -->
                      <a href="{{route('notification.readSurat', $notif->id)}}">
                        @if($notif->type == "App\Notifications\surat_masuk")
                          <i class="ion ion-android-archive text-teal"></i> Surat masuk dari {{$notif->data["pengirim"]}} <br>
                        @elseif($notif->type == "App\Notifications\surat_keluar")
                          @if(Auth::user()->role->name == "manajer")
                            <i class="ion ion-share text-orange"></i> Surat keluar untuk {{$notif->data["tujuan"]}} <br>
                          @elseif(Auth::user()->role->name == "operator")
                            <i class="ion ion-share text-orange"></i> Update status surat keluar no. {{$notif->data["nomor_surat"]}} <br>
                          @endif
                        @endif
                        <small>Perihal: {{$notif->data["perihal"]}}</small>
                        <small class="pull-right"><i class="fa fa-clock-o"></i> {{$notif->created_at->diffForHumans()}}</small>
                      </a>
                    </li>
                  @endforeach
                <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>

          <!-- Tasks Menu (WAS HERE)-->
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{asset('storage/'.Auth::user()->avatar)}}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{asset('storage/'.Auth::user()->avatar)}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}} - {{Auth::user()->role->name}}
                  {{-- <small>Member since Nov. 2012</small> --}}
                </p>
              </li>
              <!-- Menu Body (WAS HERE) -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"
                  >Sign out</a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>

          <!-- Control Sidebar Toggle Button (WAS HERE)-->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('storage/'.Auth::user()->avatar)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (WAS HERE) -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header" id="header">Main Menu</li>
        <!-- Optionally, you can add icons to the links -->

        @if(Auth::user()->role->name == "admin")
          <li id="dashboard">
            <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard "></i> <span>Dashboard</span></a>
          </li>
          @include('layouts.admin_menu')
        @elseif(Auth::user()->role->name == "operator")
          <li id="dashboard">
            <a href="{{route('operator.dashboard')}}"><i class="fa fa-dashboard "></i> <span>Dashboard</span></a>
          </li>
          @include('layouts.operator_menu')
        @elseif(Auth::user()->role->name == "manajer")
          <li id="dashboard">
            <a href="{{route('manajer.dashboard')}}"><i class="fa fa-dashboard "></i> <span>Dashboard</span></a>
          </li>
          @include('layouts.manajer_menu')
        @endif

        <li id="profil">
          <a href="{{route('profile')}}"><i class="fa fa-user"></i> <span>Profil</span></a>
        </li>

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="judul_page">@yield('page_header'){{-- <small>@yield('optional_desc')</small> --}}
      </h1>
      <ol class="breadcrumb">
        @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar (WAS HERE) -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{asset('/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>
{{-- Meta Tag Axios HTTP library, for X-CSRF Token --}}


@yield('script_src')
@yield('script')
<script type="text/javascript">
  // var judul_page = $('#judul_page').text();
  // console.log(judul_page.toLowerCase());

  // $('ul.sidebar-menu').children('li').each(function () {
  //   var sideName = $(this).attr('id');
  //   side = sideName.toLowerCase();
  //   judul = judul_page.toLowerCase();

  //   console.log("sn: "+side);
  //   if (side === judul) {
  //     console.log('yes!!');
  //     $(this).addClass('active');

  //   } else {
  //     $(this).removeClass('active');
  //   }

  // });
</script>


</body>
</html>