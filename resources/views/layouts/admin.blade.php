<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'QuantLight') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        .brand-link {
            border-bottom: 1px solid #4b545c;
        }

        .brand-text {
            font-weight: 600;
        }

        .brand-text span {
            color: #c9a96e;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #c9a96e;
            color: #fff;
        }

        .btn-primary {
            background-color: #c9a96e;
            border-color: #c9a96e;
        }

        .btn-primary:hover {
            background-color: #b8975d;
            border-color: #b8975d;
        }

        .card-primary.card-outline {
            border-top: 3px solid #c9a96e;
        }

        .nav-pills .nav-link.active {
            background-color: #c9a96e;
        }

        a {
            color: #c9a96e;
        }

        a:hover {
            color: #b8975d;
        }

        .page-item.active .page-link {
            background-color: #c9a96e;
            border-color: #c9a96e;
        }

        .content-wrapper {
            background-color: #f4f6f9;
        }
    </style>

    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link" target="_blank">View Site</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-image img-circle elevation-3"
                    style="opacity: .8; background: #c9a96e; width: 33px; height: 33px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fas fa-atom" style="color: #fff;"></i>
                </span>
                <span class="brand-text font-weight-light"><span>Quant</span>Light</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-circle fa-2x text-light"></i>
                    </div>
                    <div class="info">
                        <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Citations/Publications -->
                        <li class="nav-item {{ request()->routeIs('admin.citations.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.citations.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Citations
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.citations.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.citations.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Citations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.citations.create') }}"
                                        class="nav-link {{ request()->routeIs('admin.citations.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New Citation</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Lab Updates (Discoveries) -->
                        <li class="nav-item {{ request()->routeIs('admin.lab-updates.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('admin.lab-updates.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-flask"></i>
                                <p>
                                    Lab Updates
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.lab-updates.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.lab-updates.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Lab Updates</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.lab-updates.create') }}"
                                        class="nav-link {{ request()->routeIs('admin.lab-updates.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Contact Submissions -->
                        <li class="nav-item">
                            <a href="{{ route('admin.contact-submissions.index') }}"
                                class="nav-link {{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Contact Submissions
                                    @php
                                        $unreadCount = \App\Models\ContactSubmission::count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="badge badge-info right">{{ $unreadCount }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <!-- Separator -->
                        <li class="nav-header">SETTINGS</li>

                        <!-- Profile -->
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="/">QuantLight</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    @yield('scripts')
</body>

</html>