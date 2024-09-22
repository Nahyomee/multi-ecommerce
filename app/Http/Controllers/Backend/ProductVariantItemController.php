<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariant $variant)
    {
        $this->authorize('update', $variant->product);

        $datatable =  new ProductVariantItemDataTable($variant);

        return $datatable->render('admin.product.variants.items.index', compact('variant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ProductVariant $variant)
    {
        $this->authorize('update', $variant->product);

        return view('admin.product.variants.items.create', compact('variant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductVariant $variant, Request $request)
    {
        $this->authorize('update', $variant->product);

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'status' => ['required'],
            'is_default' => ['required'],
            'price' => ['required', 'numeric'],
        ]);

        $item = $variant->items()->create($request->all());
        if($item){
            return back()->with('success', 'Variant Item Created!');
        }
        else{
            return back()->with('error', 'Variant Item not Created!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $variant, ProductVariantItem $item)
    {
        $this->authorize('update', $variant->product);

        return view('admin.product.variants.items.edit', compact('variant', 'item'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariant $variant, ProductVariantItem $item)
    {
        $this->authorize('update', $variant->product);
        
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'status' => ['required'],
            'is_default' => ['required'],
            'price' => ['required', 'numeric'],
        ]);

        if( $item->update($request->all())){
            return back()->with('success', 'Variant Item Updated!');
        }
        else{
            return back()->with('error', 'Variant Item not Updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $variant, ProductVariantItem $item)
    {
        $this->authorize('update', $variant->product);

        if($item->delete()){
            return response(['status' => 'success', 'message' => 'Item Deleted!']);
        }

        return response(['status' => 'error', 'message' => 'Item not Deleted!']);
    }

     /**
     * Change status of item
     */
    public function changeStatus(Request $request)
    {
        $item = ProductVariantItem::findOrFail($request->id);
        $this->authorize('update', $item->variant->product);

        $item->status = $request->status == 'true' ? 1 : 0;
        if($item->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
