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
                      <div class="col">
                        
                        <a href="{{ url('items/create') }}" title='New Item' class="btn btn-flat btn-primary float-right ">New Item</a>
                         <a href="{{ url('inventories') }}" title='Inventory' class='mr-3 btn btn-flat float-right btn-info'><i class='fas fa-list'></i> Inventory</a>
                      </div>

                  </div>  

                    
              </div>
              <div class="card-body">
              <table id="itemTable" class="table table-bordered">
                <thead>
                <tr>
                  <th>SL</th>
                  <th>SubCategory</th>
                  <th>Name</th>                 
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