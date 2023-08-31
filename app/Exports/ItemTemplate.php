<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ItemTemplateSheet;
use App\Exports\Sheets\ItemCategoryTemplateSheet;

class ItemTemplate implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new ItemTemplateSheet(),
            new ItemCategoryTemplateSheet(),
        ];
    }
}
