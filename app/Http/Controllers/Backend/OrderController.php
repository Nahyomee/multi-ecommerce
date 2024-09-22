<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($status = null)
    {
        $datatable = new OrderDataTable($status);
        return $datatable->render('admin.order.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $address = json_decode($order->shipping_address);
        $shipping = json_decode($order->shipping_method);
        $coupon = json_decode($order->coupon);
        return view('admin.order.show', compact('order', 'address', 'shipping', 'coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->transaction()->delete();
        if($order->delete()){
            return response(['status' => 'success', 'message' => 'Order Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Order not Deleted!']);
    }

     /**
     * Change status of order
     */
    public function changeStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);

        $order->status = $request->status;
        if($order->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
