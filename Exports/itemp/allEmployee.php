<?php

namespace App\Exports\itemp;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class allEmployee implements FromView, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data){
        $this->data = $data;
       // dd($this->data);
    }



    public function view(): View
    {
        $employee =  $this->data;
        return view('itemp.admin.report.allemployee', compact('employee'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:E')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:E')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
               
            },
        ];
    }



}