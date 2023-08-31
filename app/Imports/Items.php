<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\ItemsSheet;
use App\Imports\Sheets\ItemCategoriesSheet;

class Items implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            new ItemsSheet(),
            new ItemCategoriesSheet(),
        ];
    }
}
