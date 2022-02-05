@extends('ivca.admin.pdf.layout.master')

@push('styles')
<style>
    .right-1 img {
        height: 200px;
    }

    .container {
        border: 2px solid black;
    }

    table {
        width: 100%;
    }

    .table_posts th,
    .table_posts td {
        border-top: 1px solid black;
        border-right: 1px solid black;
    }

    .border_right_none {
        border-right: none !important;
    }

    . {
        /* background-color: #dadada; */
    }

    .width_70 {
        width: 70%;
    }

    .width_30 {
        width: 30%;
    }

    .page-break {
        page-break-after: always;
    }

    .table_spacing table th,
    table tr td {
        padding: 0.50rem;
    }

    .table-spacing-header table th,
    table tr td {
        padding: 0.20rem;
    }

    .scoring div {
        padding: 0 3.3rem;
    }

    .cell_left {
        border-left: 1px solid black;
    }

</style>
@endpush

@section('content')

<div class="container p-0">
    <div class="text-center font-weight-bold" style="border-bottom: 2px solid black">
        The survey report of the Importer and Trader
    </div>
    <div class="d-flex justify-content-around px-5 pt-3">
        <div>
            <img src="{{ asset('all-assets/common/logo/cpb/cpbgroup.png') }}" alt="watermark"
                class="img-fluid cpb_logo" />
        </div>
        <div class="table_header_spacing" style="width: 85%">
            <table>
                <tr>
                    <th class="text-right">Date of survey : </th>
                    <td>{{ $singleAuditReport->auditData->date }}</td>
                </tr>
                <tr>
                    <th class="text-right font-weight-bold">Name of the company : </th>
                    <td>{{ $singleAuditReport->auditData->vendor->suppier_name ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-right font-weight-bold">Location of the company : </th>
                    <td>{{ $singleAuditReport->auditData->vendor->address ?? '' }}</td>
                </tr>
                <tr>
                    <th class="text-right font-weight-bold">Name of Owner / Manager :</th>
                    <td>{{ $singleAuditReport->auditData->vendor->contact_name ?? '' }}</td>
                </tr>
                <tr class="text-right font-weight-bold">
                    <th>Vendor Code : </th>
                    <td class="text-left">{{ $singleAuditReport->auditData->vendor->vendor_number ?? '' }}</td>
                </tr>
            </table>
        </div>

        <div>
            <img src="{{ asset('all-assets/common/logo/cpb/food.png') }}" alt="watermark" class="img-fluid food_logo" />
        </div>

    </div>

    <div class="mt-5 px-1">
        <span class="font-weight-bold">
            Name and position of audit committee Member:
        </span>
        <table>
            <tr>
                <th>Surveyer : </th>
                <td>{{ $singleAuditReport->auditData->auditordata->name ?? '' }}</td>
                <th>Position : </th>
                <td>{{ $singleAuditReport->auditData->auditordata->designation ?? '' }}</td>
                <th>Department : </th>
                <td>{{ $singleAuditReport->auditData->auditordata->business_unit ?? '' }}</td>
            </tr>
        </table>
    </div>

    <div class="mt-5 px-1">
        <u><b>Scoring : </b></u>
        <table>
            <tr>
                <th>Very Good = 4 points</th>
                <th>Good = 3 points</th>
                <th>Fair = 2 points</th>
                <th>Update = 1</th>
            </tr>
        </table>
    </div>


    <div class="mt-5 table_spacing">
        <table class="text-center table_posts" style="border-bottom: none !important; border-right:none;">
            <tr>
                <th rowspan="2" class="pt-2">Post assesment</th>
                <th colspan="2">Assesment Score</th>
                <th rowspan="2" class="pt-2 border_right_none">Suggestions / problems encountered</th>
            </tr>
            <tr>
                <th>Full</th>
                <th>Actually</th>
            </tr>
            <tr>
                <th class="text-left  cell_left">Place of Production / storage location</th>
                <td></td>
                <td></td>
                <td class="border_right_none "></td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->storage_1 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->storage_1 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->storage_1_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->storage_2 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->storage_2 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->storage_2_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->storage_3 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->storage_3 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->storage_3_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->storage_4 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->storage_4 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->storage_4_remarks }}</td>
            </tr>
            <tr>
                <th class="text-right font-weight-bold">
                    Total
                </th>
                <td>{{ $singleAuditReport->storageSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->storageSection->totalActualVal }}</td>
                <td class="border_right_none"></td>
            </tr>
            {{-- 2 --}}
            <tr>
                <th class="text-left  cell_left">Production planning / control product quality and service
                </th>
                <td></td>
                <td></td>
                <td class="border_right_none "></td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->production_qs_1 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->production_qs_1 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->production_qs_1_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->production_qs_2 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->production_qs_2 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->production_qs_2_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->production_qs_3 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->production_qs_3 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->production_qs_3_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->production_qs_4 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->production_qs_4 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->production_qs_4_remarks }}</td>
            </tr>
            <tr>
                <th class="text-right font-weight-bold">
                    Total
                </th>
                <td>{{ $singleAuditReport->production_qsSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->production_qsSection->totalActualVal }}</td>
                <td class="border_right_none"></td>
            </tr>

            {{-- 3 --}}
            <tr>
                <th class="text-left  cell_left">Safety</th>
                <td></td>
                <td></td>
                <td class="border_right_none "></td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->safety_1 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->safety_1 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->safety_1_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->safety_2 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->safety_2 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->safety_2_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->safety_3 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->safety_3 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->safety_3_remarks }}</td>
            </tr>
            <tr>
                <td class="text-left">{{ $templateData->safety_4 }}</td>
                <td>4</td>
                <td>{{ $singleAuditReport->auditData->safety_4 }}</td>
                <td class="border_right_none">{{ $singleAuditReport->auditData->safety_4_remarks }}</td>
            </tr>
            <tr>
                <th class="text-right font-weight-bold">
                    Total
                </th>
                <td>{{ $singleAuditReport->safetySection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->safetySection->totalActualVal }}</td>
                <td class="border_right_none"></td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"></div>

