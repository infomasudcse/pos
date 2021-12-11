@extends('admin')



@section('content')

 <!-- Content Header (Page header) -->

 <div class="content-header">

      <div class="container-fluid">

        <div class="row">

          <!-- use this space for notify user -->

           <div class="col">

            <!-- use this space for notify user -->

            @if (session('status'))

              <div class="alert alert-success">

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

   
    <!-- Main content -->

<div class="content">

      <div class="container-fluid">

        <div class="row">

          <div class="col-md-4">

            <div class="card card-outline card-primary">

              <div class="card-header">

                <h3 class="card-title">Sales</h3>                

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>

                    <li><a href="{{ url('report/sale/today') }}">Today</a></li>



                    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('report/sale/summary') }}" data-toggle="modal" data-target="#reportModal" class="clink"> Summary Sale</span></li>



                    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('report/sale/details') }}" data-toggle="modal" data-target="#reportModal" class="clink">Details Sale</span></li>

                    

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>         

          <!-- /.col -->

           <div class="col-md-4">

            <div class="card card-outline card-warning">

              <div class="card-header">

                <h3 class="card-title">Attendence</h3>

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>

                    <li>Today</li>                    

                    <li>History</li>

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>         

          <!-- /.col -->

           <div class="col-md-4">

            <div class="card card-outline card-success">

              <div class="card-header">

                <h3 class="card-title">Expense</h3>               

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>

                    <li>Today</li>

                    <li>Summary</li>

                    <li>History</li>

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>                   

          <!-- /.col -->

           <div class="col-md-4">

            <div class="card card-outline card-primary">

              <div class="card-header">

                <h3 class="card-title">Inventory</h3>               

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>                    
                    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('report/todayinventory') }}" data-toggle="modal" data-target="#inventoryToday" class="clink"> Today Inventory</span></li>

                    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('report/presentinventory') }}" data-toggle="modal" data-target="#inventoryReportModal" class="clink"> Current Inventory</span></li>

                    <li>Finish Item</li>

                    <li>History</li>

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div> 



           <div class="col-md-4">

            <div class="card card-outline card-warning">

              <div class="card-header">

                <h3 class="card-title">Payment</h3>               

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>

                    <li>Today</li>

                    <li>History</li>

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div> 



           <div class="col-md-4">

            <div class="card card-outline card-success">

              <div class="card-header">

                <h3 class="card-title">Distribute</h3>               

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>

                    <li><a href="{{ url('report/distribute/today') }}">Today</a></li>

                    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('report/distribute/history') }}" data-toggle="modal" data-target="#distributeModal" class="clink"> History</span></li>

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div> 
          <div class="col-md-4">

            <div class="card card-outline card-info">

              <div class="card-header">

                <h3 class="card-title">Pad</h3>               

                <!-- /.card-tools -->

              </div>

              <!-- /.card-header -->

              <div class="card-body" style="display: block;padding:0.75rem;">

                <ol>                    
                     <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('PreviewController/printPad') }}" data-toggle="modal" data-target="#padModal" class="clink"> Print</span></li>
                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>





        </div>

        

        <!-- /.row -->

      </div><!-- /.container-fluid -->

</div>

<div class="modal fade" id="padModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Pad Input</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" id="actionForm"  method="POST">



      <div class="modal-body">

          <input type="hidden" name="_token" id="tok" value="" />     

          <div class="form-group">

            <label for="fromdate" class="col-form-label">Select Date:</label>
             <input type="date"  placeholder="mm/dd/yyyy" class="form-control" name="fromDate" id="fromdate" autocomplete="off" required/>

            

          </div>


          <div class="form-group">
                        <div class="form-check">
                          <input class="form-check-input" value="no" type="radio" name="owner">
                          <label class="form-check-label">No Proprietor Name</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" value="yes" type="radio" name="owner" checked="">
                          <label class="form-check-label">Yes Proprietor Name</label>
                        </div>
                       
                      </div>



      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>


<!-- Inventory report mmodal -->
<!-- inventory Today -->
<div class="modal fade" id="inventoryToday" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Today Inventory Report Input</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="" id="actionForm"  method="POST">
      <div class="modal-body">
        <input type="hidden" name="_token" id="tok" value="" />
        <div class="form-group">
            <label for="branch" class="col-form-label">Select Branch:</label>
            <select name="branch" class="form-control" id="branch">
              <option value="0">All</option>
              @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->title }}</option>
              @endforeach
            </select>
          </div>       

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>

<!-- Inventory Report Modal -->
<div class="modal fade" id="inventoryReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Inventory Report Input</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" id="actionForm"  method="POST">



      <div class="modal-body">

          <input type="hidden" name="_token" id="tok" value="" />     

          <div class="form-group">

            <label for="branch" class="col-form-label">Select Branch:</label>

            <select name="branch" class="form-control" id="branch">

               <option value="0">All</option>

              @foreach($branches as $branch)

                <option value="{{ $branch->id }}">{{ $branch->title }}</option>

              @endforeach



            </select>

          </div>

            <div class="form-group">

            <label for="branch" class="col-form-label">Select Item:</label>

            <select name="item" class="form-control" id="branch">

               <option value="0">All</option>

              @foreach($items as $item)

                <option value="{{ $item->id }}">{{ $item->name }}</option>

              @endforeach



            </select>

          </div>


        

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>





<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Report Input</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" id="actionForm"  method="POST">



      <div class="modal-body">

          <input type="hidden" name="_token" id="tok" value="" />     

          <div class="form-group">  

            <label for="fromdate" class="col-form-label">From : </label>

            <input type="date"  placeholder="mm/dd/yyyy" class="form-control" name="fromDate" id="fromdate" autocomplete="off" />

          </div>

           <div class="form-group">

            <label for="toDate" class="col-form-label">To : </label>

            <input type="date" placeholder="mm/dd/yyyy" class="form-control" name="toDate" id="toDate"  autocomplete="off" />

          </div>

          <div class="form-group">

            <label for="branch" class="col-form-label">Branch:</label>

            <select name="branch" class="form-control" id="branch">

               <option value="">All ( No Details ) </option>

              @foreach($branches as $branch)

                <option value="{{ $branch->id }}">{{ $branch->title }}</option>

              @endforeach



            </select>

          </div>

        

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>



<div class="modal fade" id="distributeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Report Input</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form class="" id="actionForm"  method="POST">



      <div class="modal-body">

          <input type="hidden" name="_token" id="tok" value="" />     

          <div class="form-group">  

            <label for="fromdate" class="col-form-label">From : </label>

            <input type="date"  placeholder="mm/dd/yyyy" class="form-control" name="fromDate" id="fromdate" autocomplete="off" />

          </div>

           <div class="form-group">

            <label for="toDate" class="col-form-label">To : </label>

            <input type="date" placeholder="mm/dd/yyyy" class="form-control" name="toDate" id="toDate"  autocomplete="off" />

          </div>

          <div class="form-group">

            <label for="branch" class="col-form-label">From Branch:</label>

            <select name="frombranch" class="form-control" id="branch">              

              @foreach($branches as $branch)

                <option value="{{ $branch->id }}">{{ $branch->title }}</option>

              @endforeach



            </select>

          </div>
           <div class="form-group">

            <label for="branch" class="col-form-label">To Branch:</label>

            <select name="tobranch" class="form-control" id="branch">               

              @foreach($branches as $branch)

                <option value="{{ $branch->id }}">{{ $branch->title }}</option>

              @endforeach



            </select>

          </div>

        

      </div>

      <div class="modal-footer">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>

      </form>

    </div>

  </div>

</div>



@endsection