@extends('adminlte::page')

@section('title', 'List - Carriers')

@section('content_header')
    <h1>Carriers</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Carriers</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ route('carriers.store') }}" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('carrier_name') ? 'has-error' : ''}}">
                            <label for="carrier_name">Carrier Name *</label>
                            <input type="text"
                                   class="form-control {{ $errors->has('carrier_name') ? 'has-error' : ''}} "
                                   name="carrier_name" id="carrier_name" placeholder="Carrier Name"
                                   value="{{ old('carrier_name') }}">
                            @if ($errors->has('carrier_name'))
                                <span class="help-block text-danger">{{ $errors->first('carrier_name') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('tracking_url') ? 'has-error' : ''}}">
                            <label for="tracking_url">Tracking URL</label>
                            <input type="text" class="form-control" name="tracking_url" id="tracking_url"
                                   placeholder="Tracking URL"
                                   value="{{ old('tracking_url') }}">
                            @if ($errors->has('tracking_url'))
                                <span class="help-block text-danger">{{ $errors->first('tracking_url') }}</span>
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

    </script>
@endpush
