<?php

namespace App\Http\Controllers;

use App\Models\m_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Redis;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $category = m_category::where('IspermanentDelete', 0);
            return DataTables::of($category)
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('category.edit', $row->CategoryId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('category.destroy', $row->CategoryId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->addColumn('Parent', function ($row) {
                    $parent = m_category::where('CategoryId', $row->ParentId)->first();
                    return $parent ? 'Child Of '. $parent->Name : 'Undifined';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = m_category::all();
        return view('category.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminat'IsPermanentDelete']=0;
     * 
     * dd($data)
     */
    public function store(Request $request)
    {
        
        $request->validate(
            [
            'Name' => 'required',
            'Active' => 'required',
            ]
        );
        $data =[
            'CategoryId' =>(String)Str::uuid(),
            'Name' => $request->Name,
            'Active' => $request->Active,
            'IsPermanentDelete' => 0,
            'ParentId' => $request->ParentId,
        ];
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // $data['UpdatedBy'] = $user;
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        m_category::create($data);
        return redirect()->route('category.index')->withToastSuccess('Berhasil');
        
        
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
        $category = m_category::find($id);
        if($category){
            $categories = m_category::where('CategoryId', '!=', $id)->get();
            return view('category.edit', compact('category', 'categories'));
        }return redirect()->to('category.index')->withToastError('Data tidak ditemukan');
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
        $request->validate(
            [
            'Name' => 'required',
            'Active' => 'required',
            ]
        );
        $data =[
            'Name' => $request->Name,
            'Active' => $request->Active,
            // 'IsPermanentDelete' => $request->IsPermanentDelete,
            // 'ParentId' => $request->ParentId,
        ];
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // $data['UpdatedBy'] = $user;
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        // dd($data);
        $category = m_category::where('CategoryId', $id);
        if ($category) {
            $category->update($data);
            return redirect()->route('category.index')->withToastSuccess('Berhasil');
        } else {
            // Handle the case when the category with the specified CategoryId is not found
            return redirect()->route('category.index')->withToastError('Kategori tidak ditemukan');
        }
    }
    public function destroy($CategoryId)
    {
        $category = m_category::find($CategoryId);

// Cek apakah ada anak kategori dengan ParentId yang sama dengan categoryId
        $checkParent = m_category::where('ParentId', $category->CategoryId)->exists();

        if ($checkParent) {
    // Cek Anak Kategori dengan IsPermanentDelete = 1
            $checkDelete = m_category::where('ParentId', $category->CategoryId)
                ->where('IsPermanentDelete', 1)
                ->exists();

            if ($checkDelete) {
                $category['IsPermanentDelete'] = 1;
                $category->update();
                return redirect()->route('category.index')->withToastSuccess('Berhasil Menghapus Data');
            }
            return redirect()->route('category.index')->withToastError('Tidak dapat menghapus');
        }
        $category['IsPermanentDelete'] = 1;
        $category->update();
        return redirect()->route('category.index')->withToastSuccess('Berhasil menghapus');


    }
}
