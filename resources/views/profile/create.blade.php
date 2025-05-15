@extends('adminlte::page')

@section('title', 'Profile - Add New')

@section('content_header')
  <h1>User Details</h1>
@endsection

@section('content')
	<div class="row">
		  <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add User Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           <form action="{{ url('profile/store') }}" method="post">
             @csrf
              <div class="box-body">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
 				 @if ($errors->has('name'))
                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                  @endif
                </div>
               <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                  <label for="email">Email *</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                   @if ($errors->has('email'))
                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label for="password">Password *</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{ old('password') }}">
                   @if ($errors->has('password'))
                    <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                  @endif
                </div>
                 <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label for="password_confirmation">Confrim Password *</label>
                  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confrim Password" value="{{ old('password_confirmation') }}">
                   @if ($errors->has('password_confirmation'))
                    <span class="help-block text-danger">{{ $errors->first('password_confirmation') }}</span>
                  @endif
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
	</div>
@endsection

