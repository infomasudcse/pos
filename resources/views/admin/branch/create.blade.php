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



            @if ($status)

              <div class="alert alert-success">

                  {{ $status }}

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

                <h5 class="m-0">New Branch</h5>

              </div>

              <div class="card-body">

                

              <form class="form-horizontal" action="{{ route('branches.store') }} " method="POST" >

                @csrf

                <div class="card-body">

                   <div class="form-group row">

                    <label for="title" class="col-sm-2 col-form-label">Branch Title</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="title" name="title"  value="{{ old('title') }}" placeholder="Title Used on Sale Receipt, Report, Website">

                    </div>

                  </div>

                <div class="form-group row">

                    <label for="name" class="col-sm-2 col-form-label">Branch Name</label>

                    <div class="col-sm-10">

                      <input type="text" name="name" class="form-control is-warning" id="name"  value="{{ old('name') }}">

                    </div>

                  </div>

                 

                 

                  <div class="form-group row">

                    <label for="address" class="col-sm-2 col-form-label">Address</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="address" name="address"  value="{{ old('address') }}" placeholder="Used on Receipt, Website">

                    </div>

                  </div>

                  <div class="form-group row">

                    <label for="contact" class="col-sm-2 col-form-label">Phone</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="contact" name="phone"  value="{{ old('phone') }}" placeholder="Used on Receipt, Website">

                    </div>

                  </div>

                 

                  <div class="form-group row">

                    <label for="rp" class="col-sm-2 col-form-label">Musak</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="rp" name="musak"  value="{{ old('musak') }}">

                    </div>

                  </div>
                  <div class="form-group row">

                    <label for="rp" class="col-sm-2 col-form-label">BIN</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="rp" name="bin"  value="{{ old('bin') }}">

                    </div>

                  </div>
                   <div class="form-group row">

                    <label for="rp" class="col-sm-2 col-form-label">Dsicount</label>

                    <div class="col-sm-10">

                      <select class="form-control" name="discount">
                        <option value="0">OFF</option>
                        <option value="1">ON</option>
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