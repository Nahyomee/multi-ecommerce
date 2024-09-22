<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $datatable)
    {
        return $datatable->render('admin.child-category.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.child-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:child_categories,name', 'max:100'],
            'category' => ['required', Rule::in(Category::where('status', 1)->pluck('id')) ],
            'subcategory' => ['required', Rule::in(SubCategory::where('category_id', $request->category)
                                ->where('status', 1)->pluck('id')) ],
            'status' => ['required']
        ]);
        $category = Category::find($request->category);
        $childcategory = $category->childcategories()->create($request->except('subcategory') 
                            + ['sub_category_id' => $request->subcategory, 'slug' => Str::slug($request->name)]);
        if($childcategory){
            return back()->with('success', 'Child Category Created!');
        }
        return back()->with('error', 'Child Category not Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildCategory $child_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildCategory $child_category)
    {
        $categories = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $child_category->category_id)
            ->where('status', 1)->get();
        return view('admin.child-category.edit', compact('child_category', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildCategory $child_category)
    {
        $request->validate([
            'name' => ['required', 'unique:child_categories,name,'.$child_category->id, 'max:100'],
            'category' => ['required', Rule::in(Category::where('status', 1)->pluck('id')) ],
            'subcategory' => ['required', Rule::in(SubCategory::where('category_id', $request->category)
                                ->where('status', 1)->pluck('id')) ],
            'status' => ['required']
        ]);
        if($child_category->update($request->all() +['category_id' => $request->category, 'sub_category_id' => $request->subcategory, 'slug' => Str::slug($request->name)])){
            return redirecT()->route('admin.child-categories.edit', ['child_category' => $child_category])->with('success', 'Child Category Updated!');
        }
        return back()->with('error', 'Child Category not Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildCategory $child_category)
    {
        if($child_category->delete()){
            return response(['status' => 'success', 'message' => 'Child Category Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Child Category not Deleted!']);
    }

    /**
     * Change status of childcategory
     */
    public function changeStatus(Request $request)
    {
        $childcategory = ChildCategory::findOrFail($request->id);
        $childcategory->status = $request->status == 'true' ? 1 : 0;
        if($childcategory->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }

   
}
