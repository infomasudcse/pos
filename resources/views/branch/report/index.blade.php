

@extends('pos')



@section('content')

 <!-- Content Header (Page header) -->

 <div class="content-header">

      <div class="container">

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

           <h3 class="text-center">Report</h3>   
            <hr style="border-top: 3px solid rgb(255 3 3);"/>

          </div>



          



        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

</div>

    <!-- /.content-header -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>









    <!-- Main content -->

<div class="content">

      <div class="container">

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

                    <li><a href="{{ url('branchReport/todayDetails') }}" > Today</a></li>

                 <!--    <li><span data-tokenfrom="{{ url('HelperController/getCSRF') }}" data-action="{{ url('branchReport/saleDetails') }}" data-toggle="modal" data-target="#reportModal" class="clink">History</span></li>
 -->
                    

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

                    <!-- <li>History</li> -->

                </ol>

              </div>

              <!-- /.card-body -->

            </div>

            <!-- /.card -->

          </div>                   

          <!-- /.col -->

          

        </div>

        

        <!-- /.row -->

      </div><!-- /.container-fluid -->

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

            <input type="text"  placeholder="dd/mm/yyyy" class="form-control datepicker" name="fromDate" id="fromdate" autocomplete="off" />

          </div>

           <div class="form-group">

            <label for="toDate" class="col-form-label">To : </label>

            <input type="text" placeholder="dd/mm/yyyy" class="form-control datepicker" name="toDate" id="toDate"  autocomplete="off" />

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

    