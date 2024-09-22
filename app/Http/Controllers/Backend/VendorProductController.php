<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorPendingProductDataTable;
use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    /**
     * Display vendors products
     */

     public function vendorProducts(VendorProductDataTable $datatable)
     {
         return $datatable->render('admin.product.vendor');
     }
 
    /**
     * Display vendors products
    */
 
    public function pendingVendorProducts(VendorPendingProductDataTable $datatable)
    {
        return $datatable->render('admin.product.vendor-pending');
    }

    /**
     * Approve / Reject products
     */

    public function changeApproveStatus(Request $request){
        $product = Product::findOrFail($request->id);
        $product->is_approved = $request->value;
        if($product->save()){
            return response(['status' => 'success', 'message' => 'Approval status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Approval status not Updated!']);

    }

    /**
     * Change status of product
     */

     public function changeStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->status = $request->status == 'true' ? 1 : 0;
        if($product->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
