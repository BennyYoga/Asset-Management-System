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
                        'RequesterId' => $row->RequesterId,
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
                    'RequesterId' => $data['RequesterId'],
                    'Requester' => $data['RoleName'],
                    'Approver1' => implode(', ', $data['Approver1']),
                    'Approver2' => implode(', ', $data['Approver2']),
                    'UpdatedBy' => $data['UpdatedBy'],
                    'UpdatedDate' => $data['UpdatedDate'],
                ];
            }

            return DataTables::of($finalProcessedData)
                ->addColumn('Action', function ($row) {
                    $btn = '<a href=' . route('master.req.setting', $row['RequesterId']) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-cog"></i></a>';
                    return $btn;
                })
                ->rawColumns(['Action', 'Approver1', 'Approver2'])
                ->make(true);
        }

        return view('Master.requisition');
    }

    public function masterApprovalReqSetting(Request $request, $id)
    {
        if ($request->ajax()) {
            $applist = ApproverMaster::where('RequesterId', $id)->get();
            $processedData = [];

            foreach ($applist as $row) {
                $key = $row->ApprovalOrder;

                if (!isset($processedData[$key])) {
                    $processedData[$key] = [
                        'RequesterId' => $row->RequesterId,
                        'ApprovalOrder' => $row->ApprovalOrder,
                        'Approver' => [],
                    ];
                }

                $approverName = Role::where('RoleId', $row->ApproverId)->value('RoleName');
                $processedData[$key]['Approver'][] = $approverName;
            }

            $finalProcessedData = [];

            foreach ($processedData as $key => $data) {
                $finalProcessedData[] = [
                    'RequesterId' => $data['RequesterId'],
                    'ApprovalOrder' => $data['ApprovalOrder'],
                    'Approver' => implode(', ', $data['Approver']),
                ];
            }

            return DataTables::of($finalProcessedData)
                ->addColumn('Action', function ($row) {
                    $btn = '<a href=' . route('master.req.setting', $row['RequesterId']) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil"></i></a>';
                    $btn .= '<a href=' . route('master.req.setting', $row['RequesterId']) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->rawColumns(['Action', 'Approver'])
                ->make(true);
        }

        $appreq = ApproverMaster::where('RequesterId', $id)->firstOrFail();
        $requester = Role::where('RoleId', $appreq->RequesterId)->first();
        $role = Role::all();
        $approver = DB::table('ApproverMaster')->where('RequesterId', $id)->get();
        $selectedApprover = [];
        $unselectedApprover = [];
        $order = ApproverMaster::where('RequesterId', $id)->get();

        $approvalOrders = ApproverMaster::where('RequesterId', $id)
            ->distinct('ApprovalOrder')
            ->pluck('ApprovalOrder');

        $selectedApprovalOrder = $appreq->ApprovalOrder;
        $selectedRequesterId = $appreq->RequesterId;

        $approversWithSelectedOrder = ApproverMaster::where('ApprovalOrder', $selectedApprovalOrder)
            ->where('RequesterId', $selectedRequesterId)
            ->pluck('ApproverId')
            ->toArray();

        $allApprovers = Role::all(['RoleId', 'RoleName']);
        return view('Master.requisitionSetting', compact(
            'appreq',
            'selectedApprover',
            'unselectedApprover',
            'id',
            'requester',
            'approversWithSelectedOrder',
            'order',
            'approvalOrders',
            'selectedApprovalOrder',
            'selectedRequesterId',
            'role',
            'approver',
            'allApprovers'
        ));
    }

    public function saveApprovalReqSetting(Request $request, $id)
    {

        $appreq = new ApproverMaster();
        $appreq->RequesterId = $request->input('RequesterId');
        $appreq->ApprovalOrder = $request->input('ApprovalOrder');

        $appreq->save();

        return view('Master.requisitionSetting');
    }

    public function getLevel($id, $jabatan){
        $result = ApproverMaster::where([['RequesterId', $jabatan], ['ApprovalOrder', $id]])->get()->pluck('ApproverId');
        return response()->json($result);
    }
}
