@extends('adminlte::page')

@section('title', 'List - Contracts')

@section('content_header')
    <h1>Contracts</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Contract Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ route('contracts.store') }}" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('invoice_no') ? 'has-error' : ''}}">
                            <label for="invoice_no">Invoice No</label>
                            <input type="text"
                                   class="form-control {{ $errors->has('invoice_no') ? 'has-error' : ''}} "
                                   name="invoice_no" id="invoice_no" placeholder="Invoice No"
                                   value="{{ old('invoice_no') }}">
                            @if ($errors->has('invoice_no'))
                                <span class="help-block text-danger">{{ $errors->first('invoice_no') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('contract_no') ? 'has-error' : ''}}">
                            <label for="contract_no">Contract No</label>
                            <input type="text" class="form-control" name="contract_no" id="contract_no"
                                   placeholder="Contract No"
                                   value="{{ old('contract_no') }}">
                            @if ($errors->has('contract_no'))
                                <span class="help-block text-danger">{{ $errors->first('contract_no') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('contract_date') ? 'has-error' : ''}}">
                            <label for="contract_date">Contract Date</label>
                            <input type="text" class="form-control datepicker" name="contract_date" id="contract_date"
                                   placeholder="Contract No"
                                   value="{{ old('contract_date') }}">
                            @if ($errors->has('contract_date'))
                                <span class="help-block text-danger">{{ $errors->first('contract_date') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('supplier_name') ? 'has-error' : ''}}">
                            <label for="supplier_name">Supplier Name</label>
                            <select class="form-control" id="supplier_name" name="supplier_name">
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
                        <div class="form-group {{ $errors->has('no_of_containers') ? 'has-error' : ''}}">
                            <label for="no_of_containers">No of Containers</label>
                            <input type="number" class="form-control" min="0" name="no_of_containers"
                                   id="no_of_containers"
                                   onkeypress="return event.charCode >= 48"
                                   placeholder="Contract No"
                                   value="{{ old('no_of_containers') }}">
                            @if ($errors->has('no_of_containers'))
                                <span class="help-block text-danger">{{ $errors->first('no_of_containers') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('rate') ? 'has-error' : ''}}">
                            <label for="rate">Rate</label>
                            <input type="number" class="form-control" name="rate" id="rate" min="0"
                                   placeholder="Rate"
                                   onkeypress="return event.charCode >= 48"
                                   value="{{ old('rate') }}">
                            @if ($errors->has('rate'))
                                <span class="help-block text-danger">{{ $errors->first('rate') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
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
                        <div class="form-group {{ $errors->has('shipping_line') ? 'has-error' : ''}}">
                            <label for="shipping_line">Shipping Line</label>
                                <select class="form-control" id="shipping_line" name="shipping_line">
                                    <option value="">Select Shipping Line</option>
                                    @if(!empty($carrier_names) && count($carrier_names) >0)
                                        @foreach ($carrier_names as $shipping)
                                            <option
                                                value="{{$shipping->carrier_name}}" {{ $shipping->carrier_name == old('shipping_line') ? 'selected' : ''}}>{{$shipping->carrier_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @if ($errors->has('shipping_line'))
                                <span class="help-block text-danger">{{ $errors->first('shipping_line') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('eta') ? 'has-error' : ''}}">
                            <label for="eta">ETA</label>
                            <input type="text" class="form-control datepicker" name="eta" id="eta"
                                   placeholder="ETA"
                                   value="{{ old('eta') }}">
                            @if ($errors->has('eta'))
                                <span class="help-block text-danger">{{ $errors->first('eta') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('weight') ? 'has-error' : ''}}">
                            <label for="weight">Weight</label>
                            <input type="number" class="form-control" min="0" name="weight" id="weight"
                                   placeholder="Weight"
                                   step=0.001
                                   oninput="validity.valid||(value='');"
                                   value="{{ old('weight') }}">
                            @if ($errors->has('weight'))
                                <span class="help-block text-danger">{{ $errors->first('weight') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('invoice_value') ? 'has-error' : ''}}">
                            <label for="invoice_value">Invoice Value</label>
                            <input type="number" class="form-control" min="0" name="invoice_value" id="invoice_value"
                                   placeholder="Invoice Value"
                                   step=0.000001
                                   oninput="validity.valid||(value='');"
                                   readonly
                                   value="{{ old('invoice_value') }}">
                            @if ($errors->has('invoice_value'))
                                <span class="help-block text-danger">{{ $errors->first('invoice_value') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('container_no') ? 'has-error' : ''}}">
                            <label for="container_no">Container No</label>
                            <input type="text" class="form-control" name="container_no" id="container_no"
                                   placeholder="Container No"
                                   value="{{ old('container_no') }}">
                            @if ($errors->has('container_no'))
                                <span class="help-block text-danger">{{ $errors->first('container_no') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('comments') ? 'has-error' : ''}}">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" name="comments" id="comments"
                                      placeholder="Comments"
                            > {{ old('comments') }}</textarea>
                            @if ($errors->has('comments'))
                                <span class="help-block text-danger">{{ $errors->first('comments') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('other_info') ? 'has-error' : ''}}">
                            <label for="other_info">Other Info</label>
                            <textarea type="text" class="form-control" name="other_info" id="other_info"
                                      placeholder="Other Info"
                            >{{ old('other_info') }}</textarea>
                            @if ($errors->has('other_info'))
                                <span class="help-block text-danger">{{ $errors->first('other_info') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('cu') ? 'has-error' : ''}}">
                            <label for="cu">CU</label>
                            <input type="text" class="form-control" name="cu" id="cu"
                                   placeholder="CU"
                                   value="{{ old('cu') }}">
                            @if ($errors->has('cu'))
                                <span class="help-block text-danger">{{ $errors->first('cu') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('steal') ? 'has-error' : ''}}">
                            <label for="steal">Steal</label>
                            <input type="text" class="form-control" name="steal" id="steal"
                                   placeholder="Steal"
                                   value="{{ old('steal') }}">
                            @if ($errors->has('steal'))
                                <span class="help-block text-danger">{{ $errors->first('steal') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('lme') ? 'has-error' : ''}}">
                            <label for="lme">LME</label>
                            <input type="text" class="form-control" name="lme" id="lme"
                                   placeholder="LME"
                                   value="{{ old('lme') }}">
                            @if ($errors->has('lme'))
                                <span class="help-block text-danger">{{ $errors->first('lme') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('payment_status') ? 'has-error' : ''}}">
                            <label for="payment_status">Payment Status</label>
                            <select class="form-control" id="payment_status" name="payment_status">
                                <option value="">Select Payment Status</option>
                                <option value="paid" {{ 'paid' == old('payment_status') ? 'selected' : ''}}>Paid
                                </option>
                                <option value="not_paid" {{ 'not_paid' == old('payment_status') ? 'selected' : ''}}>Not
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

@push('js')
    <script type="text/javascript">
        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#rate').on('change', function () {
            var rate = $(this).val();
            var weight = $('#weight').val();
            if (rate !== '' && weight !== '') {
                var invoice_value = parseInt(rate) * parseFloat(weight);
                $('#invoice_value').val(parseFloat(invoice_value));
            }
        });

        $('#weight').on('change', function () {
            var rate = $('#rate').val();
            var weight = $(this).val();
            if (rate !== '' && weight !== '') {
                var invoice_value = parseInt(rate) * parseFloat(weight);
                $('#invoice_value').val(parseFloat(invoice_value));
            }
        });
    </script>
@endpush
