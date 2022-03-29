<table>
    <thead>
        <tr>
            <td colspan="9" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> {{$product[0]->category->name}} Stock Record
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">DATE</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Doc.No</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">LOCATION</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">DEPARTMENT</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Product Type</td>
            <td colspan="2" style="background-color: khaki;font-weight:bold;">BALANCE</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Unit Price</td>
            <td rowspan="2" style="background-color: khaki;font-weight:bold;">Remark</td>
        </tr>
        <tr>
            <td style="background-color: khaki">Quantity</td>
            <td style="background-color: khaki">Amount</td>
        </tr>
    </thead>
    <tbody>
        @foreach($product as $product)
        <tr>
            {{-- date --}}
            <td>{{date("F j, Y", strtotime($product->created_at))}}</td>

            {{-- doc no --}}
            @if($product->newold)
                <td>
                    @if ($product->newold->comp_id)
                        CMS-{{ $product->newold->comp_id }}
                    @else
                        <span style="color:red">N/A</span>
                    @endif
                </td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- location --}}
            @if($product->newold)
            <td>{{ $product->newold->business_unit }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- department --}}
            @if($product->newold)
            <td>{{ $product->newold->office }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- product type --}}
            @if($product->category)
            <td>{{ $product->category->name }} - {{ $product->subcategory->name }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- quantity --}}
            @if($product->qty)
            <td>{{ $product->qty }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- amount --}}
            @if($product->amount)
            <td>{{ $product->amount }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- unit_price --}}
            @if($product->unit_price)
            <td>{{ $product->unit_price }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

            {{-- remark --}}
            @if($product->remarks)
            <td>{{ strip_tags($product->remarks) }}</td>
            @else
            <td style="color:red">N/A</td>
            @endif

        </tr>
        @endforeach
        <tr>
            <td colspan="9"></td>
        </tr>
 

        <tr>
            <td rowspan="5"></td>
            <td colspan="2">TOTAL USAGE</td>
            <td>Unit Price</td>
            <td>AMOUNT</td>
            <td></td>
        </tr>
        <tr>
            <td>Received</td>
            <td>
                {{$length[0]}}
            </td>
            <td>
                @if (!empty($length[1]))
                    {{$length[1]->unit_price}}
                @else
                0
                @endif
            </td>
            <td>{{$length[2]}}</td>
            <td colspan="9" rowspan="5"></td>
            <td></td>
        </tr>

        <tr>
            <td>Issue</td>
            <td>{{$length[3]}}</td>
            <td>
                @if (!empty($length[4]))
                    {{$length[4]->unit_price}}
                @else
                0
                @endif
            </td>
            <td>{{$length[5]}}</td>
            <td></td>
        </tr>

        <tr>
            <td>Damage</td>
            <td>{{$length[6]}}</td>
            <td>
                @if (!empty($length[7]))
                    {{$length[7]->unit_price}}
                @else
                0
                @endif
            </td>
            <td>{{$length[8]}}</td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td>{{ $length[0]+$length[3]+$length[6] }}</td>
            <td>{{ $length[1]->unit_price }}</td>
            <td>{{ $length[2]+$length[5]+$length[8] }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="7"></td>
            <td colspan="2">............................</td>
            <td colspan="3"></td>
            <td colspan="2">............................</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="7"></td>
            <td colspan="2">Md. Saiful Alam</td>
            <td colspan="3"></td>
            <td colspan="2">Mr. Surachai Praniratlert</td>
            <td></td>
        </tr>
    </tbody>
</table>
