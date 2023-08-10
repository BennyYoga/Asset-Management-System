<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function masterApprovalReq(Request $request){
        if ($request->ajax()) {
            $appreq = Role::all();
            return DataTables::of($appreq)
            ->addColumn('Action', function($row){
                $btn = '<a href=' . route('role.create', $row->RoleId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                return $btn;
            })
            ->rawColumns(['Action'])
            ->make(true);
        }

        return view('Master.requisition');
    }
}
