<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;

class ItemTemplateSheet implements FromArray, WithTitle, ShouldAutoSize, WithStyles, WithColumnWidths, WithStrictNullComparison, WithEvents
{

    protected $results;

    public function title(): string
    {
        return 'Items';
    }

    public function array(): array
    {
        $data = Schema::getColumnListing("Item");
        Arr::forget($data,[15,14,13,12,10,9,8,0]);
        $this->results = [$data];
        return $this->results;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $optionsG = ["Single","Group",];
                $valG = $event->sheet->getCell("G2")->getDataValidation();
                $valG->setType(DataValidation::TYPE_LIST );
                $valG->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $valG->setAllowBlank(false);
                $valG->setShowInputMessage(true);
                $valG->setShowErrorMessage(true);
                $valG->setShowDropDown(true);
                $valG->setErrorTitle('Input error');
                $valG->setError('Value is not in list');
                $valG->setPromptTitle('Pick from list');
                $valG->setPrompt('Please pick a value from the drop-down list');
                $valG->setFormula1(sprintf('"%s"',implode(',',$optionsG)));

                $optionsD = ["Hour Usage Monitor","Consumable",];
                $valD = $event->sheet->getCell("D2")->getDataValidation();
                $valD->setType(DataValidation::TYPE_LIST );
                $valD->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $valD->setAllowBlank(false);
                $valD->setShowInputMessage(true);
                $valD->setShowErrorMessage(true);
                $valD->setShowDropDown(true);
                $valD->setErrorTitle('Input error');
                $valD->setError('Value is not in list');
                $valD->setPromptTitle('Pick from list');
                $valD->setPrompt('Please pick a value from the drop-down list');
                $valD->setFormula1(sprintf('"%s"',implode(',',$optionsD)));

                for ($i=3; $i<=(count($this->results)+1); $i++) {
                    $event->sheet->getCell("G{$i}")->setDataValidation(clone $valG);
                    $event->sheet->getCell("D{$i}")->setDataValidation(clone $valD);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $cols = $sheet->getStyle('A1:H1');
        $cols->getFont()->setBold(true);
        $cols->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'D' => 20,
            'G' => 15,
        ];
    }
}
