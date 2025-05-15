@extends('adminlte::page')

@section('title', 'Show - Shipping Companies')

@section('content_header')
<h1>Shipping Company</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('consignee.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Company Name</th>
                  <td>{{ $consignee->name }}</td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>{{ $consignee->phone ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $consignee->primary_email }}</td>
                </tr>
                 <tr>
                  <th>Address</th>
                  <td>{{ $consignee->address ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Postal Code</th>
                  <td>{{ $consignee->postal_code ?? '-' }}</td>
                </tr>
                 <tr>
                  <th>Country</th>
                  <td>{{ $consignee->country->name ?? '-' }}</td>
                </tr>
                 <tr>
                  <th>City</th>
                  <td>{{ $consignee->city->name ?? '-' }}</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection