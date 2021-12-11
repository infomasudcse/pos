@extends('admin')



@section('content')

 <!-- Content Header (Page header) -->

 <div class="content-header">



      <div class="container-fluid">

        <div class="row">

          <div class="col">

            <!-- use this space for notify user -->

            @if (session('status'))

              <div class="alert alert-info">

                  {{ session('status') }}

              </div>

            @endif

            @if ($errors->any())

              <div class="alert alert-danger">

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

      <div class="container-fluid">

        <div class="row">         

          <div class="col-lg-12">

            <div class="card card-secondary card-outline">

              <div class="card-header">

                  <div class="row">
                    <div class="col">
                       <a href="{{ url('inventories/create') }}" title='Inventory' class='btn btn-flat btn-info btn-sm'> <i class='fas fa-list'> </i> Add New</a>
                    </div>

                      <div class="col"><h5 class="m-0 text-center">{{ $title }}</h5></div>
                     
                      <div class="col searchDiv">
                        <input type="text" class="float-right" id="searchSku" actionTo="{{ url('InventoryController/searchSku') }}"  />
                        <div class="list-group-div" id="search_result" data-fill="input-pick" style="position: absolute;top:30px;right:2%; display:none; max-height:200px; z-index: 10;width:52%;">

                          <ul class="list-group">



                          </ul>                     

                      </div>



                  </div>  



                    

              </div>

              <div class="card-body">

              <table id="inventori" class="table table-bordered">

                <thead>

                <tr>

                  <th>SL</th>

                  <th>SKU</th>

                  <th>Item</th>                

                  <th>Qty</th>

                  <th>Branch</th>

                  <th>Cost</th>

                  <th>Sale</th>

                  <th>More</th>                 

                  <th>Action</th>

                </tr>

                </thead>

                <tbody id="tableBody"> 



                  

                  @foreach ($inventories as $inventory)

                      <tr>

                         <?php 

                          $variations = json_decode($inventory->variation);

                          $str ='';

                          foreach($variations as $vary){

                            $str .= $vary->variation.':'.$vary->value.', ';

                          }

                          ?>

                          <td> {{ $loop->iteration }}</td>

                          <td>{{ $inventory->sku }}</td>

                          <td>{{ $inventory->item->name }}</td>

                          <td>{{ $inventory->qty }}</td>

                          <td>{{ $inventory->branch->name }} </td>

                          <td>{{ Helper::toCurrency($inventory->cost_price) }} </td>

                          <td>{{ Helper::toCurrency($inventory->unit_price) }} </td>

                          <td>{{ $str }} </td>

                          <td>

                            <div class='btn-group'>

                              <span  data-toggle="modal" data-target="#inventoryModal" data-inv="{{ $inventory->id }}" data-whatever="{{ $inventory->sku }}" data-qty="{{ $inventory->qty }}" class="btn mr-2 btn-default btn-sm btn-item-table" title="print Barcode" data-location="{{ url('HelperController/getCSRF') }}"><i class="fas fa-barcode"></i></span>

                              <span  data-toggle="modal" data-target="#transferModal" data-origin_inv_id="{{ $inventory->id }}" data-origin-code="{{ $inventory->sku }}" data-origin-branch="{{ $inventory->branch->name }}" data-origin-qty="{{ $inventory->qty }}" class="btn mr-2 btn-default btn-sm btn-item-table" title="Transfer to another branch"  data-location="{{ url('HelperController/getCSRF') }}"><i class="fas fa-share-square"></i></span>

                               <a type='button' title='Edit' href=" {{ url('inventories/'.$inventory->id.'/edit') }}" class='btn btn-sm btn-default mr-2 btn-item-table'><i class='fas fa-edit'></i></a>

                              <form action="{{ url('inventories/'. $inventory->id.'') }}" method='post'>

                                <input type='hidden' name='_token' value="{{ csrf_token() }}" />

                                <input type='hidden' name='_method' value='DELETE'/>

                                <button type='submit' title='Delete' class='btn btn-default btn-sm btn-item-table delete'  onClick='return askConfirm()' ><i class='fas fa-trash'></i></button>

                              </form>

                            </div>

                          </td>

                     </tr> 

                  @endforeach

                </tbody>               

              </table>

             

              </div>
              <div class="card-footer">  {{ $inventories->links() }} </div>

            </div>

          </div>

          <!-- /.col-md-6 -->

        </div>

        <!-- /.row -->

      </div><!-- /.container-fluid -->

</div>



<!-- Start Modal -->





<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">New BarCode</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" action="{{ url('helper/printBarcode') }}" method="POST">



      <div class="modal-body">

          <input type="hidden" name="_token" value="" id="tok"/>

           <input type="hidden" name="data_inv" value="" id="data_inv"/>

          <div class="form-group">

            <label for="sku" class="col-form-label">Item SKU : </label>

            <input type="number" class="form-control" name="sku" id="sku" readonly/>

          </div>

          <div class="form-group">

            <label for="quantity" class="col-form-label">Quantity:</label>

            <input type="number" name="qty" class="form-control" id="quantity">

          </div>

        

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Print Barcode</button>

      </div>

      </form>

    </div>

  </div>

</div>





<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Item Transfer</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" action="{{ url('helper/transferTo') }}" method="POST">

      <div class="modal-body">

          <input type="hidden" name="_token" value="" id="ttok"/>

           <input type="hidden" name="data_origin_inv" value="" id="data_origin_inv"/>

          <div class="form-group">

            <label for="fb" class="col-form-label">From Branch : </label>

            <input type="text" class="form-control" id="fb" readonly/>

          </div>

          <div class="form-group">

            <label for="tsku" class="col-form-label">Item SKU : </label>

            <input type="number" class="form-control" name="sku" id="tsku" readonly/>

          </div>

          <div class="form-group">

            <label for="tquantity" class="col-form-label">Quantity:</label>

            <input type="number" name="qty" class="form-control" id="tquantity">

          </div>

          <div class="form-group">

            <label for="tb" class="col-form-label">Where To Transfer:</label>

            <select name="tobranch" class="form-control" id="tb">

              @foreach($branches as $branch)

                <option value="{{ $branch->id }}"> {{ $branch->title }}</option>

              @endforeach

            </select>

          </div>





        

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-warning">Transfer</button>

      </div>

      </form>

    </div>

  </div>

</div>











<!-- End Modal -->





@endsection