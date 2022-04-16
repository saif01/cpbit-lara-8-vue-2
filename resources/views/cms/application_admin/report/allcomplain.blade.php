<table>
    <thead>
        <tr>
            <td colspan="8" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office 
                <br> Information Technology 
                {{-- <br> {{ $name }} --}}
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Complain ID</td>
            <td style="font-weight:bold; background-color: khaki">Process</td>
            <td style="font-weight:bold; background-color: khaki">Software</td>
            <td style="font-weight:bold; background-color: khaki">Module</td>
            <td style="font-weight:bold; background-color: khaki">User</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Register</td>
            <td style="font-weight:bold; background-color: khaki">Last Update</td>
        </tr>
    </thead>
    <tbody>
        @foreach($complain as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->process }}</td>

            @if($item->category)
            <td>{{ $item->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($item->subcategory)
            <td>{{ $item->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($item->makby)
            <td>{{ $item->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($item->makby)
            <td>{{ $item->makby->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($item->created_at))}}</td>
            <td>{{date("F j, Y, g:i a", strtotime($item->updated_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>
