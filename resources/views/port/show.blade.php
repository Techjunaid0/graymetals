@extends('adminlte::page')

@section('title', 'Show - Port Deatils')

@section('content_header')
<h1>Port</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('port.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Port Name</th>
                  <td>{{ $port_detail->name }}</td>
                </tr>
                {{-- <tr>
                  <th>Phone</th>
                  <td>{{ $port_detail->phone }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $port_detail->primary_email }}</td>
                </tr> --}}
                {{-- <tr>
                  <th>Postal Code</th>
                  <td>{{ $port_detail->postal_code }}</td>
                </tr> --}}
                 <tr>
                  <th>Country</th>
                  <td>{{ $port_detail->country->name ?? '-' }}</td>
                </tr>
                 <tr>
                  <th>City</th>
                  <td>{{ $port_detail->city->name ?? '-' }}</td>
                </tr>
                {{-- <tr>
                  <th>Address</th>
                  <td>{{ $port_detail->address ?? '-' }}</td>
                </tr> --}}
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection