@extends('adminlte::page')

@section('title', 'List - User Profiles')

@section('content_header')
  <h1>User Profiles</h1>
@endsection

@section('content')
      <div class="row">
        <div class="col-md-12">
          @if(session('message'))
             <div class="alert alert-success" role="alert">{{ session('message') }}</div>
          @endif
        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <a href="{{ url('profile/create') }}"><button class="btn btn-primary add-btn-right">Add New</button></a>
              <a href="{{ url('download/excel/') }}"><button class="btn btn-primary add-btn-right">Export to XLSX</button></a>
              <div class="mrgn">
                <form action="{{ url('download/excel/') }}" method="post">
                @csrf
                  <div class="row">
                   <div class="col-md-4 {{ $errors->has('from') ? 'has-error' : ''}}">
                    <label>From</label>
                      <input type="date" name="from" class="form-control" value="{{ old('from') }}">
                       @if ($errors->has('from'))
                    <span class="help-block text-danger">{{ $errors->first('from') }}</span>
                  @endif
                   </div>
                   <div class="col-md-4 {{ $errors->has('to') ? 'has-error' : ''}}">
                    <label>To</label>
                      <input type="date" name="to" class="form-control" value="{{ old('to') }}">
                       @if ($errors->has('to'))
                    <span class="help-block text-danger">{{ $errors->first('to') }}</span>
                  @endif
                   </div>
                   <div class="col-md-2">
                    <label>&nbsp</label>
                      <button type="submit" name="submit" class="btn btn-block btn-primary">Export to Excel</button>
                   </div>
                  </div>
              </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="profile" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($profiles as $profile)
                  <tr>
                    <td>{{ $profile->id }}</td>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->email }}</td>
                    <td class="text-center">
                      <div class="btn-group action-buttons"> 
                         <a href="{{ url('profile/show', $profile->id) }}" >
                          <button class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Show"><i class="fa fa-eye"></i>
                          </button>
                        </a>
                        <a href="{{ url('profile/edit', $profile->id) }}">
                          <button class="btn btn-xs btn-primary" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i>
                          </button>
                        </a> 
                        <form class="inline-block remove" action="{{ url('profile/destroy',$profile->id) }}" method="post">
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
.mrgn
{
  margin: 20px 0;
}
</style>
@endpush
@push('js')
<script type="text/javascript">
  $('#profile').DataTable({
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
