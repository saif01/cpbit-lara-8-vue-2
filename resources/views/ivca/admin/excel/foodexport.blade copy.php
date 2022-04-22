<table>
    <tr>
        <td>CP Food (Bangladesh) Co., Ltd.</td>
        <td></td>
        <td>QC Department</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight:bold">PREMISE AUDIT CHECKLIST</td>
    </tr>
    <tr>
        <td>Name of Organization: </td>
        <td>
            @if($auditData->vendor)
            {{ $auditData->vendor->vendor_number }} - {{ $auditData->vendor->suppier_name }}
            @endif
        </td>
        <td>
            Audit Date: {{ $auditData->date }}
            Time: {{ $auditData->created_at }}
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

    <tr>
        <td>1. Building & facilities (Total Score 10 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->building_facilities_a }}</td>
        <td>
            {{-- @if($auditData->building_facilities_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_a_image }}" alt="image"
            class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_a }}
            <br>
            {{ $auditData->building_facilities_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->building_facilities_b }}</td>
        <td>
            {{-- @if($auditData->building_facilities_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_b_image }}" alt="image"
            class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_b }}
            <br>
            {{ $auditData->building_facilities_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->building_facilities_c }}</td>
        <td>
            {{-- @if($auditData->building_facilities_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_c_image }}" alt="image"
            class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_c }}
            <br>
            {{ $auditData->building_facilities_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->building_facilities_d }}</td>
        <td>
            {{-- @if($auditData->building_facilities_d_image)
            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_d_image }}" alt="image"
            class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_d }}
            <br>
            {{ $auditData->building_facilities_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->building_facilities_e }}</td>
        <td>
            {{-- @if($auditData->building_facilities_e_image)
            <img src="{{ $auditData->imglgpath.$auditData->building_facilities_e_image }}" alt="image"
            class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_e }}
            <br>
            {{ $auditData->building_facilities_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>2. Equipment (Total Score 6 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->equipment_a }}</td>
        <td>
            {{-- @if($auditData->equipment_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->equipment_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_a }}
            <br>
            {{ $auditData->equipment_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->equipment_b }}</td>
        <td>
            {{-- @if($auditData->equipment_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->equipment_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_b }}
            <br>
            {{ $auditData->equipment_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->equipment_c }}</td>
        <td>
            {{-- @if($auditData->equipment_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->equipment_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_c }}
            <br>
            {{ $auditData->equipment_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>3. Personnel (Total Score 6 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->personnel_a }}</td>
        <td>
            {{-- @if($auditData->personnel_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->personnel_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_a }}
            <br>
            {{ $auditData->personnel_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->personnel_b }}</td>
        <td>
            {{-- @if($auditData->personnel_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->personnel_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_b }}
            <br>
            {{ $auditData->personnel_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->personnel_c }}</td>
        <td>
            {{-- @if($auditData->personnel_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->personnel_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_c }}
            <br>
            {{ $auditData->personnel_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>4. Raw materials (Total Score 10 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->raw_materials_a }}</td>
        <td>
            {{-- @if($auditData->raw_materials_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_a }}
            <br>
            {{ $auditData->raw_materials_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->raw_materials_b }}</td>
        <td>
            {{-- @if($auditData->raw_materials_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_b }}
            <br>
            {{ $auditData->raw_materials_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->raw_materials_c }}</td>
        <td>
            {{-- @if($auditData->raw_materials_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_c }}
            <br>
            {{ $auditData->raw_materials_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->raw_materials_d }}</td>
        <td>
            {{-- @if($auditData->raw_materials_d_image)
            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_d_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_d }}
            <br>
            {{ $auditData->raw_materials_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->raw_materials_e }}</td>
        <td>
            {{-- @if($auditData->raw_materials_e_image)
            <img src="{{ $auditData->imglgpath.$auditData->raw_materials_e_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_e }}
            <br>
            {{ $auditData->raw_materials_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>5. Production (Total Score 12 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->production_a }}</td>
        <td>
            {{-- @if($auditData->production_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_a }}
            <br>
            {{ $auditData->production_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->production_b }}</td>
        <td>
            {{-- @if($auditData->production_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_b }}
            <br>
            {{ $auditData->production_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->production_c }}</td>
        <td>
            {{-- @if($auditData->production_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_c }}
            <br>
            {{ $auditData->production_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->production_d }}</td>
        <td>
            {{-- @if($auditData->production_d_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_d_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_d }}
            <br>
            {{ $auditData->production_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->production_e }}</td>
        <td>
            {{-- @if($auditData->production_e_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_e_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_e }}
            <br>
            {{ $auditData->production_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->production_f }}</td>
        <td>
            {{-- @if($auditData->production_f_image)
            <img src="{{ $auditData->imglgpath.$auditData->production_f_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_f }}
            <br>
            {{ $auditData->production_f_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>6. Records (Total Score 8 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->records_a }}</td>
        <td>
            {{-- @if($auditData->records_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->records_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_a }}
            <br>
            {{ $auditData->records_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->records_b }}</td>
        <td>
            {{-- @if($auditData->records_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->records_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_b }}
            <br>
            {{ $auditData->records_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->records_c }}</td>
        <td>
            {{-- @if($auditData->records_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->records_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_c }}
            <br>
            {{ $auditData->records_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->records_d }}</td>
        <td>
            {{-- @if($auditData->records_d_image)
            <img src="{{ $auditData->imglgpath.$auditData->records_d_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_d }}
            <br>
            {{ $auditData->records_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>7. Labelings (Total Score 6 points)</td>
    </tr>
    <tr>
        <th>Audit Guidelines</th>
        <th>Evidence</th>
        <th>Note</th>
    </tr>
    <tr>
        <td>{{ $templateData->labeling_a }}</td>
        <td>
            {{-- @if($auditData->labeling_a_image)
            <img src="{{ $auditData->imglgpath.$auditData->labeling_a_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_a }}
            <br>
            {{ $auditData->labeling_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->labeling_b }}</td>
        <td>
            {{-- @if($auditData->labeling_b_image)
            <img src="{{ $auditData->imglgpath.$auditData->labeling_b_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_b }}
            <br>
            {{ $auditData->labeling_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td>{{ $templateData->labeling_c }}</td>
        <td>
            {{-- @if($auditData->labeling_c_image)
            <img src="{{ $auditData->imglgpath.$auditData->labeling_c_image }}" alt="image" class="img-fluid">
            @endif --}}
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_c }}
            <br>
            {{ $auditData->labeling_c_remarks }}
        </td>
    </tr>


</table>
