@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
  <h1>Reports</h1>
@endsection

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="pull-left">
                <form class="form-inline" action="" method="GET">
                  <div class="form-group">
                    <label for="from_date">From:</label>
                    <input type="text" class="form-control datepicker" id="from_date" placeholder="Enter date" name="from_date" value="{{ urldecode($_GET['from_date'] ?? '') }}">
                  </div>
                  <div class="form-group">
                    <label for="to_date">To:</label>
                    <input type="text" class="form-control datepicker" id="to_date" placeholder="Enter date" name="to_date" value="{{ urldecode($_GET['to_date'] ?? '') }}">
                  </div>
                  <button type="submit" class="btn btn-primary">Go</button>
                </form>
              </div>
              <div class="pull-right">
                <a href="{{ route('reports.download') }}" id="download">
                  <button class="btn btn-danger">
                    <i class="fa fa-download"></i>
                  </button>
                </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="reports" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Date</th>
                  <th>Consignee</th>
                  <th>Supplier</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($instructions as $instruction)
                  <tr>
                    <td>{{ $instruction->id }}</td>
                    <td>{{ $instruction->case_datetime->format('d/m/Y') }}</td>
                    <td>{{ $instruction->consignment->consignee->name }}</td>
                    <td>{{ $instruction->supplier->name ?? '' }}</td>
                    <td>{{ $instruction->consignment->price ?? '' }}</td>
                    <td>
                      <button class="btn btn-xs btn-success">
                        {{ ucfirst($instruction->status) }}
                      </button>
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
   display: inline-block !important ;
}
</style>
@endpush
@push('js')
<script type="text/javascript">
  $('#reports').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order"       : [[ 0, "desc" ]]
  });
  $('.datepicker').datetimepicker({
      format: 'L'
  });
  $('.datetimepicker-addon').on('click', function() {
    $(this).prev('input.datetimepicker').data('DateTimePicker').toggle();
  });
  $('#download').click(function(e){
    e.preventDefault();
    var url       = $(this).attr('href');
    var from_date = encodeURIComponent($('input[name="from_date"]').val());
    var to_date   = encodeURIComponent($('input[name="to_date"]').val());
    window.location.href = url + "?from_date=" + from_date + "&to_date=" + to_date;
  });
</script>
@endpush
