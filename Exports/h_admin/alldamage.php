<?php

namespace App\Exports\h_admin;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class alldamage implements FromView, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data){
        $this->data = $data;
       // dd($this->data);
    }



    public function view(): View
    {
        $complain =  $this->data;
        return view('cms.hardware_admin.report.alldamage', compact('complain'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:H')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:H')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
               
            },
        ];
    }



}