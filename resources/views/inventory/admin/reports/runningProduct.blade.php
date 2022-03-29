<table>
    <thead>
        <tr>
            <td colspan="11" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> Inventory Running Product List
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="font-weight:bold; background-color: khaki">Product Name/Model</td>
            <td style="font-weight:bold; background-color: khaki">Category</td>
            <td style="font-weight:bold; background-color: khaki">Subcategory</td>
            <td style="font-weight:bold; background-color: khaki">Office</td>
            <td style="font-weight:bold; background-color: khaki">Business Unit</td>
            <td style="font-weight:bold; background-color: khaki">Operaiton</td>
            <td style="font-weight:bold; background-color: khaki">Serial</td>
            <td style="font-weight:bold; background-color: khaki">Purchase Date</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Name</td>
            <td style="font-weight:bold; background-color: khaki">Receiver Contact</td>
            <td style="font-weight:bold; background-color: khaki">Designation</td>
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

            @if($product->office)
            <td>{{ $product->office }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->business_unit)
            <td>{{ $product->business_unit }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->operation)
            <td>{{ $product->operation->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->serial)
            <td>{{ $product->serial }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->purchase)
            <td>{{ $product->purchase }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_name)
            <td>{{ $product->rec_name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_contact)
            <td>{{ $product->rec_contact }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            @if($product->rec_position)
            <td>{{ $product->rec_position }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif


        </tr>
        @endforeach
    </tbody>
</table>
