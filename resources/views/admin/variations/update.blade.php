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

                <h5 class="m-0">Update {{ $subtitle }}</h5>

              </div>

              <div class="card-body">



              <form class="form-horizontal" method="POST" action="{{ url('variations/'.$variation->id.'') }}">

                @csrf

                @method('PUT')

                <div class="card-body">

                  

                <div class="form-group row">

                    <label for="name" class="col-sm-2 col-form-label">Variation Name</label>

                    <div class="col-sm-10">

                      <input type="text" name="name"  value="{{ $variation->name }}" class="form-control" id="name" >

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