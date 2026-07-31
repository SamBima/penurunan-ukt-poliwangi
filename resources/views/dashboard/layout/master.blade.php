<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Penurunan UKT Poliwangi</title>

    <link href="{{ url('assets/dashboard/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ url('assets/dashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f1f5f9 !important;
            color: #334155;
        }
        #content-wrapper {
            background-color: #f1f5f9 !important;
        }
        .sidebar-light .nav-item .nav-link {
            color: #475569 !important;
            font-weight: 500;
            padding: 12px 20px !important;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        .sidebar-light .nav-item .nav-link i {
            color: #94a3b8 !important;
            margin-right: 10px;
            font-size: 16px;
        }
        .sidebar-light .nav-item.active .nav-link {
            color: #0284c7 !important;
            background-color: #f0f9ff !important;
            font-weight: 600;
            border-left: 4px solid #0284c7;
        }
        .sidebar-light .nav-item.active .nav-link i {
            color: #0284c7 !important;
        }
        .card {
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
            overflow: hidden;
        }
        .card-header {
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .table {
            color: #334155 !important;
            margin-bottom: 0 !important;
        }
        .table thead th {
            background-color: #2b7cb6 !important;
            color: #ffffff !important;
            font-weight: 600;
            border: none !important;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 14px 16px !important;
        }
        .table tbody td {
            padding: 14px 16px !important;
            vertical-align: middle !important;
            border-top: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            font-size: 14px;
        }
        .table-responsive {
            border: none !important;
        }
    </style>

    @stack('style')
</head>

<body id="page-top">

    <div id="wrapper">

        @include('dashboard.layout.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                @include('dashboard.layout.navbar')

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Poliwangi {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('assets/dashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ url('assets/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('assets/dashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('assets/dashboard/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ url('assets/dashboard/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('assets/dashboard/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ url('assets/dashboard/js/demo/chart-pie-demo.js') }}"></script>

    @stack('scripts')
</body>

</html>
