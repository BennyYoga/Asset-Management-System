<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


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
            $category = Category::where('IspermanentDelete', 0)->get();
            return DataTables::of($category)
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('category.edit', $row->CategoryId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    if ($row->Active == 1) {
                        $btn = '<a href=' . route('category.edit', $row->CategoryId) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                        $btn .= '<a href=' . route('category.activate', $row->CategoryId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-power-switch"></i></a>';
                        return $btn;
                    } else if ($row->Active == 0) {
                        $btn .= '<a href=' . route('category.activate', $row->CategoryId) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-power-switch"></i></a>';
                        $btn .= '<a href=' . route('category.destroy', $row->CategoryId) . ' style="font-size:20px" class="text-danger mr-10"><i class="lni lni-trash-can"></i></a>';
                        return $btn;
                    }
                })
                ->addColumn('Parent', function ($row) {
                    $parent = Category::where('CategoryId', $row->ParentId)->first();
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
        $categories = Category::where('IsPermanentDelete', 0)->get();
        return view('category.create', compact('categories'));
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
        $request->validate([
            'Name' => 'required',
            'ParentId' => 'nullable',
        ]);
    
        $data = [
            'CategoryId' => (string) Str::uuid(),
            'Name' => $request->Name,
            'ParentId' => $request->ParentId,
            'Active' => 1,
            'IsPermanentDelete' => 0,
            'CreatedBy' => 'lala',
            'UpdatedBy' => 'lala',
        ];
    
        Category::create($data);
    
        return redirect()->route('category.index')->withToastSuccess('Berhasil Menambah Data');
        
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
        $category = Category::find($id);
        if($category){
            $categories = Category::where('CategoryId', '!=', $id)->get();
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
            'ParentId' => $request->ParentId,
        ];
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // 'ParentId' => $request->ParentId,
    
        // $user = Auth::user();
        // $data['CreatedBy'] = $user;
        // $data['UpdCategory $user;
        $data['CreatedBy'] = 'lala';
        $data['UpdatedBy'] = 'lala';
        // dd($data);
        $category = Category::where('CategoryId', $id);
        if ($category) {
            $category->update($data);
            return redirect()->route('category.index')->withToastSuccess('Berhasil');
        } else {
            // Handle the case when the category with the specified CategoryId is not found
            return redirect()->route('category.index');
        }
    }
    public function destroy($CategoryId)
    {
        $category = Category::find($CategoryId);

        // Cek apakah ada anak kategori dengan ParentId yang sama dengan categoryId
        $checkParent = Category::where('ParentId', $category->CategoryId)->exists();

        if ($checkParent) {
            // Cek Anak Kategori dengan IsPermanentDelete = 1
            $checkDelete = Category::where('ParentId', $category->CategoryId)
                ->where('IsPermanentDelete', 0)
                ->exists();

            if (!$checkDelete) {
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

    public function activate($id)
    {
        $data = Category::where('CategoryId', $id)->first();
        if ($data->Active == 1) {
            Category::where('CategoryId', $id)->update(['Active' => 0]);
        } else {
            Category::where('CategoryId', $id)->update(['Active' => 1]);
        }
        return redirect()->route('category.index');
    }
}