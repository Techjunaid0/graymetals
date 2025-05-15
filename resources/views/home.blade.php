@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@push('css')
@endpush
@section('content')
    <p>You are logged in!</p>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $case_detail->count() }}</h3>

              <p>Instructions</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/instruction" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $consignee_list->count() }}</h3>

              <p>Consignees</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/consignee" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
               <h3>{{ $shipping_company_list->count() }}</h3>

              <p>Shipping Companies</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/shipping_co" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
               <h3>{{ $supplier_list->count() }}</h3>

              <p>Suppliers</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/supplier" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <h1 class="text-center">Current Month Stats</h1>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <h3 class="text-center">Instructions</h3>
          <div id="myPieChart">
            {!! $chart->container() !!}
          </div>
        </div>
        <div class="col-sm-6">
          <h3 class="text-center">Consignments</h3>
          <table class="table table-hover table-responsive">
            <thead>
              <tr>
                <th>Sr #</th>
                <th>Shipper</th>
                <th>Consignee</th>
                <th>Weight</th>
              </tr>

              @if(!empty($consignments))
                @foreach($consignments as $consignment)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ($consignment->shipper) ? $consignment->shipper->name : '--' }}</td>
                    <td>{{ ($consignment->consignee) ? $consignment->consignee->name : '--' }}</td>
                    <td>{{ $consignment->weight }}</td>
                  </tr>
                @endforeach
              @endif
            </thead>
          </table>
        </div>
      </div>
</section>
@stop

@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
  {!! $chart->script() !!}
@endpush
