<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Cell\Cell;

use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class SmsMessage extends DefaultValueBinder implements WithCustomValueBinder, FromArray
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


    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }



    // public function headings(): array
    // {
    //     return $this->headings;
    // }

    // public function registerEvents(): array
    // {
    //     return [
    //         // Handle by a closure.
    //         BeforeExport::class => function(BeforeExport $event) {
    //             $event->writer->getProperties()->setTitle('Patrick');
    //         },
    //     ];
    // }


    // public function headings(): array
    // {
    //     // return [
    //     //     'Number',
    //     //     'Message',
    //     // ];
    // }






}
