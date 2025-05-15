@extends('adminlte::page')
@section('title', 'Reports - Consignee Wise')

@section('content_header')
<h1>Consignee Wise</h1>
@endsection


@section('content')
		<div class="box">
			<div class="col-md-12">
				<div class="box-header">
					<h3>Download Reports by Consignee</h3>
				</div>
			 <div class="box-body">
			 	<form action="{{ url('consignee-wise/excel') }}" method="post">
                @csrf
                  <div class="row">
                   <div class="col-md-4 {{ $errors->has('consigneeName') ? 'has-error' : ''}}">
                   	<select class="myselect" style="width: 500px;" name="consignee_id">
						@foreach($consignees as $consignee)	
					  		<option value="{{ $consignee->id }}">{{ $consignee->name }}</option>
					  	@endforeach
			  		</select>
                   </div>
                   <div class="col-md-2">
                      <button type="submit" name="submit" class="btn btn-block btn-primary">Download Report</button>
                   </div>
                  </div>
              </form>
			 </div>
			</div>
			<div class="clearfix"></div>		
  		</div>
@endsection
@push('css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush
@push('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
      $(".myselect").select2();
</script>
@endpush