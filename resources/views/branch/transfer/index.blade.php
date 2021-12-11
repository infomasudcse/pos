@extends('pos')

@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">

      <div class="container">
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
      <div class="container">
        <div class="row">         
          <div class="col-lg-8">
            <div class="card card-secondary card-outline">
              <div class="card-header">
                    
                     <div class="row">                     
                          <div class="col-sm-12">


                           <form class="ml-0 ml-md-3" id="" method="POST" action="{{ url('branchTransfer/addToBranchTransfer') }}">
                           @csrf  
                              <div class="form-group">
                                 <input type="text" class="form-control is-warning" id="iteminput" name="sku" placeholder="Scan item or enter sku ..." autocomplete="off">
                              </div>
                            </form> 
                       
                          </div>
                    </div>                   
               
              </div>
              <div class="card-body">
                
                <?php 

                    $transItems =  session('branchTrans');
                    if($transItems){

                ?>
                   <table id="distribute" class="table">
                    <thead>
                    <tr>
                      <th>SL</th>                      
                      <th>SKU</th>                                         
                      <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($transItems as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['sku'] }}</td>
                        <td>{{ $item['qty'] }}</td>
                        
                      </tr>
                      @endforeach

                    </tbody>
                  </table>
                <?php } ?>


              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-4">
            <div class="card card-secondary card-outline"> 

            <div class="card-header">
              Transfer
            </div>             
              <div class="card-body">
                
                <div class="row">                     
                          <div class="col-sm-12">
                          
                            <form class="ml-0 ml-md-3" id="selectbranchform" method="POST" action="{{ url('branchTransfer/startMassTransfer') }}">
                           @csrf                           
                           
                           <p class="float-right">[ <a href="{{ url('branchTransfer/startOverTransfer') }}" > start again </a> ]</p><br/>
                           	<h6>Total Items : {{ $itemCount }}</h6>
                            <h6 class="p-1" > From : {{ $fromBranch }}   </h5>

                            <h6 class="p-1" > To : {{ $toBranch }}</h5>

                            <button type="submit" onclick="askConfirm()" class="btn btn-success btn-sm">Transfer</button>

                      

                           </form> 

                          </div>
                    </div> 


              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</div>


@endsection