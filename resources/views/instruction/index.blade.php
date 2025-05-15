@extends('adminlte::page')

@section('title', 'List - Case Detials')

@section('content_header')
    <h1>Instructions</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{ route('instruction.create') }}">
                        <button class="btn btn-primary add-btn-right">Add New</button>
                    </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="shippingCompany" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Shipping Company Reference</th>
                            <th>Case Date Time</th>
                            <th>Shipping Company Name</th>
                            <th>Supplier Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($instructions as $instruction)
                            <tr>
                                <td>{{ $instruction->id }}</td>
                                <td>{{ $instruction->consignment->reference ?? '-' }}</td>
                                <td>{{ $instruction->case_datetime->format('d/m/Y h:i a') }}</td>
                                <td>{{ $instruction->shippingCompany->name ?? '-' }}</td>
                                <td>{{ $instruction->supplier->name ?? '-' }}</td>
                                <td>
                                    @if($instruction->status == 'pending')
                                        <button class="btn btn-xs btn-warning">Request Sent to Shipping Co.</button>
                                    @elseif($instruction->status == 'processing')
                                        @if(!empty($instruction->consignment->confirmation_date))
                                            @if(is_file(storage_path('app/public/attachments/invoice_' . $instruction->id . '.pdf')))
                                                @if($instruction->consignment->document_sent)
                                                    <button class="btn btn-xs btn-info">Documents Sent to Customer
                                                    </button>
                                                @else
                                                    <button class="btn btn-xs btn-danger">Documents Sent for Customer
                                                        Clearance
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-xs btn-info">Booking Confirmed</button>
                                            @endif
                                        @else
                                            <button class="btn btn-xs btn-info">Shipping Co. Working on Instruction
                                            </button>
                                        @endif
                                    @else
                                        <button class="btn btn-xs btn-success">Completed</button>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group action-buttons">
                                        <a href="{{ route('instruction.show', $instruction->id) }}">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip"
                                                    title="Show"><i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('instruction.emails', $instruction->id) }}">
                                            <button class="btn btn-xs btn-info" type="button" data-toggle="tooltip"
                                                    title="Mail"><i class="fa fa-envelope"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('instruction.edit', $instruction->id) }}">
                                            <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip"
                                                    title="Edit"><i class="fa fa-pencil"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('instruction.destroy',$instruction->id) }}" method="post"
                                              class="form-inline remove">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip"
                                                    title="Remove"><i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection

@push('css')
    <style type="text/css">
        .action-buttons form {
            display: inline-block !important;
        }
    </style>
@endpush
@push('js')
    <script type="text/javascript">
        $('#shippingCompany').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "order": [[0, "desc"]]
        });
        $('form.remove').submit(function (e) {
            var node = $(this);
            e.preventDefault();
            if (confirm("Are you sure? You really want to delete this?")) {
                node.unbind('submit');
                node.submit();
            }
        });
        $('.addConsignment').click(function () {
            var instruction_id = $(this).data('instruction-id');
            $('#newConsignment form').find('input[name="instruction_id"]').val(instruction_id);
            $('#newConsignment').modal('show');
        });
    </script>
@endpush
