<table>
    <tr>
        <th style="font-weight: bold; text-align:center" colspan="4">The survey report of the Importer and Trader</th>
    </tr>

    <tr>
        <th rowspan="6" colspan="4">
            Date of survey : {{ $singleAuditReport->auditData->date }}
            <br>
            Date of survey : {{ $singleAuditReport->auditData->vendor->suppier_name ?? '' }}
            <br>
            Location of the company : {{$singleAuditReport->auditData->vendor->address ?? '' }}
            <br>
            Name of Owner / Manager : {{$singleAuditReport->auditData->vendor->contact_name ?? '' }}
            <br>
            Vendor Code : {{$singleAuditReport->auditData->vendor->vendor_number ?? '' }}
            <br>
            Surveyer : {{$singleAuditReport->auditData->auditordata->name ?? ''}} &nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp; Position : {{$singleAuditReport->auditData->auditordata->designation ?? ''}} &nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp; Department : {{$singleAuditReport->auditData->auditordata->business_unit ?? ''}}
        </th>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <th rowspan="2">Post assesment</th>
        <th colspan="2">Assesment Score</th>
        <th rowspan="2">Suggestions / problems encountered</th>
    </tr>
    <tr>
        <th style="font-weight: bold">Full</th>
        <th style="font-weight: bold">Actually</th>
    </tr>
    <tr>
        <th style="font-weight: bold; background-color:#1e755d; color:white;" colspan="4">Place of Production / storage location</th>
    </tr>
    <tr>
        <td>{{ $templateData->storage_1 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->storage_1 }}</td>
        <td>{{ $singleAuditReport->auditData->storage_1_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->storage_2 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->storage_2 }}</td>
        <td>{{ $singleAuditReport->auditData->storage_2_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->storage_3 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->storage_3 }}</td>
        <td>{{ $singleAuditReport->auditData->storage_3_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->storage_4 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->storage_4 }}</td>
        <td>{{ $singleAuditReport->auditData->storage_4_remarks }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:end">
            Total
        </th>
        <td>{{ $singleAuditReport->storageSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->storageSection->totalActualVal }}</td>
        <td></td>
    </tr>
    {{-- 2 --}}
    <tr>
        <th style="font-weight: bold; background-color:#1e755d; color:white;" colspan="4">Production planning / control product quality and ser
        <td></td>
    </tr>
    <tr>
        <td>{{ $templateData->production_qs_1 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->production_qs_1 }}</td>
        <td>{{ $singleAuditReport->auditData->production_qs_1_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->production_qs_2 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->production_qs_2 }}</td>
        <td>{{ $singleAuditReport->auditData->production_qs_2_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->production_qs_3 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->production_qs_3 }}</td>
        <td>{{ $singleAuditReport->auditData->production_qs_3_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->production_qs_4 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->production_qs_4 }}</td>
        <td>{{ $singleAuditReport->auditData->production_qs_4_remarks }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:end">
            Total
        </th>
        <td>{{ $singleAuditReport->production_qsSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->production_qsSection->totalActualVal }}</td>
        <td></td>
    </tr>

    {{-- 3 --}}
    <tr>
        <th style="font-weight: bold; background-color:#1e755d; color:white;" colspan="4">Safety</th>
    </tr>
    <tr>
        <td>{{ $templateData->safety_1 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->safety_1 }}</td>
        <td>{{ $singleAuditReport->auditData->safety_1_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->safety_2 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->safety_2 }}</td>
        <td>{{ $singleAuditReport->auditData->safety_2_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->safety_3 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->safety_3 }}</td>
        <td>{{ $singleAuditReport->auditData->safety_3_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->safety_4 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->safety_4 }}</td>
        <td>{{ $singleAuditReport->auditData->safety_4_remarks }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:end">
            Total
        </th>
        <td>{{ $singleAuditReport->safetySection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->safetySection->totalActualVal }}</td>
        <td></td>
    </tr>
    {{-- 4 --}}
    <tr>
        <th style="font-weight: bold; background-color:#1e755d; color:white;" colspan="4">Environment and Surrounding condition</th>
    </tr>
    <tr>
        <td>{{ $templateData->env_sur_con_1 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_1 }}</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_1_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->env_sur_con_2 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_2 }}</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_2_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->env_sur_con_3 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_3 }}</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_3_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->env_sur_con_4 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_4 }}</td>
        <td>{{ $singleAuditReport->auditData->env_sur_con_4_remarks }}</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:end">
            Total
        </th>
        <td>{{ $singleAuditReport->env_sur_conSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->env_sur_conSection->totalActualVal }}</td>
        <td></td>
    </tr>


    {{-- 5 --}}
    <tr>
        <th style="font-weight: bold; background-color:#1e755d; color:white;" colspan="4">To cooperate with the company</th>
    </tr>
    <tr>
        <td>{{ $templateData->cooperate_1 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->cooperate_1 }}</td>
        <td>{{ $singleAuditReport->auditData->cooperate_1_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->cooperate_2 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->cooperate_2 }}</td>
        <td>{{ $singleAuditReport->auditData->cooperate_2_remarks }}</td>
    </tr>
    <tr>
        <td>{{ $templateData->cooperate_3 }}</td>
        <td>4</td>
        <td>{{ $singleAuditReport->auditData->cooperate_3 }}</td>
        <td>{{ $singleAuditReport->auditData->cooperate_3_remarks }}</td>
    </tr>

    <tr>
        <th style="font-weight: bold; text-align:end">
            Total
        </th>
        <td>{{ $singleAuditReport->cooperateSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->cooperateSection->totalActualVal }}</td>
        <td></td>
    </tr>

    <tr>
        <td style="font-weight: bold; text-align:end; background-color:#1e755d; color:white;">Sum Total</td>
        <td>{{ $singleAuditReport->sumOfSectionMaxVal }}</td>
        <td>{{ $singleAuditReport->sumOfSectionActualVal }}</td>
        <td rowspan="2"></td>
    </tr>
    <tr>
        <td style="font-weight: bold; text-align:end; background-color:#1e755d; color:white;">Average %</td>
        <td colspan="2">{{ round($singleAuditReport->avgSectionPercentageVal, 2) }} %</td>
    </tr>
    <tr>
        <td colspan="4" rowspan="4">
            Scoring
            <br>
            Very Good = 4 points
            <br>
            Good = 3 points
            <br>
            Fair = 2 points
            <br>
            Update = 1
        </td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <th style="font-weight: bold; text-align:center" colspan="4">Summury</th>
    </tr>
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
        <td style="color: red">{{ $singleAuditReport->storageSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->storageSection->totalActualVal }}</td>
        <td>{{ $singleAuditReport->storageSection->avgSectionVal }} %</td>
    </tr>
    <tr>
        <td>2. Production planning/ control product quality and service</td>
        <td style="color: red">{{ $singleAuditReport->production_qsSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->production_qsSection->totalActualVal }}</td>
        <td>{{ $singleAuditReport->production_qsSection->avgSectionVal }} %</td>
    </tr>
    <tr>
        <td>3. Safety</td>
        <td style="color: red">{{ $singleAuditReport->safetySection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->safetySection->totalActualVal }}</td>
        <td>{{ $singleAuditReport->safetySection->avgSectionVal }} %</td>
    </tr>
    <tr>
        <td>4. Environment</td>
        <td style="color: red">{{ $singleAuditReport->env_sur_conSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->env_sur_conSection->totalActualVal }}</td>
        <td>{{ $singleAuditReport->env_sur_conSection->avgSectionVal }} %</td>
    </tr>
    <tr>
        <td>5. To Operate with the company</td>
        <td style="color: red">{{ $singleAuditReport->cooperateSection->totalMaxVal }}</td>
        <td>{{ $singleAuditReport->cooperateSection->totalActualVal }}</td>
        <td>{{ $singleAuditReport->cooperateSection->avgSectionVal }} %</td>
    </tr>
    <tr>
        <td style="font-weight: bold; background-color:#1e755d; color:white;">Total</td>
        <td>{{ $singleAuditReport->sumOfSectionMaxVal }}</td>
        <td>{{ $singleAuditReport->sumOfSectionActualVal }}</td>
        <td>{{ round($singleAuditReport->avgSectionPercentageVal, 2) }} %</td>
    </tr>

</table>
