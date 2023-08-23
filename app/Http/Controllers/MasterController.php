<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ApproverMaster;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function masterApprovalReq(Request $request){
        if ($request->ajax()) {
            $appreq = ApproverMaster::select('RequesterId','ApprovalOrder','ModuleId')
                ->orderBy('RequesterId')
                ->orderBy('ApprovalOrder')
                ->get();
            return DataTables::of($appreq)
            ->addColumn('RoleName', function ($row) {
                $name = Role::where('RoleId', $row->RequesterId)->first();
                return $name->RoleName;
            })
            ->addColumn('combined_info', function($row) {
                return "{$row->RequesterId} - Order: {$row->ApprovalOrder}";
            })
            ->addColumn('Approver1', function ($row) {
                if ($row->ApprovalOrder == 1) {
                    $approver1 = Role::where('RoleId', $row->ApproverId)->first();
                    return $approver1 ? $approver1->RoleName : '';
                } else {
                    return '';
                }
            })
            ->addColumn('Approver2', function ($row) {
                if ($row->ApprovalOrder == 2) {
                    $approver2 = Role::where('RoleId', $row->ApproverId)->first();
                    return $approver2 ? $approver2->RoleName : '';
                } else {
                    return '';
                }
            })
            ->addColumn('Action', function($row){
                $btn = '<a href=' . route('master.req.setting', $row->ApproverMasterId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                return $btn;
            })
            ->rawColumns(['Action'])
            ->make(true);
        }

        return view('Master.requisition');
    }

    public function masterApprovalReqSetting(Request $request, $id){
        if ($request->ajax()) {
            $applist = ApproverMaster::where('ApproverMasterId', $id)->get();
            return DataTables::of($applist)
            ->addColumn('RoleName', function ($row) {
                $name = Role::where('RoleId', $row->ApproverId)->first();
                return $name->RoleName;
            })
            ->addColumn('Action', function($row){
                $btn = '<a href=' . route('master.req.setting', $row->ApproverMasterId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil"></i></a>';
                $btn .= '<a href=' . route('master.req.setting', $row->ApproverMasterId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                return $btn;
            })
            ->rawColumns(['Action'])
            ->make(true);
        }

        $appreq = ApproverMaster::where('ApproverMasterId', $id)->firstOrFail();
        $role = Role::all();
        $approver = DB::table('ApproverMaster')->where('ApproverMasterId', $id)->get();
        $selectedApprover = [];
        $unselectedApprover = [];
        // $appreq = ApproverMaster::where('ApproverMasterId', $id)->first();
        // $data = [
        //     'appreq' => $appreq,
        // ];

        foreach ($role as $role) {
            $isApproverSelected = false;

            for ($i = 0; $i < count($approver); $i++) {
                if ($approver[$i]->ApproverMasterId == $role['RoleId']) {
                    $isApproverSelected = true;
                    break;
                }
            }
            if ($isApproverSelected) {
                $data = [
                    'RoleId' => $role['RoleId'],
                    'RoleName' => $role['RoleName'],
                ];
                array_push($selectedApprover, $data);
            } else {
                $data = [
                    'RoleId' => $role['RoleId'],
                    'RoleName' => $role['RoleName'],
                ];
                array_push($unselectedApprover, $data);
            }
        }

        return view('Master.requisitionSetting',compact('appreq','selectedApprover','unselectedApprover','id'));
    }

    public function saveApprovalReqSetting(Request $request, $id) {
        // Validasi input jika diperlukan
    
        $appreq = new ApproverMaster();
        $appreq->RequesterId = $request->input('RequesterId');
        $appreq->ApprovalOrder = $request->input('ApprovalOrder');
        // ... mengisi atribut-atribut lain sesuai form
    
        // Simpan instance ke database
        $appreq->save();
    
        // Redirect ke halaman yang sesuai atau tampilkan pesan sukses
        return view('Master.requisitionSetting');
    }
    
}