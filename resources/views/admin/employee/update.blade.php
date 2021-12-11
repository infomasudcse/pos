@extends('admin')

@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">

      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <!-- use this space for notify user -->
            @if (session('status'))
              <div class="alert alert-warning">
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
                <h5 class="m-0">Update Employee</h5>
              </div>
              <div class="card-body">

              <form class="form-horizontal" method="POST" action="{{ url('employees/'.$employee->id.'') }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                  
                  <div class="form-group row">
                    <label for="branch" class="col-sm-2 col-form-label">Select Branch</label>
                    <div class="col-sm-10">
                      <select id="branch" name="branch_id" class="form-control is-warning">
                          @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}" <?=(($branch->id==$employee->branch_id)?'selected':'')?>> {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                 
                  <div class="form-group row">
                    <label for="fn" class="col-sm-2 col-form-label"> Name</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $employee->name }}" class="form-control is-warning" id="fn" name="name" >
                    </div>
                  </div>
                  
                   <div class="form-group row">
                    <label for="un" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text"  value="{{ $employee->username }}" class="form-control" id="un" name="username" >
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="pass" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="pass" name="password" >
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                      <input type="text"  value="{{ $employee->phone }}" class="form-control is-warning" id="phone" name="phone" >
                    </div>
                  </div>
                   <div class="form-group row">
                    <label for="us" class="col-sm-2 col-form-label">Unit Salary(hour)</label>
                    <div class="col-sm-10">
                      <input type="number"  value="{{ $employee->unit_salary }}" step=".01"  class="form-control is-warning" id="us" name="unit_salary" >
                    </div>
                  </div> 
               
                 
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success btn-lg">UPDATE</button>
                  
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