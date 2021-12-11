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
<div id="receiptDiv" style="width:100%;">
    <table id="receiptTable" style="width:100%;" cellpadding="3" >
        <tr>
            <td>
        <table style="width:100%;text-align:center;" id="headerTable">
          <tr><td><img src="{{ asset('images/logo.png') }}" alt="logo" /></td></tr>
          <tr><td>{{ ucwords($branchinfo->title) }}</td></tr>
          <tr><td>{{ ucwords($branchinfo->address) }}</td></tr>
          <tr><td>{{ $branchinfo->phone }}</td></tr>
         
          <tr><td style="text-align:right;">Musak: {{ $branchinfo->musak }}</td></tr>
          <tr><td style="text-align:right;">BIN: {{ $branchinfo->bin }}</td></tr>
              </table>
            </td>
        </tr>
        <tr>
            <td>
              <table style="width:100%;" id="subHeaderTable">
                <tr><td>SaleID: {{ Helper::viewSaleId($sale->id) }}</td><td style="text-align:right;">Date: {{ $sale->created_at }}</td></tr>
                <tr><td>Salesman: {{ $salesman }}</td><td style="text-align:right;">Customer:  </td></tr>                
              </table>
            </td> 
        </tr>
    <tr>
            <td>
              <table id="bodyTable" style="width:100%;">
                <thead style="border-top: 1px solid #aaa; border-bottom: 1px solid #aaa;">
                  <th style="text-align:left;">Item</th>
                  <th  style="text-align:center;">Qty</th>
                  <th  style="text-align:center;">Price</th>
                  <th  style="text-align:right;">Amount</th>
                </thead>
                <tbody>
                    @foreach($cartContent as $content)
                    <tr style="border-bottom:1px solid #ccc;">
                        <td style="text-align:left;">{{ $content->name }}<br/>{{ $content->sku }}</td>
                        <td style="text-align:center;">{{ $content->qty }}</td>
                        <td style="text-align:center;">{{ $content->unit_price }}</td>
                        <td style="text-align:right;">{{ Helper::toCurrency($content->unit_price * $content->qty) }}</td>
                    </tr>
                    @endforeach
                </tbody> 
              </table>
            </td>  
        </tr>
    <tr>
            <td>
        <table style="width:100%;" id="footerTable">
                <tr>
          <td>SubTotal</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->subtotal) }} </td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->total_tax) }}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->total_discount) }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->total_sale) }}</td>
                </tr>
                <tr>
                    <td>Payment</td>
                    <td style="text-align:right;"></td>
                </tr>    
              </table>
            </td>  
        </tr>
        <tr>
            <td>
        <table style="width:100%;">
                @foreach($payments as $paid)
                <tr>
                    <td></td>
                    <td>{{ ucwords($paid->type) }}</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($paid->amount) }}</td>
                </tr> 
                @endforeach
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->total_payment) }}</td>
                </tr>
                <tr>
                    <td>Change</td>
                    <td></td>
                    <td style="text-align:right;">{{ Helper::toCurrency($sale->changeamount) }}</td>
                </tr>              
              </table>
            </td>  
        </tr>
        <tr>
            <td style="text-align:center;"><p><br/><br/><br/>{{ $config->return_policy }}<br/></p></td>  
        </tr>
        <tr>           
            <td style="text-align:center;"><p>Powered by:<br/> {{ $config->support }} : {{ $config->support_contact }}</p></td>
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