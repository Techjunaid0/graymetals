<!-- New Consignment -->
<div class="modal" id="consignmentItems">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-inline" action="{{ route('ajax.save_items', ['id' => optional($instruction)->id]) }}"
                  method="post">
                @csrf
                <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title pull-left">Items Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12 {{ $errors->has('currency_id') ? 'has-error' : ''}}">
                                <label for="currency_id">Currency *</label>
                                <select class="form-control" name="currency_id" id="currency_id">
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->symbol }}
                                            | {{ $currency->iso3 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        @forelse($instruction->consignment->consignmentDetails as $item)
                            <div class="item_parent">
                                <div class="form-group row">
                                    <div class=" col-md-3 {{ $errors->has('container_no') ? 'has-error' : ''}}">
                                        <label for="container_no">Container No </label>
                                        <input type="text"
                                               id="container_no"
                                               class="form-control container_no {{ $errors->has('container_no') ? 'has-error' : ''}} "
                                               name="container_no[]" placeholder="Enter Container No"
                                               value="{{ $item->container_no }}">
                                        @if ($errors->has('container_no'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('container_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('seal_no') ? 'has-error' : ''}}">
                                        <label for="seal_no">Seal No </label>
                                        <input type="text"
                                               class="form-control seal_no {{ $errors->has('seal_no') ? 'has-error' : ''}} "
                                               name="seal_no[]" placeholder="Enter Seal No" id="seal_no"
                                               value="{{ $item->seal_no }}">
                                        @if ($errors->has('seal_no'))
                                            <span class="help-block text-danger">{{ $errors->first('seal_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('tare_weight') ? 'has-error' : ''}}">
                                        <label for="tare_weight">Tare Weight (KG) </label>
                                        <input type="text"
                                               id="tare_weight"
                                               class="form-control tare_weight {{ $errors->has('tare_weight') ? 'has-error' : ''}} "
                                               name="tare_weight[]" placeholder="Enter Tare Weight"
                                               value="{{ $item->tare_weight }}">
                                        @if ($errors->has('tare_weight'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('tare_weight') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class=" col-md-3 {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label for="description">Item Description *</label>
                                        <input type="text"
                                               id="description"
                                               class="form-control description {{ $errors->has('description') ? 'has-error' : ''}} "
                                               name="description[]" placeholder="Enter Item Description"
                                               value="{{ $item->description }}">
                                        @if ($errors->has('description'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('item_weight') ? 'has-error' : ''}}">
                                        <label for="item_weight">Net Weight (MT) *</label>
                                        <input type="text"
                                               id="item_weight"
                                               class="form-control item_weight calculate {{ $errors->has('item_weight') ? 'has-error' : ''}} "
                                               name="item_weight[]" placeholder="Enter Weight in MT"
                                               value="{{ $item->item_weight }}">
                                        @if ($errors->has('item_weight'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('item_weight') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-2 {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price">Price/MT *</label>
                                        <input type="text"
                                               id="price"
                                               class="form-control price calculate {{ $errors->has('price') ? 'has-error' : ''}} "
                                               name="price[]" placeholder="Enter Price" value="{{ $item->price }}">
                                        @if ($errors->has('price'))
                                            <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-xs-2 col-md-2 {{ $errors->has('total_price') ? 'has-error' : ''}}">
                                        <label for="total_price">Total Price </label>
                                        <input type="text"
                                               id="total_price"
                                               class="form-control total_price {{ $errors->has('total_price') ? 'has-error' : ''}}"
                                               name="total_price[]" placeholder="Total Price"
                                               value="{{ $item->total_price }}" disabled="">
                                        @if ($errors->has('total_price'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('total_price') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <button type="button" class="btn btn-danger removeItem"
                                                style="margin-top: 25px;" title="Remove">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary addItem" style="margin-top: 25px;"
                                                title="Add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @empty
                            <div class="item_parent">
                                <div class="form-group row">
                                    <div class=" col-md-3 {{ $errors->has('container_no') ? 'has-error' : ''}}">
                                        <label for="item_weight">Container No </label>
                                        <input type="text"
                                               id="item_weight"
                                               class="form-control container_no {{ $errors->has('container_no') ? 'has-error' : ''}} "
                                               name="container_no[]" placeholder="Enter Container No">
                                        @if ($errors->has('container_no'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('container_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('seal_no') ? 'has-error' : ''}}">
                                        <label for="seal_no">Seal No </label>
                                        <input type="text"
                                               id="seal_no"
                                               class="form-control seal_no {{ $errors->has('seal_no') ? 'has-error' : ''}} "
                                               name="seal_no[]" placeholder="Enter Seal No">
                                        @if ($errors->has('seal_no'))
                                            <span class="help-block text-danger">{{ $errors->first('seal_no') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('tare_weight') ? 'has-error' : ''}}">
                                        <label for="tare_weight">Tare Weight (KG) </label>
                                        <input type="text"
                                               id="tare_weight"
                                               class="form-control tare_weight {{ $errors->has('tare_weight') ? 'has-error' : ''}} "
                                               name="tare_weight[]" placeholder="Enter Tare Weight">
                                        @if ($errors->has('tare_weight'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('tare_weight') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class=" col-md-3 {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label for="description">Item Description *</label>
                                        <input type="text"
                                               id="description"
                                               class="form-control description {{ $errors->has('description') ? 'has-error' : ''}} "
                                               name="description[]" placeholder="Enter Item Description" value="">
                                        @if ($errors->has('description'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-3 {{ $errors->has('item_weight') ? 'has-error' : ''}}">
                                        <label for="item_weight">Net Weight (MT) *</label>
                                        <input type="text"
                                               id="item_weight"
                                               class="form-control item_weight calculate {{ $errors->has('item_weight') ? 'has-error' : ''}} "
                                               name="item_weight[]" placeholder="Enter Weight in MT" value="">
                                        @if ($errors->has('item_weight'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('item_weight') }}</span>
                                        @endif
                                    </div>
                                    <div class=" col-md-2 {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price">Price/MT *</label>
                                        <input type="text"
                                               id="price"
                                               class="form-control price calculate {{ $errors->has('price') ? 'has-error' : ''}} "
                                               name="price[]" placeholder="Enter Price" value="">
                                        @if ($errors->has('price'))
                                            <span class="help-block text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-xs-2 col-md-2 {{ $errors->has('total_price') ? 'has-error' : ''}}">
                                        <label for="total_price">Total Price </label>
                                        <input type="text"
                                               id="total_price"
                                               class="form-control total_price {{ $errors->has('total_price') ? 'has-error' : ''}}"
                                               name="total_price[]" placeholder="Total Price" value=""
                                               disabled="">
                                        @if ($errors->has('total_price'))
                                            <span
                                                class="help-block text-danger">{{ $errors->first('total_price') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-xs-2 col-md-2">
                                        <button type="button" class="btn btn-danger removeItem"
                                                style="margin-top: 25px;" title="Remove">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary addItem" style="margin-top: 25px;"
                                                title="Add">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script type="text/javascript">
        $('#consignmentItems form').submit(function (e) {
            e.preventDefault();
            var node = $(this);
            var action = node.attr('action');
            var data = node.serialize();
            var hasError = false;
            $('#consignmentItems').find('.help-block').remove();
            $('#consignmentItems').find('.has-error').removeClass('has-error');
            $('#consignmentItems').find('.row').each(function (i, node) {
                var description = $(node).find('.description').val();
                var item_weight = $(node).find('.item_weight').val();
                var price = $(node).find('.price').val();

                if (description == "") {
                    $(node).find('.description').addClass('has-error');
                    $(node).find('.description').closest('div').addClass('has-error');
                    $(node).find('.description').closest('div').append('<span class="help-block text-danger">Description is required</span>');
                    hasError = true;
                }

                if (item_weight == "") {
                    $(node).find('.item_weight').addClass('has-error');
                    $(node).find('.item_weight').closest('div').addClass('has-error');
                    $(node).find('.item_weight').closest('div').append('<span class="help-block text-danger">Weight is required</span>');
                    hasError = true;
                }

                if (price == "") {
                    $(node).find('.price').addClass('has-error');
                    $(node).find('.price').closest('div').addClass('has-error');
                    $(node).find('.price').closest('div').append('<span class="help-block text-danger">Price is required</span>');
                    hasError = true;
                }

            }).promise().done(function () {
                if (hasError) {
                    toastr['error']("Form Has Errors");
                } else {
                    $.ajax({
                        type: "POST",
                        url: action,
                        data: data,
                        dataType: "json",
                        cache: false,
                        success: function (response) {
                            toastr['success'](response.message);
                            $('#consignmentItems').modal('hide');
                            $(node)[0].reset();
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function (response) {
                            if (response.status == 422) {
                                toastr['error']("Form Contain Errors.");
                            } else {
                                toastr['error']("Something Went Wrong.");
                            }
                        }
                    });
                }
            });
        });
        $('.datepicker').datetimepicker({
            format: 'L'
        });
        $('.datetimepicker-addon').on('click', function () {
            $(this).prev('input.datetimepicker').data('DateTimePicker').toggle();
        });
        $('#consignmentItems').on('click', '.removeItem', function () {
            if ($('#consignmentItems').find('.item_parent').length > 1) {
                $(this).closest('.item_parent').remove();
            }
        });
        $('#consignmentItems').on('click', '.addItem', function () {
            $('#consignmentItems').find('.box-body').append('<div class="item_parent">' + $(this).closest('.item_parent').html() + '</div>');
            $('#consignmentItems').find('.item_parent').last().find('input').val('');
        });
        $('#consignmentItems').on('input', '.calculate', function () {
            var node = $(this).closest('.row');
            var item_weight = parseFloat($(node).find('.item_weight').val());
            var price = parseFloat($(node).find('.price').val());
            var calculate = 0;
            if (!isNaN(item_weight) && !isNaN(price)) {
                calculate = item_weight * price;
            }
            $(node).find('.total_price').val(calculate);
        });
    </script>
@endpush
@push('css')
    <style type="text/css">
        #consignmentItems .modal-dialog {
            width: 80%;
        }

        .form-inline .form-control {
            width: 100%;
        }
    </style>
@endpush
