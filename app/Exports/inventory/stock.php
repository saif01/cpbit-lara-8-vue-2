<?php

namespace App\Exports\inventory;

use App\Models\Cms\Application\applicationComplain;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class stock implements FromView, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data){
        $this->data = $data;
    }



    public function view(): View
    {
        $product =  $this->data;
        return view('inventory.admin.reports.stock', compact('product'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:L')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:L')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


                //$event->sheet->setCellValue('=SUM(Table1[BALANCE])');
             
            },
        ];
    }




}