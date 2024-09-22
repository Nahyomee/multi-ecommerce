<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\Vendor\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $this->authorize('update', $product);

        $datatable =  new ProductVariantDataTable($product);

        return $datatable->render('vendor.product.variants.index', compact('product'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $this->authorize('update', $product);

        return view('vendor.product.variants.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, Request $request)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'status' => ['required']
        ]);

        $variant = $product->variants()->create($request->all());
        if($variant){
            return back()->with('success', 'Variant Created!');
        }
        else{
            return back()->with('error', 'Variant not Created!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product,ProductVariant $variant)
    {
        $this->authorize('update', $product);

        return view('vendor.product.variants.edit', compact('product', 'variant'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'status' => ['required']
        ]);


        if($variant->update($request->all())){
            return back()->with('success', 'Variant Updated!');
        }
        else{
            return back()->with('error', 'Variant not Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        $this->authorize('update', $product);

        if($variant->items()->count() > 0){
            return response(['status' => 'error', 'message' => 'This variant has items attached to it. Delete items first!']);
        }
        if($variant->delete()){
            return response(['status' => 'success', 'message' => 'Variant Deleted!']);
        }

        return response(['status' => 'error', 'message' => 'Variant not Deleted!']);
    }

     /**
     * Change status of variant
     */
    public function changeStatus(Request $request)
    {
        
        $variant = ProductVariant::findOrFail($request->id);
        $this->authorize('update', $variant->product);
        $variant->status = $request->status == 'true' ? 1 : 0;
        if($variant->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
