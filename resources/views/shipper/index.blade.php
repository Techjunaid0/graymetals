@extends('adminlte::page')

@section('title', 'List - Shipper Detials')

@section('content_header')
  <h1>Shipper Details</h1>
@endsection

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('shipper.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="shippingCompany" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Shipper Name</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($shipper_detial as $shipper_detials)
                  <tr>
                    <td>{{ $shipper_detials->id }}</td>
                    <td>{{ $shipper_detials->name }}</td>
                    <td>{{ $shipper_detials->country->name }}</td>
                    <td>{{ $shipper_detials->city->name }}</td>
                    <td>{{ $shipper_detials->address }}</td>
                    <td class="text-center">
                      <div class="btn-group action-buttons"> 
                         <a href="{{ route('shipper.show', $shipper_detials->id) }}" >
                          <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i>
                          </button>
                        </a>
                        <a href="{{ route('shipper.edit', $shipper_detials->id) }}">
                          <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i>
                          </button>
                        </a> 
                        <form action="{{ route('shipper.destroy',$shipper_detials->id) }}" method="post" class="form-inline remove">
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
