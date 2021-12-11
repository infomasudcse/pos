@extends('admin')

@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">

      <div class="container-fluid">
        <div class="row">
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
    <!-- /.content-header -->

    <!-- Main content -->
<div class="content">
      <div class="container-fluid">
        <div class="row">         
          <div class="col-lg-12">
            <div class="card card-secondary card-outline">
              <div class="card-header">
                <h5 class="m-0">Update Configuration</h5>
              </div>
              <div class="card-body">
                
              <form class="form-horizontal" action="{{ route('configs.store') }}" method="POST" >
                @csrf
                <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-3 col-form-label">Company Name</label>
                    <div class="col-9">
                      <input type="text" name="business_name" class="form-control" id="name" value="{{ $cf->business_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="slogan" class="col-3 col-form-label">Business Slogan</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="slogan" name="slogan" value="{{ $cf->slogan }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="oname" class="col-3 col-form-label">Owner Name</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="oname" name="owner_name" value="{{ $cf->owner_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="address" class="col-3 col-form-label">Address</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="address" name="address" value="{{ $cf->address }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="contact" class="col-3 col-form-label">Contact</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="contact" name="contact" value="{{ $cf->contact }}">
                    </div>
                  </div>
                 
                  <div class="form-group row">
                    <label for="rp" class="col-3 col-form-label">Return policy</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="rp" name="return_policy" value="{{ $cf->return_policy}}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="tn" class="col-3 col-form-label">Tax Name</label>
                    <div class="col-9">
                      <input type="text" class="form-control" id="tn" name="default_tax_name" value="{{ $cf->default_tax_name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="tr" class="col-3 col-form-label">Tax Rate</label>
                    <div class="col-9">
                      <input type="number" step="0.01" name="default_tax" class="form-control" id="tr" value="{{ $cf->default_tax }}">
                    </div>
                  </div>

                  <div class="form-group row">
                      <label for="inputEmail3" class="col-3 col-form-label">Email</label>
                      <div class="col-9">
                        <input type="email" class="form-control" name="email" id="inputEmail3" value="{{ $cf->email }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="nobarcode" class="col-3 col-form-label">No Auto Bar Code</label>
                      <div class="col-2">
                        <input type="checkbox" class="form-control" name="autobarcode" id="nobarcode" value="1" {{ (($cf->autobarcode) ? 'checked': '') }}>
                      </div>
                      <div class="col-4">
                           <p id="check-msg" class="d-inline-block text-truncate font-weight-light font-italic text-danger"> 
                          {{ (($cf->autobarcode) ? 'Manual Bar Code Required later !': 'Bar code will be auto generated ! ') }}
                          </p>

                        </div>
                    </div>
                  
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Update</button>
                  
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