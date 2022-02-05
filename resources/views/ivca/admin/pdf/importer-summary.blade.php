@extends('ivca.admin.pdf.layout.master')

@push('styles')
<style>
    .th_height {
        height: 93px;
    }

    .th_bg {
        background-color: #F2F2F2;
    }

    .table_survey {
        width: 100%;
    }

    .table_survey tr td {
        padding: .40rem;
    }

    img {
        width: 100%;
        height: 100%;
        display: block;
        position: relative;
    }

    ul {
        padding-left: 0.5rem;
    }

    ul li {
        list-style: none;
        margin: 0.5rem 0.5 0.5rem 0;
        padding-right: 0.5rem;
    }

    .head_left {
        width: 15%;
    }

    .head_left img {
        height: 100px;
    }

    .head_center {
        width: 70%;
    }

    .head_right {
        width: 15%;
    }

    .vend_img_col {
        width: 70%;
    }

    .image_vend_col {
        width: 30%;
    }

    .image_vend_col img {
        height: 200px;
    }

    .page_break {
        page-break-after: always;
    }

    .width_70 {
        width: 70%;
    }

    .width_30 {
        width: 30%;
    }

    .manfacturer_QR {
        width: 100%;
        height: 200px;
    }

</style>
@endpush

@section('content')

<div class="p-0 position-relative">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <img src="{{ asset('all-assets/common/logo/cpb/cpbgroup.png') }}" alt="watermark"
                class="img-fluid cpb_logo" />
        </div>
        <div class="d-flex flex-column text-center">
            <div class="font-weight-bold">C.P Bangladesh Co., Ltd.</div>
            <div>E-236, Ward- 07, Chandra, Kaliakor, Gazipur - 1750</div>
        </div>
        <div>
            <img src="{{ asset('all-assets/common/logo/cpb/food.png') }}" alt="watermark" class="img-fluid food_logo" />
        </div>
    </div>

    <div class="text-center font-weight-bold mt-4 h3">
        The survey report of the Importer and Traders
    </div>
    <div class="px-3">
        <div class="d-flex align-items-center">
            <div class="vend_img_col">
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th class="text-right">Name of the company : </th>
                            <td>{{ $finalResult->allData[0]->vendor->suppier_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Description of the company : </th>
                            <td>{{ $finalResult->allData[0]->vendor->address ?? ''}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Name of Owner/Manager : </th>
                            <td>{{ $finalResult->allData[0]->vendor->contact_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Vendor Code : </th>
                            <td>{{ $finalResult->allData[0]->vendor->vendor_number ?? ''}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($finalResult->allData[0]->vendor_image)
            <div class="image_vend_col">
                <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->vendor_image }}" alt="shop"
                    class="image_vendor img-fluid">
            </div>
            @endif
        </div>

        <div class="mt-3">
            <div class="font-weight-bold">Name and position of audit commitee Members</div>
            <div class="d-flex align-items-center">
                <div class="vend_img_col">
                    <table class="table_survey">
                        @foreach ($finalResult->allData as $key=>$item)

                        <tr>
                            <th>{{ $key+1 }}. {{ $item->auditordata->name }}</th>
                            <td>{{ $item->auditordata->name }}</td>
                            <th>Position</th>
                            <td>{{ $item->auditordata->designation }}</td>
                        </tr>

                        @endforeach
                    </table>
                </div>
                @if($finalResult->allData[0]->group_image)
                <div class="image_vend_col">
                    <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->group_image }}"
                        alt="shop" class="image_vendor img-fluid">
                </div>
                @endif
            </div>
        </div>

        <div class="d-flex mt-2">
            <div class="table-responsive">
                <table class="table text-center table-striped table-bordered">
                    <tr>
                        <td rowspan="2" style="padding-top: 1.7rem">Assesment topics</td>
                        <td colspan="3">Point</td>
                    </tr>
                    <tr>
                        <td class="th_bg">Full</td>
                        <td class="th_bg">Actually</td>
                        <td class="th_bg">%</td>
                    </tr>
                    <tr>
                        <td class="text-left">1. Place of production and storage location</td>
                        <td>{{ $finalResult->storage_result->maxSectionValue }}</td>
                        <td>{{ $finalResult->storage_result->avgActualvalue }}</td>
                        <td>{{ $finalResult->storage_result->percentageResult }} %</td>
                    </tr>
                    <tr>
                        <td class="text-left">2. Production planning/ control product quality and service</td>
                        <td>{{ $finalResult->production_qs_result->maxSectionValue }}</td>
                        <td>{{ $finalResult->production_qs_result->avgActualvalue }}</td>
                        <td>{{ $finalResult->production_qs_result->percentageResult }} %</td>
                    </tr>
                    <tr>
                        <td class="text-left">3. Safety</td>
                        <td>{{ $finalResult->safety_result->maxSectionValue }}</td>
                        <td>{{ $finalResult->safety_result->avgActualvalue }}</td>
                        <td>{{ $finalResult->safety_result->percentageResult }} %</td>
                    </tr>
                    <tr>
                        <td class="text-left">4. Environment and Surrounding condition</td>
                        <td>{{ $finalResult->env_sur_con_result->maxSectionValue }}</td>
                        <td>{{ $finalResult->env_sur_con_result->avgActualvalue }}</td>
                        <td>{{ $finalResult->env_sur_con_result->percentageResult }} %</td>
                    </tr>
                    <tr>
                        <td class="text-left">5. To Operate with the company</td>
                        <td>{{ $finalResult->cooperate_result->maxSectionValue }}</td>
                        <td>{{ $finalResult->cooperate_result->avgActualvalue }}</td>
                        <td>{{ $finalResult->cooperate_result->percentageResult }} %</td>
                    </tr>
                    <tr>
                        <td class="text-right">Total</td>
                        <th>{{ $finalResult->totalmaxSectionValue }}</th>
                        <td>{{ round($finalResult->totalavgActualvalue, 2) }}</td>
                        <td>{{ round($finalResult->totalavgPercentagevalue, 2) }} %</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="pb-3 pl-2">
            <span class="font-weight-bold">COMMENTS :</span>
            {{-- storage remarks and image --}}
            <div><u class="font-weight-bold">1. Place of Production / storage location :</u>
                <div class="row">
                    <div class="width_70">
                        <div class="ml-2">
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
                        </div>
                    </div>
                    @if($finalResult->allData[0]->storage_image)
                    <div class="width_30">
                        <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->storage_image }}"
                            alt="image" class="img-fluid manfacturer_QR">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-break"></div>
