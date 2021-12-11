<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ $title }} </title>
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
            <?php  
                  $role = Auth::user()->role;
                  if($role=='admin'){
                      $action = '/dashboard';
                  }else{
                    $action = '/sales';
                  }

            ?>

            <a href="{{ url($action)}}" class="nav-link">Back</a>
          </li>
        </ul>        
      </div>
    </div>
  </nav>

  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"><button type="button" onClick="return  print_this('receiptDiv') " class=" float-right btn btn-sm btn-default">Print</button></div>
      <div class="col-lg-12">
        <div class="card card-primary card-outline">
          <div class="card-body">
          <!-- start receipt --->
<div id="receiptDiv" style="width:100%;min-height:500px;">
    <table id="receiptTable" style="width:100%;" cellpadding="3" >
        <tr>
            <td>
            <table style="width:100%;border-bottom: 2px red solid;text-align:center;" id="headerTable">
              <tr><td><img src="{{ asset('images/logo.png') }}" alt="logo" /></td></tr>
              <tr><td>{{ ucwords($config->address) }}</td></tr>
              <tr><td>{{ ucwords($config->contact) }}</td></tr>
               
              @if($owner=='yes')               
              <tr><td>Proprietor : {{ ucwords($config->owner_name) }}</td></tr>
              @endif
            </table>


          </td>
        </tr>
        <tr>
          <td>Date: {{ date('d-m-Y', strtotime($date)) }}</td>
        </tr>
        
    </table>
<!-----end receipt--->               

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  

  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
  <footer class="main-footer">
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
</body>
</html>