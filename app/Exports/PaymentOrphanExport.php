<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Events\AfterSheet;

class PaymentOrphanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithPreCalculateFormulas
{
    use Exportable;
    private $collect;
    private $headings;
    private $cellsMerge;

    public function __construct($collect, $headings, $cellsMerge)
    {
        $this->collect = $collect;
        $this->headings = $headings;
        $this->cellsMerge = $cellsMerge;
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
        $cellRange = 'A1';
        $columnscount = sizeof($this->headings);

        if($columnscount >0 && $columnscount <=26){
            $letter = chr($columnscount+64);
            $cellRange = $cellRange.":".$letter.'1';
        }elseif ($columnscount >26 && $columnscount <=52){
            $letter = chr(($columnscount)/26+64);
            $letter = $letter.chr(($columnscount)%26+64);
            $cellRange = $cellRange.':'.$letter.'1';
        }
        return [
            AfterSheet::class  => function(AfterSheet $event) use ($cellRange) {
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle($cellRange)->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'D9D9D9'],]);

                /*  foreach ($this->cellsSum as $cellsum){
                      $cell = explode(":",$cellsum);
                      $event->sheet->setCellValue($cell[0], "=SUM($cellsum)");
                  }*/
                foreach ($this->cellsMerge as $cellMerge){
                    $event->sheet->mergeCells($cellMerge);
                }

                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $columnscount = sizeof($this->headings);
                if($columnscount >0 && $columnscount <=26){
                    $letter = chr($columnscount+64);
                }elseif ($columnscount >26 && $columnscount <=52){
                    $letter = chr(($columnscount)/26+64);
                    $letter = $letter.chr(($columnscount)%26+64);
                }

                $cellsCenter = "A2:".$letter.(sizeof($this->collect)+1);
                $event->sheet->getDelegate()->getStyle($cellsCenter)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


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
/*  for($i=1; $i<sizeof($this->collect); $i++) {
                   // dd($this->collect);
                    for ($j = 0; $j < sizeof($this->collect[$i]); $j++) {
                        if ($this->collect[$i][$j] == $this->collect[$i + 1][$j]) {
                            if($j >0 && $j <=26){
                                $letterMerge = chr($j+65);
                            }elseif ($j >26 && $j <=52){
                                $letterMerge = chr(($j)%26+65);
                            }
                            $event->sheet->mergeCells($letterMerge.($i+1).":".$letterMerge.($i+2));
                        }
                    }
                }*/
