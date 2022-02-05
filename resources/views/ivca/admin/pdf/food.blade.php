@extends('ivca.admin.pdf.layout.master-2')

@push('styles')

    <style>
        .page-break {
            page-break-after: always;
        }

        .guidelines {
            width: 45%;
        }

        .evidence {
            width: 40%;
        }

        .evidence img{
            height: 150px;
            width: 100%;
        }

        .note {
            width: 15%
        }
    </style>

@endpush

@section('content')


<div class="container-fluid">
    <div class="d-flex justify-content-between my-2">
        <div>
            CP Food (Bangladesh) Co., Ltd.
        </div>
        <div>
            QC Department
        </div>
    </div>

    <div>
        <div class="text-center font-weight-bold mb-1">
            PREMISE AUDIT CHECKLIST
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td>Name of Organization: </td>
                    <td>
                        @if($auditData->vendor) 
                            {{ $auditData->vendor->vendor_number }} - {{ $auditData->vendor->suppier_name }} 
                        @endif
                    </td>
                    <td>
                        <div>Audit Date: {{ date("d-M-Y", strtotime($auditData->date)) }}</div>
                        <div>Time: {{ date("h:i a", strtotime($auditData->created_at)) }}</div>
                    </td>
                </tr>
                <tr>
                    <td>Types of Business: </td>
                    <td>
                        @if($auditData->schedule) 
                            {{ $auditData->schedule->business_type }}
                        @endif
                    </td>
                    <td>
                        Purchased Product: 
                        @if($auditData->schedule) 
                            {{ $auditData->schedule->purchased_product }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        @if($auditData->vendor) 
                            {{ $auditData->vendor->address }}
                        @endif
                    </td>
                    <td>Auditor(s): 
                        @if($auditData->auditordata) 
                            {{ $auditData->auditordata->name }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- 1. Building & facilities (Total Score 10 points) --}}
    <div>
        <div class="font-weight-bold">1. Building & facilities (Total Score 10 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->building_facilities_a }}</td>
                    <td class="evidence">
                        @if($auditData->building_facilities_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->building_facilities_a }}</b></div>
                        <div>{{ $auditData->building_facilities_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->building_facilities_b }}</td>
                    <td class="evidence">
                        @if($auditData->building_facilities_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->building_facilities_b }}</b></div>
                        <div>{{ $auditData->building_facilities_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->building_facilities_c }}</td>
                    <td class="evidence">
                        @if($auditData->building_facilities_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->building_facilities_c }}</b></div>
                        <div>{{ $auditData->building_facilities_c_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->building_facilities_d }}</td>
                    <td class="evidence">
                        @if($auditData->building_facilities_d_image)
                            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_d_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->building_facilities_d }}</b></div>
                        <div>{{ $auditData->building_facilities_d_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->building_facilities_e }}</td>
                    <td class="evidence">
                        @if($auditData->building_facilities_e_image)
                            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_e_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->building_facilities_e }}</b></div>
                        <div>{{ $auditData->building_facilities_e_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>REC/QC-041 (REV 2: 24-1-17)</div>
        <div>Page 1 of 5</div>
        <div>Retention time 3years</div>
    </div>
    <div class="page-break"></div>

    <div class="d-flex justify-content-between my-2">
        <div>
            CP Food (Bangladesh) Co., Ltd.
        </div>
        <div>
            QC Department
        </div>
    </div>

    {{-- 2. Equipment (Total Score 6 points) --}}
    <div>
        <div class="font-weight-bold">2. Equipment (Total Score 6 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->equipment_a }}</td>
                    <td class="evidence">
                        @if($auditData->equipment_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->equipment_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->equipment_a }}</b></div>
                        <div>{{ $auditData->equipment_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->equipment_b }}</td>
                    <td class="evidence">
                        @if($auditData->equipment_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->equipment_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->equipment_b }}</b></div>
                        <div>{{ $auditData->equipment_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->equipment_c }}</td>
                    <td class="evidence">
                        @if($auditData->equipment_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->equipment_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->equipment_c }}</b></div>
                        <div>{{ $auditData->equipment_c_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- 3. Personnel (Total Score 6 points) --}}
    <div>
        <div class="font-weight-bold">3. Personnel (Total Score 6 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->personnel_a }}</td>
                    <td class="evidence">
                        @if($auditData->personnel_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->personnel_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->personnel_a }}</b></div>
                        <div>{{ $auditData->personnel_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->personnel_b }}</td>
                    <td class="evidence">
                        @if($auditData->personnel_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->personnel_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->personnel_b }}</b></div>
                        <div>{{ $auditData->personnel_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->personnel_c }}</td>
                    <td class="evidence">
                        @if($auditData->personnel_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->personnel_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->personnel_c }}</b></div>
                        <div>{{ $auditData->personnel_c_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>REC/QC-041 (REV 2: 24-1-17)</div>
        <div>Page 2 of 5</div>
        <div>Retention time 3years</div>
    </div>
    <div class="page-break"></div>

    <div class="d-flex justify-content-between my-2">
        <div>
            CP Food (Bangladesh) Co., Ltd.
        </div>
        <div>
            QC Department
        </div>
    </div>

    {{-- 4. Raw materials (Total Score 10 points) --}}
    <div>
        <div class="font-weight-bold">4. Raw materials (Total Score 10 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->raw_materials_a }}</td>
                    <td class="evidence">
                        @if($auditData->raw_materials_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->raw_materials_a }}</b></div>
                        <div>{{ $auditData->raw_materials_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->raw_materials_b }}</td>
                    <td class="evidence">
                        @if($auditData->raw_materials_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->raw_materials_b }}</b></div>
                        <div>{{ $auditData->raw_materials_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->raw_materials_c }}</td>
                    <td class="evidence">
                        @if($auditData->raw_materials_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->raw_materials_c }}</b></div>
                        <div>{{ $auditData->raw_materials_c_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->raw_materials_d }}</td>
                    <td class="evidence">
                        @if($auditData->raw_materials_d_image)
                            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_d_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->raw_materials_d }}</b></div>
                        <div>{{ $auditData->raw_materials_d_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->raw_materials_e }}</td>
                    <td class="evidence">
                        @if($auditData->raw_materials_e_image)
                            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_e_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->raw_materials_e }}</b></div>
                        <div>{{ $auditData->raw_materials_e_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>REC/QC-041 (REV 2: 24-1-17)</div>
        <div>Page 3 of 5</div>
        <div>Retention time 3years</div>
    </div>
    <div class="page-break"></div>

    {{-- 5. Production (Total Score 12 points) --}}
    <div>
        <div class="font-weight-bold">5. Production (Total Score 12 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_a }}</td>
                    <td class="evidence">
                        @if($auditData->production_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_a }}</b></div>
                        <div>{{ $auditData->production_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_b }}</td>
                    <td class="evidence">
                        @if($auditData->production_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_b }}</b></div>
                        <div>{{ $auditData->production_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_c }}</td>
                    <td class="evidence">
                        @if($auditData->production_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_c }}</b></div>
                        <div>{{ $auditData->production_c_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_d }}</td>
                    <td class="evidence">
                        @if($auditData->production_d_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_d_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_d }}</b></div>
                        <div>{{ $auditData->production_d_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_e }}</td>
                    <td class="evidence">
                        @if($auditData->production_e_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_e_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_e }}</b></div>
                        <div>{{ $auditData->production_e_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->production_f }}</td>
                    <td class="evidence">
                        @if($auditData->production_f_image)
                            <img src="{{ $auditData->imglgpath.$auditData->production_f_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->production_f }}</b></div>
                        <div>{{ $auditData->production_f_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>REC/QC-041 (REV 2: 24-1-17)</div>
        <div>Page 4 of 5</div>
        <div>Retention time 3years</div>
    </div>
    <div class="page-break"></div>

    <div class="d-flex justify-content-between my-2">
        <div>
            CP Food (Bangladesh) Co., Ltd.
        </div>
        <div>
            QC Department
        </div>
    </div>

    {{-- 6. Records (Total Score 8 points) --}}
    <div>
        <div class="font-weight-bold">6. Records (Total Score 8 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->records_a }}</td>
                    <td class="evidence">
                        @if($auditData->records_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->records_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->records_a }}</b></div>
                        <div>{{ $auditData->records_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->records_b }}</td>
                    <td class="evidence">
                        @if($auditData->records_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->records_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->records_b }}</b></div>
                        <div>{{ $auditData->records_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->records_c }}</td>
                    <td class="evidence">
                        @if($auditData->records_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->records_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->records_c }}</b></div>
                        <div>{{ $auditData->records_c_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->records_d }}</td>
                    <td class="evidence">
                        @if($auditData->records_d_image)
                            <img src="{{ $auditData->imglgpath.$auditData->records_d_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->records_d }}</b></div>
                        <div>{{ $auditData->records_d_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- 7. Labelings (Total Score 6 points) --}}
    <div>
        <div class="font-weight-bold">7. Labelings (Total Score 6 points)</div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Audit Guidelines</th>
                    <th class="text-center">Evidence</th>
                    <th class="Text-Center">Note</th>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->labeling_a }}</td>
                    <td class="evidence">
                        @if($auditData->labeling_a_image)
                            <img src="{{ $auditData->imglgpath.$auditData->labeling_a_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->labeling_a }}</b></div>
                        <div>{{ $auditData->labeling_a_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->labeling_b }}</td>
                    <td class="evidence">
                        @if($auditData->labeling_b_image)
                            <img src="{{ $auditData->imglgpath.$auditData->labeling_b_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->labeling_b }}</b></div>
                        <div>{{ $auditData->labeling_b_remarks }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="guidelines">{{ $templateData->labeling_c }}</td>
                    <td class="evidence">
                        @if($auditData->labeling_c_image)
                            <img src="{{ $auditData->imglgpath.$auditData->labeling_c_image }}" alt="image" class="img-fluid">
                        @endif
                        </td>
                    <td class="note">
                        <div>Get Point: <b>{{ $auditData->labeling_c }}</b></div>
                        <div>{{ $auditData->labeling_c_remarks }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between my-5">
        <div class="d-flex flex-column align-items-center">
            <div class="font-weight-bold">Auditee Name:</div>
            <div>.............................................</div>
        </div>
        <div class="d-flex flex-column align-items-center">
            <div class="font-weight-bold">Auditors:</div>
            <div>.............................................</div>
        </div>
    </div>

    <div class="d-flex justify-content-between ">
        <div>REC/QC-041 (REV 2: 24-1-17)</div>
        <div>Page 5 of 5</div>
        <div>Retention time 3years</div>
    </div>
    
</div>

@endsection