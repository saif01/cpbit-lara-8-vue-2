<table>
    <thead>
        <tr>
            <td colspan="5" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> iTemp All Employee List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">ID</td>
            <td style="font-weight:bold; background-color: khaki">Name</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Temparature</td>
            <td style="font-weight:bold; background-color: khaki">Date</td>
    </thead>
    <tbody>
        @foreach($employee as $employee)
        <tr>

            <td>{{ $employee->emp_id }}</td>

            @if($employee->name)
            <td>{{ $employee->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->department)
            <td>{{ $employee->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($employee->temp_final)
            <td>{{ $employee->temp_final }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($employee->created_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
