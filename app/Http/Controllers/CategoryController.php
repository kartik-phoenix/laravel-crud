<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('category', function($row){
                            $name = $row->name ?? '';
                            return $name;
                    })
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                            $btn .= '<a href="'. route('category.edit', $row->id) .'" class="edit btn btn-primary btn-sm mx-2">Edit</a>';
                            $btn .= '<a href="javascript:void(0)" onclick="deletecat('. $row->id .');" class="edit btn btn-primary btn-sm">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action', 'category'])
                    ->make(true);
        }

        return view('category.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category;
            $category->name = $request->category;
            $category->save();

            return redirect()->route('category.index')->with('success', 'Category add successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $category->name = $request->category;
            $category->update();

            return redirect()->route('category.index')->with('success', 'Category update successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => 1,
        ]);
    }
}
