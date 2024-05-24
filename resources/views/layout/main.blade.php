<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Kontrak System | Pengadaan</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('lte/dist/img/logoperuri.ico') }}"/>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/ionicons.min.css') }}"> --}}
    
    <!-- select2 -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/select2.min.css') }}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/summernote-0.8.18-dist/summernote.min.css') }}">

    {{-- datatables --}}
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    {{-- flasher --}}
    <link rel="stylesheet" href="{{ asset('assets/flasher.min.css') }}">
    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2.min.css') }}">
    <style>
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Pastikan wrapper mencakup setidaknya tinggi viewport */
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                {{-- dropdown untuk notifikasi --}}
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                    {{-- <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" style="font-size: 1.2em; position: absolute; top: -8px; right: -8px; z-index: 1;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    </a> --}}

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 30rem;">
                        <span class="dropdown-item dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
                        <div class="dropdown-divider"></div>
                        @foreach(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ url($notification->data['url']. '?id='.$notification->id) }}" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> {{ $notification->data['title'] }}
                            <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                            <p class="mb-0">{{ ucwords($notification->data['messages']) }}</p> 
                        </a>
                        @endforeach
                        {{-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
               
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('lte/dist/img/logoperuri2.png') }}" alt="Peruri Logo" class="brand-image" style="opacity: .8">
                <hr>
                <span class="brand-text font-weight-light"></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!-- <div class="image">
                        <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                    </div> -->
                    <div class="info">
                        <span class="badge badge-info">Hallo, {{ Auth::user()->name .' - '. Auth::user()->unit_kerja }}</span><br>
                        <span class="badge badge-secondary mt-2">Your Role as {{ Auth::user()->permission }}</span>
                        <a href="#" class="d-block"></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <!-- <i class="right fas fa-angle-left"></i> -->
                                </p>
                            </a>
                        </li>
                        <hr>
                        {{-- MENU INPUT KONTRAK DAN LAMPIRAN --}}
                        <li class="nav-header">MENU KONTRAK MANAGEMENT</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                {{-- <i class="fas fa-copy"></i> --}}
                                <i class="fas fa-file-contract"></i>
                                <p>
                                    <span style="margin-left: 5px;">KONTRAK</span>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- MENU MONITORING KONTRAK --}}
                                <li class="nav-item">
                                    <a href="{{ route('indexKontrak') }}" class="nav-link">
                                        <i class="nav-icon fas fa-tachometer-alt"></i>
                                        <p>Monitoring Kontrak</p>
                                    </a>
                                </li>

                                @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                    <li class="nav-item">
                                        <a href="{{ route('creatKontrak') }}" class="nav-link">
                                            <i class="nav-icon fas fa-edit"></i>
                                            <p>Input Kontrak</p>
                                        </a>
                                    </li>
                                @endif

                                {{-- MENU REVIEW KONTRAK --}}
                                <li class="nav-item">
                                    <a href="{{ route('rKontrak') }}" class="nav-link">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>Review Kontrak
                                            <span class="badge badge-danger right">{{ auth()->user()->unreadNotifications->count() }}</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- MENU EXPORT DATA --}}

                        <li class="nav-header">MENU EXPORT</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-print"></i>
                                <p>
                                    <span style="margin-left: 5px;">EXPORT KONTRAK</span>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ExKontrakPDF') }}" class="nav-link">
                                        <i class="fas fa-file-pdf"></i>
                                        <p>Export by PDF</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('viewExport') }}" class="nav-link">
                                        <i class="fas fa-file-excel"></i>
                                        <p>Export by EXCEL</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- MENU SETTING AKTA VENDOR DAN PERURI --}}
                        @if(Auth::user()->permission == 'admin' || Auth::user()->permission == 'writer')
                            <li class="nav-header">MENU AKTA MANAGEMENT</li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-file-alt"></i>
                                    <p>
                                        <span style="margin-left: 5px;">AKTA</span>
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('vendor.index') }}" class="nav-link">
                                            <i class="fas fa-burn"></i>
                                            <p> Akta Vendor Setting</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('setting.edit',1) }}" class="nav-link">
                                            <i class=" fas fa-cog"></i>
                                            <p> Akta Peruri Setting</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                            
                        {{-- MENU CONTROL USER DAN PASAL  --}}
                        @if(Auth::user()->permission=='admin')
                            <li class="nav-header">MENU TAMBAHAN</li>
                            <li class="nav-item">
                                <a href="{{ route('index') }}" class="nav-link">
                                    <i class=" fas fa-user"></i>
                                    <p>User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vPasal') }}" class="nav-link">
                                    <i class=" fas fa-book"></i>
                                    <p>Pasal</p>
                                </a>
                            </li> 
                        @endif

                        <hr>

                        {{-- MENU LOGOUT --}}
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class=" fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            
            <div class="text-center" style="position: absolute; bottom: 30px; display:block; width: 100%;">
                <div class="text-light" id="waktu" style="font-size: 10px;"></div>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy;{{ date('Y')}} Dept.Pengadaan - PERURI.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- ChartJS -->
    <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
    
    <!-- Sparkline -->
    <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script>
    
    <!-- JQVMap -->
    <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    
    <!-- daterangepicker -->
    <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    
    <!-- Summernote -->
    <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="{{ asset('lte/dist/js/demo.js') }}"></script> -->
    
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script> -->
    
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    
    <!-- select2 JS -->
    <script src="{{ asset('assets/select2.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    
    {{-- flasher --}}
    <script src="{{ asset('assets/flasher.min.js') }}"></script>
    
    {{-- sweetalert2 --}}
   <script src="{{ asset('assets/sweetalert2.all.min.js') }}"></script>


    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        $(function() {
            $("#example1").DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing":true,
            });

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing":true,
            });

            $('#example3').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing":true,
            });
            

            $('#filter_type').change(function() {
                if ($(this).val() === 'month') {
                    $('#month').show(); // Tampilkan input bulan
                    $('#year').show(); // Tampilkan input tahun
                    $('#filter_value').val(''); // Kosongkan nilai filter_value
                    $('#filter_value').hide(); // Sembunyikan input filter_value
                } else {
                    $('#month').hide(); // Sembunyikan input bulan
                    $('#year').hide(); // Sembunyikan input tahun
                    $('#filter_value').show(); // Tampilkan kembali input filter_value
                }
            });

            // setting filter_value ketika nilai input filter_type nya month
            $('#month, #year').change(function() {
                var month = $('#month').val();
                var year = $('#year').val();
                if (month && year) {
                    $('#filter_value').val(month + '/' + year); // Atur nilai input filter_value
                }
            });

            $('input[name="filter_value"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="filter_value"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('input[name="filter_value"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });


        function winpopup(url, windowname) {
            let screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            let screenHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
            
            let popupWidth = 900;
            let popupHeight = 640;
            
            let leftPosition = (screenWidth - popupWidth) / 2;
            let topPosition = (screenHeight - popupHeight) / 2;
            
            let features = 'width=' + popupWidth + ',height=' + popupHeight + ',toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=' + leftPosition + ',top=' + topPosition;
            
            window.open(url, windowname, features);
            return false;
        }


        // FUNCTION JAM DISIDEBAR
        function currentTime(){
            let date = new Date();
            let tahun = date.getFullYear();
            let bulan = date.getMonth();
            let tanggal = date.getDate();
            let hari = date.getDay();

            switch (hari) {
                case 0:
                    hari = "Minggu";
                    break;
                case 1:
                    hari = "Senin";
                    break;
                case 2:
                    hari = "Selasa";
                    break;
                case 3:
                    hari = "Rabu";
                    break;
                case 4:
                    hari = "Kamis";
                    break;
                case 5:
                    hari = "Jum'at";
                    break;
                case 6:
                    hari = "Sabtu";
                    break;
            }

            switch (bulan) {
                case 0:
                    bulan = "Januari";
                    break;
                case 1:
                    bulan = "Februari";
                    break;
                case 2:
                    bulan = "Maret";
                    break;
                case 3:
                    bulan = "April";
                    break;
                case 4:
                    bulan = "Mei";
                    break;
                case 5:
                    bulan = "Juni";
                    break;
                case 6:
                    bulan = "Juli";
                    break;
                case 7:
                    bulan = "Agustus";
                    break;
                case 8:
                    bulan = "September";
                    break;
                case 9:
                    bulan = "Oktober";
                    break;
                case 10:
                    bulan = "November";
                    break;
                case 11:
                    bulan = "Desember";
                    break;
            }

            let hh = date.getHours();
            let mm = date.getMinutes();
            let ss = date.getSeconds();
            let session = "AM";

            if (hh > 12) {
                session = "PM";
            }

            hh = hh < 10 ? "0" + hh : hh;
            mm = mm < 10 ? "0" + mm : mm;
            ss = ss < 10 ? "0" + ss : ss;

            let time = `${hari}, ${tanggal} ${bulan} ${tahun}\n${hh}:${mm}:${ss}`;

            document.getElementById("waktu").innerText = time;
            var t = setTimeout(function(){
                currentTime();
            }, 1000);
            
        }
        currentTime();
        
    </script>
    @stack('scripts')
</body>

</html>