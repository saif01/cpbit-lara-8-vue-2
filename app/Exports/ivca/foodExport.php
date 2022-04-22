<?php

namespace App\Exports\ivca;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use DB;


class foodExport implements FromView, WithEvents
{
    public $data;
    public $data2;



    public function __construct($auditData, $templateData){
        $this->data = $auditData;
        $this->data2 = $templateData;
    }


    public function view(): View
    {
        $auditData = (object) $this->data;
        $templateData = (object) $this->data2;
        //dd($finalResult);
        
        return view('ivca.admin.excel.foodExport', compact('auditData','templateData'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(80);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);

                $event->sheet->getDelegate()->getStyle('A')->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getRowDimension('9')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('11')->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension('13')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('15')->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension('17')->setRowHeight(40);

                $event->sheet->getDelegate()->getRowDimension('21')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('23')->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension('25')->setRowHeight(40);

                $event->sheet->getDelegate()->getRowDimension('29')->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension('31')->setRowHeight(50);

                $event->sheet->getDelegate()->getRowDimension('37')->setRowHeight(40);
                $event->sheet->getDelegate()->getRowDimension('43')->setRowHeight(50);
                $event->sheet->getDelegate()->getRowDimension('45')->setRowHeight(50);

                $event->sheet->getDelegate()->getRowDimension('65')->setRowHeight(40);

                
            },
        ];
    }

 

    


}