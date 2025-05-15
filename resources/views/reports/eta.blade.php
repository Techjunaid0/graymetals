@extends('adminlte::page')
@section('title', 'Reports - Contract Wise')
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
@section('content_header')
    <h1>Contract Wise</h1>
@endsection


@section('content')
    <div class="box">
        <div class="col-md-12">
            <div class="box-header">
                <h3>Download Reports by Contract</h3>
            </div>
            <div class="box-body">
                <form action="{{ url('eta/excel') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 {{ $errors->has('eta') ? 'has-error' : ''}}">
                            <label for="eta">ETA</label>
                            <input type="text" name="eta" id="eta" class="form-control"
                                   placeholder="DD-MM-YYYY">
                            @if ($errors->has('eta'))
                                <span class="help-block text-danger">{{ $errors->first('eta') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4 {{ $errors->has('shipping_line') ? 'has-error' : ''}}">
                            <label for="shipping_line">Shipping Line</label>
                            <input type="text" name="shipping_line" id="shipping_line" class="form-control"
                                   placeholder="Shipping Line">
                            @if ($errors->has('shipping_line'))
                                <span class="help-block text-danger">{{ $errors->first('shipping_line') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4 {{ $errors->has('supplier_name') ? 'has-error' : ''}}">
                            <label for="supplier_name">Supplier Name</label>
                            <select class="form-control" id="supplier_name" name="supplier_name" id="supplier_name">
                                <option value="">Select Supplier</option>
                                @foreach ($supplier_names as $supplier)
                                    <option
                                        value="{{$supplier->name}}" {{ $supplier->name == old('supplier_name') ? 'selected' : ''}}>{{$supplier->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('supplier_name'))
                                <span class="help-block text-danger">{{ $errors->first('supplier_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-4 {{ $errors->has('status') ? 'has-error' : ''}}">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="">Select Status</option>
                                <option value="loaded" {{ 'loaded' == old('status') ? 'selected' : ''}}>Loaded</option>
                                <option value="not_loaded" {{ 'not_loaded' == old('status') ? 'selected' : ''}}>Not
                                    Loaded
                                </option>
                            </select>
                            @if ($errors->has('status'))
                                <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4 {{ $errors->has('contract_date') ? 'has-error' : ''}}">
                            <label for="contract_date">Contract Date</label>
                            <input type="text" class="form-control" name="contract_date"
                                   id="contract_date"
                                   placeholder="DD-MM-YYYY"
                                   value="{{ old('contract_date') }}">
                            @if ($errors->has('contract_date'))
                                <span class="help-block text-danger">{{ $errors->first('contract_date') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4 {{ $errors->has('container_no') ? 'has-error' : ''}}">
                            <label for="container_no">Container No</label>
                            <input type="text" class="form-control" name="container_no"
                                   id="container_no"
                                   placeholder="Container No"
                                   value="{{ old('container_no') }}">
                            @if ($errors->has('container_no'))
                                <span class="help-block text-danger">{{ $errors->first('container_no') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('payment_status') ? 'has-error' : ''}}">
                                <label for="payment_status">Payment Status</label>
                                <select class="form-control" id="payment_status" name="payment_status">
                                    <option value="">Select Payment Status</option>
                                    <option value="paid" {{ 'paid' == old('payment_status') ? 'selected' : ''}}>Paid
                                    </option>
                                    <option value="not_paid" {{ 'not_paid' == old('payment_status') ? 'selected' : ''}}>
                                        Not
                                        Paid
                                    </option>
                                    <option
                                        value="partial_paid" {{ 'partial_paid' == old('payment_status') ? 'selected' : ''}}>
                                        Partial
                                        Paid
                                    </option>
                                </select>
                                @if ($errors->has('payment_status'))
                                    <span class="help-block text-danger">{{ $errors->first('payment_status') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-mdd-4"></div>
                        <div class="col-mdd-4"></div>
                    </div>
                    <div class="row" style="margin-top: 10px">

                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <a href="{{ route('reports.contract') }}" class="btn btn-block btn-primary float-right">Reset
                                Fields</a>
                        </div>
                        <div class="col-md-4">

                            <button type="submit" name="submit" class="btn btn-block btn-primary float-right">Download
                                Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>


    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        $(".myselect").select2();
        //Date range picker
        $('#eta').daterangepicker({
            format: "DD-MM-YYYY",
        });
        $('#contract_date').daterangepicker({
            format: "DD-MM-YYYY",
        });
    </script>
@endpush
