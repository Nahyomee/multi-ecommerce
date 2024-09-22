<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $datatable)
    {
        return $datatable->render('admin.subcategory.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:sub_categories,name', 'max:100'],
            'category' => ['required', Rule::in(Category::where('status', 1)->pluck('id')) ],
            'status' => ['required']
        ]);
        $category = Category::find($request->category);
        $subcategory = $category->subcategories()->create($request->all() + ['slug' => Str::slug($request->name)]);
        if($subcategory){
            return back()->with('success', 'Sub Category Created!');
        }
        return back()->with('error', 'Sub Category not Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => ['required', 'unique:sub_categories,name,'.$subcategory->id, 'max:100'],
            'category' => ['required', Rule::in(Category::where('status', 1)->pluck('id')) ],
            'status' => ['required']
        ]);
        
        if($subcategory->update($request->except('category') + ['category_id' => $request->category])){
            if($subcategory->wasChanged('name')){
                $subcategory->slug = Str::slug($request->name);
                $subcategory->save();
            }
            return redirecT()->route('admin.subcategories.edit', ['subcategory' => $subcategory])->with('success', 'Sub Category Updated!');
        }
        return back()->with('error', 'Sub Category not Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        if($subcategory->childcategories->count() > 0){
            return response(['status' => 'error', 'message' => 'This item contains sub items, delete them first!']);
            
        }
        if($subcategory->delete()){
            return response(['status' => 'success', 'message' => 'Sub Category Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Sub Category not Deleted!']);
    }

    /**
     * Change status of subcategory
     */
    public function changeStatus(Request $request)
    {
        $subcategory = SubCategory::findOrFail($request->id);
        $subcategory->status = $request->status == 'true' ? 1 : 0;
        if($subcategory->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
