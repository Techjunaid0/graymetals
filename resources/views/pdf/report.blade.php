@extends('pdf.master')

@section('content')
  <table>
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
          <td>{{ ucfirst($instruction->status) }}</td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="5">GrayMetals - Report Generate at {{ date('d-m-Y h:i:s a') }}</th>
      </tr>
    </tfoot>
  </table>
@endsection