<div class="container p-0">
    <table class="text-center table_posts" style="border-bottom: 1px solid black">
        <tr>
            <th rowspan="2" class="pt-2">Post assesment</th>
            <th colspan="2">Assesment Score</th>
            <th rowspan="2" class="pt-2 border_right_none">Suggestions / problems encountered</th>
        </tr>
        <tr>
            <th>Full</th>
            <th>Actually</th>
        </tr>
        {{-- 4 --}}
        <tr>
            <th class="text-left cell_left">Environment and Surrounding condition</th>
            <td></td>
            <td></td>
            <td class="border_right_none"></td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->env_sur_con_1 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->env_sur_con_1 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->env_sur_con_1_remarks }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->env_sur_con_2 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->env_sur_con_2 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->env_sur_con_2_remarks }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->env_sur_con_3 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->env_sur_con_3 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->env_sur_con_3_remarks }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->env_sur_con_4 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->env_sur_con_4 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->env_sur_con_4_remarks }}</td>
        </tr>
        <tr>
            <th class="text-right font-weight-bold">
                Total
            </th>
            <td>{{ $singleAuditReport->env_sur_conSection->totalMaxVal }}</td>
            <td>{{ $singleAuditReport->env_sur_conSection->totalActualVal }}</td>
            <td class="border_right_none"></td>
        </tr>


        {{-- 5 --}}
        <tr>
            <th class="text-left cell_left">To cooperate with the company</th>
            <td></td>
            <td></td>
            <td class="border_right_none"></td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->cooperate_1 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->cooperate_1 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->cooperate_1_remarks }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->cooperate_2 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->cooperate_2 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->cooperate_2_remarks }}</td>
        </tr>
        <tr>
            <td class="text-left">{{ $templateData->cooperate_3 }}</td>
            <td>4</td>
            <td>{{ $singleAuditReport->auditData->cooperate_3 }}</td>
            <td class="border_right_none">{{ $singleAuditReport->auditData->cooperate_3_remarks }}</td>
        </tr>

        <tr>
            <th class="text-right font-weight-bold">
                Total
            </th>
            <td>{{ $singleAuditReport->cooperateSection->totalMaxVal }}</td>
            <td>{{ $singleAuditReport->cooperateSection->totalActualVal }}</td>
            <td class="border_right_none"></td>
        </tr>

        <tr>
            <td class="text-right font-weight-bold">Sum Total</td>
            <td>{{ $singleAuditReport->sumOfSectionMaxVal }}</td>
            <td>{{ $singleAuditReport->sumOfSectionActualVal }}</td>
            <td rowspan="2" class="border_right_none"></td>
        </tr>
        <tr>
            <td class="text-right font-weight-bold">Average %</td>
            <td colspan="2">{{ round($singleAuditReport->avgSectionPercentageVal, 2) }} %</td>
        </tr>
    </table>

    <div class="mt-3 mb-1 pl-1">
        <b>Summury: </b>
    </div>
    <div class="table-responsive">
        <table class="text-center table_posts" style="border-bottom: 1px solid black">
            <tr>
                <td rowspan="2" class="pt-2">Assesment topics</td>
                <td colspan="3" class="border_right_none">Point</td>
            </tr>
            <tr>
                <td class="th_bg">Full</td>
                <td class="th_bg">Actually</td>
                <td class="th_bg border_right_none">%</td>
            </tr>
            <tr>
                <td class="text-left">1. Place of production and storage location</td>
                <td>{{ $singleAuditReport->storageSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->storageSection->totalActualVal }}</td>
                <td class="border_right_none">{{ $singleAuditReport->storageSection->avgSectionVal }} %</td>
            </tr>
            <tr>
                <td class="text-left">2. Production planning/ control product quality and service</td>
                <td>{{ $singleAuditReport->production_qsSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->production_qsSection->totalActualVal }}</td>
                <td class="border_right_none">{{ $singleAuditReport->production_qsSection->avgSectionVal }} %</td>
            </tr>
            <tr>
                <td class="text-left">3. Safety</td>
                <td>{{ $singleAuditReport->safetySection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->safetySection->totalActualVal }}</td>
                <td class="border_right_none">{{ $singleAuditReport->safetySection->avgSectionVal }} %</td>
            </tr>
            <tr>
                <td class="text-left">4. Environment</td>
                <td>{{ $singleAuditReport->env_sur_conSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->env_sur_conSection->totalActualVal }}</td>
                <td class="border_right_none">{{ $singleAuditReport->env_sur_conSection->avgSectionVal }} %</td>
            </tr>
            <tr>
                <td class="text-left">5. To Operate with the company</td>
                <td>{{ $singleAuditReport->cooperateSection->totalMaxVal }}</td>
                <td>{{ $singleAuditReport->cooperateSection->totalActualVal }}</td>
                <td class="border_right_none">{{ $singleAuditReport->cooperateSection->avgSectionVal }} %</td>
            </tr>
            <tr>
                <td class="text-right">Total</td>
                <td>{{ $singleAuditReport->sumOfSectionMaxVal }}</td>
                <td>{{ $singleAuditReport->sumOfSectionActualVal }}</td>
                <td class="border_right_none">{{ round($singleAuditReport->avgSectionPercentageVal, 2) }} %</td>
            </tr>
        </table>

    </div>


</div>

@endsection
