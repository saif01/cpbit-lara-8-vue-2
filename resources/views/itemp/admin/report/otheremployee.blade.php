<table>
    <thead>
        <tr>
            <td colspan="7" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> iTemp All Other Employee List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Name</td>
            <td style="font-weight:bold; background-color: khaki">From</td>
            <td style="font-weight:bold; background-color: khaki">To</td>
            <td style="font-weight:bold; background-color: khaki">Temparature</td>
            <td style="font-weight:bold; background-color: khaki">Location</td>
            <td style="font-weight:bold; background-color: khaki">Temparature By</td>
            <td style="font-weight:bold; background-color: khaki">Date</td>
    </thead>
    <tbody>
        @foreach($employee as $employee)
        <tr>

            <td>{{ $employee->name }}</td>

            @if($employee->from)
            <td>{{ $employee->from }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->to)
            <td>{{ $employee->to }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->temp)
            <td>{{ $employee->temp }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->temp_location)
            <td>{{ $employee->temp_location }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->temp_by)
            <td>{{ $employee->temp_by }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($employee->created_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
