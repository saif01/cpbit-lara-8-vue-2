<table>
    <thead>
        <tr>
            <td colspan="6" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Inventory Waranty Expired Product List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Product Name/Model</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Subcategory</td>
            <td style="font-weight:bold; background-color: khaki">Serial</td>
            <td style="font-weight:bold; background-color: khaki">Invoice</td>
            <td style="font-weight:bold; background-color: khaki">P.O.</td>
            <td style="font-weight:bold; background-color: khaki">Purchase Date</td>
            <td style="font-weight:bold; background-color: khaki">Remarks</td>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $product)
        <tr>
            <td>{{ $product->name }}</td>

            @if($product->category)
            <td>{{ $product->category->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->subcategory)
            <td>{{ $product->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->serial)
            <td>{{ $product->serial }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->invoice_num)
            <td>{{ $product->invoice_num }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->po_number)
            <td>{{ $product->po_number }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->purchase)
            <td>{{ $product->purchase }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->remarks)
            <td>{!! $product->remarks !!}</td>
            @else
            <td style="color:red">N/A</td>
            @endif


        </tr>
        @endforeach
    </tbody>
</table>