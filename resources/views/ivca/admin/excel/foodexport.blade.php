<table>
    <tr>
        <td colspan="3" rowspan="2" style="text-align: center">
            CP Food (Bangladesh) Co., Ltd.
            <br>
            QC Department
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">PREMISE AUDIT CHECKLIST</td>
    </tr>
    <tr>
        <td colspan="3" rowspan="3">
            Name of Organization: @if($auditData->vendor)
            {{ $auditData->vendor->vendor_number }} - {{ $auditData->vendor->suppier_name }}
            @endif
            Audit Date: {{ $auditData->date }} || Time: {{ $auditData->created_at }}
            <br>
            Types of Business: @if($auditData->schedule)
            {{ $auditData->schedule->business_type }}
            @endif
            Purchased Product:
            @if($auditData->schedule)
            {{ $auditData->schedule->purchased_product }}
            @endif
            <br>
            Address: @if($auditData->vendor)
            {{ $auditData->vendor->address }}
            @endif
            Auditor(s): @if($auditData->auditordata)
            {{ $auditData->auditordata->name }}
            @endif
        </td>
        
    </tr>
    <tr></tr>
    <tr></tr>


    <tr>
        <td colspan="3" style="font-weight:bold"> Building and facilities (Total Score 10 points) </td>
    </tr>

    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->building_facilities_a }}</td>
        <td rowspan="2">
            @if($auditData->building_facilities_a_image)
            {{-- <img src="http://cpbit-8/images/ivca/food/Awr3pv1637405800.jpeg" alt=""> --}}
            {{-- <img src="{{URL::asset($auditData->imglgpath.$auditData->building_facilities_a_image)}}" /> --}}
            {{-- <img src="{{ $auditData->imglgpath.$auditData->building_facilities_a_image }}" alt="image"> --}}
            @endif
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_a }}
            <br>
            {{ $auditData->building_facilities_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->building_facilities_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_b }}
            <br>
            {{ $auditData->building_facilities_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->building_facilities_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_c }}
            <br>
            {{ $auditData->building_facilities_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->building_facilities_d }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_d }}
            <br>
            {{ $auditData->building_facilities_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->building_facilities_e }}</td>
        <td rowspan="2">
           
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->building_facilities_e }}
            <br>
            {{ $auditData->building_facilities_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">2. Equipment (Total Score 6 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->equipment_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_a }}
            <br>
            {{ $auditData->equipment_a_remarks }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->equipment_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_b }}
            <br>
            {{ $auditData->equipment_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->equipment_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->equipment_c }}
            <br>
            {{ $auditData->equipment_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">3. Personnel (Total Score 6 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->personnel_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_a }}
            <br>
            {{ $auditData->personnel_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->personnel_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_b }}
            <br>
            {{ $auditData->personnel_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->personnel_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->personnel_c }}
            <br>
            {{ $auditData->personnel_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">4. Raw materials (Total Score 10 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->raw_materials_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_a }}
            <br>
            {{ $auditData->raw_materials_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->raw_materials_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_b }}
            <br>
            {{ $auditData->raw_materials_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->raw_materials_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_c }}
            <br>
            {{ $auditData->raw_materials_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->raw_materials_d }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_d }}
            <br>
            {{ $auditData->raw_materials_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->raw_materials_e }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->raw_materials_e }}
            <br>
            {{ $auditData->raw_materials_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">5. Production (Total Score 12 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_a }}
            <br>
            {{ $auditData->production_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_b }}
            <br>
            {{ $auditData->production_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_c }}
            <br>
            {{ $auditData->production_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_d }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_d }}
            <br>
            {{ $auditData->production_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_e }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_e }}
            <br>
            {{ $auditData->production_e_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->production_f }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->production_f }}
            <br>
            {{ $auditData->production_f_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">6. Records (Total Score 8 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->records_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_a }}
            <br>
            {{ $auditData->records_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->records_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_b }}
            <br>
            {{ $auditData->records_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->records_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_c }}
            <br>
            {{ $auditData->records_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->records_d }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->records_d }}
            <br>
            {{ $auditData->records_d_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3" style="font-weight:bold">7. Labelings (Total Score 6 points)</td>
    </tr>
    <tr>
        <th style="font-weight: bold; text-align:center">Audit Guidelines</th>
        <th style="font-weight: bold; text-align:center">Evidence</th>
        <th style="font-weight: bold; text-align:center">Note</th>
    </tr>
    <tr>
        <td rowspan="2">{{ $templateData->labeling_a }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_a }}
            <br>
            {{ $auditData->labeling_a_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->labeling_b }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_b }}
            <br>
            {{ $auditData->labeling_b_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td rowspan="2">{{ $templateData->labeling_c }}</td>
        <td rowspan="2">
            
        </td>
        <td rowspan="2" style="font-weight: bold">
            Get Point: {{ $auditData->labeling_c }}
            <br>
            {{ $auditData->labeling_c_remarks }}
        </td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="3">REC/QC-041 (REV 2: 24-1-17)</td>
    </tr>
    

    
    


</table>
