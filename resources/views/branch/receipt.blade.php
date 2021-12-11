@extends('pos')



@section('content')


<div class="">

      <div class="container">

        <div class="row mb-2">

          <div class="col">        

             <!-- use this space for notify user -->

            @if (session('status'))

              <div class="alert-warning">

                  {{ session('status') }}

              </div>

            @endif

            @if ($errors->any())

              <div class="alert-danger">

                  <ul>

                      @foreach ($errors->all() as $error)

                          <li>{{ $error }}</li>

                      @endforeach

                  </ul>

              </div>

            @endif

          </div>

        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content-header -->



    <!-- Main content -->

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

                          <td style="text-align:left;">{{ $content->name }}<br/>{{ $content->id }}</td>

                          <td style="text-align:center;">{{ $content->qty }}</td>

                          <td style="text-align:center;">{{ $content->price }}</td>

                          <td style="text-align:right;">{{ Helper::toCurrency($content->price * $content->qty) }}</td>

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

                    <td>{{ ucwords($paid['payment_type']) }}</td>

                    <td style="text-align:right;">{{ Helper::toCurrency($paid['amount']) }}</td>

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

        <!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>
</div>
<script type="text/javascript">

  document.addEventListener('DOMContentLoaded', function() {

   print_this('receiptDiv');

}, false);



</script>





    @endsection 