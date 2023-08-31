<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Models\Category;

class ItemCategoryTemplateSheet implements FromArray, WithTitle, ShouldAutoSize, WithStyles, WithColumnWidths, WithStrictNullComparison, WithEvents
{

    protected $results;

    public function title(): string
    {
        return 'Item Categories';
    }

    public function array(): array
    {
        $this->results = [ ["Item Code","Category"], ];
        return $this->results;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $optionsB = array_map(
                    fn($value) => $value['Name'] ." | ". $value['CategoryId'],
                    Category::where("IsPermanentDelete",0)->where("Active",1)->get()->toArray()
                );
                $valB = $event->sheet->getCell("B2")->getDataValidation();
                $valB->setType(DataValidation::TYPE_LIST );
                $valB->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $valB->setAllowBlank(false);
                $valB->setShowInputMessage(true);
                $valB->setShowErrorMessage(true);
                $valB->setShowDropDown(true);
                $valB->setErrorTitle('Input error');
                $valB->setError('Value is not in list');
                $valB->setPromptTitle('Pick from list');
                $valB->setPrompt('Please pick a value from the drop-down list');
                $valB->setFormula1(sprintf('"%s"',implode(',',$optionsB)));

                for ($i=3; $i<=(count($this->results)+1); $i++) {
                    $event->sheet->getCell("B{$i}")->setDataValidation(clone $valB);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $cols = $sheet->getStyle('A1:B1');
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
        ];
    }
}
