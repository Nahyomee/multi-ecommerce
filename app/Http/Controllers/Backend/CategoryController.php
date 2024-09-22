<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $datatable)
    {
        return $datatable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:categories', 'max:100'],
            'icon' => ['required', 'not_in:empty' ],
            'status' => ['required']
        ]);
        $category = Category::create($request->all() + ['slug' => Str::slug($request->name)]);
        if($category){
            return back()->with('success', 'Category Created!');
        }
        return back()->with('error', 'Category not Created!');
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
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'unique:categories,name,'.$category->id, 'max:100'],
            'icon' => ['required', 'not_in:empty' ],
            'status' => ['required']
        ]);
        
        if($category->update($request->all())){
            if($category->wasChanged('name')){
                $category->slug = Str::slug($request->name);
                $category->save();
            }
            return redirect()->route('admin.categories.edit', ['category' => $category])->with('success', 'Category Updated!');
        }
        return back()->with('error', 'Category not Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->subcategories->count() > 0){
            return response(['status' => 'error', 'message' => 'This item contains sub items, delete them first!']);
            
        }
        if($category->delete()){
            return response(['status' => 'success', 'message' => 'Category Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Category not Deleted!']);
    }

    /**
     * Change status of category
     */
    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        if($category->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
