<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $item = Item::all();
        dd($item);
        return view('item.index', compact('item'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = [
            'ItemId' => (string) Str::uuid(),
            'Name' => request('Name'),
            'Unit' => request('Unit'),
            'ItemBehavior' => (int) request('ItemBehavior'),
            'Active' => 1,
            'IsPermanentDelete' => 0,
            'CreatedBy' => 32,
            'CreatedByLocation' => 11,
            'UpdatedBy' => 32
        ];

        if($data['ItemBehavior'] == 1){
            $data['AlertHourMaintenance'] = request('alert');
            $data['alertConsumable'] = 0;
        }
        elseif ($data['ItemBehavior'] == 2) {
            $data['AlertHourMaintenance'] = 0;
            $data['alertConsumable'] = request('alert');
        }
        else if($data['ItemBehavior'] == 3){
            $data['AlertHourMaintenance'] = 0;
            $data['alertConsumable'] = 0;
        }

        Item::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
