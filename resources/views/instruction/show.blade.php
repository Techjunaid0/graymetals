@extends('adminlte::page')

@section('title', 'Show - Instruction Details')

@section('content_header')
    <h1 class="pull-left">Instruction # {{ ($instruction->consignment) ? $instruction->consignment->reference : '--' }}</h1>
    @if($instruction->status != 'completed')
        <a href="{{ route('instruction.complete', $instruction->id) }}" title="Mark as Completed">
            <button class="btn btn-success pull-right" id="completeInstruction">Completed?</button>
        </a>
    @endif
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4>Details</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered">
                        <tr>
                            <th>Instruction Date Time</th>
                            <td>{{ $instruction->case_datetime->format('d/m/Y h:i a') }}</td>
                            <th>Pickup Date Time</th>
                            <td>{{ $instruction->pickup_datetime->format('d/m/Y h:i a') }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Company</th>
                            <td>{{ $instruction->shippingCompany->name }}</td>
                            <th>Supplier</th>
                            <td>{{ $instruction->supplier->name }}</td>
                        </tr>
                        <tr>
                            <th>Consignee</th>
                            <td>
                                <div class="form-group" id="selectConsignee"
                                     style="display: {{ isset($instruction->consignment->consignee) ? 'none;' : 'block;' }}">
                                    <select class="form-control" name="consignee_id">
                                        <option value="">Select</option>
                                        @foreach($consignee_list as $consignee)
                                            <option value="{{ $consignee->id }}">{{ $consignee->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="" id="saveConsignee"><i>Save</i></a>
                                </div>
                                <div id="showConsignee"
                                     style="display: {{ isset($instruction->consignment->consignee) ? 'block;' : 'none;' }}">
                                    <span>{{ $instruction->consignment->consignee->name ?? '-' }}</span> <a href=""
                                                                                                            id="updateConsignee"><i>Update</i></a>
                                </div>
                            </td>
                            <th>Consignee Address</th>
                            <td>{{ $instruction->consignment->consignee->address ?? '-' }}
                                , {{ $instruction->consignment->consignee->country->name ?? '' }}</td>
                        </tr>
                        <tr>
                            <th>Notify Party</th>
                            <td>
                                <div class="form-group" id="selectNotify"
                                     style="display: {{ isset($instruction->consignment->notifyParty) ? 'none;' : 'block;' }}">
                                    <select class="form-control" name="notify_party_id">
                                        <option value="">Select</option>
                                        @foreach($consignee_list as $consignee)
                                            <option value="{{ $consignee->id }}">{{ $consignee->name }}</option>
                                        @endforeach
                                    </select>
                                    <a href="" id="saveNotify"><i>Save</i></a>
                                </div>
                                <div id="showNotify"
                                     style="display: {{ isset($instruction->consignment->notifyParty) ? 'block;' : 'none;' }}">
                                    <span>{{ $instruction->consignment->notifyParty->name ?? '-' }}</span> <a href=""
                                                                                                              id="updateNotify"><i>Update</i></a>
                                </div>
                            </td>
                            <th>Port of Loading</th>
                            <td>{{ $instruction->consignment->loadingPort->name }}</td>
                        </tr>
                        <tr>
                            <th>Port of Discharge</th>
                            <td>{{ $instruction->consignment->dischargePort->name }}</td>
                            <th>Final Destination</th>
                            <td>{{ $instruction->consignment->final_destination }}</td>
                        </tr>
                        <tr>
                            <th>Weight (KG)</th>
                            <td>{{ $instruction->weight }}</td>
                            <th>Instructions</th>
                            <td colspan="3">{{ $instruction->instructions }}</td>
                        </tr>
                        <tr>
                            <th>No of Containers</th>
                            <td colspan="3">{{ $instruction->no_of_containers }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4>Booking Info</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    @if(!empty($instruction->consignment->confirmation_date))
                        <table class="table table-bordered">
                            <tr>
                                <th>Date</th>
                                <td>{{ $instruction->consignment->confirmation_date->format('m/d/Y') }}</td>
                                <th>Carrier</th>
                                <td>{{ $instruction->consignment->carrier }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Company's Reference</th>
                                <td>{{ ($instruction->consignment->reference) ? $instruction->consignment->reference : '--' }}</td>
                                <th>ETA</th>
                                <td>{{ ($instruction->consignment->eta) ? $instruction->consignment->eta->format('m/d/Y') : '--' }}</td>
{{--                                <th>Line Reference</th>--}}
{{--                                <td>{{($instruction->consignment->line_reference) ? $instruction->consignment->line_reference : '--' }}</td>--}}
                            </tr>
{{--                            <tr>--}}
{{--                                <th>Vessel</th>--}}
{{--                                <td>{{ ($instruction->consignment->vessel) ? $instruction->consignment->vessel :'--' }}</td>--}}
{{--                                <th>UCR</th>--}}
{{--                                <td>{{ ($instruction->consignment->ucr) ? $instruction->consignment->ucr : '-' }}</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <th>ETS</th>--}}
{{--                                <td>{{ ($instruction->consignment->ets) ? $instruction->consignment->ets->format('m/d/Y') : '--' }}</td>--}}
{{--                               --}}
{{--                            </tr>--}}

                            <tr>
                                <th>Tracking URL</th>
                                <td colspan="3">{{ $instruction->consignment->tracking_url }}</td>
                            </tr>
                        </table>
                    @endif
                    <button id="addConsignment"
                            class="btn btn-success pull-right">{{ !empty($instruction->consignment->confirmation_date) ? 'Update ' : '' }}
                        Booking Confirmation
                    </button>
                    @if(!empty($instruction->consignment->confirmation_date))
                        <a href="{{$instruction->consignment->tracking_url}}" target="_blank">
                            <button id="trackIT" class="btn btn-danger pull-right"
                                    style="float: left !important; margin: 10px;"><i class="fa fa-search"></i> Track
                            </button>
                        </a>
                    @endif
                    @include('instruction.consignment_modal')
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4>Documents Courier</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    @if($instruction->consignment->document_sent)
                        <table class="table table-bordered">
                            <tr>
                                <th>Courier Service</th>
                                <td>{{ strtoupper($instruction->consignment->courier_service) }}</td>
                                <th>Courier Tracking No</th>
                                <td>{{ $instruction->consignment->courier_tracking_no }}</td>
                            </tr>
                            <tr>
                                <th>Courier Last Tracked</th>
                                <td>{{ $instruction->consignment->courier_last_tracked->format('m/d/Y') }}</td>
                                <th>Courier Status</th>
                                <td>{{ ucfirst($instruction->consignment->courier_status) }}</td>
                            </tr>
                        </table>
                        <a href="#" id="trackIT" class="btn btn-danger pull-right trackIT"
                           style="float: left !important; margin: 10px;"><i class="fa fa-search"></i> Track
                        </a>
                    @endif
                    <button id="addTracking" class="btn btn-success pull-right"
                            style="float: left !important; margin: 10px;{{ $instruction->consignment->document_sent ? '' : 'margin-top: 0px;' }}">
                        <i class="fa fa-truck"></i> {{ $instruction->consignment->document_sent ? 'Update ' : 'Add ' }}
                        Tracking Info
                    </button>
                    @include('instruction.tracking_modal')
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="pull-left">Invoice</h4>
                    @if(optional($instruction->consignment->consignmentDetails)->count() > 0)
                        <a href="{{ route('ajax.download_invoice', ['id' => $instruction->id]) }}">
                            <button class="btn btn-primary pull-right" style="margin: 0 5px;" title="Download"><i
                                    class="fa fa-download"></i></button>
                        </a>
                        <button class="btn btn-success pull-right" style="margin: 0 5px;" title="Email Invoice"
                                onclick="$('#composeEmail').modal('show')"><i class="fa fa-envelope"></i></button>
                    @endif
                </div>
                <div class="box-body table-responsive no-padding">
                    @if(optional($instruction->consignment->consignmentDetails)->count() > 0)
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Item Description</th>
                                <th>Total Qty. (Weight)</th>
                                <th>Price/Ton</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($instruction->consignment->consignmentDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->description }}</td>
                                    {{--                                    <td>{{ number_format($item->item_weight / 1000, 2, '.', '') }}(approx.)</td>--}}
                                    <td>{{ number_format($item->item_weight, 2, '.', '') }}</td>
                                    {{--                                    <td>{{ $instruction->consignment->currency->symbol }}{{ number_format($item->price * 1000, 2, '.', '') }}</td>--}}
                                    <td>{{ $instruction->consignment->currency->symbol }}{{ number_format($item->price, 2, '.', '') }}</td>
                                    <td>{{ $instruction->consignment->currency->symbol }}{{ number_format($item->total_price, 2, '.', '') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4">Total Amount Payable</th>
                                <td>{{ $instruction->consignment->currency->symbol }}{{ number_format($instruction->consignment->consignmentDetails->pluck('total_price')->sum(), 2, '.', '') }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        <button class="btn btn-success pull-right consignmentItems"
                                style="float: right !important; margin: 10px;">
                            <i class="fa fa-cogs"> Update Invoice</i>
                        </button>
                    @else
                        <button class="btn btn-success pull-right consignmentItems"
                                style="float: left !important; margin: 10px; margin-top: 0px;">
                            <i class="fa fa-cogs"> Generate Invoice</i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4 class="pull-left">Documents</h4>
                    {{-- <a href="{{ route('ajax.download_si', ['id' => $instruction->id]) }}">
                      <button class="btn btn-primary pull-right" style="margin: 0 5px;" title="Download SI Document"><i class="fa fa-download"></i></button>
                    </a> --}}
                    <button class="btn btn-success pull-right" style="margin: 0 5px;" title="Email Documents"
                            onclick="$('#composeDocumentEmail').modal('show')"><i class="fa fa-envelope"></i></button>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Document</th>
                            <th>Download</th>
                            {{-- <th>Email</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Invoice</td>
                            <td>
                                @if(optional($instruction->consignment->consignmentDetails)->count() > 0)
                                    <a href="{{ route('ajax.download_invoice', ['id' => $instruction->id]) }}">
                                        <button class="btn btn-primary pull-right" style="margin: 0 5px;"
                                                title="Download"><i class="fa fa-download"></i></button>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>SI Document</td>
                            <td>
                                <a href="{{ route('ajax.download_si', ['id' => $instruction->id]) }}">
                                    <button class="btn btn-primary pull-right" style="margin: 0 5px;"
                                            title="Download SI Document"><i class="fa fa-download"></i></button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>VGM FORM</td>
                            <td>
                                <a href="{{ route('ajax.download_vgm', ['id' => $instruction->id]) }}">
                                    <button class="btn btn-primary pull-right" style="margin: 0 5px;"
                                            title="Download VGM FORM"><i class="fa fa-download"></i></button>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h4>Files & Documents</h4>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Datetime</th>
                            <th>From/To</th>
                            <th>Subject</th>
                            <th>File(s)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($instruction->emails->sortByDesc('id') as $email)
                            @continue(!$email->has_attachments)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $email->created_at->format('d/m/Y h:i:s a') }}</td>
                                <td>{{ $email->otherParty()->name }} &lt;
                                    <span>{{ $email->otherParty()->primary_email }}</span> &gt;
                                </td>
                                <td>{{ $email->subject }}</td>
                                <td class="">
                                    <ul>
                                        @foreach($email->emailAttachments as $attachment)
                                            <li><a href="{{ asset('storage/attachments/' . $attachment->path) }}"
                                                   target="_blank">{{ $attachment->orig_filename }}</a></li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Compose Email -->
    <div class="modal" id="composeEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ajax.email_invoice') }}" method="post">
                    @csrf
                    <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title pull-left">Send Invoice</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="subject">Recipient*</label>
                                <select class="form-control" name="primary_email">
                                    <option value="">Select Recipient</option>
                                    @if(isset($instruction->consignment->consignee))
                                        <option
                                            value="{{ $instruction->consignment->consignee->primary_email }}">{{ $instruction->consignment->consignee->name }}
                                            | Consignee
                                        </option>
                                    @endif
                                    <option
                                        value="{{ $instruction->shippingCompany->primary_email }}">{{ $instruction->shippingCompany->name }}
                                        | Shipping Company
                                    </option>
                                    <option
                                        value="{{ $instruction->supplier->primary_email }}">{{ $instruction->supplier->name }}
                                        | Supplier
                                    </option>
                                </select>
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject*</label>
                                <input type="text" class="form-control" name="subject" id="subject"
                                       placeholder="Enter Subject"
                                       value="Invoice for Instruction # {{ ($instruction->consignment) ? $instruction->consignment->reference : '--' }} - GrayMetals">
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>

                            <div class="form-group">
                                <label for="message">Message*</label>
                                <textarea class="textarea" name="body" placeholder="Enter Message"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Compose Email SI Document -->
    <div class="modal" id="composeDocumentEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ajax.email_documents') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title pull-left">Send Documents</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="primary_email">Recipient*</label>
                                <select class="form-control" name="primary_email" id="primary_email">
                                    <option value="">Select Recipient</option>
                                    @if(isset($instruction->consignment->consignee))
                                        <option
                                            value="{{ $instruction->consignment->consignee->primary_email }}">{{ $instruction->consignment->consignee->name }}
                                            | Consignee
                                        </option>
                                    @endif
                                    <option
                                        value="{{ $instruction->shippingCompany->primary_email }}">{{ $instruction->shippingCompany->name }}
                                        | Shipping Company
                                    </option>
                                    <option
                                        value="{{ $instruction->supplier->primary_email }}">{{ $instruction->supplier->name }}
                                        | Supplier
                                    </option>
                                </select>
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject*</label>
                                <input type="text" class="form-control" name="subject" id="subject"
                                       placeholder="Enter Subject"
                                       value="Documents # {{ ($instruction->consignment) ? $instruction->consignment->reference : '--' }} - GrayMetals">
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                            <div class="form-group">
                                <label for="subject">Attachments</label>
                                <input type="file" multiple="" class="form-control" name="attachments[]"
                                       id="attachments">
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                            <div class="form-group">
                                <label for="body">Message*</label>
                                <textarea class="textarea" name="body" id="body" placeholder="Enter Message"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    Dear Sir,
                    Please find attached SI, VGM and PI for above mentioned loading.

                    Thanks
                  </textarea>
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Instruction Items -->
    @include('instruction.items_modal')
@endpush

@push('css')
    <style type="text/css">
        .disabledDiv {
            pointer-events: none;
            opacity: 1.4;
        }

        div.box-header h4 {
            margin-top: 0px;
            font-weight: bold;
        }

        #addConsignment {
            float: left !important;
            margin: 10px;
            @if(empty($instruction->consignment->confirmation_date))
      margin-top: 0px;
        @endif






        }

        .mce-notification-warning {
            display: none;
        }
    </style>
@endpush

@push('js')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({selector: 'textarea'});
        $('#composeEmail form').submit(function (e) {
            e.preventDefault();
            tinymce.triggerSave();
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
                    $('#composeEmail').modal('hide');
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
        $('#composeDocumentEmail form').submit(function (e) {
            e.preventDefault();
            tinymce.triggerSave();
            var node = $(this);
            var action = node.attr('action');
            var data = new FormData(node[0]);
            $.ajax({
                type: "POST",
                url: action,
                data: data,
                contentType: false,
                processData: false,
                dataType: "json",
                cache: false,
                success: function (response) {
                    toastr['success'](response.message);
                    $('#composeDocumentEmail').modal('hide');
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
        $('.consignmentItems').click(function (e) {
            e.preventDefault();
            $('#consignmentItems').modal('show');
        });
        @if($instruction->consignment->document_sent)
        $('.trackIT').click(function () {
            var courier = '{{$instruction->consignment->courier_service}}';
            var url ='';
            if( courier === 'dhl'){
                url ='http://www.dhl.com.pk/en/express.html';
            }else if(courier === 'ups'){
                url ='https://www.ups.com/track?loc=en_US&requester=ST/';
            }else{
                url ='https://www.fedex.com/en-us/home.html';
            }


            {{--var url = "{{ $instruction->consignment->courier_service == 'dhl'  ? "http://www.dhl.com.pk/en/express.html" : "https://www.ups.com/track?loc=en_US&requester=ST/" }}";--}}
            var code = "{{ $instruction->consignment->courier_tracking_no }}";
            const el = document.createElement('textarea');
            el.value = code;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            toastr['success']("Tracking Code Copied to Clipboard. You're being Redirected...");
            setTimeout(function () {
                window.open(url, '_blank');
            }, 2000);
        });
        @endif
        $('#updateConsignee').click(function (e) {
            e.preventDefault();
            $('#showConsignee').hide();
            $('#selectConsignee').show();
        });
        $('#saveConsignee').click(function (e) {
            e.preventDefault();
            var consignee_id = $('#selectConsignee').find('select option:selected').val();
            if (consignee_id != "") {
                var data = "consignee_id=" + $('#selectConsignee').find('select option:selected').val();
                $.ajax({
                    type: "PUT",
                    url: "{{ route('ajax.save_consignee', ['id' => $instruction->id]) }}",
                    data: data,
                    dataType: "json",
                    cache: false,
                    success: function (response) {
                        toastr['success'](response.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (response) {
                        toastr['error']("Something Went Wrong.")
                    }
                });
            } else {
                $('#showConsignee').show();
                $('#selectConsignee').hide();
            }
        });
        $('#updateNotify').click(function (e) {
            e.preventDefault();
            $('#showNotify').hide();
            $('#selectNotify').show();
        });
        $('#saveNotify').click(function (e) {
            e.preventDefault();
            var consignee_id = $('#selectNotify').find('select option:selected').val();
            if (consignee_id != "") {
                var data = "consignee_id=" + $('#selectNotify').find('select option:selected').val();
                $.ajax({
                    type: "PUT",
                    url: "{{ route('ajax.save_notify', ['id' => $instruction->id]) }}",
                    data: data,
                    dataType: "json",
                    cache: false,
                    success: function (response) {
                        toastr['success'](response.message);
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (response) {
                        toastr['error']("Something Went Wrong.")
                    }
                });
            } else {
                $('#showNotify').show();
                $('#selectNotify').hide();
            }
        });
    </script>
@endpush