<div class="px-3 position-relative">
    <div style="page-break-after: always"></div>
    {{-- production_qs remarks and image --}}
    <div>
        <u class="font-weight-bold">2. Production planning / control product quality and service :</u>
        <div class="row">
            <div class="width_70">
                <div class="ml-2">
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
                </div>
            </div>
            @if($finalResult->allData[0]->production_qs_image)
            <div class="width_30">
                <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->production_qs_image }}"
                    alt="image" class="img-fluid manfacturer_QR">
            </div>
            @endif
        </div>
    </div>
    <hr>

    {{-- safety remarks and image --}}
    <div>
        <u class="font-weight-bold">3. Safety :</u>
        <div class="row">
            <div class="width_70">
                <div class="ml-2">
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
                </div>
            </div>
            @if($finalResult->allData[0]->safety_image)
            <div class="width_30">
                <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->safety_image }}"
                    alt="image" class="img-fluid manfacturer_QR">
            </div>
            @endif
        </div>
    </div>
    <hr>

    {{-- env_sur_con remarks and image --}}
    <div>
        <u class="font-weight-bold">4. Environment and Surrounding condition :</u>
        <div class="row">
            <div class="width_70">
                <div class="ml-2">
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
                </div>
            </div>
            @if($finalResult->allData[0]->env_sur_con_image)
            <div class="width_30">
                <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->env_sur_con_image }}"
                    alt="image" class="img-fluid manfacturer_QR">
            </div>
            @endif
        </div>
    </div>
    <hr>


    {{-- cooperate remarks and image --}}
    <div>
        <u class="font-weight-bold">5. To cooperate with the company :</u>
        <div class="row">
            <div class="width_70">
                <div class="ml-2">
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
                </div>
            </div>
            @if($finalResult->allData[0]->cooperate_image)
            <div class="width_30">
                <img src="{{ $finalResult->allData[0]->imglgpath . $finalResult->allData[0]->cooperate_image }}"
                    alt="image" class="img-fluid manfacturer_QR">
            </div>
            @endif
        </div>
    </div>
    <hr>

</div>


@endsection
