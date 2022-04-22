<table>
    <tr>
        <td colspan="4" rowspan="2" style="text-align: center; ">
            C.P Bangladesh Co., Ltd.
            <br>
            E-236, Ward- 07, Chandra, Kaliakor, Gazipur - 1750
        </td>
    </tr>
    <tr></tr>

    <tr>
        <td style="font-weight: bold; text-align:center" colspan="4">The survey report of the supplier manufacturer</td>
    </tr>

    <tr>
        <td colspan="4" rowspan="4">
            Name of the company : {{ $finalResult->allData[0]->vendor->suppier_name ?? ''}}
            <br>
            Description of the company : {{ $finalResult->allData[0]->vendor->address ?? ''}}
            <br>
            Name of Owner/Manager : {{ $finalResult->allData[0]->vendor->contact_name ?? ''}}
            <br>
            Vendor Code : {{ $finalResult->allData[0]->vendor->vendor_number ?? ''}}
        </td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>

    <tr>
        <td style="font-weight: bold; text-align:center" colspan="4">Name and position of audit commitee Members</td>
    </tr>

    <tr>
        <th colspan="4" rowspan="10">
            @foreach ($finalResult->allData as $key=>$item)
            {{ $key+1 }}. Surveyor: {{ $item->auditordata->name }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Position:
            {{ $item->auditordata->designation }} <br>
            @endforeach
        </th>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>

    <tr>
        <td rowspan="2">Assesment topics</td>
        <td colspan="3">Point</td>
    </tr>
    <tr>
        <td>Full</td>
        <td>Actually</td>
        <td>%</td>
    </tr>
    <tr>
        <td>1. Place of production and storage location</td>
        <td>{{ $finalResult->storage_result->maxSectionValue }}</td>
        <td>{{ $finalResult->storage_result->avgActualvalue }}</td>
        <td>{{ $finalResult->storage_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td>2. Production planning/ control product quality and service</td>
        <td>{{ $finalResult->production_qs_result->maxSectionValue }}</td>
        <td>{{ $finalResult->production_qs_result->avgActualvalue }}</td>
        <td>{{ $finalResult->production_qs_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td>3. Safety</td>
        <td>{{ $finalResult->safety_result->maxSectionValue }}</td>
        <td>{{ $finalResult->safety_result->avgActualvalue }}</td>
        <td>{{ $finalResult->safety_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td>4. Environment and Surrounding condition</td>
        <td>{{ $finalResult->env_sur_con_result->maxSectionValue }}</td>
        <td>{{ $finalResult->env_sur_con_result->avgActualvalue }}</td>
        <td>{{ $finalResult->env_sur_con_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td>5. Machinery Equipment</td>
        <td>{{ $finalResult->equipment_result->maxSectionValue }}</td>
        <td>{{ $finalResult->equipment_result->avgActualvalue }}</td>
        <td>{{ $finalResult->equipment_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td>6. To Operate with the company</td>
        <td>{{ $finalResult->cooperate_result->maxSectionValue }}</td>
        <td>{{ $finalResult->cooperate_result->avgActualvalue }}</td>
        <td>{{ $finalResult->cooperate_result->percentageResult }} %</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Total</td>
        <th style="font-weight: bold">{{ $finalResult->totalmaxSectionValue }}</th>
        <td style="font-weight: bold">{{ round($finalResult->totalavgActualvalue, 2) }}</td>
        <td style="font-weight: bold">{{ round($finalResult->totalavgPercentagevalue, 2) }} %</td>
    </tr>

    <tr>
        <td style="font-weight: bold">COMMENTS</td>
    </tr>

    <tr>
        <td style="font-weight: bold">1. Place of Production / storage location :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->storage_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->storage_1_remarks }},</span>
            @endif

            @if($item->storage_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->storage_2_remarks }},</span>
            @endif

            @if($item->storage_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->storage_3_remarks }},</span>
            @endif

            @if($item->storage_4_remarks)
            <span><span class="text-muted">QR-4:</span>
                {{ $item->storage_4_remarks }}</span>
            @endif

            @if( $item->storage_1_remarks || $item->storage_2_remarks || $item->storage_3_remarks ||
            $item->storage_4_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">2. Production planning / control product quality and service :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->production_qs_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->production_qs_1_remarks }},</span>
            @endif

            @if($item->production_qs_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->production_qs_2_remarks }},</span>
            @endif

            @if($item->production_qs_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->production_qs_3_remarks }},</span>
            @endif

            @if($item->production_qs_4_remarks)
            <span><span class="text-muted">QR-4:</span>
                {{ $item->production_qs_4_remarks }}</span>
            @endif

            @if( $item->production_qs_1_remarks || $item->production_qs_2_remarks ||
            $item->production_qs_3_remarks || $item->production_qs_4_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">3. Safety :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->safety_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->safety_1_remarks }},</span>
            @endif

            @if($item->safety_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->safety_2_remarks }},</span>
            @endif

            @if($item->safety_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->safety_3_remarks }},</span>
            @endif

            @if($item->safety_4_remarks)
            <span><span class="text-muted">QR-4:</span>
                {{ $item->safety_4_remarks }}</span>
            @endif

            @if( $item->safety_1_remarks || $item->safety_2_remarks || $item->safety_3_remarks ||
            $item->safety_4_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">4. Environment and Surrounding condition :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->env_sur_con_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->env_sur_con_1_remarks }},</span>
            @endif

            @if($item->env_sur_con_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->env_sur_con_2_remarks }},</span>
            @endif

            @if($item->env_sur_con_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->env_sur_con_3_remarks }},</span>
            @endif

            @if($item->env_sur_con_4_remarks)
            <span><span class="text-muted">QR-4:</span>
                {{ $item->env_sur_con_4_remarks }}</span>
            @endif

            @if( $item->env_sur_con_1_remarks || $item->env_sur_con_2_remarks ||
            $item->env_sur_con_3_remarks || $item->env_sur_con_4_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">5. Machinery Equipment :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->equipment_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->equipment_1_remarks }},</span>
            @endif

            @if($item->equipment_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->equipment_2_remarks }},</span>
            @endif

            @if($item->equipment_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->equipment_3_remarks }},</span>
            @endif

            @if($item->equipment_4_remarks)
            <span><span class="text-muted">QR-4:</span>
                {{ $item->equipment_4_remarks }}</span>
            @endif

            @if( $item->equipment_1_remarks || $item->equipment_2_remarks ||
            $item->equipment_3_remarks || $item->equipment_4_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">6. To cooperate with the company :</td>
    </tr>
    <tr>
        <td>
            @foreach ($finalResult->allData as $item)

            @if($item->cooperate_1_remarks)
            <span><span class="text-muted">QR-1:</span>
                {{ $item->cooperate_1_remarks }},</span>
            @endif

            @if($item->cooperate_2_remarks)
            <span><span class="text-muted">QR-2:</span>
                {{ $item->cooperate_2_remarks }},</span>
            @endif

            @if($item->cooperate_3_remarks)
            <span><span class="text-muted">QR-3:</span>
                {{ $item->cooperate_3_remarks }},</span>
            @endif

            @if( $item->cooperate_1_remarks || $item->cooperate_2_remarks ||
            $item->cooperate_3_remarks )
            <div>
                <span class="text-muted small ml-2"> --
                    {{ $item->auditordata->name }}</span>
            </div>
            @endif

            @endforeach
        </td>
    </tr>
</table>
