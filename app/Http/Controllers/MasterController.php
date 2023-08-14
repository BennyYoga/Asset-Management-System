<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ApproverMaster;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function masterApprovalReq(Request $request){
        if ($request->ajax()) {
            $appreq = ApproverMaster::all();
            return DataTables::of($appreq)
            ->addColumn('RoleName', function ($row) {
                $name = Role::where('RoleId', $row->RequesterId)->first();
                return $name->RoleName;
            })
            ->addColumn('Action', function($row){
                $btn = '<a href=' . route('master.req.setting', $row->RequesterId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                return $btn;
            })
            ->rawColumns(['Action'])
            ->make(true);
        }

        return view('Master.requisition');
    }

    public function masterApprovalReqSetting($id){
        $appreq = ApproverMaster::where('ApproverMasterId', $id)->first();
        $role = Role::all();
        $data = [
            'appreq' => $appreq,
            'role' => $role
        ];
        return view('Master.requisitionSetting', compact('data'));
    }
}