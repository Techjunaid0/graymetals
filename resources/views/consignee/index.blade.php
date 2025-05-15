@extends('adminlte::page')

@section('title', 'List - Consignee Detials')

@section('content_header')
  <h1>Consignee Details</h1>
@endsection

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('consignee.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="shippingCompany" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Consignee Name</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($consignees as $consignee)
                  <tr>
                    <td>{{ $consignee->id }}</td>
                    <td>{{ $consignee->name }}</td>
                    <td>{{ $consignee->country->name ?? '-' }}</td>
                    <td>{{ $consignee->city->name ?? '-' }}</td>
                    <td>{{ $consignee->address ?? '-' }}</td>
                    <td class="text-center">
                      <div class="btn-group action-buttons"> 
                         <a href="{{ route('consignee.show', $consignee->id) }}" >
                          <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i>
                          </button>
                        </a>
                        <a href="{{ route('consignee.edit', $consignee->id) }}">
                          <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i>
                          </button>
                        </a> 
                        <form class="inline-block remove" action="{{ route('consignee.destroy',$consignee->id) }}" method="post">
                          @csrf
                          @method('delete')
                          <button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i>
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
   display: inline-block !important ;
}
</style>
@endpush
@push('js')
<script type="text/javascript">
  $('#shippingCompany').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "order"       : [[ 0, "desc" ]]
  });
  $('form.remove').submit(function(e){
    var node = $(this);
    e.preventDefault();
    if(confirm("Are you sure? You really want to delete this?"))
    {
      node.unbind('submit');
      node.submit();
    }
  });
</script>
@endpush
