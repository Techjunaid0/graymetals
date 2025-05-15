@extends('adminlte::page')

@section('title', 'List - Contracts')

@section('content_header')
    <h1>Contracts</h1>
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
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="contracts" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice No</th>
                            <th>Contract No</th>
                            <th>Container No</th>
                            <th>Contract Date</th>
                            <th>Supplier Name</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($contracts as $key=>$contract)
                            <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $contract->invoice_no }}</td>
                                <td>{{ $contract->contract_no }}</td>
                                <td>{{ $contract->container_no }}</td>
                                <td>{{ $contract->contract_date }}</td>
                                <td>{{ $contract->supplier_name }}</td>
                                <td>{{ ucfirst(str_replace('_',' ',$contract->status)) ?? '-' ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_',' ',$contract->payment_status)) ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group action-buttons">
                                        <a href="{{ route('contracts.show', $contract->id) }}">
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip"
                                                    title="Show"><i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('contracts.edit', $contract->id) }}">
                                            <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip"
                                                    title="Edit"><i class="fa fa-pencil"></i>
                                            </button>
                                        </a>
                                        <form class="inline-block remove"
                                              action="{{ route('contracts.destroy',$contract->id) }}" method="post">
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
        $('#contracts').DataTable({
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
    </script>
@endpush

