<?php

namespace App\Imports\Sheets;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ItemCategoriesSheet implements ToCollection
{
    public function collection(Collection $rows) {
        foreach ($rows as $k => $row) {
            if($k==0) continue;
            $item = Item::where("Code",$row[0])->first();
            if($item==null) continue;
            $category = explode(" | ",$row[1]);
            $data = [
                'ItemId' => $item->ItemId,
                'CategoryId' => $category[1],
            ];
            DB::table('CategoryItem')->insert($data);
        }
    }
}
