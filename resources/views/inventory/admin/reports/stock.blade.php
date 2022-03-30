<table>
    <thead>
        <tr>
            <td colspan="7" rowspan="3">
                C.P. Bangladesh Co., Ltd. - Head Office <br> Information Technology <br> {{$product->catagoryName}} Stock Record
            </td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">DATE</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">Doc.No</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">LOCATION</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">DEPARTMENT</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">Product Type</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">Unit Price</td>
            <td style="background-color: #3F51B5; color:white;font-weight:bold;">Remark</td>
        </tr>
    </thead>
    <tbody>
        @if($product->totalIssue != 0)
        {

            @foreach($product->data as $singleData)
            <tr>
                {{-- date --}}
                @if($singleData->updated_at)
                <td>
                    {{date("F j, Y", strtotime($singleData->updated_at))}}
                </td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- doc no --}}
                @if($singleData->newold)
                    <td>
                        @if ($singleData->newold->new_pro_id)
                            CMS-{{ $singleData->newold->new_pro_id }}
                        @else
                            <span style="color:red">N/A</span>
                        @endif
                    </td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- location --}}
                @if($singleData->newold)
                <td>{{ $singleData->newold->business_unit }}</td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- department --}}
                @if($singleData->newold)
                <td>{{ $singleData->newold->office }}</td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- product type --}}
                @if($singleData->category)
                <td>{{ $singleData->category->name }} - {{ $singleData->subcategory->name }}</td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- unit_price --}}
                @if($singleData->unit_price)
                <td>{{ $singleData->unit_price }}</td>
                @else
                <td style="color:red">N/A</td>
                @endif

                {{-- remark --}}
                @if($singleData->remarks)
                <td>{!! $singleData->remarks !!}</td>
                @else
                <td style="color:red">N/A</td>
                @endif

            </tr>
            @endforeach
        }
        @else
        <tr>
            <td colspan="7" rowspan="9" style="color: red; font-size: 50px">Sorry !! Don't use this month</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        @endif
        <tr>
            <td colspan="9"></td>
        </tr>
 
        <tr>
            <td colspan="2">TOTAL USAGE</td>
            <td>Unit Price</td>
            <td>AMOUNT</td>
            <td rowspan="5" colspan="3"></td>
        </tr>
        
        <tr>
            <td>Received</td>

            @if($product->totalReceived)
            <td>{{ $product->totalReceived }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->receivedAmmountUnit)
            <td>{{ $product->receivedAmmountUnit }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->totalReceivedAmmount)
            <td>{{ $product->totalReceivedAmmount }}</td>
            @else
            <td>0</td>
            @endif

            
        </tr>

        <tr>
            <td>Issue</td>
            
            @if($product->totalIssue)
            <td>{{ $product->totalIssue }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->issueAmmountUnit)
            <td>{{ $product->issueAmmountUnit }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->totalIssueAmmount)
            <td>{{ $product->totalIssueAmmount }}</td>
            @else
            <td>0</td>
            @endif
            
        </tr>

        <tr>
            <td>Damage</td>
            
            @if($product->totalDamaged)
            <td>{{ $product->totalDamaged }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->totalDamagedAmmount)
            <td>{{ $product->totalDamagedAmmount }}</td>
            @else
            <td>0</td>
            @endif

            @if($product->damagedAmmountUnit)
            <td>{{ $product->damagedAmmountUnit }}</td>
            @else
            <td>0</td>
            @endif

        </tr>

        <tr>
            <td style="background-color: #009688; color:white">Remaining</td>
            
            @if($product->totalRemaining)
            <td style="background-color: #009688; color:white">{{ $product->totalRemaining }}</td>
            @else
            <td style="background-color: #009688; color:white">0</td>
            @endif

            @if($product->totalRemainingAmmount)
            <td style="background-color: #009688; color:white">{{ $product->totalRemainingAmmount }}</td>
            @else
            <td style="background-color: #009688; color:white">0</td>
            @endif

            @if($product->remainingAmmountUnit)
            <td style="background-color: #009688; color:white">{{ $product->remainingAmmountUnit }}</td>
            @else
            <td style="background-color: #009688; color:white">0</td>
            @endif

        </tr>

        <tr>
            <td></td>
            <td colspan="3"></td>
            <td colspan="1" rowspan="2">
                .........................................
                <br> Mr Saiful Islam
            </td>
            <td colspan="1"></td>
            <td colspan="1" rowspan="2">
                .........................................
                <br> Mr Surachai Praneerachlerd</td>
            <td></td>
        </tr>
    </tbody>
</table>
