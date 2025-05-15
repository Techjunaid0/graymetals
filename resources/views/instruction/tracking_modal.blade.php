<!-- Tracking Info -->
<div class="modal" id="updateTracking">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('ajax.tracking_info') }}" method="post">
                @csrf
                <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title pull-left">Tracking Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="courier_service">Courier Service*</label>
                            <select class="form-control" id="courier_service" name="courier_service">
                                <option value="">Select Courier Service</option>
                                <option value="dhl">DHL</option>
                                <option value="ups">UPS</option>
                                <option value="fedx">FEDEX</option>
                            </select>
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="courier_tracking_no">Tracking No*</label>
                            <input class="form-control" id="courier_tracking_no" name="courier_tracking_no">
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="courier_last_tracked">Last Tracked</label>
                            <input class="form-control" id="courier_last_tracked" name="courier_last_tracked"
                                   readonly="">
                            <span class="help-block text-danger" style="display: none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="courier_status">Status*</label>
                            <select class="form-control" id="courier_status" name="courier_status">
                                <option value="">Select Status</option>
                                <option value="booked">Booked</option>
                                <option value="dispatched">Dispatched</option>
                                <option value="delivered">Delivered</option>
                            </select>
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
        $('#addTracking').click(function () {
            var node = $('#updateTracking form');
            var instruction_id = node.find('input[name="instruction_id"]').val();
            var route = "{{ route('ajax.get_consignment', "INSTRUCTION_ID") }}".replace("INSTRUCTION_ID", instruction_id);
            $.ajax({
                type: "GET",
                url: route,
                cache: false,
                dataType: "json",
                success: function (response) {
                    node.find('select[name="courier_service"] option[value="' + response.courier_service + '"]').prop('selected', true);
                    node.find('input[name="courier_tracking_no"]').val(response.courier_tracking_no);
                    node.find('input[name="courier_last_tracked"]').val(response.courier_last_tracked);
                    node.find('select[name="courier_status"] option[value="' + response.courier_status + '"]').prop('selected', true);
                    $('#updateTracking').modal('show');
                },
                error: function () {
                    toastr['error']("Something Went Wrong");
                }
            });
        });
        $('#updateTracking form').submit(function (e) {
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
                    $('#updateTracking').modal('hide');
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
        // $('.datepicker').datetimepicker({
        //     format: 'L'
        // });
        // $('.datetimepicker-addon').on('click', function() {
        //   $(this).prev('input.datetimepicker').data('DateTimePicker').toggle();
        // });
    </script>
@endpush
