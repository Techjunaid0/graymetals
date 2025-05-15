<!-- New Consignment -->
<div class="modal" id="newConsignment">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('ajax.booking_confirmation') }}" method="post">
                @csrf
                <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title pull-left">Booking Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="confirmation_date">Confirmation Date*</label>
                            <input class="form-control datepicker" id="confirmation_date" name="confirmation_date"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="carrier">Carrier*</label>
                            <select class="form-control" id="carrier" name="carrier">
                                <option value="">-- Select Carrier --</option>
                                @if(!empty($carriers))
                                    @foreach($carriers as $carrier)
                                        <option value="{{ $carrier->id }}"> {{ $carrier->carrier_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="tracking_url">Tracking URL*</label>;
                            <input class="form-control" id="tracking_url" name="tracking_url" value="" readonly=""/>
                        </div>
                        <div class="form-group">
                            <label for="reference">Reference*</label>
                            <input class="form-control" id="reference" name="reference"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="line_reference">Line Reference</label>
                            <input class="form-control" id="line_reference" name="line_reference"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="vessel">Vessel</label>
                            <input class="form-control" id="vessel" name="vessel"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="ucr">UCR</label>
                            <input class="form-control" id="ucr" name="ucr"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="ets">ETS</label>
                            <input class="form-control datepicker" id="ets" name="ets"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="eta">ETA*</label>
                            <input class="form-control datepicker" id="eta" name="eta"/>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
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
        $('#addConsignment').click(function () {
            var node = $('#newConsignment form');
            var instruction_id = node.find('input[name="instruction_id"]').val();
            var route = "{{ route('ajax.get_consignment', "INSTRUCTION_ID") }}".replace("INSTRUCTION_ID", instruction_id);
            $.ajax({
                type: "GET",
                url: route,
                cache: false,
                dataType: "json",
                success: function (response) {
                    node.find('input[name="confirmation_date"]').val(response.confirmation_date);
                    node.find('select[name="carrier"]').val(response.carrier);
                    node.find('input[name="reference"]').val(response.reference);
                    node.find('input[name="line_reference"]').val(response.line_reference);
                    node.find('input[name="vessel"]').val(response.vessel);
                    node.find('input[name="ucr"]').val(response.ucr);
                    node.find('input[name="ets"]').val(response.ets);
                    node.find('input[name="eta"]').val(response.eta);
                    node.find('input[name="tracking_url"]').val(response.tracking_url);
                    $('#newConsignment').modal('show');
                },
                error: function () {
                    toastr['error']("Something Went Wrong");
                }
            });
        });
        $('#newConsignment form').submit(function (e) {
            e.preventDefault();
            var node = $(this);
            var action = node.attr('action');
            var data = node.serialize();
            $.ajax({
                type: "POST",
                url: action,
                data: data,
                dataType: "json",
                cache: false,
                success: function (response) {
                    toastr['success'](response.message);
                    $('#newConsignment').modal('hide');
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
        });
        $('.datepicker').datetimepicker({
            format: 'L'
        });
        $('.datetimepicker-addon').on('click', function () {
            $(this).prev('input.datetimepicker').data('DateTimePicker').toggle();
        });
        $('#carrier').change(function () {
            var selectedCarrier = $(this).val();
            if(selectedCarrier == ""){
                toastr['error']("Please Select Carrier");
            }else{
                var route = "{{ route('ajax.get_tracking_url', "CARRIER_ID") }}".replace("CARRIER_ID", selectedCarrier);

                $.ajax({
                    type: "GET",
                    url: route,
                    cache: false,
                    dataType: "json",
                    success: function (response) {
                        $('#tracking_url').val(response.tracking_url);

                    },
                    error: function () {
                        toastr['error']("Something Went Wrong");
                    }
                });
            }


        });

    </script>
@endpush
