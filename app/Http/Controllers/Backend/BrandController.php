<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $datatable)
    {
        return $datatable->render('admin.brand.index');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $brand = Brand::create($request->except('logo') + ['slug' => Str::slug($request->name)]);
        if($brand){
            $brand->logo = $this->uploadImage($request, Str::slug($brand->name).rand(10,99), 'brands', 'logo');
            $brand->save();
            return back()->with('success', 'Brand Created!');
        }
        else{
            return back()->with('error', 'Brand not Created!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        if($brand->update($request->except('logo') + ['slug' => Str::slug($request->name)])){
            $oldPath = 'brands/'.$brand->logo;
            $filename = Str::slug($brand->name).rand(10,99);
            $logo = $this->updateImage($request, $filename, 'brands', $oldPath, 'logo');
            if($logo != null){
                $brand->logo = $logo;
                $brand->save(); 
            }
            return redirect()->route('admin.brands.edit', ['brand' => $brand])->with('success', 'Brand Updated!');
        }
        else{
            return back()->with('error', 'Brand not Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $this->deleteImage('brands/'.$brand->logo);
        if($brand->delete()){
            return response(['status' => 'success', 'message' => 'Brand Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Brand not Deleted!']);
    }

    /**
     * Change status of brand
     */
    public function changeStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->status = $request->status == 'true' ? 1 : 0;
        if($brand->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
