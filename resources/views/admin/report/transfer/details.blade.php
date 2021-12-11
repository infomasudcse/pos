@extends('admin')



@section('content')

 <!-- Content Header (Page header) -->

 <div class="content-header">

      <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12"><button type="button" onClick="return  print_this('receiptDiv') " class=" float-right btn btn-sm btn-default">Print</button></div>
        </div>

      </div><!-- /.container-fluid -->

</div>

    <!-- /.content-header -->



    <!-- Main content -->

<div class="content" id="receiptDiv">

      <div class="container-fluid">
        <div class="row">
          <div class="col">
              <table id="receiptTable" style="width:100%;" cellpadding="3" >
              <tr>
                  <td>
                  <table style="width:100%;border-bottom: 2px red solid;text-align:center;" id="headerTable">
                    <tr><td><img src="{{ asset('images/logo.png') }}" alt="logo" /></td></tr>
                    <tr><td>{{ ucwords($config->address) }}</td></tr>
                    <tr><td>{{ ucwords($config->contact) }}</td></tr>
                    
                   
                  </table>
                </td>
              </tr>
              
          </table>
          </div>
        </div>

        <div class="row">

          <!-- use this space for notify user -->

          <div class="col">

            <h2> Date: {{ $from_to }}</h2>
            <h3>Branch: {{ $from_to_branch }}</h3>
          </div>



        </div><!-- /.row -->

        <div class="row">

          <div class="col-md-12">

            <div class="card card-outline card-primary">

              <div class="card-header">

                <h3 class="card-title">Distributes</h3>                

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body">
              
                    <table class="table" width="100%" style="text-align:center" >

                      <tr>

                        <th>SL.</th>
                        <th>SKU</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>

                      </tr>                      

                      @foreach($transfers as $trans)

                        <tr>

                          <td>{{ $loop->iteration }}</td>

                          <td>{{ $trans->sku }}</td>

                          <td>{{ $trans->qty }} </td>
                          <td>{{ $trans->unit_price }}</td>
                          <td>{{ $trans->from_branch }} </td>
                          <td>{{ $trans->to_branch }} </td>
                          <td>{{ $trans->created_at }} </td>

                        </tr>

                        @endforeach  

                    </table>

                    <h3>Total Qty : {{ $totQty }}</h3>
                    <h3>Total Cost : {{ $totTotal }}</h3>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>         

            





        </div>

        

        <!-- /.row -->

      </div><!-- /.container-fluid -->

</div>





@endsection