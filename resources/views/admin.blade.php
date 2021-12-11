<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta http-equiv="x-ua-compatible" content="ie=edge">

<?php  $subtitle = $subtitle??''; $newTitle = $title ?? 'Dashboard';  ?>

  <title>{{ $newTitle }}</title>



  <!-- Font Awesome Icons -->

  <link rel="stylesheet" href="{{ asset('alte/fontawesome-free/css/all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('alte/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

  <!-- Theme style -->

  <link rel="stylesheet" href="{{ asset('alte/css/adminlte.min.css') }}">

  <link rel="stylesheet" href="{{ asset('alte/css/custom.css') }}">

  <!-- Google Font: Source Sans Pro -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">



  <!-- Navbar -->

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->

    <ul class="navbar-nav">

      <li class="nav-item">

        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>

      </li>

     

    </ul>



    <!-- SEARCH FORM -->

    <div class="ml-5">

     



      <h4>{{ $newTitle }}</h4>

    </div>



    <!-- Right navbar links -->

    <ul class="navbar-nav ml-auto">

      

      <li class="nav-item dropdown">

        <a class="nav-link" data-toggle="dropdown" href="#">

          <i class="fas fa-th-large"></i>

          <!-- <span class="badge badge-warning navbar-badge">15</span> -->

        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          <span class="dropdown-header">{{ Auth::user()->name }}</span>

          <div class="dropdown-divider"></div>

         

          <form method="POST" action="{{ route('logout') }}" >

            @csrf

            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();this.closest('form').submit();">

              <i class="fas fa-users mr-2"></i> Logout            

            </a>

                           

            </form>

          <div class="dropdown-divider"></div>

          

          <span class="dropdown-footer"></span>

         

        </div>

      </li>

     

    </ul>

  </nav>

  <!-- /.navbar -->



  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="{{ route('dashboard') }} " class="brand-link">

      <img src="{{ asset('images/mono.png') }}" alt="Company Logo" class="brand-image img-circle elevation-3"

           style="opacity: .8">

      <span class="brand-text font-weight-light">{{ Auth::user()->name }}</span>

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

     <!--  <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="{{ asset('alte/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">

        </div>

        <div class="info">

          <a href="#" class="d-block">{{ Auth::user()->name }}</a>

        </div>

      </div> -->



      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->

           <li class="nav-item">

            <a href="{{ url('/report') }}" class="nav-link <?=(($newTitle=='Report')?'active':'');?>">

              <i class="nav-icon fas fa-chart-bar"></i>

              <p>Report </p>

            </a>

          </li>    

          <li class="nav-item has-treeview <?=(($newTitle=='Inventory')?'menu-open':'');?>">

            <a href="#" class="nav-link  <?=(($newTitle=='Inventory')?'active':'');?>">

              <i class="nav-icon fas fa-list"></i>

              <p>Inventory<i class="right fas fa-angle-left"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="{{ url('inventory/massDistribute') }}" class="nav-link ">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Distribute</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="{{ route('inventories.index') }}" class="nav-link ">

                  <i class="far fa-circle nav-icon"></i>

                  <p>List</p>

                </a>

              </li>

               <li class="nav-item">

                <a href="{{ route('inventories.create') }}" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Create New</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item has-treeview <?=(($newTitle=='Item')?'menu-open':'');?>">
            <a href="#" class="nav-link  <?=(($newTitle=='Item')?'active':'');?>">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Items<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('items.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item List</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('items.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Item</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?=(($newTitle=='Item-Settings')?'menu-open':'');?>">
            <a href="#" class="nav-link  <?=(($newTitle=='Item-Settings')?'active':'');?>">
              <i class="nav-icon fas fa-drum-steelpan"></i>
              <p>Item Settings<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('subcategories.index') }}" class="nav-link <?=(($subtitle=='Sub Category')?'active':'');?>">
                  <i class="nav-icon fab fa-pagelines"></i>
                  <p>Sub Category </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link <?=(($subtitle=='Category')?'active':'');?>">
                  <i class="nav-icon fas fa-tree"></i>
                  <p>Category </p>
                </a>
              </li>
              <li class="nav-item">
              <a href="{{ route('variationvals.index') }}" class="nav-link  <?=(($subtitle=='Variation value')?'active':'');?>">
                <i class="nav-icon fab fa-creative-commons-nd"></i>
                <p>Variation Value </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('variations.index') }}" class="nav-link  <?=(($subtitle=='Variations')?'active':'');?>">
                <i class="nav-icon fab fa-blackberry"></i>
                <p>Variations </p>
              </a>
            </li>

            </ul>
          </li>

           <li class="nav-item">

            <a href="{{ route('employees.index') }}" class="nav-link  <?=(($newTitle=='Employees')?'active':'');?>">

              <i class="nav-icon fas fa-user-tie"></i>

              <p>Employee </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="{{ route('branches.index') }}" class="nav-link  <?=(($newTitle=='Branches')?'active':'');?>">

              <i class="nav-icon fab fa-hubspot"></i>

              <p> Branches </p>

            </a>

          </li>

          
          <li class="nav-item has-treeview <?=(($newTitle=='Configuration')?'menu-open':'');?>">
            <a href="#" class="nav-link  <?=(($newTitle=='Configuration')?'active':'');?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>Configuration<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('expensetype.index') }}" class="nav-link <?=(($subtitle=='Expense-Type')?'active':'');?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expense Type</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('configs.index') }}" class="nav-link <?=(($subtitle=='Config')?'active':'');?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>System Configuration</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

      <!--Content -->

    

     @yield('content')

   

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->



 



   

</div>

<!-- ./wrapper -->



<!-- REQUIRED SCRIPTS -->



<!-- jQuery -->

<script src="{{ asset('alte/js/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap 4 -->

<script src="{{ asset('alte/js/bootstrap.bundle.min.js') }}"></script>

<!-- DataTables -->

<script src="{{ asset('alte/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('alte/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- AdminLTE App -->

<script src="{{ asset('alte/js/adminlte.min.js') }}"></script>

<!--admin panel -->

<script src="{{ asset('alte/js/custom.js') }}"></script>



<?php if($newTitle=='Index'){ ?>

<!-- load only on dashboard -->

<!--FLOT CHARTS -->

<script src="{{ asset('alte/js/flot/jquery.flot.js') }}"></script>

<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized  -->

<script src="{{ asset('alte/js/flotold/jquery.flot.resize.min.js') }}"></script>

<script src="{{ asset('alte/js/chart.js') }}"></script>

<?php } ?> 

</body>

</html>