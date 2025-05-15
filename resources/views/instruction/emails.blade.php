@extends('adminlte::page')

@section('title', 'Emails - Instruction #' . $instruction->id)

@section('content_header')
    <h1 class="pull-left">Instruction <i>#{{ $instruction->id }}</i> - Emails</h1>
    <button id="addConsignment" class="btn btn-success pull-right">Booking Confirmation</button>
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button class="btn btn-primary add-btn-right" id="compose">Compose</button>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Sent/Received</th>
                            <th>From/To</th>
                            <th>Subject</th>
                            <th>Datetime</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($instruction->emails->sortByDesc('id') as $email)
                            <tr class="{{ $email->read ? '' : 'unread' }} read_email" data-email-id="{{ $email->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <button
                                        class="btn btn-xs btn-{{ $email->type == 'sent' ? 'warning' : 'success' }}">{{ $email->type == 'sent' ? 'Sent' : 'Received' }}</button>
                                </td>
                                <td class="sender">{{ $email->otherParty()->name }} &lt;
                                    <span>{{ $email->otherParty()->primary_email }}</span> &gt;
                                </td>
                                <td>{{ $email->subject }}</td>
                                <td>{{ $email->created_at->format('d/m/Y h:i:s a') }}</td>
                                <td>
                                    @if($email->type == 'received')
                                        <button class="btn btn-xs btn-success reply_email">
                                            <i class="fa fa-reply"></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-xs btn-primary forward_email">
                                        <i class="fa fa-reply forward"></i>
                                    </button>
                                    <form method="POST" action="" style="display: inline;" title="Remove">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('modals')
    <!-- Read Email -->
    <div class="modal" id="viewEmail">
        <div class="modal-dialog">
            <div class="modal-content" style="min-width: 680px;">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title pull-left" id="emailSubject"></h4>
                    <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th id="emailSender"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="emailBody"></td>
                            </tr>
                            </tbody>
                        </table>
                        <div id="forwardHeader" style="display: none;"></div>
                        {{-- <div class="col-md-12 email_border_bottom">
                          <strong id="emailSender"></strong>
                          <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12">
                          <div id="emailBody"></div>
                          <div class="clearfix"></div>
                        </div> --}}
                        <div id="emailAttachments" style="display: none;">
                            <h3 style="margin-top: 0px;">Attachments</h3>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>File</th>
                                    <th>Size</th>
                                </tr>
                                </thead>
                                <tbody class="">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Compose Email -->
    <div class="modal" id="composeEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ajax.new_email') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title pull-left">Compose New Email</h4>
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
                                       placeholder="Enter Subject" value="">
                                <span class="help-block text-danger" style="display: none;"></span>
                            </div>
                            <div class="form-group">
                                <label for="subject">Attachments</label>
                                <input type="file" multiple="" class="form-control" name="attachments[]"
                                       id="attachments">
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
    <!-- Forward Email -->
    <div class="modal" id="forwardEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ajax.forward_email') }}" method="post" enctype="multipart/form">
                    @csrf
                    <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                    <input type="hidden" name="email_id" value="">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title pull-left">Forward Email</h4>
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
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Forward</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Forward Email -->
    <div class="modal" id="replyEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ajax.reply_email') }}" method="post" enctype="multipart">
                    @csrf
                    <input type="hidden" name="instruction_id" value="{{ $instruction->id }}">
                    <input type="hidden" name="email_id" value="">
                    <input type="hidden" name="primary_email" value="">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title pull-left">Reply Email</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="subject">Attachments</label>
                                <input type="file" multiple="" class="form-control" name="attachments[]"
                                       id="attachments">
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
    @include('instruction.consignment_modal')
@endpush

@push('css')
    <style type="text/css">
        table {
            border: 3px solid #FFF;
            border-top: unset;
        }

        table thead tr {
            border-bottom: 3px solid #605ca8;
        }

        table tbody {
            background-color: #f5f7f7;
        }

        table tbody tr {
            cursor: pointer;
        }

        table tbody tr.unread {
            background-color: #FFF;
            font-weight: bold;
        }

        table tbody tr td form {
            display: inline !important;
        }

        i.fa-reply.forward {
            transform: rotateY(180deg);
        }

        .email_border_bottom {
            border-bottom: 1px solid #f4f4f4;
            padding-bottom: 5px;
        }

        .table {
            margin-bottom: 10px !important;
        }

        .mce-notification-warning {
            display: none;
        }

        .disabledDiv {
            pointer-events: none;
            opacity: 1.4;
        }
    </style>
@endpush

@push('js')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({selector: 'textarea'});
        $('.read_email').click(function () {
            var node = $(this)
            var email_id = node.data('email-id');
            var route = "{{ route('ajax.get_email', ['EMAIL_ID']) }}".replace("EMAIL_ID", email_id);
            $.ajax({
                type: "GET",
                url: route,
                dataType: "json",
                cache: true,
                success: function (response) {
                    $('#emailSubject').text(response.subject);
                    $('#emailSender').text(node.find('.sender').text());
                    $('#emailBody').html(response.body);
                    $('#forwardHeader').text(response.forward_header);
                    if (response.has_attachments) {
                        var html = '';
                        $(response.email_attachments).each(function (i, instance) {
                            html += '<tr><td>' + (i + 1) + '</td><td>';
                            html += '<a href="{{ asset('storage/attachments') }}/' + instance.path + '" target="_blank">' + instance.orig_filename + '</a>';
                            html += '</td><td>' + Math.round(instance.size / 1024) + ' KB</td></tr>'
                        });
                        $('#emailAttachments table tbody').html(html);
                        $('#emailAttachments').show();
                    } else {
                        $('#emailAttachments').html("");
                        $('#emailAttachments').hide();
                    }
                    // if(!response.read)
                    // {
                    markEmailAsRead(email_id);
                    // }
                    $('#viewEmail').modal('show');
                },
                error: function () {
                    toastr['error']("Something Went Wrong.");
                }
            });
        });
        $('#compose').click(function () {
            $('#composeEmail').modal('show');
        });
        $('#composeEmail form').submit(function (e) {
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
        $('.forward_email').click(function (e) {
            e.stopPropagation();
            var node = $(this).closest('tr');
            var email_id = node.data('email-id');
            $('#forwardEmail').modal('show');
            $('#forwardEmail form').find('input[name="email_id"]').val(email_id);
        });
        $('#forwardEmail form').submit(function (e) {
            e.preventDefault();
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
                    $('#forwardEmail').modal('hide');
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
        $('.reply_email').click(function (e) {
            e.stopPropagation();
            var node = $(this).closest('tr');
            var email_id = node.data('email-id');
            var primary_email = node.find('.sender span').text();
            $('#replyEmail').modal('show');
            $('#replyEmail form').find('input[name="email_id"]').val(email_id);
            $('#replyEmail form').find('input[name="primary_email"]').val(primary_email);
        });
        $('#replyEmail form').submit(function (e) {
            e.preventDefault();
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
                    $('#replyEmail').modal('hide');
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

        function markEmailAsRead(email_id) {
            if (email_id != '') {
                var route = "{{ route('ajax.email_read', ['EMAIL_ID']) }}".replace("EMAIL_ID", email_id);
                $.ajax({
                    type: "PUT",
                    url: route,
                    dataType: "json",
                    cache: false,
                    success: function (response) {
                        $('table tbody tr[data-email-id="' + email_id + '"]').removeClass('unread');
                    }
                });
            }
        }
    </script>
@endpush
