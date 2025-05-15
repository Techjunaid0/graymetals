@extends('email_templates.master')

@section('title', $subject . " - GrayMetals")

@section('heading', $subject)

@section('content')
	{!! $body !!}
@endsection