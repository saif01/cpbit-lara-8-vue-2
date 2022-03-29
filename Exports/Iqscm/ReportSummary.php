<?php

namespace App\Exports\Iqscm;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use PhpOffice\PhpSpreadsheet\Cell\Cell;
//use PhpOffice\PhpSpreadsheet\Cell\DataType;
//use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
//use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;


use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;





class ReportSummary implements FromArray, WithHeadings, WithTitle, WithCustomStartCell
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // return [
        //     [
        //         'name' => 'Povilas',
        //         'email' => 'povilas@laraveldaily.com',
        //     ],
        //     [
        //         'name' => 'Taylor',
        //         'email' => 'taylor@laravel.com',
        //     ],
        // ];

        return  $this->data;
    }

    public function headings(): array
    {
        return [
            'Zone',
            'Zone Manager',
            'Total Inspect',
            'Corrective Action Taken',
            'Score >= 80',
            'Score 70-79',
            'Score < 70',
            'Qality (25%)',
            'Service (20%)',
            'Cleaning (35%)',
            'Maintenance (20%)',
            'Average QSCM Score'

        ];
    }




    // public function registerEvents()
    // {
    //    return [
    //        AfterSheet::class => function(AfterSheet $event) {
    //            $event->sheet->setCellValue('A1:M1', 'STUDENT PERFORMANCE');
    
    //            // $cells->setAlignment('center')
    
    //            //$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
    //        },
    //    ];
    // }

    public function startCell(): string
    {
        return 'A1';
    }


    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function(AfterSheet $event) use ($stylesArray, $vacancy) {
    //             $event->sheet->setCellValue('A1:M1', 'STUDENT PERFORMANCE');
    //         },
    //     ];
    // }


    public function title(): string
    {
    	return 'Some Text';
    }

}
