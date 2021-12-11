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

                <h5 class="m-0">Update Branch</h5>

              </div>

              <div class="card-body">



              <form class="form-horizontal" method="POST" action="{{ url('branches/'.$branch->id.'') }}">

                @csrf

                @method('PUT')

                <div class="card-body">

                   <div class="form-group row">

                    <label for="title" class="col-sm-2 col-form-label">Branch Title</label>

                    <div class="col-sm-10">

                      <input type="text" value="{{ $branch->title }}"  class="form-control" id="title" name="title" >

                    </div>

                  </div>

                <div class="form-group row">

                    <label for="name" class="col-sm-2 col-form-label">Branch Name</label>

                    <div class="col-sm-10">

                      <input type="text" name="name"  value="{{ $branch->name }}" class="form-control" id="name" >

                    </div>

                  </div>                 

                 

                  <div class="form-group row">

                    <label for="address" class="col-sm-2 col-form-label">Address</label>

                    <div class="col-sm-10">

                      <input type="text"  value="{{ $branch->address }}" class="form-control" id="address" name="address">

                    </div>

                  </div>

                  <div class="form-group row">

                    <label for="contact" class="col-sm-2 col-form-label">Phone</label>

                    <div class="col-sm-10">

                      <input type="text"  value="{{ $branch->phone }}" class="form-control" id="contact" name="phone">

                    </div>

                  </div>

                 
                   <div class="form-group row">

                    <label for="rp" class="col-sm-2 col-form-label">Musak</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="rp" name="musak"  value="{{  $branch->musak }}">

                    </div>

                  </div>
                  <div class="form-group row">

                    <label for="rp" class="col-sm-2 col-form-label">BIN</label>

                    <div class="col-sm-10">

                      <input type="text" class="form-control is-warning" id="rp" name="bin"  value="{{  $branch->bin }}">

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