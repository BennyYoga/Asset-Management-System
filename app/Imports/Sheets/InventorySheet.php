<?php

namespace App\Imports\Sheets;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Item;
use App\Models\Location;
use App\Models\Project;

class InventorySheet implements ToCollection
{
    public function collection(Collection $rows) {
        foreach ($rows as $k => $row) {
            if($k==0) continue;
            $item = Item::where("Code",explode(" | ",$row[2])[0])->first();
            if($item==null) continue;
            $location = Location::where("LocationId",explode(" | ",$row[1])[1])->first();
            if($location==null) continue;
            $project = Project::where("ProjectId",explode(" | ",$row[0])[1])->first();
            if($project==null) continue;
            $data = [
                'LocationId' => $location->LocationId,
                'ItemId' => $item->ItemId,
                'ProjectId' => $project->ProjectId,
                'ItemName' => $item->ItemBehavior==2 ? $item->Name : $row[3],
                'HourMaintenance' => $row[4],
                'ItemQty' => $row[5],
            ];
            DB::table("Inventory")->insert($data);
        }
    }
}
