@extends('email_templates.master')

@section('title', "Supplier Instruction - GrayMetals")

@section('heading', "New Instruction")

@section('content')
{{--	<p>Dear Sir</p>--}}
	<p>
		{{ $instruction->instructions }}
	</p>
	<br>
	<p><strong>Datetime: </strong>{{ $instruction->pickup_datetime->format('l d/m/Y \a\t ha') }}</p>
	<p><strong>Loading from: </strong>{{ $instruction->supplier->address }}</p>
	<p><strong>Going to: </strong>{{ $instruction->consignment->dischargePort->name }}</p>
	<p><strong>Doors to: </strong>{{ $instruction->door_orientation }}</p>
	<br>
	<p>Thanks</p>
@endsection
