<?php

namespace App\Exports\inventory;

use App\Models\Cms\Application\applicationComplain;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class newProduct implements FromView, ShouldAutoSize, WithEvents
{
    public $data, $length;

    public function __construct($data, $length){
        $this->data = $data;
        $this->length = $length;
    }



    public function view(): View
    {
        

        $product =  $this->data;
        $length =  $this->length;
        return view('inventory.admin.reports.newProduct', compact('product','length'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:H')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:H')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


                //$event->sheet->setCellValue('=SUM(Table1[BALANCE])');
             
            },
        ];
    }




}