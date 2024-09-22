<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FlashSaleItemDataTable $datatable)
    {
        $products = Product::approved()->active()->latest()->get();
        $flashSale = FlashSale::first();
        return $datatable->render('admin.flash-sales.index', compact('products', 'flashSale'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'end_date' => ['required', 'date']
        ]);

        $flashSale = FlashSale::updateOrCreate(
            ['id' => 1],
            ['end_date' => $request->end_date]
        );

        if($flashSale){
            return back()->with('success', 'Flash Sale Updated!');
        }
        return back()->with('error', 'Flash Sale not Updated!');
    }

     /**
     *Add product in flash sale.
     */
    public function addProduct(Request $request)
    {
        $request->validate([
            'product' => ['required'],
            'home' => ['required'],
            'status' => ['required'],
        ]);
        $flashSale = FlashSale::first();
        $flashSaleItem = $flashSale->items()->create($request->except('product') + 
        ['product_id' => $request->product]);

        if($flashSaleItem){
            return back()->with('success', 'Products added to Flash Sale!');
        }
        return back()->with('error', 'Product not Added!');
    }

      /**
     * Remove the specified resource from storage.
     */
    public function deleteProduct(FlashSaleItem $item)
    {
        if($item->delete()){
            return response(['status' => 'success', 'message' => 'Product Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Product not Deleted!']);
    }

    /**
     * Change status of flash sale product
     */
    public function changeStatus(Request $request)
    {
        $flashSale = FlashSaleItem::findOrFail($request->id);

        $flashSale->status = $request->status == 'true' ? 1 : 0;
        if($flashSale->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }

    /**
     * Change status of flash sale product
     */
    public function changeHomeStatus(Request $request)
    {
        $flashSale = FlashSaleItem::findOrFail($request->id);

        $flashSale->home = $request->status == 'true' ? 1 : 0;
        if($flashSale->save()){
            return response(['status' => 'success', 'message' => 'Home status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Home status not Updated!']);

    }
}
