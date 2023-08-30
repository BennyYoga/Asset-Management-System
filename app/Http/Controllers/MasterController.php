<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ApproverMaster;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function masterApprovalReq(Request $request)
    {
        if ($request->ajax()) {
            $appreq = ApproverMaster::where('ModuleId', 1)
                ->join('Role as r1', 'ApproverMaster.RequesterId', '=', 'r1.RoleId')
                ->select('ApproverMaster.*', 'r1.RoleName as RequesterRoleName')
                ->orderBy('ApproverMasterId', 'desc')
                ->get();
            
            $processedData = [];
    
            foreach ($appreq as $row) {
                $key = $row->RequesterId;
    
                if (!isset($processedData[$key])) {
                    $processedData[$key] = [
                        'ApproverMasterId' => $row->ApproverMasterId,
                        'RoleName' => $row->RequesterRoleName,
                        'Approver1' => [],
                        'Approver2' => [],
                        'UpdatedBy' => $row->UpdatedBy,
                        'UpdatedDate' => $row->UpdatedDate,
                    ];
                }
    
                if ($row->ApprovalOrder == 1) {
                    $approverName = Role::where('RoleId', $row->ApproverId)->value('RoleName');
                    $processedData[$key]['Approver1'][] = $approverName;
                } elseif ($row->ApprovalOrder == 2) {
                    $approverName = Role::where('RoleId', $row->ApproverId)->value('RoleName');
                    $processedData[$key]['Approver2'][] = $approverName;
                }
            }
    
            $finalProcessedData = [];
    
            foreach ($processedData as $key => $data) {
                $finalProcessedData[] = [
                    'ApproverMasterId' => $data['ApproverMasterId'],
                    'Requester' => $data['RoleName'],
                    'Approver1' => implode(', ', $data['Approver1']),
                    'Approver2' => implode(', ', $data['Approver2']),
                    'UpdatedBy' => $data['UpdatedBy'],
                    'UpdatedDate' => $data['UpdatedDate'],
                ];
            }
    
            return DataTables::of($finalProcessedData)
                ->addColumn('Action', function ($row) {
                    $btn = '<a href=' . route('master.req.setting', $row['ApproverMasterId']) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                    return $btn;
                })
                ->rawColumns(['Action', 'Approver1', 'Approver2'])
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
        $requester = Role::where('RoleId', $appreq->RequesterId)->first();
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

        $selectedApprovalOrder = $appreq->ApprovalOrder;
        $approversWithSelectedOrder = ApproverMaster::where('ApprovalOrder', $selectedApprovalOrder)
        ->pluck('ApproverId')
        ->toArray();

        return view('Master.requisitionSetting',compact('appreq','selectedApprover','unselectedApprover','id', 'requester','approversWithSelectedOrder'));
    }

    public function saveApprovalReqSetting(Request $request, $id) {
    
        $appreq = new ApproverMaster();
        $appreq->RequesterId = $request->input('RequesterId');
        $appreq->ApprovalOrder = $request->input('ApprovalOrder');
    
        $appreq->save();
    
        return view('Master.requisitionSetting');
    }
    
}