@extends('adminlte::page')

@section('title', 'List - Shipping Companies')

@section('content_header')
  <h1>Shipping Company</h1>
@endsection

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ route('shipping_co.create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="shippingCompany" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Company Name</th>
                  <th>Country</th>
                  <th>City</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($shipping_companies as $shipping_company)
                  <tr>
                    <td>{{ $shipping_company->id }}</td>
                    <td>{{ $shipping_company->name }}</td>
                    <td>{{ $shipping_company->country->name ?? '-' }}</td>
                    <td>{{ $shipping_company->city->name ?? '-' }}</td>
                    <td>{{ $shipping_company->address ?? '-' }}</td>
                    <td class="text-center">
                      <div class="btn-group action-buttons"> 
                         <a href="{{ route('shipping_co.show', $shipping_company->id) }}" >
                          <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i>
                          </button>
                        </a>
                        <a href="{{ route('shipping_co.edit', $shipping_company->id) }}">
                          <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i>
                          </button>
                        </a> 
                        <form action="{{ route('shipping_co.destroy',$shipping_company->id) }}" method="post" class="form-inline remove">
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
