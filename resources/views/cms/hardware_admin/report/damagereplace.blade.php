<table>
    <thead>
        <tr>
            <td colspan="20" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> All Hardware Partial Damage Product Complain List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Complain Number</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Subcategory</td>
            <td style="font-weight:bold; background-color: khaki">Damaged Reason</td>
            <td style="font-weight:bold; background-color: khaki">Complain By</td>
            <td style="font-weight:bold; background-color: khaki">Department</td>
            <td style="font-weight:bold; background-color: khaki">Damaged By</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Name</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Position</td>
            <td style="font-weight:bold; background-color: khaki">Product Name</td>
            <td style="font-weight:bold; background-color: khaki">Product Serial</td>
            <td style="font-weight:bold; background-color: khaki">Purchase Date</td>
            <td style="font-weight:bold; background-color: khaki">PO Number</td>
            <td style="font-weight:bold; background-color: khaki">Request Payment Number</td>
            <td style="font-weight:bold; background-color: khaki">Bill Submit Date</td>
            <td style="font-weight:bold; background-color: khaki">Invoice Number</td>
            <td style="font-weight:bold; background-color: khaki">Warranty</td>
            <td style="font-weight:bold; background-color: khaki">Register</td>
            <td style="font-weight:bold; background-color: khaki">Last Update</td>
        </tr>
    </thead>
    <tbody>
        @foreach($complain as $complain)
        <tr>
            <td>{{ $complain->id }}</td>

            @if($complain->complain->category)
            <td>{{ $complain->complain->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->complain->subcategory)
            <td>{{ $complain->complain->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->damaged_reason)
            <td>{{ $complain->damaged_reason }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->complain->makby)
            <td>{{ $complain->complain->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->makby)
            <td>{{ $complain->makby->department }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->makby)
            <td>{{ $complain->makby->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->rec_name)
            <td>{{ $complain->rec_name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->rec_contact)
            <td>{{ $complain->rec_contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->rec_position)
            <td>{{ $complain->rec_position }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- replace_product --}}
            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->name){{$key+1}}: {{ $item->name }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->serial){{$key+1}}: {{ $item->serial }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->purchase){{$key+1}}: {{ $item->purchase }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->po_number){{$key+1}}: {{ $item->po_number }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

             @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->req_payment_num){{$key+1}}: {{ $item->req_payment_num }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

             @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->bill_submit){{$key+1}}: {{ $item->bill_submit }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->invoice_num){{$key+1}}: {{ $item->invoice_num }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            

            @if($complain->replace_product)
            <td>
                @foreach ($complain->replace_product as $key => $item)
                @if($item->warranty){{$key+1}}: {{ warranty_check($item->warranty) }},@endif
                @endforeach
            </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            <td>{{date("F j, Y, g:i a", strtotime($complain->created_at))}}</td>
            <td>{{date("F j, Y, g:i a", strtotime($complain->updated_at))}}</td>

        </tr>
        @endforeach
    </tbody>
</table>



{{-- warranty_check function --}}
@php

function warranty_check($date){
    $currentdate    = date('Y-m-d');
    $ts3            = strtotime($currentdate);
    $ts4            = strtotime($date);
    $seconds        = abs($ts3 - $ts4); # difference will always be positive
    $days           = round( $seconds/(60*60*24) );
    $month          = round( $seconds/(60*60*24*30) );
    $years          = round( $seconds/(60*60*24*30*12) );

    if( $ts3 >= $ts4 ){
        return "Expired";
    }elseif( $days < 30 )
    {   return $days ." Days"; }
    elseif( $month < 12 )
    {   return $month ." Month"; }
    else{
        return $years." Year"; }
            
}
           
@endphp
