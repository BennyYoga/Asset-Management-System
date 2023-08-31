<?php

namespace App\Imports\Sheets;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class ItemsSheet implements ToCollection
{
    public function collection(Collection $rows) {
        foreach ($rows as $k => $row) {
            if($k==0) continue;
            $uuid = (string) Str::uuid();
            $behavior = $row[3]=="Consumable" ? 2 : 1;
            $data = [
                'ItemId' => $uuid,
                'Code' => $row[0],
                'Name' => $row[1],
                'Unit' => $row[2],
                'UseType' => strtolower($row[6]),
                'ItemBehavior' => $behavior,
                'IsPermanentDelete' => 0,
                'CreatedBy' => session('user')->UserId,
                'CreatedByLocation' => 11,
                'UpdatedBy' => session('user')->UserId,
                'Active' => 1,
                'AlertHourMaintenance' => $behavior==1 ? (int) $row[4] : null,
                'AlertConsumable' => $behavior==2 ? (int) $row[5] : null,
            ];
            Item::create($data);
        }
    }
}
