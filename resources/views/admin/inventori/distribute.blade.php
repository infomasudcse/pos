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
          <div class="col-lg-6">
            <div class="card card-secondary card-outline">
              <div class="card-header">
                    
                     <div class="row">                     
                          <div class="col-sm-12">

                      <?php  $select_branch = session('branch_for_transfer');
                            if($select_branch){ ?>      

                           <form class="ml-0 ml-md-3" id="" method="POST" action="{{ url('helper/addToAdminTransfer') }}">
                           @csrf  
                              <div class="form-group">
                                 <input type="text" class="form-control is-warning" id="iteminput" name="sku" placeholder="Scan item or enter sku ..." autocomplete="off">
                              </div>
                            </form> 
                       <?php }else{ echo '<div class="alert alert-warning"> <h3>Set Branches First ! </h3> </div>';} ?>     

                          </div>
                    </div>                   
               
              </div>
              <div class="card-body">
                
                <?php 

                    $transItems =  session('adminTrans');
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
          <div class="col-lg-6">
            <div class="card card-secondary card-outline"> 

            <div class="card-header">
              Transfer
            </div>             
              <div class="card-body">
                
                <div class="row">                     
                          <div class="col-sm-10">

                           <?php
                               
                               
                                if(!$select_branch){ 
                              ?>      


                            <form class="ml-0 ml-md-3" id="selectbranchform" method="POST" action="{{ url('helper/setBranchForTransfer') }}">
                           @csrf

                              <input type="hidden" name="from_branch_name" id="from_branch_name"  value="" />
                              <input type="hidden" name="to_branch_name" id="to_branch_name" value="" />

                              <div class="form-group">
                                <label>From</label>

                                 <select name="from_branch" class="form-control" id="from_branch_id">
                                  <option>Select Branch</option>
                                  @foreach($branches as $branch)
                                   <option value="{{ $branch->id }}" >{{ $branch->title }}</option>
                                   @endforeach
                                 </select>
                              </div>

                               <div class="form-group">
                                <label>To</label>

                                 <select name="to_branch" class="form-control" id="to_branch_id">
                                  <option>Select Branch</option>
                                  @foreach($branches as $branch)
                                   <option value="{{ $branch->id }}" >{{ $branch->title }}</option>
                                   @endforeach
                                 </select>
                              </div>
                               <div class="form-group">
                                <label></label>

                                 <button type="submit" class="btn btn-info btn-sm">Set Branches</button>
                              </div>


                            </form> 


                          <?php  }else{  ?>
                            <form class="ml-0 ml-md-3" id="selectbranchform" method="POST" action="{{ url('helper/startMassDistribute') }}">
                           @csrf                           
                           

                            <h5 class="p-3" > From: {{ $select_branch['from_branch_name'] }}   [ <a href="{{ url('helper/startOverDistribute') }}" > start again </a> ]</h5>

                            <h5 class="p-3" > To: {{ $select_branch['to_branch_name'] }}</h5>

                            <button type="submit" onclick="askConfirm()" class="btn btn-success btn-sm">Distribute Now</button>

                         <?php  } ?>

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