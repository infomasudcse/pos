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
                <h5 class="m-0">Update {{ $title }}</h5>
              </div>
              <div class="card-body">
                
              <form class="form-horizontal" action="/inventories/{{ $inventory->id }}" method="POST" >
                @csrf
                @method('PUT')
                <div class="card-body">

                
                 <div class="form-group row">
                    <label for="branch" class="col-sm-2 col-form-label">Select Branch</label>
                    <div class="col-sm-8">
                      <select id="branch" name="branch_id" class="form-control is-warning">
                          @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}"  <?=(($inventory->branch_id==$branch->id)?'selected':'')?>> {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 error-branch"></div>
                  </div>
                  
                 <div class="form-group row">
                    <label for="qty" class="col-sm-2 col-form-label">Quantity</label>
                    <div class="col-sm-8">
                      <input type="number" name="qty" class="form-control is-warning" id="qty"  value="{{ $inventory->qty }}">
                    </div>
                    <div class="col-sm-2 error-qty"></div>
                </div>
                <div class="form-group row">
                    <label for="costp" class="col-sm-2 col-form-label">Cost Price</label>
                    <div class="col-sm-8">
                      <input type="number" step=".01" name="costp" class="form-control is-warning" id="costp"  value="{{ $inventory->cost_price }}">
                    </div>
                    <div class="col-sm-2 error-costp"></div>
                </div>
                <div class="form-group row">
                    <label for="salep" class="col-sm-2 col-form-label">Sale Price</label>
                    <div class="col-sm-8">
                      <input type="number" step=".01" name="salep" class="form-control is-warning" id="salep"  value="{{ $inventory->unit_price }}">
                    </div>
                    <div class="col-sm-2 error-salep"></div>
                </div>

                 <div class="form-group row custom-color-row-two">
                   <div class="col-sm-2">
                      <p>Item Variation</p>
                      <p class="text-danger">No Change ?? Dont Change !!</p>
                    </div>
                   <div class="col-sm-8">
                       @foreach ($variations as $variation)


                      <div class="row mt-2 mb-2">
                        <div class="col-sm-5">
                            <label class="form-label text-center">{{ $loop->iteration}} . {{ $variation['v_name'] }}</label>
                        </div>
                        <div class="col-sm-5">
                            
                            <select  name="vaval_id[]" class="form-control">
                                <option value="">Select</option>
                              @foreach ($variation['variationvals'] as $vals)
                                <option value="{{ $vals->id }}" > {{ $vals->value }} </option>

                              @endforeach
                            </select>
                        </div>                                                
                      </div>

                      @endforeach
                   </div>
                    
                </div>  



                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success btn-lg">Update</button>
                  
                </div>
                <!-- /.card-footer -->
              </form>




              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</div>



@endsection