@extends('adminlte::page')

@section('title', 'Show - Supplier Deatils')

@section('content_header')
<h1>Supplier Details</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('supplier.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Supplier Name</th>
                  <td>{{ $supplier_detail->name }}</td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>{{ $supplier_detail->phone ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $supplier_detail->primary_email }}</td>
                </tr>
                 <tr>
                  <th>Address</th>
                  <td>{{ $supplier_detail->address ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Postal Code</th>
                  <td>{{ $supplier_detail->postal_code ?? '-' }}</td>
                </tr>
                 <tr>
                  <th>Country</th>
                  <td>{{ $supplier_detail->country->name ?? '-' }}</td>
                </tr>
                 <tr>
                  <th>City</th>
                  <td>{{ $supplier_detail->city->name ?? '-' }}</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection
