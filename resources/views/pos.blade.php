<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php  $newTitle = $title?? 'POS'; ?>
  <title>{{ $newTitle }} </title>

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('alte/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('alte/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('alte/css/register.css') }}">
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('images/mono.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3 justify-content-center" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
        
          <li class="nav-item">
            <a href="{{ route('sale') }}" class="nav-link">Sales</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Attendence</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Expense</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('branch-report') }}" class="nav-link">Report</a>
          </li>
          @if(Auth::user()->canTransfer==1)
          <li class="nav-item">
             <a href="{{ route('branch-transfer') }}" class="nav-link">Transfer</a>
          </li>
          @endif

        </ul>

        <!-- SEARCH FORM -->
        
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link disabled" href="#">            
            {{ Auth::user()->name }}
          </a>        
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <form method="POST" action="{{ route('logout') }}" >
            @csrf
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();this.closest('form').submit();">
               Logout            
            </a>
                           
            </form>          
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
              class="fas fa-th-large"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header)  class content-header has removed -->

    @yield('content')


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Copyright &copy; Branch Name.
    </div>
    <!-- Default to the left -->
    <strong>Software company</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('alte/js/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('alte/js/bootstrap.bundle.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('alte/js/adminlte.min.js') }}"></script>
<script src="{{ asset('alte/js/pos.js') }}"></script>
<?php if($newTitle=='Report'){ ?>
<!--load only on report -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('.datepicker').datepicker({format: 'yyyy-mm-dd',autoclose:true});
  });
</script>

<?php } ?> 

</body>
</html>