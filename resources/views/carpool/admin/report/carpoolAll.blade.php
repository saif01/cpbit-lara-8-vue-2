<table>
    <thead>
        <tr>
            <td colspan="13" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Carppool Car Booking Report
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Driver Name</td>
            <td style="font-weight:bold; background-color: khaki">Driver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Car</td>
            <td style="font-weight:bold; background-color: khaki">Book By</td>
            <td style="font-weight:bold; background-color: khaki">Booking Start</td>
            <td style="font-weight:bold; background-color: khaki">Booking End</td>
            <td style="font-weight:bold; background-color: khaki">Purpose</td>
            <td style="font-weight:bold; background-color: khaki">Destination</td>
            <td style="font-weight:bold; background-color: khaki">Mileage</td>
            <td style="font-weight:bold; background-color: khaki">Gasoline</td>
            <td style="font-weight:bold; background-color: khaki">Octane</td>
            <td style="font-weight:bold; background-color: khaki">Toll</td>
            <td style="font-weight:bold; background-color: khaki">Total</td>
            
    </thead>
    <tbody>
        
        @foreach($data as $data)
        <tr>

            @if($data->driver)
            <td>{{ $data->driver->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->driver)
            <td>{{ $data->driver->contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->car)
            <td>{{ $data->car->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->bookby)
            <td>{{ $data->bookby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->start)
            <td>{{ date("F j, Y, g:i a", strtotime($data->start)) }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->end)
            <td>{{ date("F j, Y, g:i a", strtotime($data->end)) }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->purpose)
            <td>{{ $data->purpose }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->destination)
            <td>{{ $data->destination }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->km)
            <td>{{ $data->km }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->gas)
            <td>{{ $data->gas }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->octane)
            <td>{{ $data->octane }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->toll)
            <td>{{ $data->toll }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($data->cost)
            <td>{{ $data->cost }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            

        </tr>
        @endforeach
    </tbody>
</table>
