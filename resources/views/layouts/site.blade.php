<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.structure.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/site.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-slide="true" href="{{ url('/perfil') }}">
                        <i class="fas fa-key"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-slide="true" href="{{ url('/logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="brand-link">
                <img src="{{asset('img/AdminLTELogo.png')}}" alt="Eglise Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Eglise</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (!Auth::user()->avatar_blob)
                        <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                        @else
                        <img src="{{Auth::user()->avatar_blob}}" class="img-circle elevation-2" alt="User Image">
                        @endif
                    </div>
                    <div class="info" style="max-height: 48px;">                        
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="d-block text-wrap">{{\Auth::user()->name}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{route('home')}}"
                                class="nav-link {{ in_array(_route(),_home()) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Home</p>
                            </a>
                        </li>

                        @if(\Auth::user()->hasAnyRole(['SuperAdmin','Admin']))
                            @include('layouts.menus.seguranca')

                            <!--<li class="nav-item">
                                <a href="{{route('igrejas')}}"
                                    class="nav-link {{ in_array(_route(),['igrejas']) ? 'active' : '' }}">
                                    <i class="fas fa-church"></i>
                                    <p>Igrejas</p>
                                </a>
                            </li>-->
                        @endif
                        
                        @if (\Request::session()->get('igreja_id'))

                        @if(\Auth::user()->hasRole('Admin'))
                            @include('layouts.menus.admin')
                        @endif

                        <li class="nav-item">
                            <a href="{{route('celulas')}}"
                                class="nav-link {{ in_array(_route(),['celulas']) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Células</p>
                            </a>
                        </li>
                        @endif

                    </ul>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> {{env('APP_VERSION')}}
            </div>
            <strong>Copyright &copy; 2020 <a href="#">Hotsystems IT Solutions</a>.</strong> Todos os direitos reservados.
        </footer>

        <!-- Control Sidebar -->
        <!--<aside class="control-sidebar control-sidebar-dark">
  </aside>-->
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- SweetAlert2 -->
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Custom File Input -->
    <script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('js/demo.js')}}"></script>
    <!-- ClipboardJS -->
    <script src="{{asset('plugins/clipboardjs/clipboard.min.js')}}"></script>
    <!-- Jquery Validate -->
    <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>

    <script src="{{asset('js/jsfunctions.js')}}"></script>

    @stack('script')
</body>




<script type="text/javascript">
    $(document).ready(function () {
  //Inicializa Bootstrap Custom FileInput
  bsCustomFileInput.init();
});

  @if(Session::has('message'))
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
      var type = "{{ Session::get('alert-type', 'info') }}";
      Toast.fire({
        type: type,
        title: "{{ Session::get('message') }}"
      });
    @endif
</script>

</html>
