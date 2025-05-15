@extends('adminlte::page')

@section('title', 'List - Suppliers')

@section('content_header')
<h1>Supplier Deatils</h1>
@endsection

@section('content')
<div class="row">
      <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Supplier Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           <form action="{{ route('supplier.update', $supplier_detail->id) }}" method="post">
             @csrf
             @method('put')
              <div class="box-body">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                  <label for="name">Supplier Name</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? 'has-error' : ''}} " name="name" id="name" placeholder="Supplier Name" value="{{ old('name', $supplier_detail->name) }}">
                  @if ($errors->has('name'))
                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                  <label for="phone">Supplier Phone</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Supplier Phone" value="{{ old('phone', $supplier_detail->phone) }}">
                  @if ($errors->has('phone'))
                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                  @endif
                </div>
                 <div class="form-group {{ $errors->has('primary_email') ? 'has-error' : ''}}">
                  <label for="primary_email">Supplier Primary Email</label>
                  <input type="text" class="form-control" name="primary_email" id="primary_email" placeholder="Supplier Primary Email" value="{{ old('primary_email', $supplier_detail->primary_email) }}">
                   @if ($errors->has('primary_email'))
                    <span class="help-block text-danger">{{ $errors->first('primary_email') }}</span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : ''}}">
                  <label for="postal_code">Postal Code </label>
                  <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Postal Code" value="{{ old('postal_code', $supplier_detail->postal_code) }}">
                   @if ($errors->has('postal_code'))
                    <span class="help-block text-danger">{{ $errors->first('postal_code') }}</span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
                  <label for="country_id">Country</label>
                  <select class="form-control" id="country_id" name="country_id">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                     <option value="{{$country->id}}" {{ $country->id == old('country_id', $supplier_detail->country_id) ? 'selected' : ''}}>{{$country->name }}</option>
                    @endforeach
                  </select>
                   @if ($errors->has('country_id'))
                    <span class="help-block text-danger">{{ $errors->first('country_id') }}</span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
                  <label for="city_id">City</label>
                 <select class="form-control" id="city_id" name="city_id">
                    <option value="">Select City</option>
                  </select>
                  @if ($errors->has('city_id'))
                    <span class="help-block text-danger">{{ $errors->first('city_id') }}</span>
                  @endif
                </div>
                 <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                  <label for="category_title">Supplier Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Supplier Address" value="{{ old('address', $supplier_detail->address) }}">
                   @if ($errors->has('address'))
                    <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                  @endif
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection

@push('js')
  <script type="text/javascript">
     $(function(){
        $("#country_id").change(function(){
          var countryId = $(this).val();
          if ( $('countryId').val() != '' ) 
          {
            var endPoint  = "{{ route('ajax.get_states', ['COUNTRY_ID']) }}".replace("COUNTRY_ID", countryId);
            $.ajax({
                type: "GET",
                url: endPoint,
                dataType: "json",
                cache: true,
                success: function(response)
                {
                  $("#state_id").empty();
                  $("#state_id").html("<option value=''>Select State</option>");
                  $.each(response, function(i, item) {
                    $('#state_id').append($('<option>', {value:item.id, text:item.name}));
                  });
                }
            });
            endPoint  = "{{ route('ajax.get_cities_by_country', ['COUNTRY_ID']) }}".replace("COUNTRY_ID", countryId);
            $.ajax({
                type: "GET",
                url: endPoint,
                dataType: "json",
                cache: true,
                success: function(response)
                {
                  $("#city_id").empty();
                  $("#city_id").html("<option value=''>Select City</option>");
                  $.each(response, function(i, item) {
                    $('#city_id').append($('<option>', {value:item.id, text:item.name}));
                  });
                }
            });
          }
        });
         $("#state_id").change(function(){
            var stateId = $(this).val();
            if ( $('stateId').val() != '' ) {
            var endPoint  = "{{ route('ajax.get_cities_by_state', ['STATE_ID']) }}".replace("STATE_ID", stateId);
            $.ajax({
                type: "GET",
                url: endPoint,
                dataType: "json",
                cache: true,
                success: function(response)
                {
                  $("#city_id").empty();
                  $("#city_id").html("<option value=''>Select City</option>");
                  $.each(response, function(i, item) {
                    $('#city_id').append($('<option>', {value:item.id, text:item.name}));
                  });
                }
            });
          }
        });
        $("#country_id").trigger('change');
        $("#state_id").trigger('change');
        setTimeout(function(){
          var old_state_id  = '{{ old('state_id', $supplier_detail->state_id) }}';
          var old_city_id   = '{{ old('city_id', $supplier_detail->city_id) }}';
          if(old_state_id != '')
          {
            $("#state_id option[value='" + old_state_id + "']").prop('selected', true);
          }
          if(old_city_id != '')
          {
            $("#city_id option[value='" + old_city_id + "']").prop('selected', true);
          }
        }, 1000);
    });
  </script>
@endpush