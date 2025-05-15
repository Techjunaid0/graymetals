@extends('adminlte::page')

@section('title', 'Show - Shipper Deatils')

@section('content_header')
<h1>Shipper</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('shipper.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Shipper Name</th>
                  <td>{{ $shipper_detial->name }}</td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>{{ $shipper_detial->phone }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $shipper_detial->primary_email }}</td>
                </tr>
                 <tr>
                  <th>Address</th>
                  <td>{{ $shipper_detial->address }}</td>
                </tr>
                <tr>
                  <th>Postal Code</th>
                  <td>{{ $shipper_detial->postal_code }}</td>
                </tr>
                 <tr>
                  <th>Country</th>
                  <td>{{ $shipper_detial->country->name }}</td>
                </tr>
                 <tr>
                  <th>City</th>
                  <td>{{ $shipper_detial->city->name }}</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection