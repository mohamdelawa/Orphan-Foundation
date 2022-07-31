<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PaymentOrphanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;
    private $collect;
    private $headings;

    public function __construct($collect, $headings)
    {
        $this->collect = $collect;
        $this->headings = $headings;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  $this->collect;
    }


    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        $cellRange = 'A1:';
        $columnscount = sizeof($this->headings);

        if($columnscount >0 && $columnscount <=26){
            $letter = chr($columnscount+64);
            $cellRange = $cellRange.$letter.'1';
        }elseif ($columnscount >26 && $columnscount <=52){
            $letter = chr(($columnscount)%26+64);
            $cellRange = $cellRange.'A'.$letter.'1';
        }
        return [
            AfterSheet::class    => function(AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },

        ];
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return $this->headings;

    }
}
