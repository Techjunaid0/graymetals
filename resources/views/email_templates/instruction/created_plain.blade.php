{{--Dear Sir--}}

{{ $instruction->instructions }}

Datetime: {{ $instruction->pickup_datetime->format('l d/m/Y \a\t ha') }}
Loading from: {{ $instruction->supplier->address }} ,{{ !is_null($instruction->supplier->city) ? $instruction->supplier->city->name : '' }} , {{ $instruction->supplier->postal_code }}
Going to: {{ $instruction->consignment->dischargePort->name }}
Doors to: {{ $instruction->door_orientation }}

Thanks
