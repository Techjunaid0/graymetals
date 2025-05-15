@extends('adminlte::page')

@section('title', 'Show - Profile Details')

@section('content_header')
<h1>Profile Details</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ url('profile/create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Name</th>
                  <td>{{ $profiles->name }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $profiles->email }}</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection