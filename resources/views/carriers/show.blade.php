@extends('adminlte::page')

@section('title', 'Show - Carriers')

@section('content_header')
<h1>Carrier</h1>
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('carriers.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered">
                <tr>
                  <th>Carrier Name</th>
                  <td>{{ $carrier->carrier_name }}</td>
                </tr>
                <tr>
                  <th>Tracking URL</th>
                  <td>{{ $carrier->tracking_url ?? '-' }}</td>
                </tr>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection
