<table>
    <thead>
        <tr>
            <td colspan="6" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Carppool Car Maintenance Report
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Driver Name</td>
            <td style="font-weight:bold; background-color: khaki">Driver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Car</td>
            <td style="font-weight:bold; background-color: khaki">Maintenance Start</td>
            <td style="font-weight:bold; background-color: khaki">Maintenance End</td>
            <td style="font-weight:bold; background-color: khaki">Status</td>
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

            @if($data->status == '1')
            <td>Approve</td>
            @else
            <td style="color:red">Not Approve</td>
            @endif

        </tr>
        @endforeach
    </tbody>
</table>
