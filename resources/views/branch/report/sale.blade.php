

@extends('pos')



@section('content')

 <!-- Content Header (Page header) -->

 <div class="content-header">

      <div class="container">

        <div class="row">

          <!-- use this space for notify user -->

           <div class="col-sm-12">

            <h2> Date: {{ $from_to }}</h2>

          </div>

          <div class="col-sm-12">

              <table style="width:100%;text-align:center;" id="headerTable">

                <tr><td><img src="{{ asset('images/logo.png') }}" alt="logo" /></td></tr>

                <tr><td>{{ ucwords($branchinfo->title) }}</td></tr>

                <tr><td>{{ ucwords($branchinfo->address) }}</td></tr>

                <tr><td>{{ $branchinfo->phone }}</td></tr>

                <tr><td style="text-align:right;">Musak: {{ $branchinfo->musak }}</td></tr>
                <tr><td style="text-align:right;">BIN: {{ $branchinfo->bin }}</td></tr>

              </table>

          </div>



         



        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

</div>

    <!-- /.content-header -->



    <!-- Main content -->

<div class="content">

      <div class="container">

        <div class="row">

          <div class="col-md-12">

            <div class="card card-outline card-primary">

              <div class="card-header">

                <h3 class="card-title">Sales</h3>                

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body">

                    <table class="table">

                      <tr>

                        <th>SaleID</th>

                        <th>Items</th>

                        <th>Subtotal</th>

                        <th>Total Sale</th>

                        <th>Payment</th>

                        <th>Tax</th>

                        <th>Discount</th>

                      </tr>

                      

                    @foreach($sales as $sale)

                        <tr class="details pointer" data-id="{{$sale->id}}">

                          <td><a href="{{ url('/sales/receipt/'.$sale->id)}}" class="clink" target="_blank">{{ Helper::viewSaleId($sale->id) }}</a></td>

                          <td>{{ $sale->total_item }}</td>

                          <td>{{ Helper::toCurrency($sale->subtotal) }}</td>

                          <td>{{ Helper::toCurrency($sale->total_sale) }} </td>

                          <td>{{ Helper::toCurrency($sale->total_payment) }}</td>

                          <td>{{ Helper::toCurrency($sale->total_tax) }}</td>

                          <td>{{ Helper::toCurrency($sale->total_discount) }}</td>

                        </tr>

                        <tr style="display:none;" id="details{{$sale->id}}">

                          <td colspan="6">

                              

                                  <table class="table">

                                      <tr>

                                        <th>SKU</th>

                                        <th>Qty</th>

                                        <th>Cost Price</th>

                                        <th>Unit Price</th>                                        

                                        <th>Tax Amount</th>

                                      </tr>

                                  @foreach($sale->saleitems as $item)

                                      <tr>

                                        <td>{{ $item->sku }}</td>

                                        <td>{{ $item->qty }}</td>

                                        <td>{{ Helper::toCurrency($item->cost_price) }}</td>

                                        <td>{{ Helper::toCurrency($item->unit_price) }}</td>

                                        <td>{{ Helper::toCurrency($item->tax_amount) }} ({{ $item->tax_code }}%)</td>

                                      </tr>                                          

                                   

                                  @endforeach

                               </table>

                          </td>

                        </tr>  



                        @endforeach 

                    </table>

                   



                   <div class="bg-gray disabled color-palette p-3 mt-2">

                      @foreach($summary as $summ)

                     <h4>Total Items : {{ $summ->items }}</h4>
                     <h4>Sub total : {{ Helper::toCurrency($summ->subtotal) }}</h4>

                     <h4>Total Tax : {{ Helper::toCurrency($summ->taxs) }}</h4>

                     <h4>Total Discount : {{ Helper::toCurrency($summ->discounts) }}</h4>

                     <h4>Total Sale : {{ Helper::toCurrency($summ->totals) }}</h4>

                    @endforeach 

                   </div>



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