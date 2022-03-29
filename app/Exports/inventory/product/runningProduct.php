<?php

namespace App\Exports\inventory\product;

use App\Models\Cms\Application\applicationComplain;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use DB;


class runningProduct implements FromView, ShouldAutoSize, WithEvents
{
    public $data;

    public function __construct($data){
        $this->data = $data;
       // dd($this->data);
    }



    public function view(): View
    {
        // return view('cms.application_admin.report.allcomplain', [ 
        //     //'complain' => applicationComplain::with('makby', 'category', 'subcategory')->get()
        //     //applicationComplain::with('makby', 'category', 'subcategory')->get()
        // ]);

        $product =  $this->data;
        return view('inventory.admin.reports.runningProduct', compact('product'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A:K')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A:K')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                // $event->sheet->getStyle('A4:H4')->applyFromArray([
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //             'color' => ['rgb' => 'FF0000'],
                //         ],
                //     ],
                // ]);
            },
        ];
    }


    // public function query()
    // {
    //     return applicationComplain::query();
    // }


    // public function map($applicationComplain): array
    // {
    //     return [
    //         $applicationComplain->id,
    //         $applicationComplain->process,
    //         $applicationComplain->category->name,
    //         $applicationComplain->subcategory->name,
    //         $applicationComplain->subcategory->name,
    //         $applicationComplain->makby->department,
    //         Date::dateTimeToExcel($applicationComplain->created_at),
    //     ];
    // }


}