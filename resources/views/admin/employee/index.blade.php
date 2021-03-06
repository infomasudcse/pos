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
                      <div class="col"><h5 class="m-0">{{ $title }}</h5></div>
                      <div class="col"><a href="{{ url('employees/create') }}" class="btn btn-flat btn-primary float-right">New</a></div>

                  </div>  

                    
              </div>
              <div class="card-body">
              <table id="employeesTable" class="table table-bordered">
                <thead>
                <tr>                  
                  <th>Branch</th> 
                  <th>Name</th>                 
                  <th>Phone</th>
                  <th>Username</th>
                  <th>Salary(H)</th>
                  <th>Status</th>
                  <th>Transfer</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>                 

                </tbody>               
              </table>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</div>


@endsection