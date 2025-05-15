@extends('adminlte::page')

@section('title', 'Show - Contract')

@section('content_header')
    <h1>Contract Details</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{ route('contracts.create') }}">
                        <button class="btn btn-primary add-btn-right">Add New</button>
                    </a>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered">
                        <tr>
                            <th>Invoice No</th>
                            <td>{{ $contract->invoice_no ?? '-'}}</td>
                        </tr>
                        <tr>
                            <th>Contract No</th>
                            <td>{{ $contract->contract_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Contract Date</th>
                            @php


                                if(!is_null($contract->contract_date)){
                                    $date = Carbon\Carbon::parse($contract->contract_date);
                                }else{
                                    $date = null;
                                }

                            @endphp
                            <td>{{ (!is_null($date)) ? $date->format('d-m-Y')  : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Supplier Name</th>
                            <td>{{ $contract->supplier_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No of Container</th>
                            <td>{{ $contract->no_of_containers ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Rate</th>
                            <td>{{ $contract->rate ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst(str_replace('_',' ',$contract->status)) ?? '-' ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Line</th>
                            <td>{{ $contract->shipping_line ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>ETA</th>
                            @php
                                if(!is_null($contract->eta)){
                                    $eta = Carbon\Carbon::parse($contract->eta);
                                }else{
                                    $eta = null;
                                }

                            @endphp
                            <td>{{ (!is_null($eta)) ? $eta->format('d-m-Y')  : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td>{{ $contract->weight ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Value</th>
                            <td>{{ $contract->invoice_value ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Container No</th>
                            <td>{{ $contract->container_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Comments</th>
                            <td>{{ $contract->comments ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Other Info</th>
                            <td>{{ $contract->other_info ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>CU</th>
                            <td>{{ $contract->cu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Steal</th>
                            <td>{{ $contract->steal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>LME</th>
                            <td>{{ $contract->lme ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>{{ ucfirst(str_replace('_',' ',$contract->payment_status)) ?? '-' }}</td>
                        </tr>


                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
