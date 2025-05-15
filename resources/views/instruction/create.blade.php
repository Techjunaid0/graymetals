@extends('adminlte::page')

@section('title', 'List - Instruction Detials')

@section('content_header')
    <h1>Instruction Details</h1>
@endsection

@section('content')
    <div class="row">
        <!-- form start -->
        <form action="{{ route('instruction.store') }}" method="post">
            @csrf
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Instruction Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('case_datetime') ? 'has-error' : ''}}">
                            <label for="case_datetime">Instruction Date Time</label>
                            <input type="text"
                                   class="form-control datetimepicker {{ $errors->has('case_datetime') ? 'has-error' : ''}} "
                                   name="case_datetime" id="case_datetime" placeholder="Instruction Date Time"
                                   value="{{ old('case_datetime', date('m/d/Y h:i:s')) }}" readonly="">
                            @if ($errors->has('case_datetime'))
                                <span class="help-block text-danger">{{ $errors->first('case_datetime') }}</span>
                            @endif
                        </div>
                        {{-- <div class="form-group {{ $errors->has('consignee_id') ? 'has-error' : ''}}">
                          <label for="consignee_id">Consignee</label>
                          <select class="form-control" id="consignee_id" name="consignee_id">
                            <option value="">Select Consignee</option>
                            @foreach ($consignees as $consignee)
                             <option value="{{$consignee->id}}" {{ $consignee->id == old('consignee_id') ? 'selected' : ''}}>{{$consignee->name }}</option>
                            @endforeach
                          </select>
                           @if ($errors->has('consignee_id'))
                            <span class="help-block text-danger">{{ $errors->first('consignee_id') }}</span>
                          @endif
                        </div> --}}
                        <div class="form-group {{ $errors->has('loading_port_id') ? 'has-error' : ''}}">
                            <label for="loading_port_id">Port of Loading</label>
                            <select class="form-control" id="loading_port_id" name="loading_port_id">
                                <option value="">Select Port</option>
                                @foreach ($ports as $port)
                                    <option
                                        value="{{$port->id}}" {{ $port->id == old('loading_port_id') ? 'selected' : ''}}>{{$port->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('loading_port_id'))
                                <span class="help-block text-danger">{{ $errors->first('loading_port_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('discharge_port_id') ? 'has-error' : ''}}">
                            <label for="discharge_port_id">Port of Discharge</label>
                            <select class="form-control" id="discharge_port_id" name="discharge_port_id">
                                <option value="">Select Port</option>
                                @foreach ($ports as $port)
                                    <option
                                        value="{{$port->id}}" {{ $port->id == old('discharge_port_id') ? 'selected' : ''}}>{{$port->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('discharge_port_id'))
                                <span class="help-block text-danger">{{ $errors->first('discharge_port_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('shipping_company_id') ? 'has-error' : ''}}">
                            <label for="shipping_company_id">Shipping Company</label>
                            <select class="form-control" id="shipping_company_id" name="shipping_company_id">
                                <option value="">Select Shipping Company</option>
                                @foreach ($shipping_company_list as $company_list)
                                    <option
                                        value="{{$company_list->id}}" {{ $company_list->id == old('shipping_company_id') ? 'selected' : ''}}>{{$company_list->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('shipping_company_id'))
                                <span class="help-block text-danger">{{ $errors->first('shipping_company_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('supplier_id') ? 'has-error' : ''}}">
                            <label for="supplier_id">Supplier</label>
                            <select class="form-control" id="supplier_id" name="supplier_id">
                                <option value="">Select Supplier</option>
                                @foreach ($supplier_list as $supplier)
                                    <option
                                        value="{{$supplier->id}}" {{ $supplier->id == old('supplier_id') ? 'selected' : ''}}>{{$supplier->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('supplier_id'))
                                <span class="help-block text-danger">{{ $errors->first('supplier_id') }}</span>
                            @endif
                        </div>
                        {{-- <div class="form-group {{ $errors->has('weight') ? 'has-error' : ''}}">
                          <label for="weight">Weight (KG)</label>
                          <input type="text" class="form-control" name="weight" id="weight" placeholder="Weight" value="{{ old('weight') }}" readonly="">
                          @if ($errors->has('weight'))
                            <span class="help-block text-danger">{{ $errors->first('weight') }}</span>
                          @endif
                        </div> --}}
                        <div class="form-group {{ $errors->has('pickup_datetime') ? 'has-error' : ''}}">
                            <label for="pickup_datetime">Pickup Date Time</label>
                            <input type="text"
                                   class="form-control datetimepicker {{ $errors->has('pickup_datetime') ? 'has-error' : ''}} "
                                   name="pickup_datetime" id="case_datetime" placeholder="Pickup Date Time"
                                   value="{{ old('pickup_datetime') }}">
                            @if ($errors->has('case_datetime'))
                                <span class="help-block text-danger">{{ $errors->first('pickup_datetime') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('door_orientation') ? 'has-error' : ''}}">
                            <label for="door_orientation">Door Orientation</label>
                            <select class="form-control" id="door_orientation" name="door_orientation">
                                <option value="">Select Door Orientation</option>
                                <option {{ "Towards Rear" == old('door_orientation') ? 'selected' : ''}}>Towards Rear
                                </option>
                                <option {{ "Towards Cab" == old('door_orientation') ? 'selected' : ''}}>Towards Cab
                                </option>
                            </select>
                            @if ($errors->has('door_orientation'))
                                <span class="help-block text-danger">{{ $errors->first('door_orientation') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('no_of_containers') ? 'has-error' : ''}}">
                            <label for="no_of_containers">No of Containers</label>
                            <input type="text" class="form-control" name="no_of_containers" id="no_of_containers" placeholder="No of Containers"
                                   value="{{ old('no_of_containers') }}">
                            @if ($errors->has('no_of_containers'))
                                <span class="help-block text-danger">{{ $errors->first('no_of_containers') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('instructions') ? 'has-error' : ''}}">
                            <label for="instructions">Instructions</label>
                            <textarea class="textarea" name="instructions" placeholder="Instructions"
                                      id="instructions_text"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('instructions') }}</textarea>
                            @if ($errors->has('instructions'))
                                <span class="help-block text-danger">{{ $errors->first('instructions') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            {{-- <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Consignment Items</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="consignmentItems">
                  @forelse(old('description') ?? [] as $i => $description)
                    <fieldset class="consignment_item">
                      <legend>Item # <span class="item_count">{{ $loop->iteration }}</span>
                        <button type="button" class="btn btn-xs btn-danger pull-right remove" title="Remove"><i class="fa fa-remove"></i></button>
                      </legend>
                      <div class="form-group input-group {{ $errors->has('description.' . $i) ? 'has-error' : ''}}">
                        <label for="description">Item Description *</label>
                        <input type="text" class="form-control {{ $errors->has('description.' . $i) ? 'has-error' : ''}} " name="description[]" placeholder="Enter Item Description" value="{{ old('description.' . $i) }}">
                        @if ($errors->has('description.' . $i))
                          <span class="help-block text-danger">{{ $errors->first('description.' . $i) }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('item_weight.' . $i) ? 'has-error' : ''}}">
                        <label for="item_weight">Total Qty. (Weight) *</label>
                        <input type="text" class="form-control item_weight calculate {{ $errors->has('item_weight.' . $i) ? 'has-error' : ''}} " name="item_weight[]" placeholder="Enter Weight in KG" value="{{ old('item_weight.' . $i) }}">
                        @if ($errors->has('item_weight.' . $i))
                          <span class="help-block text-danger">{{ $errors->first('item_weight.' . $i) }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('price.' . $i) ? 'has-error' : ''}}">
                        <label for="price">Price/KG *</label>
                        <input type="text" class="form-control price calculate {{ $errors->has('price.' . $i) ? 'has-error' : ''}} " name="price[]" placeholder="Enter Price" value="{{ old('price.' . $i) }}">
                        @if ($errors->has('price.' . $i))
                          <span class="help-block text-danger">{{ $errors->first('price.' . $i) }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('total_price.' . $i) ? 'has-error' : ''}}">
                        <label for="total_price">Total Price ($)</label>
                        <input type="text" class="form-control total_price {{ $errors->has('total_price.' . $i) ? 'has-error' : ''}}" disabled="" name="total_price[]" placeholder="Total Price" value="{{ old('total_price.' . $i) }}" disabled="">
                        @if ($errors->has('total_price.' . $i))
                          <span class="help-block text-danger">{{ $errors->first('total_price.' . $i) }}</span>
                        @endif
                      </div>
                    </fieldset>
                  @empty
                    <fieldset class="consignment_item">
                      <legend>Item # <span class="item_count">1</span>
                        <button type="button" class="btn btn-xs btn-danger pull-right remove" title="Remove"><i class="fa fa-remove"></i></button>
                      </legend>
                      <div class="form-group input-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        <label for="description">Item Description *</label>
                        <input type="text" class="form-control {{ $errors->has('description') ? 'has-error' : ''}} " name="description[]" placeholder="Enter Item Description" value="">
                        @if ($errors->has('description'))
                          <span class="help-block text-danger">{{ $errors->first('description') }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('item_weight') ? 'has-error' : ''}}">
                        <label for="item_weight">Total Qty. (Weight) *</label>
                        <input type="text" class="form-control item_weight calculate {{ $errors->has('item_weight') ? 'has-error' : ''}} " name="item_weight[]" placeholder="Enter Weight in KG" value="">
                        @if ($errors->has('item_weight'))
                          <span class="help-block text-danger">{{ $errors->first('item_weight') }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('price') ? 'has-error' : ''}}">
                        <label for="price">Price/Ton *</label>
                        <input type="text" class="form-control price calculate {{ $errors->has('price') ? 'has-error' : ''}} " name="price[]" placeholder="Enter Price" value="">
                        @if ($errors->has('price'))
                          <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                        @endif
                      </div>
                      <div class="form-group input-group {{ $errors->has('total_price') ? 'has-error' : ''}}">
                        <label for="total_price">Total Price ($)</label>
                        <input type="text" class="form-control total_price {{ $errors->has('total_price') ? 'has-error' : ''}}" disabled="" name="total_price[]" placeholder="Total Price" value="" disabled="">
                        @if ($errors->has('total_price'))
                          <span class="help-block text-danger">{{ $errors->first('total_price') }}</span>
                        @endif
                      </div>
                    </fieldset>
                  @endforelse
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="button" class="btn btn-success pull-right" id="addNewItem">Add New</button>
                  </div>
                </div>
              </div>
            </div> --}}
        </form>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#instructions_text').text('Dear Sir\n' +
                '\n' +
                'Please book as per instruction.\n' +
                '\n' +
                'Thanks\n');
            $('.datetimepicker').datetimepicker({

            });
            $('.datetimepicker-addon').on('click', function () {
                $(this).prev('input.datetimepicker').data('DateTimePicker').toggle();
            });
        });

        $('#addNewItem').click(function () {
            $('#consignmentItems').find('.consignment_item').last().clone().prependTo("#consignmentItems .box-footer");
            $('#consignmentItems').find('.consignment_item').last().find('input').val('');
            // var fieldset = $('#consignmentItems').find('.consignment_item').last().wrap('<p/>').parent().html();
            // $('#consignmentItems').find('.box-footer').prepend(fieldset);
            // setTimeout(function(){
            //   var node = $('#consignmentItems').find('.consignment_item').last();
            //   console.log(node.find('input'));
            //   node.find('input').val('');
            //   // node.find('.datetimepicker').datetimepicker();
            // }, 500);
            // $('#consignmentItems').find('.consignment_item:last-child input').val('');
            reIndexItems();
        });

        function reIndexItems() {
            var itemCount = 0;
            $('#consignmentItems').find('.consignment_item').each(function (i, node) {
                $(node).find('.item_count').text(i + 1);
                $(node).find('button.remove').show();
                itemCount++;
            }).promise().done(function () {
                if (itemCount == 1) {
                    $('#consignmentItems').find('.consignment_item button.remove').hide();
                }
            });
            totalWeightCalculate();
        }

        function totalWeightCalculate() {
            var weight = 0;
            $('#consignmentItems').find('.consignment_item').each(function (i, node) {
                tmp = parseFloat($(node).find('.item_weight').val());
                weight += isNaN(tmp) ? 0 : tmp;
            }).promise().done(function () {
                $('#weight').val(weight);
                console.log(weight);
            });
        }

        $('#consignmentItems').on('click', '.remove', function () {
            var node = $(this);
            if (confirm("Are you sure? You want to remove this?")) {
                node.closest('fieldset').remove();
                reIndexItems();
            }
        });
        $('#consignmentItems').on('input', '.calculate', function () {
            var node = $(this).closest('fieldset');
            var item_weight = parseFloat($(node).find('.item_weight').val());
            var price = parseFloat($(node).find('.price').val());
            var calculate = 0;
            if (!isNaN(item_weight) && !isNaN(price)) {
                calculate = item_weight * price;
            }
            $(node).find('.total_price').val(calculate);
            totalWeightCalculate();
        });
        reIndexItems();
    </script>
@endpush
