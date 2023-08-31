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
use App\Models\Project;
use App\Models\Location;
use App\Models\Item;

class InventoryTemplate implements FromArray, WithTitle, ShouldAutoSize, WithStyles, WithColumnWidths, WithStrictNullComparison, WithEvents
{

    protected $results;

    public function title(): string
    {
        $loc = Request()->loc;
        $title = 'Inventory';
        $location = Location::where("LocationId",$loc)->first();
        if($loc && $location) $title .= " ".$location->Name;
        return $title;
    }

    public function array(): array
    {
        $this->results = [ ["Project","Location","Item Code","Item Name","Hour Maintenance","Quantity"], ];
        return $this->results;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $loc = Request()->loc;
                $optionsA = array_map(
                    fn($value) => $value['Name'] ." | ". $value['ProjectId'],
                    Project::when($loc,function($query) use($loc) {
                            $query->where("LocationId",$loc);
                        })
                        ->where("IsPermanentDelete",0)
                        ->where("Active",1)
                        ->get()
                        ->toArray()
                );
                $valA = $event->sheet->getCell("A2")->getDataValidation();
                $valA->setType(DataValidation::TYPE_LIST );
                $valA->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $valA->setAllowBlank(false);
                $valA->setShowInputMessage(true);
                $valA->setShowErrorMessage(true);
                $valA->setShowDropDown(true);
                $valA->setErrorTitle('Input error');
                $valA->setError('Value is not in list');
                $valA->setPromptTitle('Pick from list');
                $valA->setPrompt('Please pick a value from the drop-down list');
                $valA->setFormula1(sprintf('"%s"',implode(',',$optionsA)));

                $optionsB = array_map(
                    fn($value) => $value['Name'] ." | ". $value['LocationId'],
                    Location::when($loc,function($query) use($loc) {
                            $query->where("LocationId",$loc);
                        })
                        ->where("IsPermanentDelete",0)
                        ->where("Active",1)
                        ->get()
                        ->toArray()
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

                $optionsC = array_map(
                    fn($value) => $value['Code'] ." | ". $value['Name'],
                    Item::where("IsPermanentDelete",0)->where("Active",1)->get()->toArray()
                );
                $valC = $event->sheet->getCell("C2")->getDataValidation();
                $valC->setType(DataValidation::TYPE_LIST );
                $valC->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $valC->setAllowBlank(false);
                $valC->setShowInputMessage(true);
                $valC->setShowErrorMessage(true);
                $valC->setShowDropDown(true);
                $valC->setErrorTitle('Input error');
                $valC->setError('Value is not in list');
                $valC->setPromptTitle('Pick from list');
                $valC->setPrompt('Please pick a value from the drop-down list');
                $valC->setFormula1(sprintf('"%s"',implode(',',$optionsC)));

                for ($i=3; $i<=(count($this->results)+1); $i++) {
                    $event->sheet->getCell("A{$i}")->setDataValidation(clone $valA);
                    $event->sheet->getCell("B{$i}")->setDataValidation(clone $valB);
                    $event->sheet->getCell("C{$i}")->setDataValidation(clone $valC);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $cols = $sheet->getStyle('A1:F1');
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
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 15,
        ];
    }
}
