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
                <h5 class="m-0">New {{ $title }}</h5>
              </div>
              <div class="card-body">
                
              <form class="form-horizontal" action="{{ url('items') }}" method="POST" >
                @csrf
                <div class="card-body">

                 <div class="form-group row">
                    <label for="item-category" class="col-sm-2 col-form-label">Select Category</label>
                    <div class="col-sm-10">
                      <select id="item-category" name="category_id" class="form-control is-warning" data-find-url="{{ url('SubCategoryController/getSubCategoryByCatId') }}">
                                <option>Select</option>
                          @foreach ($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="subcategory" class="col-sm-2 col-form-label">Select Sub Category</label>
                    <div class="col-sm-8">
                      <select id="subcategory" name="subcategory_id" class="form-control is-warning">
                          <option>Select Category First</option>
                         
                        </select>
                    </div>
                  </div> 
                  
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Item Name</label>
                    <div class="col-sm-6">
                      <input type="text" name="name" class="form-control is-warning" id="name"  value="{{ old('name') }}">
                    </div>
                  </div> 


                    <div class="form-group row">
                    <label for="active" class="col-sm-2 col-form-label">Item Name</label>
                    <div class="col-sm-4">
                         <select id="active" name="active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div>
                  </div>  



                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success btn-lg">SAVE</button>
                  
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