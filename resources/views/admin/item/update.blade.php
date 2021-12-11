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
                
              <form class="form-horizontal" action="{{ url('items/'.$item->id.'') }}" method="POST" >
                @csrf
                @method('PUT')
                <div class="card-body">

                 <div class="form-group row">
                    <label for="item-category" class="col-sm-2 col-form-label">Select Category</label>
                    <div class="col-sm-10">
                      <select id="item-category" name="category_id" class="form-control is-warning">
                            <option value="{{ $current_cat->id }}">{{ $current_cat->name }}</option>
                          @foreach ($categories as $category)
                                <option value="{{ $category->id }}" > {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <label for="subcategory" class="col-sm-2 col-form-label">Select Sub Category</label>
                    <div class="col-sm-8">
                      <select id="subcategory" name="subcategory_id" class="form-control is-warning">
                        @foreach($subcategories as $subcategory)
                          <option value="{{ $subcategory->id }}" <?=(($item->subcategory_id==$subcategory->id)?'selected':'')?>>{{ $subcategory->name }}</option>
                        @endforeach  
                         
                        </select>
                    </div>
                  </div> 
                  
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Item Name</label>
                    <div class="col-sm-6">
                      <input type="text" name="name" class="form-control is-warning" id="name"  value="{{ $item->name }}">
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