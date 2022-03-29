<?php

namespace App\Exports\carpool;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class carpoolMaint implements FromView, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data){
        $this->data = $data;
       // dd($this->data);
    }



    public function view(): View
    {
        $data =  $this->data;
        return view('carpool.admin.report.carpoolMaint', compact('data'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:F')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:F')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
               
            },
        ];
    }



}