<!DOCTYPE html>
<html>
    <head>
        <title>Backyard<?php

        use App\Libraries\Mad\Helper;

        echo(isset($modelName) ? " - ".ucwords($modelName):'') ?></title>

        @yield('css-include-before')
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- AdminLTE -->
        <link rel="stylesheet" href="{{asset('vendor/adminlte/css/adminlte.min.css')}}">
        <!-- Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Datatable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <!-- MadStyleBackend -->
        <link rel="stylesheet" href="{{asset('helper/backend/styles.css')}}"/>
        @yield('css-include-after')
    </head>
    <body class="sidebar-mini layout-fixed layout-navbar-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <!-- Left Navbar -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="" class="nav-link" data-widget="pushmenu" role="button"><i class="fa fa-bars"></i></a>
                    </li>
                    <?php
                        $modules = require base_path('resources/views')."/modules.php";
                        echo(Helper::renderModule($modules, $moduleName));
                    ?>
                </ul>
                <!-- Right Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <?php
                            $profpic_filename = Auth::user()->photo_filename ? : "default.jpg";
                        ?>
                        <a class="nav-link" data-toggle="dropdown" href=""><img src="<?=asset("storage/profpic/$profpic_filename")?>" alt="User Avatar" class="img-circle mr-3" style="height:100%"> {{Auth::user()->name}}</a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="<?php echo route('backyard.user.profile.show', Auth::user()->id)?>" class="dropdown-item" >Profile</a>
                            <a href="<?= route('logout') ?>" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Left Sidebar -->
            <aside class="main-sidebar elevation-4 sidebar-dark-lime">
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php
                                $basePath = base_path('resources/views/menus');
                                $activeMenu = $moduleName ? "$moduleName.php" : "default.php";
                                $menus = require "$basePath/$activeMenu";
                                echo(Helper::renderMenus($menus));
                            ?>
                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- Content -->
            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">
                                    @yield('page-header')
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @yield('breadcrumb')
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>
            <!-- Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    Greengroceries
                </div>
            </footer>
        </div>
        <!-- Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <!-- Fontawesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- AdminLTE -->
        <script src="{{asset('vendor/adminlte/js/adminlte.min.js')}}"></script>
        <!-- Datatable -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <!-- Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <!-- MadHelperBackend -->
        <script src="{{asset('helper/backend/script.js')}}"></script>
        <script type="text/javascript">
            @yield('js-inline-data')
        </script>
        @yield('js-include')
        <script type="text/javascript">
            @yield('js-inline')
            $(function(){
                @if($message = Session::get('success'))
                    toastr.success('<?= $message ?>');
                @endif
                @if($message = Session::get('error'))
                    toastr.error('<?= $message ?>');
                @endif
                @if($message = Session::get('warning'))
                    toastr.notify('<?= $message ?>', 'yellow');
                @endif
                @if($message = Session::get('info'))
                    toastr.notify('<?= $message ?>', 'blue');
                @endif
                @if(isset($errors) && count($errors) > 0)
                    <?php
                    $message = implode('</br>', $errors->all());
                    ?>
                    toastr.error('<?= $message ?>');
                @endif
            });
        </script>
    </body>
</html>